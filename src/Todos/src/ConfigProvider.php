<?php

declare(strict_types=1);

namespace Todos;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

/**
 * The configuration provider for the Todos module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'doctrine'    => $this->getDoctrineEntities(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'delegators' => [
                \Mezzio\Application::class => [
                    RoutesDelegator::class,
                ],
            ],
            'invokables' => [
            ],
            'factories'  => [
                Handler\TodosReadAllHandler::class => Handler\TodosReadAllHandlerFactory::class,
                Handler\TodosReadHandler::class => Handler\TodosReadHandlerFactory::class,
                Handler\TodosCreateHandler::class => Handler\TodosCreateHandlerFactory::class,
                Handler\TodosUpdateHandler::class => Handler\TodosUpdateHandlerFactory::class,
                Handler\TodosDeleteHandler::class => Handler\TodosDeleteHandlerFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'todos'    => [__DIR__ . '/../templates/'],
            ],
        ];
    }

    /**
     * This is a module-specific configuration
     * Maps the doctrine entity or rather
     * Contains the entity location settings
     * @return \array[][]
     */
    public function getDoctrineEntities() : array
    {
        return [
            'driver' => [
                'orm_default' => [
                    'class' => MappingDriverChain::class,
                    'drivers' => [
                        'Todos\Entity' => 'todo_entity',
                    ],
                ],
                'todo_entity' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ],
            ],
        ];
    }
}
