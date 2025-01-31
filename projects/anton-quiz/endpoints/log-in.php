<?php
session_start();

require_once __DIR__ . '/../dbconnect.php';

if (!isset($username)) {
    $username = $_POST["username"];
}
if (!isset($password)) {
    $password = $_POST["password"];
}

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$results = $stmt->get_result();

if (mysqli_num_rows($results) > 0) {

    foreach ($results as $res) {
        $hash = $res["password"];

        if (password_verify($password, $hash)) {
            $id = $res["id"];
            $username = $res["username"];
            $latest_login = $res["latest_login"];
            $is_admin = $res["is_admin"];

            $_SESSION["id"] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["latest_login"] = $latest_login;
            $_SESSION["is_admin"] = $is_admin;

            if ($is_admin) {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../logged-in/dashboard.php");
            }
        } else {
            echo 'Fel lösenord';
        }
    }
} else {
    echo 'Fel användarnamn';
}
