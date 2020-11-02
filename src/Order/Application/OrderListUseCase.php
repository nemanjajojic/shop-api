<?php

namespace App\Order\Application;

use App\Order\Application\DTO\OrderListResponseDTO;
use App\Order\Domain\Repository\OrderRepository;
use App\Order\Domain\ValueObject\Page;
use App\Order\Domain\ValueObject\SortBy;

class OrderListUseCase
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function findAllOrders(
        SortBy $sortBy,
        Page $page
    ): OrderListResponseDTO {
        $total = $this->orderRepository->totalOrderCount();
        $orders = $this->orderRepository->findAllOrders($sortBy, $page);

        return new OrderListResponseDTO($total, $orders);
    }
}