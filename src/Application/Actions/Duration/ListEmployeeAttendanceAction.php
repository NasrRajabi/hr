<?php

declare(strict_types=1);

namespace App\Application\Actions\Duration;

use App\Application\Actions\Action;
use App\Application\Actions\Shared\Calendar;
use App\Models\AttendanceAgreements\AgreementModel;
use App\Models\Duration\DurationListModel;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response;

class ListEmployeeAttendanceAction extends Action
{
    use Calendar;
    protected function action(): Response 
   { 

    // dd($this->getCalendar((int) $this->args["id"]));
        return $this->view->render(
            $this->response,
            'duration/emp_att_calendar.twig',
      
          $this->getCalendar((int) $this->args["id"])
        
        );
    }
    

   
    
}
