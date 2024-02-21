<?php

declare(strict_types=1);

namespace App\Application\Actions\Movement;


use App\Models\Model;
use App\RequestValidators\Movement\MovementRequestValidator;
use App\Application\Actions\Action;
use App\Models\Movement\MovementAddModel;
use Psr\Http\Message\ResponseInterface as Response;
class UpdateMovementAction extends Action
{
//LeaveRequestValidator

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
       $data = $this->request->getParsedBody();
    //    dd($data);
    $id=($this->args["id"]);
// dd($data["id"]);die;
    MovementAddModel::updateMovement($data["vehicle_id"],$data["itinerary"],$data["movement_date"],$data["driver"],$data["starting_hour"],$data["end_hour"],$data["star_counter_no"],$data["end_counter_no"],$id);
        return $this->response
        ->withHeader('Location', '/movement/list')
        ->withStatus(302);
        
    }

   
}