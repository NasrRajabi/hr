<?php

declare(strict_types=1);

namespace App\Application\Actions\Vacation;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Vacation\VacationModel;
use App\RequestValidators\Vacation\VacationRequestValidator;

//use App\Services\UserProviderService;

class AddManTOEmpVacAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $user_id = $this->session->get("user_id");

        $vac_sts = 1 ;

        //$data = $this->requestValidatorFactory->make(VacationRequestValidator::class)->validate($this->request->getParsedBody());
        $data = $this->request->getParsedBody();
       
        VacationModel::storeEmpVac([(int) $data['employee_id'], (int) $data['vacation_type'], (int) $data['annual_vac_type'], $data['start_date'],
                       $data['end_date'], (string) $data['address'], (string) $data['mobile'], (string) $data['phone'], (string) $data['notes'], (int) $vac_sts, (int) $user_id, date('Y-m-d H:i:s') ]);


        $date1 = date_create($data['start_date']);
        $date2 = date_create($data['end_date']);
        $day_count = (date_diff($date1,$date2)->format("%a")) + 1 ;

        VacationModel::updateEmpVacCurrentBal((int) $day_count, (int) $data['employee_id'], (int) $data['vacation_type']);

        return $this->response
        ->withHeader('Location', '/vacation/listManTOEmp')
        ->withStatus(302);
        
    }


}
