<?php
require __DIR__ . '/../../../dbconnect.php';
ob_clean(); //rensa output buffer


$key = $_GET['name'];
// Med LIKE i en SELECT kan vi hitta namn som börjar på den bokstav
// vi skickar in - $key - genom att lägga till %.
// T ex "...LIKE 'h%'" hittar alla namn som börjar på h/H.
$query = "SELECT * FROM ajax_tabell WHERE name LIKE '$key%' ORDER by name";
$stmt = $dbconn->prepare($query);
$data = array();
$stmt->execute($data);


$output = "";
while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $name = $res["name"];
    $score = $res["score"];
    
    if ($output != "") $output .= ", ";
    $output .= "<br>$name: $score";
}
echo "$output";