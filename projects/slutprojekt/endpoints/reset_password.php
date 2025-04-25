<?php

session_start();

require __DIR__ . '/../../../dbconnect.php';
require_once __DIR__  . '/../functions/test_inputs.php';

test_all($_POST);
$token = bin2hex(random_bytes(20));

$stmt = $dbconn -> prepare('UPDATE slutprojekt_hungry_users SET login_token=? WHERE email=?');
$stmt->execute([$token, $_POST["email"]]);

// Lägg till uppdatering av lösenord efter inloggning
$content = '<a href="labb.vgy.se/~antonlm/webbserverprogrammering/projects/slutprojekt/resetpw.php?token=' . $token . '">Klicka här</a>';
if (mail($_POST["email"], "Återställ lösenord", $content)) {
    echo 'Du har fått mejl med återställningslänk';
}