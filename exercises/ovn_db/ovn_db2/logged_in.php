<?php

session_start();

if (!isset($_SESSION["type"])) {
    die();
}

if ($_SESSION["type"] == "admin") {
    echo "Du är admin";
} else {
    echo "Du är inte admin";
}