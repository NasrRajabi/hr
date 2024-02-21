<?php

declare(strict_types=1);

namespace App\Application\Actions\Setting;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Setting\VacationModel;

class ListVacationAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $all = VacationModel::all();

        return $this->view->render(
            $this->response,
            'setting/vacationList.twig',
            [ 'all' => $all['result'] ]
        );
    }
}
