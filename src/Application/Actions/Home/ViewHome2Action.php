<?php

declare(strict_types=1);

namespace App\Application\Actions\Home;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class ViewHome2Action extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        
        $this->logger->info("Home list was viewed.");

        return $this->respondWithData("home2-index");
    }

}
