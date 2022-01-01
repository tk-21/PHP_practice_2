<?php

//continue 実行せずに次へ移る
//break 終了


$color = ['白', '黒', '', '赤'];

foreach ($color as $color_name) {
    if ($color_name === '') {
        continue;
    }

    echo $color_name . PHP_EOL;
}
