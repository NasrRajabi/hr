<?php

declare(strict_types=1);

namespace App\Models\Job;

use App\Models\Model;


class JobModel
{


    public static function all(): array
    {

        $sql = 'SELECT  id, job_title
                FROM jobs
                ';

        $results = Model::query_get($sql);
        // dd($results);
        return $results;
    }

   
   
}