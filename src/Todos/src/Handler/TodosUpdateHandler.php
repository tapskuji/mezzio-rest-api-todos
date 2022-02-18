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

class TodosUpdateHandler implements RequestHandlerInterface
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = $request->getAttribute('id', null);
        $requestBody = $request->getParsedBody();

        if (empty($requestBody)) {
            $response['error']['error'] = 400;
            $response['error']['message'] = 'Missing request body.';
            return new JsonResponse($response, 400);
        }

        if (empty($id)) {
            $response['error']['code'] = 400;
            $response['error']['message'] = 'Missing attribute id.';
            return new JsonResponse($response, 400);
        }

        $repository = $this->entityManager->getRepository(Todo::class);
        $entity = $repository->find($id);

        if (empty($entity)) {
            $response['error']['code'] = 404;
            $response['error']['message'] = 'Record not found.';
            return new JsonResponse($response, 404);
        }

        try {
            $entity->updateTodo($requestBody);
            $this->entityManager->merge($entity);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            $response['error']['error'] = 500;
            $response['error']['message'] = 'Internal server error.';
            return new JsonResponse($response, 500);
        }

        // extract array
        $doctrineObject = new DoctrineObject($this->entityManager);
        $response = $doctrineObject->extract($entity);
        $response['isComplete'] = $response['isComplete'] ? true : false;
        return new JsonResponse($response, 201);
    }
}
