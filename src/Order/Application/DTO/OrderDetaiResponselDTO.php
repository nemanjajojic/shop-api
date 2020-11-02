<?php

namespace App\Order\Application\DTO;

use App\Order\Domain\Entity\Order;
use App\Order\Domain\Entity\OrderLine;
use JsonSerializable;

class OrderDetaiResponselDTO implements JsonSerializable
{
    /**
     * @var Order
     */
    private $order;
    /**
     * @var OrderLine[]
     */
    private $orderLines;

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @return OrderLine
     */
    public function getOrderLines(): OrderLine
    {
        return $this->orderLines;
    }

    public function __construct(
        Order $order,
        array $orderLines
    ) {
        $this->order = $order;
        $this->orderLines = $orderLines;
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
            'order'      => $this->order,
            'orderLines' => $this->orderLines,
        ];
    }
}