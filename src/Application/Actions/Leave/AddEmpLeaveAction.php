<?php

declare(strict_types=1);

namespace App\Application\Actions\Leave;


use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Leave\LeaveListModel;
class AddEmpLeaveAction extends Action
{


    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
 // dd($_SESSION['os_id']);
 $LeaveListModel= new LeaveListModel();
  $data=$LeaveListModel->allempindept();
 
         return $this->view->render(
            $this->response,
            'leave/addemp.twig',['data'=>$data['result']]
        );
    }
}
