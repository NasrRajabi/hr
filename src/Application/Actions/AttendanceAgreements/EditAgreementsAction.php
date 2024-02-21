<?php

declare(strict_types=1);


namespace App\Application\Actions\AttendanceAgreements;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\AttendanceAgreements\AgreementModel;

class EditAgreementsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected  function action(): Response
    {
        $id = $this->args["id"];

        $agreement = AgreementModel::findAgeement(((int) $id));
        $all = AgreementModel::findAll((int) $id);

        // dd($agreement);

        return $this->view->render(
            $this->response,
            'attendance_agreements/edit.twig',
            ['data' => $all['result'], 'agreement' =>  $agreement['result']],

        );
    }
}
