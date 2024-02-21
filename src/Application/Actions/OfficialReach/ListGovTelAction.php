<?php

declare(strict_types=1);

namespace App\Application\Actions\OfficialReach;

use App\Application\Actions\Action;
use App\Models\Employee\EmployeeContactsInfoModel;
use Psr\Http\Message\ResponseInterface as Response;


class ListGovTelAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

    
 
    $all = EmployeeContactsInfoModel::all();

    // dd($all);

        return $this->view->render(
            $this->response,
            'official_reach/gov_tel.twig',
            ['data' => $all['result']]
           
        );
    }
}
