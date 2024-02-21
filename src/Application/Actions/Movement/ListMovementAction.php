<?php

declare(strict_types=1);

namespace App\Application\Actions\Movement;


use App\Models\Model;
use App\Application\Actions\Action;
use App\Models\Movement\MovementListModel;
use Psr\Http\Message\ResponseInterface as Response;
    
    class ListMovementAction extends Action
    {
    
    
        /**
         * {@inheritdoc}
         */
        protected function action(): Response
        {
            $MovementListModel = new MovementListModel();
            $data=$MovementListModel->all();
            
               return $this->view->render(
                $this->response,
                'movement/list.twig',['data'=>$data['result'] ]
            );
        }
    }
    