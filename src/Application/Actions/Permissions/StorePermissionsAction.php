<?php
declare(strict_types=1);
namespace App\Application\Actions\Permissions;

use App\Application\Actions\Action;
use App\Models\Permissions\PermissionsModel;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Permissions\PermissionsRequestValidator;

class StorePermissionsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $temp = $this->request->getParsedBody();
        $temp["id"] = 0;
        $data = $this->requestValidatorFactory->make(PermissionsRequestValidator::class)->validate($temp);
        PermissionsModel::store($data['key'], $data['group_name'], $data['description']);  
        
        return $this->response
         ->withHeader('Location', '/permissions')
         ->withStatus(302);     
    }
}