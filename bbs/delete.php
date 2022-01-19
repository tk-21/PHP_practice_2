<?php

session_start();
require_once('./library.php');

// ログインされているかどうか（セッションの情報があるか）を確認する
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
    // セッション変数をそのまま使うのは気持ち悪いので、一旦変数に入れる
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
} else {
    // セッションの情報がなければ、ログイン画面に戻す
    header('Location: login.php');
}

// URLパラメータでidを受け取る
$post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$post_id) {
    header('Location: index.php');
    exit();
}

$db = dbconnect();

// 事故を防ぐため、limit 1 を入れて1件だけしか削除できないようにする
// 自分のものではないメッセージは削除できないようにするため、member_idがログインしている人のものであるかどうかも条件に加えている
$stmt = $db->prepare('delete from posts where id=? and member_id=? limit 1');
if (!$stmt) {
    die($db->error);
}
$stmt->bind_param('ii', $post_id, $id);
$success = $stmt->execute();
if (!$success) {
    die($db->error);
}

header('Location: index.php');
exit();
