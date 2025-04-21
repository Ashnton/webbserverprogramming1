<?php

session_start();

require __DIR__ . '/../../../../dbconnect.php';
require_once __DIR__  . '/../../functions/test_inputs.php';
require_once __DIR__ . '/../../incl/classes/Order.php';
require_once __DIR__ . '/../../incl/classes/Item.php';

test_all($_POST);

$stmt = $dbconn->prepare('UPDATE slutprojekt_orders SET status=? WHERE id=?');
$params = [$_POST["status"], $_POST["item_id"]];
if ($stmt->execute($params)) {
    echo 'success';
}
