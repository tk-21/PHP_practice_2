<?php

//CSVファイルを読み込み

$file = new SplFileObject('data/items.csv', 'r');

// while (!$file->eof()) {
//     $item = $file->fgetcsv();
//     echo $item[0] . PHP_EOL;
// }

//フラグで処理する
$file->setFlags(SplFileObject::READ_CSV);
foreach ($file as $item) {
    echo $item[0] . PHP_EOL;
}
