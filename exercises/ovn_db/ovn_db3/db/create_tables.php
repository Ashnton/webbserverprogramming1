<?php

require __DIR__ . '/../../../../dbconnect.php';

$sql = "CREATE TABLE garage (garageid int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(255) NOT NULL)";
$stmt = $dbconn->prepare($sql);
$result = $stmt->execute();

$sql = "CREATE TABLE owner (ownerid int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(255) NOT NULL)";
$stmt = $dbconn->prepare($sql);
$result = $stmt->execute();

$sql = "CREATE TABLE car (carid int NOT NULL AUTO_INCREMENT PRIMARY KEY, regnr varchar(255) NOT NULL, color varchar(255), garage int(11), owner int(11))";
$stmt = $dbconn->prepare($sql);
$result = $stmt->execute();