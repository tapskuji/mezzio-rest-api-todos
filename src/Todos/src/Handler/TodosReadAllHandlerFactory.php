<?php

declare(strict_types=1);

namespace Todos\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class TodosReadAllHandlerFactory
{
    public function __invoke(ContainerInterface $container) : TodosReadAllHandler
    {
        $entityManager = $container->get(EntityManager::class);
        return new TodosReadAllHandler($entityManager);
    }
}
