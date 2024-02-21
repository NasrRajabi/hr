<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Models\User\UserModel;
use Psr\Http\Message\ResponseInterface as Response;

class SaveUserAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $data = $this->request->getParsedBody();
        $data['password'] = password_hash($data['password'],PASSWORD_BCRYPT, ['cost'=> 12]);
        $UserModel = new UserModel($this->logger, $this->connection);
        dd($data);
        $UserModel->addUser($data);
        return $this->view->render(
            $this->response,
            'users/add.twig',
      
        );
    }
}
