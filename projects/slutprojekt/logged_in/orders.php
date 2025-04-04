<?php
session_start();

if (!$_SESSION["permission"]) {
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
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
</head>

<body>
    <?php
    include __DIR__ . '/../incl/elements/nav.php';

    // require_once __DIR__ . '/../incl/phpqrcode/qrlib.php';
    require_once __DIR__ . '/../incl/classes/Order.php';
    require_once __DIR__ . '/../incl/classes/Item.php';
    require_once __DIR__ . '/../../../dbconnect.php';

    $stmt = $dbconn->prepare("SELECT id, item_id, restaurant_id, status, price, token, created_at FROM slutprojekt_orders WHERE customer_id=?");
    $stmt->execute([$_SESSION["id"]]);
    ?>

    <div class="big-flex">

        <?php
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $order = Order::init_from_db($res["item_id"], $_SESSION["id"], $res["restaurant_id"], $res["status"], $res["price"], $res["token"], $res["id"], $res["created_at"]);

            // Går att effektivisera med join
            $stmt2 = $dbconn->prepare("SELECT restaurant_id, item_name, item_description, item_price, item_enabled, item_image FROM slutprojekt_menu_items WHERE id = ?");
            $stmt2->execute([$order->get_item_id()]);
            while ($res2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $item = Menu_Item::init_from_db($res2["restaurant_id"], $res2["item_name"], $res2["item_description"], $res2["item_price"], $res2["item_enabled"], $res2["item_image"], $res["item_id"]);
            }
            $order->set_menu_item($item);
        ?>
            <div class="flex-item">
                <canvas id="canvas-<?php echo $order->get_order_id();?>"></canvas>
                <img src="../img/menu-items/<?php echo $order->get_menu_item()->get_item_image(); ?>" class="img-block" alt="Logotyp: <?php echo $order->get_menu_item()->get_item_name(); ?>">
                <h2>
                    <?php echo $order->get_menu_item()->get_item_name(); ?>
                </h2>
                <p>
                    <?php echo $order->get_menu_item()->get_item_description(); ?>
                </p>
                <button disabled class="btn-order-placed"><?php echo $order->get_status(); ?></button>
                <button class="btn-order" onclick="generateQR(<?php echo $order->get_order_id();?>, '<?php echo $order->get_token();?>')">Visa QR-kod</button>
            </div>
        <?php
        }
        ?>

    </div>

    <script>
        function generateQR(canvasId, text) {
            const canvas = document.getElementById('canvas-' + canvasId);
            QRCode.toCanvas(canvas, text, {
                width: 200
            }, function(error) {
                if (error) {
                    console.error('Fel vid generering:', error);
                } else {
                    console.log('QR-kod genererad!');
                }
            });
        }
    </script>
</body>

</html>