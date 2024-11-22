<?php

require __DIR__ . '/../../../../dbconnect.php';

$username = "Anton";
$password = "12345678";

$stmt = $dbconn -> prepare("INSERT INTO users (firstname, lastname, username, password, type, date_changed) VALUES (?, ?, ?, ?, ?, ?)");
$data = ["Anton", "Lidström", $username, $password, "admin", date('Y-m-d')];
$result = $stmt -> execute($data);

echo $result;