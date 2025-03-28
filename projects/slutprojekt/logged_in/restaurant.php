<?php
session_start();

if (!$_SESSION["permission"]) {
    echo "Du är inte inloggad med korrekt behörighet";
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
    <div class="big-flex">
        <?php
        require_once __DIR__ . '/../../../dbconnect.php';

        $stmt = $dbconn->prepare("SELECT id, item_name, item_description, item_price, item_image FROM slutprojekt_menu_items WHERE restaurant_id=? AND item_enabled=?");
        $stmt->execute([$_GET["restaurant_id"], true]);
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="flex-item">
                <img src="../img/menu-items/<?php echo $res['item_image']; ?>" class="img-block" alt="Logotyp: <?php echo $res["item_name"]; ?>">
                <h2>
                    <?php echo $res["item_name"]; ?>
                </h2>
                <p>
                    <?php echo $res["item_description"]; ?>
                </p>
                <button class="btn-order" onclick="sendOrder(<?php echo $res['id']; ?>)">Beställ</button>
            </div>
        <?php
        }
        ?>
    </div>

    <script>
        function sendOrder(itemId) {
            // Skapa ett FormData-objekt och lägg in alla key-value-par
            const formData = new FormData();
            formData.append('item_id', itemId);

            // Skicka POST-förfrågan med fetch
            const url = '../endpoints/register-order.php';
            fetch(url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    console.log('Svar från servern:', result);
                })
                .catch(error => {
                    console.error('Fel vid förfrågan:', error);
                });
        }
    </script>
</body>

</html>