<?php

require_once __DIR__ . '/../dbconnect.php';

$username = $_POST["username"];
$password = $_POST["password"];
$hash = password_hash($password, PASSWORD_DEFAULT);

$zero = 0;
$date = date('Y-m-d');

$stmt = $conn->prepare("INSERT INTO quizdb_users (username, password, latest_login, is_admin) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $username, $hash, $date, $zero);
$result = $stmt->execute();

require __DIR__ . '/log-in.php';