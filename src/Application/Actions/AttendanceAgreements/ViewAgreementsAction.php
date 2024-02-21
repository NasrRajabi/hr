<?php

declare(strict_types=1);


namespace App\Application\Actions\AttendanceAgreements;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\AttendanceAgreements\AgreementModel;
use App\Models\Employee\EmployeeModel;

class ViewAgreementsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected  function action(): Response
    {

        $all = AgreementModel::allBy();
        $all_employee = EmployeeModel::all_emp_name();

        $groupedData = [];

        foreach ($all['result'] as $item) {
            $name = $item->name;

            if (!array_key_exists($name, $groupedData)) {
                $groupedData[$name] = [];
            }

            $groupedData[$name][] = $item;
        }

        // dd($groupedData);
        return $this->view->render(
            $this->response,
            'attendance_agreements/view.twig',
            ['data' => $groupedData , 'employee' => $all_employee['result']],

        );
    }
}
