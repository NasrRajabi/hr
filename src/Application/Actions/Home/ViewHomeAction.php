<?php

declare(strict_types=1);

namespace App\Application\Actions\Home;

use App\Application\Actions\Action;
use App\Models\User\UserModel;
use Psr\Http\Message\ResponseInterface as Response;

class ViewHomeAction extends Action
{




    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        
    
    $user = new UserModel($this->logger, $this->connection);

    $users = $user->users();

        return $this->view->render(
            $this->response,
            'home.twig',
            [ 'users' => $users['data'] ]
        );
       

    }

}
