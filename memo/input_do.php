<?php
$memo = filter_input(INPUT_POST, 'memo', FILTER_SANITIZE_SPECIAL_CHARS);
$db = new mysqli('localhost', 'root', 'root', 'mydb');
$stmt = $db->prepare('insert into memos(memo) values(?)');
if (!$stmt) :
    die($db->error);
endif;
$stmt->bind_param('s', $memo);
$ret = $stmt->execute();

if ($ret) :
    echo '登録されました';
else :
    echo $db->error;
endif;
