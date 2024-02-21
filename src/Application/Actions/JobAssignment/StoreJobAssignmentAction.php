<?php

declare(strict_types=1);

namespace App\Application\Actions\JobAssignment;


use App\Models\Model;
use App\RequestValidators\JobAssignment\JobAssignmentRequestValidator;
use App\Application\Actions\Action;
use App\Models\JobAssignment\JobAssignmentstoreModel;
use Psr\Http\Message\ResponseInterface as Response;
class StoreJobAssignmentAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        
        $data = $this->requestValidatorFactory->make(JobAssignmentRequestValidator::class)->validate($this->request->getParsedBody());
     
    if($data['mission_type']==2){
        JobAssignmentstoreModel::store([
           // $data['employee_id'],
            2,
            $data['mission_status'],
            $data['mission_supject'],
            $data['mission_start_date'],
            $data['mission_end_date'],
            $data['last_date'],
            $data['mission_country'],
            $data['hosted_type'],
            $data['mission_funded'],
            $data['short_description'],
            $data['note'],
            $data['create_user']=$this->session->get("user_id"),
            $data['create_date']=date("Y-m-d")          
        ]);
    }elseif($data['mission_type']==1){
        JobAssignmentstoreModel::store_local_assignment([
        $data['employee_id'],
            1,
            $data['mission_status'],
            $data['mission_supject'],
            $data['mission_start_date'],
            $data['mission_end_date'],
            $data['city'],
            $data['note'],
            $data['create_user']=$this->session->get("user_id"),
            $data['create_date']=date("Y-m-d") 
        ]);
    }

            return $this->response
            ->withHeader('Location', '/job_assignment/list')
            ->withStatus(302);
        
    }
}
