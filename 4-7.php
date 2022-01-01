<?php

//厳密な型指定
//自動的な型変換が行われないようになる
declare(strict_types=1);

$tax = 10;

//型の指定
//パラメータやファンクションに型指定ができる
function sum(int $a, int $b): int
{
    global $tax;
    $ret = ($a + $b) * ($tax / 100 + 1);

    return $ret;
}

$num1 = 100;
$num2 = 200;

$answer = sum($num1, $num2);
echo $answer;
