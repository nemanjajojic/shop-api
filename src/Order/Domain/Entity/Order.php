<?php

namespace App\Order\Domain\Entity;

class Order implements \JsonSerializable
{
    /**
     * @var int
     */
    private $orderId;
    /**
     * @var int
     */
    private $totalAmount;
    /**
     * @var bool
     */
    private $isActive;
    /**
     * @var string
     */
    private $hostName;
    /**
     * @var string
     */
    private $createdAt;
    /**
     * @var null|string
     */
    private $cancellationDate;
    /**
     * @var BillingStatus
     */
    private $billingStatus;
    /**
     * @var OrderAddress
     */
    private $billingAddress;
    /**
     * @var OrderAddress
     */
    private $deliveryAddress;

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @param int $totalAmount
     */
    public function setTotalAmount(int $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string|null
     */
    public function getCancellationDate(): ?string
    {
        return $this->cancellationDate;
    }

    /**
     * @param string|null $cancellationDate
     */
    public function setCancellationDate(?string $cancellationDate): void
    {
        $this->cancellationDate = $cancellationDate;
    }

    /**
     * @param string $hostName
     */
    public function setHostName(string $hostName): void
    {
        $this->hostName = $hostName;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return BillingStatus
     */
    public function getBillingStatus(): BillingStatus
    {
        return $this->billingStatus;
    }

    /**
     * @param BillingStatus $billingStatus
     */
    public function setBillingStatus(BillingStatus $billingStatus): void
    {
        $this->billingStatus = $billingStatus;
    }

    /**
     * @return OrderAddress
     */
    public function getBillingAddress(): OrderAddress
    {
        return $this->billingAddress;
    }

    /**
     * @param OrderAddress $billingAddress
     */
    public function setBillingAddress(OrderAddress $billingAddress): void
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return OrderAddress
     */
    public function getDeliveryAddress(): OrderAddress
    {
        return $this->deliveryAddress;
    }

    /**
     * @param OrderAddress $deliveryAddress
     */
    public function setDeliveryAddress(OrderAddress $deliveryAddress): void
    {
        $this->deliveryAddress = $deliveryAddress;
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
            'id'              => $this->orderId,
            'totalAmount'     => $this->totalAmount,
            'isActive'        => $this->isActive,
            'hostName'        => $this->hostName,
            'createdAt'       => $this->createdAt,
            'billingStatus'   => $this->billingStatus,
            'billingAddress'  => $this->billingAddress,
            'deliveryAddress' => $this->deliveryAddress
        ];
    }
}
