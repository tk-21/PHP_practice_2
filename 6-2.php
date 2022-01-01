<?php

//CSVファイルに書き込み

$items = [
    ['PHP', 1500],
    ['JS', 2000]
];

$file = new SplFileObject('data/items.csv', 'a');

foreach ($items as $item) {
    $file->fputcsv($item);
}
