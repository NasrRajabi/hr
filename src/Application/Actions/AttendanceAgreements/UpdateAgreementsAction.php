<?php

declare(strict_types=1);


namespace App\Application\Actions\AttendanceAgreements;

use App\Models\Model;
use App\Application\Actions\Action;
use App\Models\AttendanceAgreements\AgreementModel;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Agreements\AgreementRequestValidator;
use App\RequestValidators\Agreements\AgreementDetailsRequestValidator;

class UpdateAgreementsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected  function action(): Response
    {
        // $data = $this->request->getParsedBody();
        $data = $this->requestValidatorFactory->make(AgreementRequestValidator::class)->validate($this->request->getParsedBody());
        $item_key = $this->requestValidatorFactory->make(AgreementDetailsRequestValidator::class)->validate($data);
        // dd($data);
        Model::start_tran();

      AgreementModel::updateAgreementTrans([
            $data['name'],
            $data['description'],
            $data['id'], 
        ]);

 
        foreach ($this->lookups->get('days') as $key => $day) {

            AgreementModel::updateAgreementDetailsTrans([
               
                $key,
                $item_key[$key . '_att_status'],
                $item_key[$key . '_start_time'] == "" ? '00:00:00' :  $item_key[$key . '_start_time'],
                $item_key[$key . '_end_time'] == "" ? '00:00:00' :  $item_key[$key . '_end_time'],
                $item_key[$key . '_check_in_end'] == "" ? '00:00:00' :  $item_key[$key . '_check_in_end'],
                $item_key[$key . '_allowed_time_check_in'] == "" ? 00 :  $item_key[$key . '_allowed_time_check_in'],
                $item_key[$key . '_allowed_time_check_out'] == "" ? 00 :  $item_key[$key . '_allowed_time_check_out'],
                (int) $item_key[$key . '_allowed_p_leave_hours'],
                $data['id'],
                $key,
            ]);
        }

        Model::save_tran();

        return $this->response
        ->withHeader('Location', '/attendance_agreements/agreement_list')
        ->withStatus(302);
    }
}
