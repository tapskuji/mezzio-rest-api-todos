<?php

declare(strict_types=1);

namespace Todos\Handler;

use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Todos\Entity\Todo;

class TodosReadHandler implements RequestHandlerInterface
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = $request->getAttribute('id', null);

        if (!isset($id)) {
            $response['error']['code'] = 400;
            $response['error']['message'] = 'Missing attribute id.';
            return new JsonResponse($response, 400);
        }

        try {
            $repository = $this->entityManager->getRepository(Todo::class);
            $entity = $repository->find($id);
        } catch (ORMException | \Exception $e) {
            //ORMException $e->getMessage(); log data
            $response['error']['code'] = 500;
            $response['error']['message'] = 'Internal Server Error';
            return new JsonResponse($response, 500);
        }

        if (empty($entity)) {
            $response['error']['code'] = 404;
            $response['error']['message'] = 'Todo with id '.$id.' not found.';
            return new JsonResponse($response, 404);
        }

        $doctrineObject = new DoctrineObject($this->entityManager);
        $response = $doctrineObject->extract($entity);
        $response['isComplete'] = $response['isComplete'] ? true : false;
        return new JsonResponse($response);
    }
}
