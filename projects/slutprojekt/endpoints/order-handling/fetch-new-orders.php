<?php
session_start();

// Professional permission check
if (empty($_SESSION["restaurant_permission"])) {
    http_response_code(403);
    echo json_encode(["error" => "Permission denied."]);
    exit;
}

require __DIR__ . '/../../../../dbconnect.php';
require_once __DIR__  . '/../../functions/test_inputs.php';
require_once __DIR__ . '/../../incl/classes/Order.php';
require_once __DIR__ . '/../../incl/classes/Item.php';  // Assuming class name

// Validate/sanitize all POST inputs (if any)
test_all($_POST);

header('Content-Type: application/json; charset=utf-8');

try {
    // 1) Fetch all new orders for this restaurant
    $stmt = $dbconn->prepare(
        'SELECT id, item_id, customer_id, restaurant_id, status, price, token, created_at
         FROM slutprojekt_orders
         WHERE restaurant_id = ?
         ORDER BY created_at DESC'
    );
    $stmt->execute([$_SESSION["restaurant_id"]]);
    $orders = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Build Order object
        $order = Order::init_from_db(
            $row["item_id"],
            $row["customer_id"],
            $row["restaurant_id"],
            $row["status"],
            $row["price"],
            $row["token"],
            $row["id"],
            $row["created_at"]
        );

        // 2) Fetch menu‑item details
        $stmt2 = $dbconn->prepare(
            'SELECT restaurant_id, item_name, item_description, item_price, item_enabled, item_image
             FROM slutprojekt_menu_items
             WHERE id = ?'
        );
        $stmt2->execute([$row["item_id"]]);
        if ($itemRow = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $menuItem = Menu_Item::init_from_db(
                $itemRow["restaurant_id"],
                $itemRow["item_name"],
                $itemRow["item_description"],
                $itemRow["item_price"],
                $itemRow["item_enabled"],
                $itemRow["item_image"],
                $row["item_id"]
            );
            $order->set_menu_item($menuItem);
        }

        $orders[] = $order->toArray();  // Make sure you have a method that returns an array
    }

    echo json_encode($orders);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Server error."]);
}
