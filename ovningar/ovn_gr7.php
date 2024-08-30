<?php

$mina_primtal = [];

while (count($mina_primtal) < 100) {
    if (!count($mina_primtal)) {
        array_push($mina_primtal, 2);
    } else {
        $är_primtal = false;
        $tal = $mina_primtal[count($mina_primtal) - 1];
        while ($är_primtal == false) {
            $tal+=1;
            if (testa_primtal($tal)) {
                array_push($mina_primtal, $tal);
                $är_primtal = true;
            }
        }
    }
}

foreach ($mina_primtal as $primtal) {
    echo "$primtal <br>";
}

function testa_primtal($tal)
{
    $resultat_array = [];
    for ($i = 2; $i <= $tal ** 0.5; $i++) {
        if ($tal % $i == 0) {
            array_push($resultat_array, 1);
        } else {
            array_push($resultat_array, 0);
        }
    }

    for ($i=0; $i < count($resultat_array); $i++) { 
        if ($resultat_array[$i]) {
            return false;
        }
    }

    return true;
}