<?php

//グローバル変数
//スコープの外からでも変数が使えるようになる

$tax = 10;

function sum($a, $b)
{
    global $tax;
    $ret = ($a + $b) * ($tax / 100 + 1);

    return $ret;
}

$num1 = 100;
$num2 = 200;

$answer = sum($num1, $num2);
echo $answer;
