<?php

declare(strict_types=1);

namespace App\Application\Actions\EmployeeOS;


use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Employee\EmployeeOSModel;

class EndUserOSAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        if($data["end_date"] != null && $data["end_date"] > $data["start_date"]) {
           EmployeeOSModel::setEndEmployeeOS((int)$data["c_id"], $data["end_date"]);          
        } else {
            $this->msgError(error: "end date should be grater than start date");
        }
        
        return $this->response
         ->withHeader('Location', '/employee/assigne_position/'.$data["employee_no"])
         ->withStatus(302); 
    }
}