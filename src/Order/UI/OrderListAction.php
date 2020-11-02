<?php

namespace App\Order\UI;

use App\Order\Application\OrderListUseCase;
use App\Order\Domain\ValueObject\Page;
use App\Order\Domain\ValueObject\SortBy;
use App\Responder\JsonResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OrderListAction
{
    /**
     * @var JsonResponder
     */
    private $jsonResponder;
    /**
     * @var OrderListUseCase
     */
    private $orderListUseCase;

    public function __construct(
        OrderListUseCase $orderListUseCase,
        JsonResponder $jsonResponder
    ) {
        $this->orderListUseCase = $orderListUseCase;
        $this->jsonResponder = $jsonResponder;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ): ResponseInterface {
        $queryParams = $request->getQueryParams();

        try {
            $page = new Page(
                $queryParams['skip'] ?? 0,
                $queryParams['limit'] ?? 10
            );

            $sortBy = new SortBy(
                $queryParams['field'] ?? null,
                $queryParams['direction'] ?? null
            );

            $orderListDto = $this->orderListUseCase->findAllOrders(
                $sortBy,
                $page
            );

            return $this->jsonResponder->successResponse(
                $response,
                $orderListDto
            );
        } catch (\InvalidArgumentException $exception) {
            return $this->jsonResponder->badRequestResponse(
                $response,
                $exception->getMessage()
            );
        }
    }
}
