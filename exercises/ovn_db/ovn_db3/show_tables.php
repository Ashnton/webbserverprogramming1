<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage</title>
</head>

<body>
    <?php
    require __DIR__ . '/../../../dbconnect.php';

    $stmt = $dbconn->prepare("SELECT * FROM garage");
    $stmt->execute();

    ?>

    Hittade följande data i tabellen garage:

    <table>

        <tr>
            <td>Index</td>
            <td>Namn</td>
        </tr>
        <?php
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>

            <tr>
                <td><?php echo $res["garageid"]; ?></td>
                <td><?php echo $res["name"]; ?></td>
            </tr>

        <?php
        }
        ?>

    </table>
    <?php

    $stmt = $dbconn->prepare("SELECT * FROM owner");
    $stmt->execute();

    ?>

    Hittade följande data i tabellen owner:

    <table>

        <tr>
            <td>Index</td>
            <td>Namn</td>
        </tr>
        <?php
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>

            <tr>
                <td><?php echo $res["ownerid"]; ?></td>
                <td><?php echo $res["name"]; ?></td>
            </tr>

        <?php
        }
        ?>

    </table>

    <?php

    $stmt = $dbconn->prepare("SELECT * FROM car");
    $stmt->execute();

    ?>

    Hittade följande data i tabellen car:

    <table>

        <tr>
            <td>Index</td>
            <td>Reg.nummer</td>
            <td>Färg</td>
            <td>Garage-id</td>
            <td>Owner-id</td>
        </tr>
        <?php
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>

            <tr>
                <td><?php echo $res["carid"]; ?></td>
                <td><?php echo $res["regnr"]; ?></td>
                <td><?php echo $res["color"]; ?></td>
                <td><?php echo $res["garage"]; ?></td>
                <td><?php echo $res["owner"]; ?></td>
            </tr>

        <?php
        }
        ?>

    </table>


</body>

</html>