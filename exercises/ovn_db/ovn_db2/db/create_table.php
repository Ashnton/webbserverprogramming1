<?php

require __DIR__ . '/../../../../dbconnect.php';

$sql = "CREATE TABLE users (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, firstname varchar(255) NOT NULL, lastname varchar(255) NOT NULL, username varchar(255) NOT NULL, password varchar(255) NOT NULL, type varchar(255) NOT NULL, date_changed date NOT NULL)";
$stmt = $dbconn->prepare($sql);
$result = $stmt->execute();

echo $result;