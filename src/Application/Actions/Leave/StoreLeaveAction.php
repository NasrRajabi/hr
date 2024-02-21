<?php

declare(strict_types=1);

namespace App\Application\Actions\Leave;


use App\Models\Model;
use App\RequestValidators\Leave\LeaveRequestValidator;
use App\Application\Actions\Action;
use App\Models\Leave\LeaveAddModel;
use Psr\Http\Message\ResponseInterface as Response;
class StoreLeaveAction extends Action
{
//LeaveRequestValidator

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->requestValidatorFactory->make(LeaveRequestValidator::class)->validate($this->request->getParsedBody());
      
      LeaveAddModel::store([
            $data['employee_id'],
            $data['leave_type'],
            $data['leave_dir'],
            $data['need_car'],
            $data['leave_date'],
            $data['leave_start'],
            $data['leave_end'],
            $data['leave_status']=1,
            $data['created_by']=$this->session->get("user_id"),
            $data['created_at']=date("Y-m-d")          
        ]);
    

            return $this->response
            ->withHeader('Location', '/leave/list')
            ->withStatus(302);
        
    }
}
