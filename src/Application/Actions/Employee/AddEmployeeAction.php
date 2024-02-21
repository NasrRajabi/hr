<?php

declare(strict_types=1);

namespace App\Application\Actions\Employee;


use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class AddEmployeeAction extends Action
{


    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->view->render(
            $this->response,
            'employee/add.twig',
        );
    }
}
