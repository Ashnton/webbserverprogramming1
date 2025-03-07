<?php

require __DIR__ . '/../../../dbconnect.php';
require_once __DIR__  . '/../functions/test_inputs.php';

test_all($_POST);

$stmt = $dbconn->prepare("INSERT INTO slutprojekt_hungry_users (email, phonenumber, password) VALUES (?, ?, ?)");
$stmt->execute([$_POST["email"], $_POST["phonenumber"], $_POST["password"]]);