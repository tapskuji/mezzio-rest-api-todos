<?php

declare(strict_types=1);

namespace Todos\Handler;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Todos\Entity\Todo;

class TodosReadAllHandler implements RequestHandlerInterface
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $repository = $this->entityManager->getRepository(Todo::class);
        $query = $repository->createQueryBuilder('t')->getQuery();
        $paginator = new Paginator($query);
        $entities = $paginator->getQuery()->getResult(Query::HYDRATE_ARRAY);

        $response = [];

        foreach ($entities as $index => $entity) {
            $entity['isComplete'] = $entity['isComplete'] ? true : false;
            $response[$index] = $entity;
        }

        return new JsonResponse($response);
    }
}
