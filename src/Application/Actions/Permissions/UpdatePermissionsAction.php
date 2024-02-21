<?php
declare(strict_types=1);
namespace App\Application\Actions\Permissions;

use App\Application\Actions\Action;
use App\Models\Permissions\PermissionsModel;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Permissions\PermissionsRequestValidator;

class UpdatePermissionsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->requestValidatorFactory->make(PermissionsRequestValidator::class)->validate($this->request->getParsedBody());

        PermissionsModel::update($data['id'], $data['key'], $data['group_name'], $data['description']);

        return $this->response
         ->withHeader('Location', '/permissions')
         ->withStatus(302);        
    }
}