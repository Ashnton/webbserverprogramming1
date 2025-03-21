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
</head>

<body>
    <div class="big-flex">
        <?php
        require_once __DIR__ . '/../../../dbconnect.php';

        $stmt = $dbconn->prepare("SELECT id, restaurant_name, logotype_url FROM slutprojekt_restaurants WHERE restaurant_enabled=?");
        $stmt->execute([true]);
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <a href="restaurant.php?restaurant_id=<?php echo $res["id"]; ?>" class="flex-item">
                <img src="../img/restaurants/<?php echo $res['logotype_url']; ?>" class="img-block" alt="Logotyp: <?php echo $res["restaurant_name"]; ?>">
                <h2>
                    <?php echo $res["restaurant_name"]; ?>
                </h2>
            </a>
        <?php
        }
        ?>
    </div>
</body>

</html>