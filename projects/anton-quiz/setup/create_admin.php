<?php
session_start();

// Exempel: Ingen kontroll här, men du kan (och bör) införa en säkerhetskontroll 
// om du vill köra denna fil på en redan driftad server. 
// T.ex. om (!$_SESSION["is_admin"]) { die("Ej behörig!"); }

require_once __DIR__ . '/../dbconnect.php';

// 1) Definiera ett admin-konto (hardcode här, eller hämta från formulär)
$username = "admin";
$plaintextPassword = "hemligtLösenord123";

// 2) Hasha lösenordet (rekommenderat standard: PASSWORD_DEFAULT)
$hashedPassword = password_hash($plaintextPassword, PASSWORD_DEFAULT);

// 3) Sätt is_admin till 1 för att göra användaren till admin
$isAdmin = 1;

// 4) Försök att skapa användaren i tabellen "users"
$stmt = $conn->prepare("
    INSERT INTO users (username, password, is_admin) 
    VALUES (?, ?, ?)
");

// Bind parametrar (typ: str, str, int)
$stmt->bind_param("ssi", $username, $hashedPassword, $isAdmin);

if ($stmt->execute()) {
    echo "<p>Admin-användaren '$username' har skapats!</p>";
} else {
    echo "<p>Kunde inte skapa admin-användaren.</p>";
    echo "<p>Felmeddelande: " . $conn->error . "</p>";
}

// 5) Stäng anslutningen
$stmt->close();
$conn->close();
