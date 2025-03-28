<?php

session_start();

require __DIR__ . '/../../../../dbconnect.php';
require_once __DIR__  . '/../../functions/test_inputs.php';
require_once __DIR__ . '/../../incl/classes/Order.php';
require_once __DIR__ . '/../../incl/classes/Item.php';

test_all($_POST);

Order::create_new($_POST["item_id"], $_SESSION["id"], );

// TODO: Implementera kontroll om användaren redan beställt mat under den senaste minuten.

$stmt = $conn->prepare("INSERT INTO slutprojekt_orders (item_id, customer_id, restaurant_id, status, price, token) VALUES (?, ?, ?, ?, ?, ?)");
$stmt -> bind_param("iiisss", );