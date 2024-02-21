<?php

declare(strict_types=1);


namespace App\Application\Actions\AttendanceAgreements;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\AttendanceAgreements\AgreementModel;

class CreateAgreementAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected  function action(): Response
    {
    //     $id = $this->args["id"];

    //     $agreement = AgreementModel::findAgeement(((int) $id));

    //    $all = AgreementModel::findAll((int) $id); 




        return $this->view->render(
            $this->response,
            'attendance_agreements/create.twig',
            
        );
        
    }
}
