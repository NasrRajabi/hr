<?php

namespace App\Application\Actions\Os;

use App\Models\Os\OsModel;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StoreAction extends Action
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();


         OsModel::store((int) $data['parent_id'],(int) $data['node_level'], (int) $data['dept_type'], (string) $data['name']);

         return $this->response
         ->withHeader('Location', 'view')
         ->withStatus(302);

        //  return $this->view->render(
        //     $this->response,
        //     'os/view.twig',
      
        // );
        
    }



}
