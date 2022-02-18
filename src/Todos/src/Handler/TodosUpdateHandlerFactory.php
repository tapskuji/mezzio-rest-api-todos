<?php

declare(strict_types=1);

namespace Todos\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class TodosUpdateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : TodosUpdateHandler
    {
        $entityManager = $container->get(EntityManager::class);
        return new TodosUpdateHandler($entityManager);
    }
}
