<?php

//参照渡し
//元の値を書き換えてしまう
//配列のデータ量が大きいため、配列を書き換えるときなどに使う

function add_head(&$target)
{
    for ($i = 0; $i < count($target); $i++) {
        $target[$i] = '・' . $target[$i];
    }
}

$color = ['赤', '白', '黒'];

add_head($color);
add_head($color);
print_r($color);
