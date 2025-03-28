<?php

class Order
{
    private ?int $order_id;
    private int $item_id;
    private int $customer_id;
    private int $restaurant_id;
    private string $status;
    private string $price;
    private string $token;
    private ?string $created_at;

    public function __construct(int $item_id, int $customer_id, int $restaurant_id, string $status, string $price, string $token, ?int $order_id = null, ?string $created_at = null)
    {
        $this->order_id = $order_id;
        $this->item_id = $item_id;
        $this->customer_id = $customer_id;
        $this->restaurant_id = $restaurant_id;
        $this->status = $status;
        $this->price = $price;
        $this->token = $token;
        $this->created_at = $created_at;
    }

    // Statiska metoder för att initiera nya instanser av klassen
    public static function create_new(int $item_id, int $customer_id, int $restaurant_id, string $status, string $price)
    {
        $token = bin2hex(random_bytes(20));
        return new self($item_id, $customer_id, $restaurant_id, $status, $price, $token);
    }

    public static function init_from_db(int $item_id, int $customer_id, int $restaurant_id, string $status, string $price, string $token, int $order_id, string $created_at) 
    {
        return new self($item_id, $customer_id, $restaurant_id, $status, $price, $token, $order_id, $created_at);
    }

    // Metoder för att hämta data
}
