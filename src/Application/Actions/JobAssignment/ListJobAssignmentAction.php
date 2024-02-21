<?php

declare(strict_types=1);

namespace App\Application\Actions\JobAssignment;


use App\Models\Model;
use App\RequestValidators\JobAssignment\JobAssignmentRequestValidator;
use App\Application\Actions\Action;
use App\Models\JobAssignment\JobAssignmentstoreModel;
use Psr\Http\Message\ResponseInterface as Response;
class listJobAssignmentAction extends Action
{
//LeaveRequestValidator

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
      $leave_types = $this->lookups->get('leave');
            $vacation_status = $this->lookups->get('vacation_status');
            $job_assignment_type = $this->lookups->get('job_assignment_type');   
            $country = $this->lookups->get('country'); 
            $hosting_type = $this->lookups->get('hosting_type'); 
            $job_assignment_supject= $this->lookups->get('job_assignment_supject'); 
      $data=JobAssignmentstoreModel::list();
      //dd($data);
      return $this->view->render(
        $this->response,
        
        'job_assignment/list.twig',['data'=>$data['result'],'vacation_status'=>$vacation_status,'job_assignment_type'=>$job_assignment_type,'country'=>$country,
        'hosting_type'=>$hosting_type,'job_assignment_supject'=>$job_assignment_supject]); 
    
    }
}
