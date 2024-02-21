<?php

declare(strict_types=1);

namespace App\Application\Actions\Attendance;


use Rats\Zkteco\Lib\ZKTeco;
use App\Application\Actions\Action;

use App\Models\Attendance\DevicesModel;
use Psr\Http\Message\ResponseInterface as Response;


class ViewAttendanceDevicesAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
   //     $zk = new ZKTeco('10.98.67.31', 4370);

//   if ($zk->connect()) {
      //     dd("connect");
 // dd( $zk->getAttendance());
//     //     //     $users = $zk->getUser();
//     //     //     dd($users);
//     //     // //     //$total = end($users);
//     //     // //     //$lastId=$total['uid']+1;
//     //     // //     //$zk->setUser($lastId, '168139', 'Asem', '123', 0);
//     //     // //     //$users = $zk->getUser();
//     //     // //     dd($attendance);
//     //     // //     //dd($zk->serialNumber());
//     //     // //     //dd($zk->restart());
//     //     // //     //dd($zk->disconnect());
//     //     // //     //dd( $zk->faceFunctionOn());
//     //     // //     //dd( $zk->deviceName());
//     //     // //     //dd($zk->pinWidth());
//     //     // //     //dd($zk->workCode());
//     //     // //     //dd($zk->testVoice());
//     //     // date_default_timezone_set('Asia/Jerusalem');
//     //     // $serverTime = date('Y-m-d H:i:s');
        
//     //     //     dd($zk->setTime($serverTime));
//     //     // //     //dd($zk->getTime());c
//     //       // dd($zk->getFingerprint(3));
//     //    $ayaFing = $zk->getFingerprint(1);
//     //    //dd($ayaFing);
//     //   $zk->removeFingerprint(1,[6]);
//     //     dd( $zk->setFingerprint(3,$ayaFing));
//     //      //$zk->setFingerprint(3,$zk->getFingerprint(1));
//     //         //$fp = $zk->getFingerprint(2);
//     //     // //     //dd($zk->removeFingerprint(2, $fp));
//     //     // //     die;
        //   } else {
        //      dd('Not Connected');
        //  }



        $last_device_id = DevicesModel::last_device_id();

        if ($last_device_id['rowCount'] != 1) {
            $last_id = 1;
        } else {

            $last_id = $last_device_id['result']->last_id + 1;
        }

        $all = DevicesModel::all();
        // dd($all);



        return $this->view->render(
            $this->response,
            'attendance/devices.twig',
            ['last_device_id' => $last_id, 'data' => $all['result']], 
           
        );
    }
}