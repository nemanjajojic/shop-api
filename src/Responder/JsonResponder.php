<?php

namespace App\Responder;

use Psr\Http\Message\ResponseInterface;

class JsonResponder
{
    public function successResponse(
        ResponseInterface $response, $payload): ResponseInterface {
        $response->getBody()->write(
            json_encode(
                [
                    'data' => $payload
                ]
            )
        );

        return $this->response($response, 200);

    }

    public function badRequestResponse(
        ResponseInterface $response,
        string $error,
        int $statusCode = 422
    ): ResponseInterface {
        $response->getBody()->write(
            json_encode(
                [
                    'errors' => [
                        'error' => $error
                    ]
                ]
            )
        );

        return $this->response($response, $statusCode);

    }

    public function notFountResponse(ResponseInterface $response)
    {
        return $this->response($response, 404);
    }

    private function response(ResponseInterface $response, int $statusCode): ResponseInterface
    {
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }
}