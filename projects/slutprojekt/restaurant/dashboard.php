<?php
session_start();

if (!$_SESSION["restaurant_permission"]) {
    echo "Fuck you";
    die();
}

?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php
    include __DIR__ . '/../incl/elements/nav.php';
    ?>
    <div class="big-flex">
        <?php
        require_once __DIR__ . '/../../../dbconnect.php';
        require_once __DIR__ . '/../incl/classes/Order.php';
        require_once __DIR__ . '/../incl/classes/Item.php';

        $stmt = $dbconn->prepare("SELECT id, item_id, customer_id, status, price, token, created_at FROM slutprojekt_orders WHERE restaurant_id=?");
        $stmt->execute([true]);

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $order = Order::init_from_db($res["item_id"], $res["customer_id"], $_SESSION["restaurant_id"], $res["status"], $res["price"], $res["token"], $res["id"], $res["created_at"]);

            // Går att effektivisera med join
            $stmt2 = $dbconn->prepare("SELECT restaurant_id, item_name, item_description, item_price, item_enabled, item_image FROM slutprojekt_menu_items WHERE id = ?");
            $stmt2->execute([$order->get_item_id()]);
            while ($res2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $item = Menu_Item::init_from_db($res2["restaurant_id"], $res2["item_name"], $res2["item_description"], $res2["item_price"], $res2["item_enabled"], $res2["item_image"], $res["item_id"]);
            }
            $order->set_menu_item($item);
        ?>
            <div class="flex-item">
                <img src="../img/menu-items/<?php echo $order->get_menu_item()->get_item_image(); ?>" class="img-block" alt="Logotyp: <?php echo $order->get_menu_item()->get_item_name(); ?>">
                <h2>
                    <?php echo $order->get_menu_item()->get_item_name(); ?>
                </h2>
                <p>
                    <?php echo $order->get_menu_item()->get_item_description(); ?>
                </p>
                <p>
                    <select name="order-status" id="order-status-<?php echo $order->get_order_id(); ?>" class="btn-order-placed order-status-select">
                        <?php
                        $statuses = ["Order placerad", "Mottagen", "Tillagas", "Slutförd"];
                        foreach ($statuses as $status) {
                            if ($status == $order->get_status()) {
                        ?>
                                <option value="<?php echo $status; ?>" selected><?php echo $status; ?></option>
                            <?php
                            } else {
                            ?>
                                <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </p>
                <button class="btn-order" onclick="generateQR(<?php echo $order->get_order_id(); ?>, '<?php echo $order->get_token(); ?>')">Visa QR-kod</button>
            </div>
        <?php
        }
        ?>
    </div>

    <script>
        document.querySelectorAll('.order-status-select').forEach(element => {
            element.addEventListener('change', () => {
                
            })
        });
    </script>

</body>

</html>