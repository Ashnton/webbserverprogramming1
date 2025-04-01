<?php

session_start();

require __DIR__ . '/../../../../dbconnect.php';
require_once __DIR__  . '/../../functions/test_inputs.php';
require_once __DIR__ . '/../../incl/classes/Order.php';
require_once __DIR__ . '/../../incl/classes/Item.php';

test_all($_POST);

// Hämta restaurangens id som är kopplat till den item som beställs
$stmt = $dbconn->prepare("SELECT restaurant_id, item_price FROM slutprojekt_menu_items WHERE id = ?");
$stmt->execute([$_POST["item_id"]]);
while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $restaurant_id = $res["restaurant_id"];
    $item_price = $res["item_price"];
}

$new_order = Order::create_new($_POST["item_id"], $_SESSION["id"], $restaurant_id, "Order placerad", $item_price);

// TODO: Implementera kontroll om användaren redan beställt mat under den senaste minuten.
$stmt = $dbconn->prepare("INSERT INTO slutprojekt_orders (item_id, customer_id, restaurant_id, status, price, token) VALUES (?, ?, ?, ?, ?, ?)");
$params = [$new_order->get_item_id(), $new_order->get_customer_id(), $new_order->get_restaurant_id(), $new_order->get_status(), $new_order->get_price(), $new_order->get_token()];
if ($stmt->execute($params)) {
    echo 'success';
}
