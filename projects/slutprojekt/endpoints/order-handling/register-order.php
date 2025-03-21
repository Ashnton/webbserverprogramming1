<?php

session_start();

require __DIR__ . '/../../../../dbconnect.php';
require_once __DIR__  . '/../../functions/test_inputs.php';

test_all($_POST);

// TODO: Implementera kontroll om användaren redan beställt mat under den senaste minuten.

$stmt = $conn -> prepare("INSERT INTO slutprojekt_orders")