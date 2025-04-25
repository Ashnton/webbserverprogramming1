#!/usr/bin/env php
<?php
require __DIR__ . '/../../../dbconnect.php';
$dbname = $dbname ?? 'antonlm';
$sqlFile = __DIR__ . '/dump.sql';     // <-- lägg hela .sql-dumpen här

if (!is_file($sqlFile)) {
    die("🚫 Filen dump.sql hittades inte.\n");
}

/* 1) Rensa databasen ****************************************/
echo "Rensar databasen '$dbname' …\n";
$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbconn->exec('SET FOREIGN_KEY_CHECKS = 0');

foreach ($dbconn->query("SHOW FULL TABLES IN `$dbname`") as $row) {
    [$t, $type] = $row;
    $dbconn->exec(($type === 'VIEW' ? 'DROP VIEW' : 'DROP TABLE') . " IF EXISTS `$t`");
    echo "  • Droppade $type $t\n";
}
$dbconn->exec('SET FOREIGN_KEY_CHECKS = 1');
echo "✅ Alla objekt borttagna.\n";

/* 2) Kör dumpen *********************************************/
echo "Återskapar databasen …\n";
$sql = file_get_contents($sqlFile);

/*  ➜  Byt ut kollationen om servern är < 8.0  */
$sql = str_replace('utf8mb4_0900_ai_ci', 'utf8mb4_unicode_ci', $sql);

try {
    $dbconn->exec("SET SESSION max_allowed_packet = 64*1024*1024");
} catch (PDOException $e) {
    echo "ℹ️  max_allowed_packet lämnades oförändrat (saknar rättighet).\n";
}

try {
    $dbconn->exec($sql);
    echo "🎉  Databasen '$dbname' återskapad utan fel.\n";
} catch (PDOException $e) {
    echo "🚫 Fel vid körning av dumpen:\n{$e->getMessage()}\n";
    exit(1);
}
