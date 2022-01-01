<?php

//可変パラメータ
//いくつでもパラメータを入れられる

function sum(...$numbers)
{
    $answer = 0;

    foreach ($numbers as $num) {
        $answer += $num;
    }

    return $answer;
}

$item_sum = sum(10, 20, 30, 40, 50);
echo $item_sum;
