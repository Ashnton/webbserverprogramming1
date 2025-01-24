<?php
session_start();

require_once __DIR__ . '/../../../dbconnect.php';

$sql = "SELECT * FROM users WHERE username = ?";
$data = [$username];
$stmt = $dbconn->prepare($sql);
$stmt->execute($data);

if ($stmt->rowCount() > 0) {

    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $hash = $res["password"];

        if (password_verify($password, $hash)) {
            $id = $res["id"];
            $username = $res["username"];
            $latest_login = $res["latest_login"];
            $is_admin = $res["is_admin"];

            $_SESSION["id"] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["latest_login"] = $latest_login;
            $_SESSION["is_admin"] = $is_admin;

            header("Location: ../logged-in/dashboard.php");
        } else {
            echo 'Fel lösenord';
        }
    }
} else {
    echo 'Fel användarnamn';
}
