<?php

declare(strict_types=1);


use App\Application\Middleware\BasicInfoMiddleware;
use App\Application\Middleware\CanPermissionsMiddleware;
use App\Application\Middleware\ErrorMiddleware;
use App\Application\Middleware\MenuItemsMiddleware;
use App\Application\Middleware\OtherMiddleware;
use App\Application\Middleware\SuccessMiddleware;
use Slim\App;


use App\Application\Middleware\LookupMiddleware;
use App\Application\Middleware\CsrfFieldsMiddleware;
use App\Application\Middleware\OldFormDataMiddleware;
use App\Application\Middleware\StartSessionsMiddleware;
use App\Application\Middleware\ValidationErrorsMiddleware;
use App\Application\Middleware\ValidationExceptionMiddleware;

return function (App $app) {
    $app->add(CsrfFieldsMiddleware::class);
    $app->add('csrf');

    $app->add(ValidationErrorsMiddleware::class);
    $app->add(ValidationExceptionMiddleware::class);
    $app->add(OldFormDataMiddleware::class);
    $app->add(LookupMiddleware::class);
    $app->add(ErrorMiddleware::class);
    $app->add(SuccessMiddleware::class);
    $app->add(CanPermissionsMiddleware::class);
    $app->add(MenuItemsMiddleware::class);
    $app->add(BasicInfoMiddleware::class);

    $app->add(StartSessionsMiddleware::class);
    $app->addBodyParsingMiddleware();

};
