<?php

declare(strict_types=1);

namespace App\Application\Actions\Movement;


use App\Models\Model;
use App\RequestValidators\Movement\MovementRequestValidator;
use App\Application\Actions\Action;
use App\Models\Movement\MovementAddModel;
use Psr\Http\Message\ResponseInterface as Response;
class StoreMovementAction extends Action
{
//LeaveRequestValidator

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->requestValidatorFactory->make(MovementRequestValidator::class)->validate($this->request->getParsedBody());
      
      MovementAddModel::store([
            $data['vehicle_id'],
            $data['itinerary'],
            $data['movement_date'],
            $data['driver'],
            $data['starting_hour'],
            $data['end_hour'],
            $data['star_counter_no'],
            $data['end_counter_no'],
            $data['movement_status']=1,
            $data['created_by']=$this->session->get("user_id"),
            $data['created_at']=date("Y-m-d")          
        ]);
    

            return $this->response
            ->withHeader('Location', '/movement/add')
            ->withStatus(302);
        
    }
}
