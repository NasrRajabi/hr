<?php

declare(strict_types=1);

namespace App\Application\Actions\Movement;

use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Movement\MovementAddModel;


class EndMovementAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        
       
        $data = $this->request->getParsedBody();
        //    dd($data);
        $id=($this->args["id"]);
    // dd($data["id"]);die;
        MovementAddModel::updateEndMovement($data["end_movement_date"],$data["end_hour"],$data["end_counter_no"],$data["movement_status"],$id);
            return $this->response
            ->withHeader('Location', '/movement/list')
            ->withStatus(302);
    }

}
