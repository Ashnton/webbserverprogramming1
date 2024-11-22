<?php

session_start();

$username = $_POST["username"];
$password = $_POST["password"];

require __DIR__ . '/../../../dbconnect.php';

$sql = "SELECT * FROM users WHERE username = ?";
$data = [$username];
$stmt = $dbconn->prepare($sql);
$stmt->execute($data);

if ($stmt->rowCount() > 0) {

    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $hash = $res["password"];

        if (password_verify($password, $hash)) {
            $id = $res["id"];
            $firstname = $res["firstname"];
            $lastname = $res["lastname"];
            $type = $res["type"];
            $date_changed = $res["date_changed"];

            $_SESSION["id"] = $id;
            $_SESSION["firstname"] = $firstname;
            $_SESSION["lastname"] = $lastname;
            $_SESSION["username"] = $username;
            $_SESSION["type"] = $type;
            $_SESSION["date_changed"] = $date_changed;

            header("Location: logged_in.php");
        } else {
            echo 'Fel lösenord';
        }
    }
} else {
    echo 'Fel användarnamn';
}
