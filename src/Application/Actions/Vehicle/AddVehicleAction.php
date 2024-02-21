<?php

declare(strict_types=1);

namespace App\Application\Actions\Vehicle;


use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class AddVehicleAction extends Action
{


    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
  
         return $this->view->render(
            $this->response,
            'vehicle/add.twig',
        );
    }
}
