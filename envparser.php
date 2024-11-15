<?php

function parseEnvFile($filePath)
{
    if (!file_exists($filePath)) {
        // Optionally handle the case where the file does not exist
        throw new Exception("The file at $filePath does not exist.");
    }

    $envArray = [];
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        // Remove surrounding quotes from the value
        $value = trim($value, "\"'");

        $envArray[$name] = $value;
    }

    return $envArray;
}
