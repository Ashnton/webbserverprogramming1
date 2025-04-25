<?php

/**
 * dump_all_tables.php  – HTML-version
 *
 *  • Använder din befintliga PDO-anslutning från dbconnect.php
 *  • Loopar över SHOW TABLES, hämtar kolumner med SHOW COLUMNS
 *  • Skriver ut varje tabell som <table> med rubriker + rader
 *  • Fungerar även om tabellen saknar data (visar “0 rader”)
 */

require __DIR__ . '/../../../dbconnect.php';   // $dbconn (PDO) + $dbname?

// ----------------------------------------------------
// Hämta alla tabellnamn
// ----------------------------------------------------
$tables = $dbconn->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

if (!$tables) {
    die('Inga tabeller hittades.');
}

// ----------------------------------------------------
// HTML-huvud
// ----------------------------------------------------
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <title>Dump av alla tabeller – <?php echo htmlspecialchars($dbname ?? 'databas'); ?></title>
    <style>
        body {
            font-family: system-ui, sans-serif;
            margin: 2rem;
            color: #222
        }

        table {
            border-collapse: collapse;
            margin-bottom: 2rem;
            width: max-content;
            max-width: 100%
        }

        th,
        td {
            border: 1px solid #666;
            padding: .4rem .6rem;
            vertical-align: top
        }

        th {
            background: #f0f0f0;
            font-weight: 600;
            white-space: nowrap
        }

        caption {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: .4rem;
            text-align: left
        }

        em {
            color: #666
        }
    </style>
</head>

<body>
    <h1>Dump av alla tabeller i databasen
        <code><?php echo htmlspecialchars($dbname ?? '(okänd)'); ?></code>
    </h1>

    <?php
    // ----------------------------------------------------
    // Loopa igenom varje tabell och dumpa dess innehåll
    // ----------------------------------------------------
    foreach ($tables as $tbl) {

        // 1) Hämta kolumnnamn
        $cols = $dbconn->query("SHOW COLUMNS FROM `$tbl`")
            ->fetchAll(PDO::FETCH_COLUMN);

        // 2) Hämta data
        $rows = $dbconn->query("SELECT * FROM `$tbl`")
            ->fetchAll(PDO::FETCH_ASSOC);

        // 3) Skriv ut tabell
        echo '<table>';
        echo '<caption>' . htmlspecialchars($tbl) .
            ' <small>(' . count($rows) . ' rader)</small></caption>';

        // rubrikrad
        echo '<thead><tr>';
        foreach ($cols as $c) {
            echo '<th>' . htmlspecialchars($c) . '</th>';
        }
        echo '</tr></thead><tbody>';

        // data-rader
        if ($rows) {
            foreach ($rows as $row) {
                echo '<tr>';
                foreach ($cols as $c) {
                    $cell = $row[$c] ?? '';
                    echo '<td>' . htmlspecialchars(
                        $cell,
                        ENT_QUOTES | ENT_SUBSTITUTE,
                        'UTF-8'
                    ) . '</td>';
                }
                echo '</tr>';
            }
        } else {
            // tom tabell → en rad som säger “0 rader”
            echo '<tr><td colspan="' . count($cols) .
                '"><em>0 rader</em></td></tr>';
        }

        echo '</tbody></table>';
    }

    ?>
</body>

</html>