<?php
session_start();

require __DIR__ . '/../../../dbconnect.php';
require_once __DIR__  . '/../functions/test_inputs.php';

test_all($_POST);

$hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$stmt = $dbconn->prepare("INSERT INTO slutprojekt_restaurant_users (restaurant_id, email, password) VALUES (?, ?, ?)");
if ($stmt->execute([$_POST["restaurant"], $_POST["email"], $hash])) {

    $_SESSION["email"] = $_POST["email"];
    $_SESSION["password"] = $_POST["password"];

    header("Location: restaurant_login.php");
} else {
    header("Location: ../fail.php");
}
