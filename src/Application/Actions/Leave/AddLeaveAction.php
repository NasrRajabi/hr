<?php

declare(strict_types=1);

namespace App\Application\Actions\Leave;


use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class AddLeaveAction extends Action
{


    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
  
         return $this->view->render(
            $this->response,
            'leave/add.twig',
        );
    }
}
