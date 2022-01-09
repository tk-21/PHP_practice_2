<?php
require_once('dbconnect.php');

$memo = filter_input(INPUT_POST, 'memo', FILTER_SANITIZE_SPECIAL_CHARS);
$stmt = $db->prepare('insert into memos(memo) values(?)');
if (!$stmt) :
    die($db->error);
endif;
$stmt->bind_param('s', $memo);
$ret = $stmt->execute();

if ($ret) :
    echo '登録されました';
    echo '<br>→<a href="index.php">トップへ戻る</a>';
else :
    echo $db->error;
endif;
