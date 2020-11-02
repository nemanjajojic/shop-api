<?php

namespace App\Order\Domain\Repository;

use App\Order\Domain\Entity\Order;
use App\Order\Domain\Entity\OrderLine;
use App\Order\Domain\Exception\OrderRecordNotFountException;
use App\Order\Domain\ValueObject\OrderId;
use App\Order\Domain\ValueObject\Page;
use App\Order\Domain\ValueObject\SortBy;

interface OrderRepository
{
    /**
     * @param SortBy $sortBy
     * @param Page $page
     *
     * @return Order[]
     */
    public function findAllOrders(
        SortBy $sortBy,
        Page $page
    ): array;

    /**
     * @param OrderId $orderId
     *
     * @return Order
     *
     * @throws OrderRecordNotFountException
     */
    public function findOrderById(OrderId $orderId): Order;

    /**
     * @return int
     */
    public function totalOrderCount(): int;

    /**
     * @param OrderId $orderId
     *
     * @return OrderLine[]
     */
    public function findOrderLines(OrderId $orderId): array;
}
