<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function test_all(&$postData)
{
    foreach ($postData as $key => &$value) {
        if (is_array($key)) test_all($key);
        else {
            $value = test_input($value);
        }
    }
}
