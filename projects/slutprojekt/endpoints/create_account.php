<?php
session_start();

require __DIR__ . '/../../../dbconnect.php';
require_once __DIR__  . '/../functions/test_inputs.php';

test_all($_POST);

$hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
$login_token = bin2hex(random_bytes(20));

$creation_time = date('Y-m-d H:i:s');

$stmt = $dbconn->prepare("INSERT INTO slutprojekt_hungry_users (email, phonenumber, password, latest_login, login_token) VALUES (?, ?, ?, ?, ?)");
if ($stmt->execute([$_POST["email"], $_POST["phonenumber"], $hash, $creation_time, $login_token])) {
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["password"] = $_POST["password"];

    $content = '<a href="labb.vgy.se/~antonlm/webbserverprogrammering/projects/slutprojekt/endpoints/login.php?token=' . $login_token . '">Klicka här</a>';
    if (mail($_POST["email"], "Logga in", $content)) {
        echo 'Kolla din mejl';
    }
} else {
    header("Location: ../fail.php");
}
