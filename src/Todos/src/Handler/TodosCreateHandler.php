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

class TodosCreateHandler implements RequestHandlerInterface
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $requestBody = $request->getParsedBody();
        if (empty($requestBody)) {
            $response['error']['error'] = 400;
            $response['error']['message'] = 'Missing request body.';
            return new JsonResponse($response, 400);
        }

        $entity = new Todo();

        try {
            $entity->setTodo($requestBody);
            $this->entityManager->persist($entity);
            $this->entityManager->flush(); // inserts the record in database
        } catch (ORMException | \Exception $e) {
            // log error message $e->getMessage()
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
