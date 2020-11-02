<?php

namespace App\Order\UI;

use App\Order\Application\OrderDetailUseCase;
use App\Order\Domain\Exception\OrderRecordNotFountException;
use App\Order\Domain\ValueObject\OrderId;
use App\Responder\JsonResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OrderAction
{
    /**
     * @var JsonResponder
     */
    private $jsonResponder;
    /**
     * @var OrderDetailUseCase
     */
    private $orderDetailUseCase;

    public function __construct(
        OrderDetailUseCase $orderDetailUseCase,
        JsonResponder $jsonResponder
    ) {
        $this->jsonResponder = $jsonResponder;
        $this->orderDetailUseCase = $orderDetailUseCase;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ): ResponseInterface {
        $orderId = new OrderId($args['id']);

        try {
            $orderAggregate = $this->orderDetailUseCase->findOrderDetail($orderId);

            return $this->jsonResponder->successResponse($response, $orderAggregate);
        } catch (OrderRecordNotFountException $exception) {
            return $this->jsonResponder->notFountResponse($response);
        }
    }
}
