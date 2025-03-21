<?php
session_start();

require __DIR__ . '/../../../dbconnect.php';
require_once __DIR__  . '/../functions/test_inputs.php';

test_all($_POST);

$hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$stmt = $dbconn->prepare("INSERT INTO slutprojekt_hungry_users (email, phonenumber, password) VALUES (?, ?, ?)");
if ($stmt->execute([$_POST["email"], $_POST["phonenumber"], $hash])) {

    $_SESSION["email"] = $_POST["email"];
    $_SESSION["password"] = $_POST["password"];

    header("Location: login.php");
} else {
    header("Location: ../fail.php");
}
