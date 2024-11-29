<?php

require __DIR__ . '/../../../../dbconnect.php';

// $owner_name = "Filip";

$stmt = $dbconn->prepare("INSERT INTO owner (name) VALUES (?)");
$data[] = $owner_name;
$stmt->execute($data);
