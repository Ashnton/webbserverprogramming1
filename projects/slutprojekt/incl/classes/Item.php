<?php

class Menu_Item 
{
    private ?int $item_id;
    private int $restaurant_id;
    private string $item_name;
    private string $item_description;
    private string $item_price;
    private int $item_enabled;
    private string $item_image;

    public function __construct(int $restaurant_id, string $item_name, string $item_description, string $item_price, int $item_enabled, string $item_image, ?int $item_id = null)
    {
        $this->restaurant_id = $restaurant_id;
        $this->item_name = $item_name;
        $this->item_description = $item_description;
        $this->item_price = $item_price;
        $this->item_enabled = $item_enabled;
        $this->item_image = $item_image;
        $this->item_id = $item_id; 
    }

    public static function create_new(int $restaurant_id, string $item_name, string $item_description, string $item_price, int $item_enabled, string $item_image) {
        return new self($restaurant_id, $item_name, $item_description, $item_price, $item_enabled, $item_image);
    }

    public static function init_from_db(int $restaurant_id, string $item_name, string $item_description, string $item_price, int $item_enabled, string $item_image, int $item_id) {
        return new self($restaurant_id, $item_name, $item_description, $item_price, $item_enabled, $item_image, $item_id);
    }
}
