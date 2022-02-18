<?php

namespace Todos;

use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    /**
     * @param ContainerInterface $container
     * @param string $serviceName Name of the service being created.
     * @param callable $callback Creates and returns the service.
     * @return Application
     */
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback)
    {
        /** @var $app Application */
        $app = $callback();

        /* Setup routes here */
        // create
        $app->post('/api/todos', Handler\TodosCreateHandler::class, 'api.todos.create');
        // read
        $app->get('/api/todos[/]', Handler\TodosReadAllHandler::class, 'api.todos.list');
        $app->get('/api/todos/id={id:\d+}', Handler\TodosReadHandler::class, 'api.todos.read');
        // update
        $app->put('/api/todos/id={id:\d+}', Handler\TodosUpdateHandler::class, 'api.todos.update');
        // delete

        return $app;
    }
}
