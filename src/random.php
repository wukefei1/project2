<?php
function compare($x, $y)
{
    return rand(0, 2000000000) - 1000000000;
}


function getRandom($count)
{
    $array = array();

    for ($i = 0; $i < $count; $i++) {
        $array[$i] = $i + 1;
    }
    usort($array, "compare");

    return $array;
}

