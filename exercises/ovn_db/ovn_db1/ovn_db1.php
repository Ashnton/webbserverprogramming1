<?php

require __DIR__ . '/../../../dbconnect.php';

$sql = "CREATE TABLE kompisar (id int NOT NULL AUTO_INCREMENT, firstname varchar(255), lastname varchar(255), mobil int(10), epost varchar(255))";
$stmt = $dbconn->prepare($sql);
$result = $stmt->execute();

echo $result;
