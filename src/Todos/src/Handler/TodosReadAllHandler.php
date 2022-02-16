<?php

declare(strict_types=1);

namespace Todos\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TodosReadAllHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Create and return a response
        $response['status'] = 200;
        $response['message'] = 'Hello World.';
        return new JsonResponse($response);
    }
}
