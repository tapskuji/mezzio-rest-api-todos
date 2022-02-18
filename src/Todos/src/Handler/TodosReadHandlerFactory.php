<?php

declare(strict_types=1);

namespace Todos\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class TodosReadHandlerFactory
{
    public function __invoke(ContainerInterface $container) : TodosReadHandler
    {
        $entityManager = $container->get(EntityManager::class);
        return new TodosReadHandler($entityManager);
    }
}
