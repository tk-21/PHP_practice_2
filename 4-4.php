<?php

//デフォルト引数
//必ず後ろに置く

function make_list($list, $head = '・')
{
    foreach ($list as $key => $val) {
        echo $head, $key, ': ', $val . PHP_EOL;
    }
}

$pref = [
    'hokkaido' => '北海道',
    'aomori' => '青森',
    'iwate' => '岩手'
];

make_list($pref);
