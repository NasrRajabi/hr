<?php

declare(strict_types=1);

namespace App\Application\Actions\Attendance;


use Rats\Zkteco\Lib\ZKTeco;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;


class ViewAttendanceAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        // // $zk = new ZKLibrary('10.98.70.48','4370'); 
         //$zk = new ZKTeco('10.98.70.48', 4370);

        // if ($zk->connect()) {
        //     $attendance = $zk->getAttendance();
        //     //$users = $zk->getUser();
        //     //$total = end($users);
        //     //$lastId=$total['uid']+1;
        //     //$zk->setUser($lastId, '168139', 'Asem', '123', 0);
        //     //$users = $zk->getUser();
        //     dd($attendance);
        //     //dd($zk->serialNumber());
        //     //dd($zk->restart());
        //     //dd($zk->disconnect());
        //     //dd( $zk->faceFunctionOn());
        //     //dd( $zk->deviceName());
        //     //dd($zk->pinWidth());
        //     //dd($zk->workCode());
        //     //dd($zk->testVoice());
        //     //dd($zk->setTime('2023-05-11 14:22:37'));
        //     //dd($zk->getTime());c
        //     //dd($zk->getFingerprint(2));
        //     //$fp = $zk->getFingerprint(2);
        //     //dd($zk->removeFingerprint(2, $fp));
        //     die;
        // } else {
        //     dd('Not Connected');
        // }
        return $this->view->render(
            $this->response,
            'attendance/monitoring.twig',
        );
    }
}
