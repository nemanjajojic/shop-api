<?php

namespace App\Order\UI;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OpenApiDocAction
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ): ResponseInterface
    {
        $swaggerDoc = \OpenApi\scan(__DIR__ . '/../../../swagger-doc');

        $response->getBody()->write($swaggerDoc->toJson(JSON_PRETTY_PRINT));

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}