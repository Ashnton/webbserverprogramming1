<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webbserverprogrammering</title>
</head>

<body>
    <?php
    for ($i = 0; $i < 999; $i++) {
        if (file_exists(__DIR__ . "/ovningar/ovn_gr$i.php")) {
            ?> <a href="<?php echo "ovningar/ovn_gr$i.php" ?>">Övning Grund <?php echo $i; ?></a><br> <?php
        }
    }
    for ($i = 0; $i < 999; $i++) {
        if (file_exists(__DIR__ . "/ovningar/ovn_fr$i.php")) {
            ?> <a href="<?php echo "ovningar/ovn_fr$i.php" ?>">Övning Formulär <?php echo $i; ?></a><br> <?php
        }
    }
    ?>
</body>

</html>