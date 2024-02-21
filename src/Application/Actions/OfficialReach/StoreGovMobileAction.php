<?php

declare(strict_types=1);

namespace App\Application\Actions\OfficialReach;

use App\Application\Actions\Action;
use App\Models\Employee\EmployeeContactsInfoModel;
use App\RequestValidators\OfficialReach\GovEmailRequestValidator;
use Psr\Http\Message\ResponseInterface as Response;


class StoreGovMobileAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

    
 
    //    $data = $this->request->getParsedBody();
        
         $data = $this->requestValidatorFactory->make(GovEmailRequestValidator::class)->validate($this->request->getParsedBody());

        $all = EmployeeContactsInfoModel::update_gov_email((int) $data['id'] , (string) $data['email']);
        if ($all['rowCount'] !== 1) {
            return $this->responseFormatter->asJson($this->response->withStatus(400),'asjdhajsdhgjkas');
        }
        return $this->responseFormatter->asJson($this->response, 'OK');

    }
}
