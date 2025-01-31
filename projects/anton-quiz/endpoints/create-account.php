<?php

require_once __DIR__ . '/../dbconnect.php';

$username = $_POST["username"];
$password = $_POST["password"];

$stmt = $conn->prepare("INSERT INTO users (username, password, latest_login, is_admin) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $username, $password, date('Y-m-d'), 0);
$result = $stmt->execute();

require 'log_in.php';