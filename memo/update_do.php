<?php
require_once('dbconnect.php');

$stmt = $db->prepare('update memos set memo=? where id=?');
if (!$stmt) {
    die($db->error);
}

// ここでupdate.phpから値を受け取る
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$memo = filter_input(INPUT_POST, 'memo', FILTER_SANITIZE_STRING);

$stmt->bind_param('si', $memo, $id);
$result = $stmt->execute();
if (!$result) {
    die($db->error);
}

//updateの実行がうまくいったら詳細画面に移動する。そのときに指定されたidをURLにパラメータとして渡す
header('Location: memo.php?id=' . $id);
