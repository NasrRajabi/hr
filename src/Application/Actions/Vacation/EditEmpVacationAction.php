<?php

declare(strict_types=1);

namespace App\Application\Actions\Vacation;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Vacation\VacationModel;
use App\RequestValidators\Vacation\VacationRequestValidator;

class EditEmpVacationAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
      //  dd($this->args);
        $employee_id = $this->session->get("user_id");

        $data = $this->requestValidatorFactory->make(VacationRequestValidator::class)->validate($this->request->getParsedBody());
   
//////// vacation to edit
        $get_vac_to_edit = VacationModel::getEmpVactionByVacId((int) $data['id'], (int) $employee_id);

        if ($get_vac_to_edit['result']->vacation_status != 2 ) {       

                $vac_to_edit_type = $get_vac_to_edit['result']->vacation_type ;

                $vac_to_edit_date1 = $get_vac_to_edit['result']->start_date ;
                $vac_to_edit_date2 = $get_vac_to_edit['result']->end_date ;
                $vac_to_edit_date1 = date_create($vac_to_edit_date1);
                $vac_to_edit_date2 = date_create($vac_to_edit_date2);
                $vac_to_edit_days = (date_diff($vac_to_edit_date1, $vac_to_edit_date2)->format("%a")) + 1 ;
        ///////////////////////        
                $date1 = date_create($data['start_date']);
                $date2 = date_create($data['end_date']);
                $day_count = (date_diff($date1, $date2)->format("%a")) + 1 ;

                VacationModel::updateEmpVacation([(int) $data['vacation_type'], (int) $data['annual_vac_type'] , $data['start_date'], $data['end_date']
                                                        ,(string) $data['address'], (string) $data['mobile'], (string) $data['phone'], (string) $data['notes']
                                                        , (int) $employee_id, (int) $vac_to_edit_type , (int) $data['id']]);


                VacationModel::returnEmpVacCurrentBal((int) $vac_to_edit_days, (int) $employee_id, (int) $vac_to_edit_type);
                
                VacationModel::updateEmpVacCurrentBal((int) $day_count, (int) $employee_id, (int) $data['vacation_type']);
        }                

        return $this->response
        ->withHeader('Location', '/vacation/listEmpVacation' )
        ->withStatus(302);
        
    }

}
