<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

ini_set('max_execution_time', 0);
require 'vendor/autoload.php';

use Rats\Zkteco\Lib\ZKTeco;


        $zk = new ZKTeco('10.98.67.31');

        if ($zk->connect()) {
            // $zk->testVoice();
            //$zk_att = (array) $zk->getAttendance();
		//	print_r($zk_att);
        } else {
            return die( 'No');
        }

        return die( 'Yes');

