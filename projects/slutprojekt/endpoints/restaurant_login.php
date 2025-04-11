<?php

session_start();

require __DIR__ . '/../../../dbconnect.php';
require_once __DIR__  . '/../functions/test_inputs.php';

test_all($_POST);

if (isset($_SESSION["email"]) && $_SESSION["password"]) {
    $login_details = [$_SESSION["email"], $_SESSION["password"]];
} else {
    $login_details = [$_POST["email"], $_POST["password"]];
}

$stmt = $dbconn->prepare("SELECT id, restaurant_id, email, password FROM slutprojekt_restaurant_users WHERE email = ?");
if ($stmt->execute([$login_details[0]])) {
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];

    if (password_verify($login_details[1], $result["password"])) {
        $_SESSION["id"] = $result["id"];
        $_SESSION["restaurant_id"] = $result["restaurant_id"];
        $_SESSION["restaurant_permission"] = true;
        header("Location: ../restaurant/dashboard.php");
    } else {
        echo 'Fel lösenord eller epost';
    }
}
