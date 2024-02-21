<?php

declare(strict_types=1);

namespace App\Application\Actions\Shared;

use App\Models\Vacation\VacationModel;
use DateTime;
use App\Models\Duration\DurationListModel;
use App\Models\AttendanceAgreements\AgreementModel;
use App\Models\Employee\EmployeeBasicInfoModel;
use App\Models\Leave\LeaveListModel;

use DateInterval;

trait Calendar
{
    protected function getCalendar(int $id): array
    {
        $year = (int) date('Y');
        $month = (int) date('m');
        $today = (int) date('d');

        $calendarData = $this->generateCalendarData($year, $month);

        $DurationListModel = new DurationListModel();
        $data = $DurationListModel->findByEmpIdByMonthByYear((int) $id, $month, $year);

        $EmployeeBasicInfoModel = new EmployeeBasicInfoModel();
        $employee = $EmployeeBasicInfoModel->getEmpById((int) $id);

        $EmpVacationModel = new VacationModel();
        $emp_vacation = $EmpVacationModel->getAllEmpVactionByMonthByYear((int) $id, $month, $year);

        $EmpLeaveModel = new LeaveListModel();
        $emp_leave = $EmpLeaveModel->getLeavebyEmpIdAndMonth((int) $id,  $month, $year);

         
        $ag_id = $employee['result']->attendance_agreements_id;

        $agreement  = AgreementModel::findAll((int)  $ag_id);
        $agreementData = $agreement['result'];
        $dataIndexedByDate = [];



        foreach ($data['result'] as $value) {
           
                           $date = date_create($value->date);
    
    $dayName = date_format($date,"D");  
            

             $agreementDetails = AgreementModel::getEmpAttendenceAgreement((int) $value->id, $dayName);

            if ($agreementDetails['rowCount'] == 1) {
                // $value->ag_details = $agreementDetails['result'];
                $this->calculateCheckInDiff($value, $agreementDetails['result']);
                $this->calculateCheckOutDiff($value, $agreementDetails['result']);
            }
            
        }



        // Create a merged array of each day in month and agreement details
        $merged = [];

        $agreementMapping = [];
        foreach ($agreementData as $agreementItem) {
            $agreementMapping[$agreementItem->day] = (array)$agreementItem; // Convert the object to an array
        }

        foreach ($calendarData as $calendarMonth) {
            $mergedMonth = [];

            foreach ($calendarMonth as $calendarDay) {
                $dayName = $calendarDay["dayName"];

                // Check if there is an agreement for this dayName
                if (isset($agreementMapping[$dayName])) {

                    $mergedDay = array_merge($calendarDay, $agreementMapping[$dayName]);
                } else {

                    $mergedDay = $calendarDay;
                }

                $mergedMonth[] = $mergedDay;
            }

            $merged[] = $mergedMonth;
        }

        //  dd($data['result'], $merged);

        // marge calnderDate + agreement details + attendance data 
        foreach ($merged as  $value) {
            foreach ($value as  $inValue) {
                foreach ($data['result'] as $item) {
                    if ($inValue['date'] == $item->date) {
                        $dataIndexedByDate[$inValue['date']] = array_merge((array) $item, $inValue);
                    }
                }
            }
        }

        // involve days that have no attendance record such as fri, sat and any day havn't checkin and checkout 
        foreach ($merged as  $value) {
            foreach ($value as  $inValue) {
                if (!array_key_exists($inValue['date'], $dataIndexedByDate)) {
                    $dataIndexedByDate[$inValue['date']] = $inValue;
                }
            }
        }


        ksort($dataIndexedByDate);


        // merge above merged array with employee vaction by month and year 
        foreach ($emp_vacation['result'] as $value) {
            foreach ($dataIndexedByDate as $key => $item) {
                if ($key >= $value->start_date && $key <= $value->end_date) {
                    // $dataIndexedByDate[$key]['att_status'] = 2;
                    $dataIndexedByDate[$key] = array_merge($dataIndexedByDate[$key], (array) $value);
                }
            }
        }

        $totalLeave = new DateTime('00:00'); // Initialize with zero time


        foreach ($emp_leave['result'] as $value) {
            $startTime = new DateTime($value->leave_start);
            $endTime = new DateTime($value->leave_end);

            // Calculate the time difference
            $timeDifference = $startTime->diff($endTime);

            // Add the time difference to the total sum
            $totalLeave->add($timeDifference);

            // Create a new DateTime object for the current day
            $currentDay = new DateTime($value->leave_date);

            // Initialize or retrieve the day's total leave time
            if (!isset($dataIndexedByDate[$value->leave_date]['leaves_total'])) {
                $dataIndexedByDate[$value->leave_date]['leaves_total'] = new DateTime('00:00');
            }
            

            // Add the time difference to the day's total leave time
            $dataIndexedByDate[$value->leave_date]['leaves_total']->add($timeDifference);
        



            if (isset($dataIndexedByDate[$value->leave_date]['leaves'])) {
                // If 'leaves' key exists, append to the existing array
                $dataIndexedByDate[$value->leave_date]['leaves'][] = (array) $value;
            } else {
                // If 'leaves' key doesn't exist, create a new array with the current value
                $dataIndexedByDate[$value->leave_date]['leaves'] = [(array) $value];
            }
        }

        // Extract the total leave time components
        $totalHours = $totalLeave->format('H');
        $totalMinutes = $totalLeave->format('i');
        $totalSeconds = $totalLeave->format('s');

       // dd($dataIndexedByDate);
      //  dd("Total Leave Time: $totalHours hours, $totalMinutes minutes, $totalSeconds seconds");




// Calculate the day of the week for the first day of the month
$firstDayOfWeek = date('N', strtotime("$year-$month-01"));
// Determine the difference between the desired starting day (Wednesday) and the actual starting day
$desiredStartDayOfWeek = 3; // 3 represents Wednesday
$dayDifference = $desiredStartDayOfWeek - $firstDayOfWeek;

//dd($firstDayOfWeek,$desiredStartDayOfWeek);
// If the calculated day difference is negative, add 7 to it
if ($dayDifference < 0) {
    $dayDifference += 7;
}

// Create an array to store the calendar data
$calendarData = [];

// Get the number of days in the month
$daysInMonth = 30;//cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Initialize the day counter
$dayCounter = 1 + $dayDifference;

// Define the number of weeks in the calendar (typically 4 or 5)
$weeks = 5;

// Loop through the weeks
for ($week = 1; $week <= $weeks; $week++) {
    $weekData = [];

    // Loop through the days of the week (7 days)
    for ($dayOfWeek = 1; $dayOfWeek <= 7; $dayOfWeek++) {
        if ($week === 1 && $dayOfWeek <= $firstDayOfWeek) {
            // If it's the first week and the day of the week is before the first day of the month, use null data
            $weekData[] = null;
        } elseif ($dayCounter <= $daysInMonth) {
            // Create a data structure for each day
            $dayData = [
                'date' => "$year-$month-$dayCounter",
                // You can add more data here as needed
            ];
            $weekData[] = $dayData;
            $dayCounter++;
        } else {
            // If we've exceeded the number of days in the month, use null data
            $weekData[] = null;
        }
    }

    $calendarData[] = $weekData;
}

// Now, $calendarData contains the structured data for the calendar



        return [
            'year' => $year,
            'month' => $month,
            'today' => $today,
            'employee' => $employee["result"],
            'data' => $dataIndexedByDate,
            // "vacation" => $emp_vacation["result"],
            // 'agreement' => $agreementData,
             'calendarData' => $calendarData,

        ];
    }


    private function calculateCheckInDiff($value, $agreementDetails)
    {
        
        if ($value->check_in !== null) {
           
            $check = new DateTime($value->check_in);
            $check_in = $check->format("H:i");
            
            $start_time = $agreementDetails->start_time;

            $minutes1 = $this->convertToMinutes($start_time);
            $minutes2 = $this->convertToMinutes($check_in);

            $value->diff = (int) $minutes1 - (int) $minutes2;
            $value->att_hours = (int) $agreementDetails->end_time - (int) $agreementDetails->start_time - (int) $agreementDetails->allowed_p_leave_hours;
        }
    }

    private function calculateCheckOutDiff($value, $agreementDetails)
    {
       
      
        if ( $value->check_out !== null) {
           
            $check = new DateTime($value->check_out);
            $check_out = $check->format("H:i");
            $end_time = new DateTime($agreementDetails->end_time);

            $minutes1 = $this->convertToMinutes($end_time->format("H:i"));
            $minutes2 = $this->convertToMinutes($check_out);

            $value->diff_out = (int) $minutes2 - (int) $minutes1;
            if ( $value->check_in !== null) {
            $interval = $check->diff(new DateTime($value->check_in));
            $value->att_hours = $interval->h;
            }
            $value->min_att_hours = (int) $agreementDetails->end_time - (int) $agreementDetails->start_time - (int) $agreementDetails->allowed_p_leave_hours;
        }
    }


    private function generateCalendarData($year, $month)
    {
        $daysInMonth = (new DateTime("$year-$month-01"))->format('t');
        $firstDayOfWeek = date('w', strtotime("$year-$month-01"));

        $calendarData = [];
        $dayCounter = 1;

        for ($week = 0; $week < 6; $week++) {
            $weekData = [];

            for ($dayOfWeek = 0; $dayOfWeek < 7; $dayOfWeek++) {
                if (($week === 0 && $dayOfWeek < $firstDayOfWeek) || $dayCounter > $daysInMonth) {
                    $weekData[] = [
                        'day' => null, // Empty cell
                        'dayName' => null, // Empty day name
                        'date' => null

                    ];
                } else {
                    $date = new DateTime("$year-$month-$dayCounter");
                    $weekData[] = [
                        'day' => $dayCounter,
                        'dayName' => $date->format('D'), // Get the day name (e.g., Mon, Tue, etc.)
                        'date' => $date->format('Y-m-d'),
                    ];
                    $dayCounter++;
                }
            }

            $calendarData[] = $weekData;

            if ($dayCounter > $daysInMonth) {
                break;
            }
        }

        return $calendarData;
    }




    private function convertToMinutes($time)
    {
        [$hours, $minutes] = explode(':', $time);
        return ($hours * 60.0 + $minutes);
    }
}
