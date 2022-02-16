<?php

declare(strict_types=1);

namespace Todos\Handler;

use Psr\Container\ContainerInterface;

class TodosReadAllHandlerFactory
{
    public function __invoke(ContainerInterface $container) : TodosReadAllHandler
    {
        return new TodosReadAllHandler();
    }
}
