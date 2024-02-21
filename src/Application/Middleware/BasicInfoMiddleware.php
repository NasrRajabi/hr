<?php

declare(strict_types = 1);

namespace App\Application\Middleware;

use App\Contracts\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

readonly class BasicInfoMiddleware implements MiddlewareInterface
{
    public function __construct(
        private Twig             $twig,
        private SessionInterface $session
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $basicInfo['basicInfo'] =[
                'user_id'=>$this->session->get('user_id'),
                'f_name'=>$this->session->get('f_name'),
                's_name'=>$this->session->get('s_name'),
                't_name'=>$this->session->get('t_name'),
                'l_name'=>$this->session->get('l_name'),
                'gender'=>$this->session->get('gender'),
                'religion'=>$this->session->get('religion'),
                'birthday'=>$this->session->get('birthday'),
                'birthplace'=>$this->session->get('birthplace'),
                'nationality'=>$this->session->get('nationality'),
                'national_id'=>$this->session->get('national_id'),
                'passport_no'=>$this->session->get('passport_no'),
                'marital_status'=>$this->session->get('marital_status'),
                'disability'=>$this->session->get('disability'),
                'avatar'=>$this->session->get('avatar'),
                'secret_key'=>$this->session->get('secret_key'),
                'active'=>$this->session->get('active'),
                'lock'=>$this->session->get('lock'),
                'has_multi_oS'=>$this->session->get('has_multi_oS'),
            ];
            $this->twig->getEnvironment()->addGlobal('basicInfo', $basicInfo['basicInfo']);


        return $handler->handle($request);
    }
}