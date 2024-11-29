<?php

require __DIR__ . '/../../../../dbconnect.php';

// $garage_name = "Filips garage";

$stmt = $dbconn -> prepare("INSERT INTO garage (name) VALUES (?)");
$data[] = $garage_name;
$stmt -> execute($data);