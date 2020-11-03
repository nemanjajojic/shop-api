<?php

/**
 *
 * @OA\Get(
 *     path="/api/v1/orders",
 *     summary="Return an array of orders",
 *     description="Return list of all orders",
 *     tags={"Orders"},
 *     parameters={
 *          @OA\Parameter(ref="#/components/parameters/field"),
 *          @OA\Parameter(ref="#/components/parameters/direction"),
 *          @OA\Parameter(ref="#/components/parameters/skip"),
 *          @OA\Parameter(ref="#/components/parameters/limit")
 *     },
 *     @OA\Response(
 *          response="200",
 *          description="Succesuful",
 *          @OA\JsonContent(ref="#/components/schemas/DataList")
 *     ),
 *     @OA\Response(
 *          response="422",
 *          description="Bad request",
 *          @OA\JsonContent(ref="#/components/schemas/Errors")
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/v1/orders/{id}",
 *     summary="Return order by id",
 *     description="Return order by id",
 *     tags={"Orders"},
 *     @OA\Parameter(
 *          name="id",
 *          description="Order id",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *          in="path"
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Succesuful",
 *          @OA\JsonContent(ref="#/components/schemas/DataOrder")
 *     ),
 *     @OA\Response(
 *          response="404",
 *          description="Order not found"
 *     )
 * )
 *
 * @OA\Parameter(
 *   parameter="field",
 *   name="field",
 *   description="Field you wanna sort results. Available options: totalAmount and createdAt",
 *   @OA\Schema(
 *     type="string",
 *   ),
 *   in="query"
 * )
 *
 * @OA\Parameter(
 *   parameter="skip",
 *   name="skip",
 *   description="Number of items you wanna skip",
 *   @OA\Schema(
 *     minimum=0,
 *     type="integer",
 *   ),
 *   in="query"
 * )
 *
 * @OA\Parameter(
 *   parameter="limit",
 *   name="limit",
 *   description="Max number of items you'll get per request",
 *   @OA\Schema(
 *     minimum=1,
 *     maximum=30,
 *     type="integer",
 *   ),
 *   in="query"
 * )
 *
 * @OA\Parameter(
 *   parameter="direction",
 *   name="direction",
 *   description="Choose sort direction. Available options: asc and desc",
 *   @OA\Schema(
 *     type="string",
 *   ),
 *   in="query"
 * )
 *
 * @OA\Schema(
 *   schema="DataList",
 *   type="object",
 *   description="Data object wrapper for order list",
 *   @OA\Property(property="data", ref="#/components/schemas/OrderList")
 * )
 *
 * @OA\Schema(
 *   schema="OrderList",
 *   type="object",
 *   description="Entity for list of orders",
 *   @OA\Property(property="total", type="integer", description="Total amount of orders."),
 *   @OA\Property(
 *     property="orders",
 *     type="array",
 *     items={
 *          "$ref"="#/components/schemas/Order"
 *     }
 *   )
 * )
 *
 * @OA\Schema(
 *   schema="DataOrder",
 *   type="object",
 *   description="Data object wrapper for single order",
 *   @OA\Property(property="data", ref="#/components/schemas/OrderAndOrderLines")
 * )
 *
 *@OA\Schema(
 *  schema="OrderAndOrderLines",
 *  type="object",
 *  description="Order object wrapper",
 *  @OA\Property(property="order", ref="#/components/schemas/Order"),
 *  @OA\Property(
 *     property="orderLines",
 *     type="array",
 *     items={
 *          "$ref"="#/components/schemas/OrderLines"
 *     }
 *   )
 * )
 *
 * @OA\Schema(
 *   schema="Order",
 *   type="object",
 *   description="Entity for listo of orders",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="totalAmount", type="integer"),
 *   @OA\Property(property="isActive", type="boolean"),
 *   @OA\Property(property="hostName", type="string"),
 *   @OA\Property(property="createdAt", type="string"),
 *   @OA\Property(property="billingStatus", ref="#/components/schemas/BillingStatus"),
 *   @OA\Property(property="billingAddress", ref="#/components/schemas/OrderAddress"),
 *   @OA\Property(property="deliveryAddress", ref="#/components/schemas/OrderAddress")
 * )
 *
 * @OA\Schema(
 *   schema="BillingStatus",
 *   type="object",
 *   description="Entity for biling status",
 *   @OA\Property(property="status", type="string"),
 * )
 *
 * @OA\Schema(
 *   schema="OrderAddress",
 *   type="object",
 *   description="Entity for billing and delivery address",
 *   @OA\Property(property="title", type="string"),
 *   @OA\Property(property="company", type="string"),
 *   @OA\Property(property="firstname", type="string"),
 *   @OA\Property(property="lastname", type="string"),
 *   @OA\Property(property="email", type="string"),
 *   @OA\Property(property="address", type="string"),
 *   @OA\Property(property="otherAddress", type="string"),
 *   @OA\Property(property="zip", type="integer"),
 *   @OA\Property(property="location", type="string"),
 *   @OA\Property(property="phoneNUmber", type="string"),
 * )
 *
 * @OA\Schema(
 *   schema="OrderLines",
 *   type="object",
 *   description="Entity for order lines",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="price", type="integer"),
 *   @OA\Property(property="quantity", type="integer"),
 *   @OA\Property(property="tax", type="integer"),
 *   @OA\Property(property="status", type="string"),
 *   @OA\Property(property="title", type="string")
 * )
 *
 * @OA\Schema(
 *   schema="Errors",
 *   type="object",
 *   description="API errors",
 *   @OA\Property(property="errors", ref="#/components/schemas/Error")
 * )
 *
 * @OA\Schema(
 *   schema="Error",
 *   type="object",
 *   description="API error",
 *   @OA\Property(property="error", type="string")
 * )
 */