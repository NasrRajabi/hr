<?php

declare(strict_types=1);

namespace App\Application\Actions\Vehicle;


use App\Models\Model;
use App\Application\Actions\Action;
use App\Models\Vehicle\VehicleListModel;
use Psr\Http\Message\ResponseInterface as Response;
    
    class ListVehicleAction extends Action
    {
    
    
        /**
         * {@inheritdoc}
         */
        protected function action(): Response
        {
            $VehicleListModel = new VehicleListModel();
            $data=$VehicleListModel->all();
            
               return $this->view->render(
                $this->response,
                'vehicle/list.twig',['data'=>$data['result'] ]
            );
        }
    }
    