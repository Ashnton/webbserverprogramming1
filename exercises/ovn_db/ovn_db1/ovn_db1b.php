<?php
require __DIR__ . '/../../../dbconnect.php';

$sql = "SELECT * FROM kompisar";
$stmt = $dbconn->prepare($sql);
$success = $stmt -> execute();
if ($success) {
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    foreach ($res as $item) {
        echo htmlentities($item);
    }
}
