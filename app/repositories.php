<?php

declare(strict_types=1);

use App\Session;
use App\Models\Model;
use DI\ContainerBuilder;
use App\Contracts\ModelInterface;
use App\Contracts\SessionInterface;


return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
       // UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        SessionInterface::class => \DI\autowire(Session::class),
        ModelInterface::class => \DI\autowire(Model::class),
    ]);
};
