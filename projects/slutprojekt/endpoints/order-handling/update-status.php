<?php

session_start();
if (!$_SESSION["restaurant_permission"]) {
    echo "Fuck you";
    die();
}

require __DIR__ . '/../../../../dbconnect.php';
require_once __DIR__  . '/../../functions/test_inputs.php';

test_all($_POST);

$stmt = $dbconn->prepare('UPDATE slutprojekt_orders SET status=? WHERE id=?');
$params = [$_POST["status"], $_POST["order_id"]];
if ($stmt->execute($params)) {
    echo 'success';
}
