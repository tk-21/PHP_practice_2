<?php

//ファイルの読み書き

$file = new SplFileObject('log.txt', 'a');//書き込みをするときはw、追記をしたい場合はa
$today = new DateTime();
$today->setTimezone(new DateTimeZone('Asia/Tokyo'));
$file->fwrite($today->format('Y-m-d H:i:s') . "\n");
