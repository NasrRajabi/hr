<?php

namespace App\Application\Actions\Attendance;

use App\Application\Actions\Action;
use App\Models\AttendanceAgreements\AgreementModel;
use App\Models\AttendanceAgreements\AttendanceAgreementActionsModel;
use App\Models\Attendance\AttendanceCheckInOutModel;
use App\Models\Attendance\AttendanceModel;
use App\Models\Attendance\DevicesModel;
use App\Models\Model;
use App\RequestValidators\Attendance\DeviceCheckConnectRequestValidator;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Rats\Zkteco\Lib\ZKTeco;

class StoreAttendanceLogs extends Action
{
    private array $employeeRecords = [];
    protected function action(): Response
    {

        // $zk_att = [
        // 0 =>  [
        // "uid" => 115,
        // "id" => "1",
        // "state" => 1,
        // "timestamp" => "2023-06-02 12:01:22",
        // "type" => 0
        // ],
        // 1 =>  [
        // "uid" => 116,
        // "id" => "1",
        // "state" => 1,
        // "timestamp" => "2023-06-02 11:10:00",
        // "type" => 0
        // ],
        // 2 => [
        // "uid" => 117,
        // "id" => "1",
        // "state" => 1,
        // "timestamp" => "2023-06-06 11:11:48",
        // "type" => 0
        // ],
        // 3 =>  [
        // "uid" => 118,
        // "id" => "1",
        // "state" => 1,
        // "timestamp" => "2023-06-06 11:13:48",
        // "type" => 0
        // ],
        // 4 =>  [
        // "uid" => 119,
        // "id" => "1",
        // "state" => 1,
        // "timestamp" => "2023-06-08 11:00:00",
        // "type" => 0
        // ],
        // 5 =>  [
        // "uid" => 119,
        // "id" => "1",
        // "state" => 1,
        // "timestamp" => "2023-06-08 11:57:26",
        // "type" => 0
        // ],
        // 6 =>  [
        // "uid" => 119,
        // "id" => "1",
        // "state" => 1,
        // "timestamp" => "2023-06-08 15:00:26",
        // "type" => 0
        // ]
        // ];

        $data = $this->requestValidatorFactory->make(DeviceCheckConnectRequestValidator::class)->validate($this->request->getParsedBody());
        $ip =$data['device_ip'];
        $zk = new ZKTeco($ip);
        if (!$zk->connect()) {
            return $this->responseFormatter->asJson($this->response, 'الساعة غير متصلة');
        } else {
            $zk_att = (array) $zk->getAttendance();
            $att_count = count($zk_att);
            $device = DevicesModel::findByIP($ip);

            if ($device['rowCount'] === 1) {
                if ($att_count != 0) {
                    Model::start_tran();
                    foreach ($zk_att as $value) {
                        AttendanceModel::store(
                            (int) $value['id'],
                            (string) $value['timestamp'],
                            (int) $value['state'],
                            (int) $value['type'],
                            (int) $device['result']->id
                        );

                        $this->inOutArray(record:$value);
                    }

                    $this->inOutStore(device_id:(int) $device['result']->id);

                    Model::save_tran();
                }
            } else {
                return $this->responseFormatter->asJson($this->response, 'الساعة غير موجودة');
            }
        
            return $this->responseFormatter->asJson($this->response, "عدد البصمات التي تم سحبها بنجاح  ( " . $att_count . " )");
        }
    }

    private function inOutArray(array $record)
    {

        $AgreementDetial = $this->getEmployeeAttAgreement($record);
        
       
        if (!$AgreementDetial) {
            return;
        }
        $id = $AgreementDetial->employee_id;
        $timestamp = $record["timestamp"];
        $date = date("Y-m-d", strtotime($timestamp));
        $time = date("H:i:s", strtotime($timestamp));
        $key = $id . "_" . $date;
        if ($AgreementDetial) {
            $checkInEnd = $AgreementDetial->check_in_end;
            if (!isset($this->employeeRecords[$key])) {
                // Initialize the check-in and check-out times for the employee
                $this->employeeRecords[$key] = [
                    "employee_id" => $id,
                    "date" => $date,
                    "checkIn" => ($time <= $checkInEnd) ? $time : null,
                    "checkOut" => ($time > $checkInEnd) ? $time : null,
                ];
            } else {
                // Update the check-in and check-out times if necessary
                if ($time <= $checkInEnd && ($this->employeeRecords[$key]["checkIn"] === null || $time < $this->employeeRecords[$key]["checkIn"])) {
                    $this->employeeRecords[$key]["checkIn"] = $time;
                }
                if ($time > $checkInEnd && ($this->employeeRecords[$key]["checkOut"] === null || $time > $this->employeeRecords[$key]["checkOut"])) {
                    $this->employeeRecords[$key]["checkOut"] = $time;
                }
            }
        } else {
            //First --- Last
            if (!isset($this->employeeRecords[$key])) {
                $this->employeeRecords[$key] = [
                    "employee_id" => $id,
                    "date" => $date,
                    "checkIn" => $timestamp,
                    "checkOut" => $timestamp,
                ];
            } else {
                if ($timestamp < $this->employeeRecords[$key]["checkIn"]) {
                    $this->employeeRecords[$key]["checkIn"] = $timestamp;
                }
                if ($timestamp > $this->employeeRecords[$key]["checkOut"]) {
                    $this->employeeRecords[$key]["checkOut"] = $timestamp;
                }
            }
        }
    }

    /**
     * return Employee Agreement Detial
     */
    private function getEmployeeAttAgreement(array $record): false | object
    {

        $dateTime = new DateTime($record['timestamp']);
        $dayName = $dateTime->format('D'); //get day name Fri, Sun ... for specific date

        $currentDate = date("Y-m-d"); // Current date
        $timestamp = strtotime($record['timestamp']); // Convert timestamp to integer

        $timestampDate = date("Y-m-d", $timestamp); // Date from timestamp

        // compare two date
        if ($timestampDate === $currentDate) {
            //Employee basic info table agreement_id
            $AgreementDetial = AgreementModel::employeeAgreementDetial((int) $record['id'], $dayName);
            return $this->checkAttStatus($AgreementDetial);
        } else {
            //Agreement actions table employee last agreement_id
            $AgreementDetial = AttendanceAgreementActionsModel::employeeAgreementDetial((int) $record['id'], $dayName);
          //  dd($AgreementDetial);
            return $this->checkAttStatus($AgreementDetial);
        }
    }

    /**
     * check if working day or day off
     */
    private function checkAttStatus($AgreementDetial): false | object
    {
        if ($AgreementDetial['rowCount'] == 1) {
        if ($AgreementDetial['result']->att_status === 5) {
            return false;
        }else {
            return $AgreementDetial['result'];
        }
        }
         return false;
     
    }

    private function inOutStore(int $device_id): void
    {
        foreach ($this->employeeRecords as $record) {
            AttendanceCheckInOutModel::store(
                (int) $record["employee_id"],
                $record["date"],
                $record["checkIn"],
                $record["checkOut"],
                $device_id
            );
        }
    }
}
