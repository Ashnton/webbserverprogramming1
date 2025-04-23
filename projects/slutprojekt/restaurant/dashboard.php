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
    <link rel="stylesheet" href="../css/scanner.css">
</head>

<body>
    <?php
    include __DIR__ . '/../incl/elements/nav.php';
    ?>
    <div class="section">
        <div id="my-qr-reader">
        </div>
    </div>
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
            <div class="flex-item" data-order-token="<?php echo $order->get_token(); ?>" id="order-<?php echo $order->get_order_id(); ?>">
                <img src="../img/menu-items/<?php echo $order->get_menu_item()->get_item_image(); ?>" class="img-block" alt="Logotyp: <?php echo $order->get_menu_item()->get_item_name(); ?>">
                <h2>
                    <?php echo $order->get_menu_item()->get_item_name(); ?>
                </h2>
                <p>
                    <?php echo $order->get_menu_item()->get_item_description(); ?>
                </p>
                <p>
                    <select name="order-status" id="order-status-<?php echo $order->get_order_id(); ?>" data-order-id="<?php echo $order->get_order_id(); ?>" class="btn-order-placed order-status-select">
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
                <p>
                    <button class="btn-order-placed" onclick="deleteOrder(<?php echo $order->get_order_id(); ?>)">Radera order</button>
                </p>
            </div>
        <?php
        }
        ?>
    </div>

    <script>
        document.querySelectorAll('.order-status-select').forEach(element => {
            element.addEventListener('change', () => {
                let orderId = element.getAttribute('data-order-id');

                if (updateOrderStatus(element.value, orderId)) {
                    console.log('Status uppdaterad');
                }
            })
        });
    </script>
    <script
        src="https://unpkg.com/html5-qrcode">
    </script>
    <script>
        // script.js file

        function domReady(fn) {
            if (
                document.readyState === "complete" ||
                document.readyState === "interactive"
            ) {
                setTimeout(fn, 1000);
            } else {
                document.addEventListener("DOMContentLoaded", fn);
            }
        }

        domReady(function() {

            // If found you qr code
            function onScanSuccess(decodeText, decodeResult) {
                let element = document.querySelector(`[data-order-token="${decodeText}"]`);
                let select = element.querySelector('select');
                select.value = "Slutförd";
                orderId = select.getAttribute('data-order-id');
                element.style.border = "solid 4px green";

                if (updateOrderStatus("Slutförd", orderId)) {
                    console.log('success');
                };
            }

            let htmlscanner = new Html5QrcodeScanner(
                "my-qr-reader", {
                    fps: 10,
                    qrbos: 250
                }
            );
            htmlscanner.render(onScanSuccess);
        });
    </script>
    <script>
        function updateOrderStatus(status, orderId) {
            // Skapa ett FormData-objekt och lägg in alla key-value-par
            const formData = new FormData();
            formData.append('order_id', orderId);
            formData.append('status', status);

            // Skicka POST-förfrågan med fetch
            const url = '../endpoints/order-handling/update-status.php';
            fetch(url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    console.log('Svar från servern:', result);
                    if (result.trim() === "success") {
                        return true;
                    }
                })
                .catch(error => {
                    console.error('Fel vid förfrågan:', error);
                    return false;
                });
        }

        function deleteOrder(orderId) {
            // Skapa ett FormData-objekt och lägg in alla key-value-par
            const formData = new FormData();
            formData.append('order_id', orderId);

            // Skicka POST-förfrågan med fetch
            const url = '../endpoints/order-handling/delete-order.php';
            fetch(url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    // console.log('Svar från servern:', result);
                    if (result.trim() === "success") {
                        document.getElementById('order-' + orderId).remove();
                    }
                })
                .catch(error => {
                    console.error('Fel vid förfrågan:', error);
                    return false;
                });
        }
    </script>

    <script>
        // Poll every 10 seconds instead of 1 ms
        const POLL_INTERVAL = 10;

        function fetchNewOrders() {
            fetch('../endpoints/order-handling/fetch-new-orders.php')
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP ${response.status}`);
                    return response.json();
                })
                .then(orders => {
                    if (!Array.isArray(orders)) {
                        console.error('Expected array of orders, got:', orders);
                        return;
                    }

                    orders.forEach(order => {
                        // Skip if already in DOM
                        if (document.querySelector(`[data-order-token="${order.token}"]`)) {
                            return;
                        }

                        const orderEl = document.createElement('div');
                        orderEl.classList.add('flex-item');
                        orderEl.setAttribute('data-order-token', order.token);
                        orderEl.innerHTML = `
          <img
            src="../img/menu-items/${order.item_image}"
            class="img-block"
            alt="Bild på ${order.item_name}"
          >
          <h2>${order.item_name}</h2>
          <p>${order.item_description}</p>
          <p>
            <select
              name="order-status"
              id="order-status-${order.id}"
              data-order-id="${order.id}"
              class="btn-order-placed order-status-select"
            >
              ${["Order placerad", "Mottagen", "Tillagas", "Slutförd"].map(status => `
                <option value="${status}" ${status === order.status ? 'selected' : ''}>
                  ${status}
                </option>
              `).join('')}
            </select>
          </p>
          <p>
            <button class="btn-order-placed" onclick="deleteOrder(${order.id})">
              Radera order
            </button>
          </p>
        `;

                        // Attach change listener once
                        orderEl.querySelector('.order-status-select')
                            .addEventListener('change', event => {
                                const newStatus = event.target.value;
                                const id = event.target.dataset.orderId;
                                updateOrderStatus(newStatus, id);
                            });

                        document.querySelector('.big-flex').append(orderEl);
                        console.log('Order tillagd')
                    });
                })
                .catch(err => console.error('Fel vid hämtning av nya ordrar:', err));
        }

        // Start polling
        fetchNewOrders(); // initial fetch immediately
        setInterval(fetchNewOrders, POLL_INTERVAL);
    </script>

</body>

</html>