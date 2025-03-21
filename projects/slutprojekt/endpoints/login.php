<?php

session_start();

require __DIR__ . '/../../../dbconnect.php';
require_once __DIR__  . '/../functions/test_inputs.php';

test_all($_POST);

echo $_SESSION["email"];

if (isset($_SESSION["email"]) && $_SESSION["password"]) {
    // $login_details = ["antonlm@varmdogymnasium.se", $_SESSION["password"]];
    $login_details = [$_SESSION["email"], $_SESSION["password"]];
} else {
    $login_details = [$_POST["email"], $_POST["password"]];
}

$stmt = $dbconn->prepare("SELECT id, email, password FROM slutprojekt_hungry_users WHERE email = ?");
if ($stmt->execute([$login_details[0]])) {
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];

    if (password_verify($login_details[1], $result["password"])) {
        $_SESSION["id"] = $result["id"];
        $_SESSION["permission"] = true;
        header("Location: ../logged_in/dashboard.php");
    } else {
        echo 'Fel lösenord eller epost';
    }
}
