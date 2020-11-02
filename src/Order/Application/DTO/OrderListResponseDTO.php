<?php

namespace App\Order\Application\DTO;

use App\Order\Domain\Entity\Order;

class OrderListResponseDTO implements \JsonSerializable
{
    /**
     * @var int
     */
    private $total;
    /**
     * @var Order[]
     */
    private $orders;

    public function __construct(
        int $total,
        array $orders
    ) {
        $this->total = $total;
        $this->orders = $orders;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return Order
     */
    public function getOrders(): Order
    {
        return $this->orders;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'total' => $this->total,
            'orders' => $this->orders
        ];
    }
}