<?php

namespace App\Order\Application;

use App\Order\Application\DTO\OrderDetaiResponselDTO;
use App\Order\Domain\Entity\OrderAggregate;
use App\Order\Domain\Repository\OrderRepository;
use App\Order\Domain\ValueObject\OrderId;

class OrderDetailUseCase
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function findOrderDetail(OrderId $orderId): OrderDetaiResponselDTO
    {
        $order = $this->orderRepository->findOrderById($orderId);

        $orderLines = $this->orderRepository->findOrderLines($orderId);

        return new OrderDetaiResponselDTO($order, $orderLines);
    }
}