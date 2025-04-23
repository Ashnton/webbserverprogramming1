<?php

session_start();

require __DIR__ . '/../../../dbconnect.php';
require_once __DIR__  . '/../functions/test_inputs.php';

if (isset($_GET['token']) && !empty($_GET['token'])) {
    test_all($_GET);
    $stmt = $dbconn->prepare('SELECT id, email, latest_login FROM slutprojekt_hungry_users WHERE login_token = ?');
    $stmt->execute([$_GET["token"]]);

    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $latest_login = $res["latest_login"];

        if (strtotime($latest_login) >= strtotime('-15 minutes')) {
            $_SESSION["id"] = $res["id"];
            $_SESSION["permission"] = true;

            $stmt = $dbconn->prepare('UPDATE slutprojekt_hungry_users SET login_token=? WHERE id=?');
            $stmt->execute(["", $_SESSION["id"]]);

            header("Location: ../logged_in/dashboard.php");
        } else {
            echo 'Token har gått ut.';
            exit;
        }
    }
}

if (isset($_SESSION["email"]) && isset($_SESSION["password"])) {
    test_all($_POST);
    $login_details = [$_SESSION["email"], $_SESSION["password"]];
} else if (isset($_POST["email"]) && isset($_POST["password"])) {
    test_all($_POST);
    $login_details = [$_POST["email"], $_POST["password"]];
}


$stmt = $dbconn->prepare("SELECT id, email, password, login_token FROM slutprojekt_hungry_users WHERE email = ?");
if ($stmt->execute([$login_details[0]])) {
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];

    if (empty($result["login_token"])) {
        if (password_verify($login_details[1], $result["password"])) {
            $_SESSION["id"] = $result["id"];
            $_SESSION["permission"] = true;
            header("Location: ../logged_in/dashboard.php");
        } else {
            echo 'Fel lösenord eller epost';
            exit();
        }
    } else {
        echo 'Du får inte logga in för du är inte verifierad';
        exit();
    }
}
