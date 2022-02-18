<?php

declare(strict_types=1);

namespace Todos\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class TodosDeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container) : TodosDeleteHandler
    {
        $entityManager = $container->get(EntityManager::class);
        return new TodosDeleteHandler($entityManager);
    }
}
