<?php

declare(strict_types=1);

namespace App\Application\Actions\Employee;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Employee\EmployeeModel;

class ViewProfileAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $id =(int)  $this->args["id"];
        $data = EmployeeModel::find( $id);

        // dd($data);
    
        return $this->view->render(
            $this->response,
            'employee/profile.twig',
            ['data' => $data['result'] ],
        );
    }
}
