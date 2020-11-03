<?php

namespace App\Order\Infrastructure\Persistence;

use App\Order\Domain\Entity\BillingStatus;
use App\Order\Domain\Entity\Order;
use App\Order\Domain\Entity\OrderAddress;
use App\Order\Domain\Entity\OrderAggregate;
use App\Order\Domain\Entity\OrderLine;
use App\Order\Domain\Exception\OrderRecordNotFountException;
use App\Order\Domain\Repository\OrderRepository;
use App\Order\Domain\ValueObject\OrderId;
use App\Order\Domain\ValueObject\Page;
use App\Order\Domain\ValueObject\SortBy;
use PDO;

class MysqlOrderRepository implements OrderRepository
{
    /**
     * @var PDO
     */
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritdoc
     */
    public function findAllOrders(
        SortBy $sortBy,
        Page $page
    ): array {
        $limit = $page->getLimit();
        $skip = $page->getSkip();
        $fieldName = $sortBy->getFieldName();
        $direction = $sortBy->getDirection();

        $sql = "SELECT 
                    ID,
                    total,
                    active,
                    created_at,
                    (
                        SELECT host
                        FROM t_hosts
                        WHERE id = o.host_id
                    ) as host_name
                FROM t_orders AS o
                ORDER BY $fieldName $direction
                LIMIT :limit OFFSET :skip";
        // todo: add where host=? if needed to fetch orders per host

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $statement->bindParam(':skip', $skip, \PDO::PARAM_INT);

        $statement->execute();

        $results = $statement->fetchAll();

        $orders = [];
        foreach ($results as $result) {
            $order = new Order();
            $order->setOrderId($result['ID']);
            $order->setTotalAmount($result['total']);
            $order->setIsActive($result['active']);
            $order->setHostName($result['host_name']);
            $order->setCreatedAt($result['created_at']);

            $orders[] = $order;
        }

        return $orders;
    }

    /**
     * @inheritdoc
     */
    public function findOrderById(OrderId $id): Order
    {
        $sql = "
            SELECT 
                o.ID as orderId,
                o.total, 
                o.active,
                o.created_at,
                o.cancellation_date,
                bs.status_0,
                ba.ID as billingAddressId,
                ba.company,
                ba.firstname,
                ba.lastname,
                ba.email,
                ba.address_1,
                ba.address_2,
                ba.zip,
                ba.location,
                ba.phone,
                da.ID as deliveryAddressId,  
                da.company as deliveryAddressCompany,
                da.firstname as deliveryAddressFirstname,
                da.lastname as deliveryAddressLastname,
                da.email as deliveryAddressEmail,
                da.address_1 as deliveryAddress1,
                da.address_2 as deliveryAddress2,
                da.zip as deliveryAddressZip,
                da.location as deliveryAddressLocation,
                da.phone as deliveryAddressPhone
            FROM t_orders as o
            INNER JOIN t_billing_status bs ON o.billing_status_id=bs.ID
            INNER JOIN t_address ba ON o.billing_address_id=ba.ID
            LEFT JOIN t_address da ON o.delivery_address_id=da.ID
            WHERE o.ID=:id
        ";

        // todo: add where host=? if needed to fetch orders per host

        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $id->getId()]);

        $result = $statement->fetch();

        if (!$result) {
            throw new OrderRecordNotFountException('Order with given id does not exist.');
        }

        $order = new Order();
        $order->setOrderId($result['orderId']);
        $order->setTotalAmount($result['total']);
        $order->setIsActive($result['active']);
        $order->setCreatedAt($result['created_at']);
        $order->setCancellationDate($result['cancellation_date']);
        $order->setBillingStatus($result['status_0']);

        $billingAddress = new OrderAddress();
//        $billingAddress->setId($result['billingAddressId']);
        $billingAddress->setCompany($result['company']);
        $billingAddress->setFirstname($result['firstname']);
        $billingAddress->setLastname($result['lastname']);
        $billingAddress->setEmail($result['email']);
        $billingAddress->setAddress1($result['address_1']);
        $billingAddress->setAddress2($result['address_2']);
        $billingAddress->setZip($result['zip']);
        $billingAddress->setLocation($result['location']);
        $billingAddress->setPhoneNumber($result['phone']);

        $deliveryAddress = new OrderAddress();
//        $deliveryAddress->setId($result['deliveryAddressId']);
        $deliveryAddress->setCompany($result['deliveryAddressCompany']);
        $deliveryAddress->setFirstname($result['deliveryAddressFirstname']);
        $deliveryAddress->setLastname($result['deliveryAddressLastname']);
        $deliveryAddress->setEmail($result['deliveryAddressEmail']);
        $deliveryAddress->setAddress1($result['deliveryAddress1']);
        $deliveryAddress->setAddress2($result['deliveryAddress2']);
        $deliveryAddress->setZip($result['deliveryAddressZip']);
        $deliveryAddress->setLocation($result['deliveryAddressLocation']);
        $deliveryAddress->setPhoneNumber($result['deliveryAddressPhone']);

        $order->setBillingAddress($billingAddress);
        $order->setDeliveryAddress($deliveryAddress);

        return $order;

    }

    /**
     * @inheritdoc
     */
    public function totalOrderCount(): int
    {
        $sql = "SELECT COUNT(id) as total
                FROM t_orders";
        // todo: add where host=? if needed to fetch orders per host

        $result = $this->connection->query($sql)->fetch();

        return $result['total'];
    }

    /**
     * @inheritdoc
     */
    public function findOrderLines(OrderId $orderId): array
    {
        $sql = "
            SELECT
                ol.ID,
                ol.price, 
                ol.quantity,
                ss.status_0,
                (
                    SELECT
                        tax 
                    FROM t_taxes
                    WHERE t_taxes.ID = ol.taxID
                ) AS tax,
                (
                    SELECT 
                        title
                    FROM t_article_verticals AS av
                    WHERE ol.article_id = av.article_id
                    AND ol.host_id = av.host_id
                ) AS title
            FROM t_order_lines AS ol
            LEFT JOIN t_shipping_status AS ss ON ss.ID = ol.shipping_status_id
            WHERE ol.orderID = :orderId AND ol.active = 1
        ";

        //todo: if needed pass active as filter param

        $statement = $this->connection->prepare($sql);
        $statement->execute(['orderId' => $orderId->getId()]);

        $results = $statement->fetchAll();

        $orderLines = [];
        foreach ($results as $result) {
            $orderLine = new OrderLine();
            $orderLine->setId($result['ID']);
            $orderLine->setPrice($result['price']);
            $orderLine->setQuantity($result['quantity']);
            $orderLine->setStatus($result['status_0']);
            $orderLine->setTax($result['tax']);
            $orderLine->setTitle($result['title']);

            $orderLines[] = $orderLine;
        }

        return $orderLines;
    }
}