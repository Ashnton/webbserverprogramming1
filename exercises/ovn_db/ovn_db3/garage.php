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
    ?>

    <form action="db/add_car.php" method="post">
        <h2>Lägg till en bil</h2>
        <label for="regnr">Registreringsnummer*:</label>
        <input type="text" id="regnr" name="regnr">

        <label for="color">Färg*:</label>
        <input type="text" id="color" name="color">

        <label for="garage">Garage*:</label>
        <select name="garage" id="garage">
            <?php
            $stmt = $dbconn->prepare("SELECT * FROM garage");
            $stmt->execute();

            while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <option value="<?php echo $res["garageid"]; ?>"><?php echo $res["name"]; ?></option>
            <?php
            }
            ?>
        </select>

        <label for="owner">Ägare*:</label>
        <select name="owner" id="owner">
            <?php
            $stmt = $dbconn->prepare("SELECT * FROM owner");
            $stmt->execute();

            while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <option value="<?php echo $res["ownerid"]; ?>"><?php echo $res["name"]; ?></option>
            <?php
            }
            ?>
        </select>

        * = obligatoriskt
        <button type="submit">Lägg till</button>
    </form>
</body>

</html>