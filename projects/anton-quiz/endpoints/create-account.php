<?php

require_once __DIR__ . '/../../../dbconnect.php';

$stmt = $dbconn -> prepare("INSERT INTO users (username, password, latest_login, is_admin) VALUES (?, ?, ?, ?)");
$data = [$username, $password, date('Y-m-d'), 0];
$result = $stmt -> execute($data);

require 'log_in.php';