<?php

declare(strict_types=1);

namespace App\Application\Actions\Dashboard;

use App\Application\Actions\Action;
use App\Application\Actions\Shared\Calendar;
use Psr\Http\Message\ResponseInterface as Response;

class ViewDashboardAction extends Action
{
    use Calendar;
    protected function action(): Response
    {
       // dd(\xdebug_info());
      // dd($this->getCalendar((int) $this->session->get('user_id')));
        return $this->view->render(
            $this->response,
            'dashboard/employee_dash.twig',
            $this->getCalendar((int) $this->session->get('user_id'))
        
        );
    }

}
