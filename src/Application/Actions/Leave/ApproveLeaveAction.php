<?php

declare(strict_types=1);

namespace App\Application\Actions\Leave;

use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Leave\LeaveListModel;
use App\RequestValidators\Vacation\VacationRequestValidator;

class ApproveLeaveAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        
       
       $leave_id = $this->args['id'];
       $leave_status = $this->args['sts'];

       if ($leave_status == 3 || $leave_status == 4) {
          $get_leave=LeaveListModel::getLeave((int) $leave_id);
        
        $employee_id = $get_leave['result']->employee_id;
        $leave_type = $get_leave['result']->leave_type;

       }

       LeaveListModel::approveLeave((int) $leave_id, (int) $leave_status);
             
        return $this->response
        ->withHeader('Location', '/leave/list')
        ->withStatus(302);
    }

}
