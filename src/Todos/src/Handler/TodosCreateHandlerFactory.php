<?php

declare(strict_types=1);

namespace Todos\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class TodosCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : TodosCreateHandler
    {
        $entityManager = $container->get(EntityManager::class);
        return new TodosCreateHandler($entityManager);
    }
}
