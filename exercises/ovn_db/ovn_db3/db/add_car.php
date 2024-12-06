<?php

require __DIR__ . '/../../../../dbconnect.php';

$regnr = $_POST["regnr"];
$color = $_POST["color"];
$garage = $_POST["garage"];
$owner = $_POST["owner"];

$stmt = $dbconn->prepare("INSERT INTO car (regnr, color, garage, owner) VALUES (?, ?, ?, ?)");
$data = [$regnr, $color, $garage, $owner];
$stmt->execute($data);