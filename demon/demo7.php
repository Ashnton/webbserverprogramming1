<html>

<head>
    <title>Demo6a</title>
</head>

<body>
    <?php
    $minarray[0] = 6;
    $minarray[1] = 8;
    $minarray[2] = -3;
    $minarray[5] = 5;

    $antal = count($minarray);
    echo "Antal:" . $antal . " st" . '<br>';

    for ($i = 0; $i < $antal; $i++) {
        echo $i . ' : ' . $minarray[$i] . '<br>';
    }
    echo "<br /><br />";

    foreach ($minarray as $i => $val) {
        echo $i . ' : ' . $val . '<br>';
    }
    echo "br /><br />";

    echo "<pre>" . print_r($minarray, true) . "</pre>";
    echo "<pre>" . var_dump($minarray) . "</pre>";
    ?>
</body>

</html>