<?php

declare(strict_types=1);

namespace App\Application\Actions\JobAssignment;
use App\Models\Model;
//use App\RequestValidators\JobAssignment\JobAssignmentRequestValidator;
use App\Application\Actions\Action;
use App\Models\JobAssignment\JobAssignmentstoreModel;
use Psr\Http\Message\ResponseInterface as Response;

class StoreCustomizeJobAssignmentAction extends Action
{


    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data=$this->request->getParsedBody();
        $dept=JobAssignmentstoreModel::Customize_dep();
        $id=($this->args["id"]);
        $user=$this->session->get("user_id");
        $date=date("Y-m-d") ;
       $i=0 ;
       $coun=array();
        foreach ($dept['result'] as $da) {
            $dep='check_'.$da->dept_id  ;
            if($data['check_'.$da->dept_id]==1){
                $emp_coun=$data['emp_coun_'.$da->dept_id];
                JobAssignmentstoreModel::store_job_assigment_dep($id,$da->dept_id,$emp_coun,$user,$date);
               // $coun[$i]['dep_id']=$da->dept_id ;
                //$coun[$i]['job_assigment_id']=$id ;
            }else{
                goto nex  ;
            }
            nex:
         $i++;
        }
        return $this->response
            ->withHeader('Location', '/job_assignment/list')
            ->withStatus(302);
       
    }
}