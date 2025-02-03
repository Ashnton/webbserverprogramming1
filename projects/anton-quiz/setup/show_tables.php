<?php

// show all error reporting
error_reporting(-1); // Report all type of errors
ini_set('display_errors', 1); // Display all errors 
ini_set('output_buffering', 0); // Do not buffer outputs, write directly


require __DIR__ . '/../dbconnect.php';

if ($conn->connect_errno) {
    die("Misslyckades att ansluta till databasen: " . $conn->connect_error);
}

// Visa alla tabeller i databasen
$result = $conn->query("SHOW TABLES");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_array()) {
        $table = $row[0];
        echo "<h2>Tabell: {$table}</h2>";

        // Hämta allt innehåll från tabellen
        $tableResult = $conn->query("SELECT * FROM `{$table}`");

        if ($tableResult && $tableResult->num_rows > 0) {
            // Hämta kolumninformation
            $fields = $tableResult->fetch_fields();

            // Börja bygga en HTML-tabell
            echo "<table border='1' cellpadding='5' cellspacing='0'>";

            // Skriv ut kolumnnamn som tabellhuvud (thead)
            echo "<tr>";
            foreach ($fields as $field) {
                echo "<th>" . htmlspecialchars($field->name) . "</th>";
            }
            echo "</tr>";

            // Hoppa tillbaka till början (ej alltid nödvändigt, men bra om man behöver läsa data igen)
            $tableResult->data_seek(0);

            // Iterera över alla rader och skriv ut data
            while ($dataRow = $tableResult->fetch_assoc()) {
                echo "<tr>";
                foreach ($fields as $field) {
                    $colName = $field->name;
                    echo "<td>" . htmlspecialchars($dataRow[$colName]) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Inga rader i denna tabell.</p>";
        }
    }
} else {
    echo "<p>Inga tabeller hittades i databasen.</p>";
}
