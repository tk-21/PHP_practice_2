<?php

session_start();
require_once('../library.php');

// セッションの値がなければ、check.phpを表示させない
// $_SESSION['form']が存在すれば、$formの中にセッションの値を入れる
if (isset($_SESSION['form'])) {
	// ここで$_SESSIONの値を受け取っている
	// セッションを使って値を行き来させることができる
	$form = $_SESSION['form'];
} else {
	// 直接呼び出された場合は正しくないので、index.phpに移動させる
	header('Location: index.php');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// ここでDBに接続する
	$db = new mysqli('localhost', 'root', 'root', 'mini_bbs');
	if (!$db) {
		die($db->error);
	}

	$stmt = $db->prepare('insert into members (name, email, password, picture) VALUES (?, ?, ?, ?)');
	if (!$stmt) {
		die($db->error);
	}

	// パスワードの暗号化をしてからDBに登録する
	$password = password_hash($form['password'], PASSWORD_DEFAULT);
	$stmt->bind_param('ssss', $form['name'], $form['email'], $password, $form['image']);
	$success = $stmt->execute();
	if (!$success) {
		die($db->error);
	}

	// セッションの内容を消してから完了画面に移ることで、重複登録などを防ぐことができる
	unset($_SESSION['form']);
	header('Location: thanks.php');
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>会員登録</title>

	<link rel="stylesheet" href="../style.css" />
</head>

<body>
	<div id="wrap">
		<div id="head">
			<h1>会員登録</h1>
		</div>

		<div id="content">
			<p>記入した内容を確認して、「登録する」ボタンをクリックしてください</p>
			<form action="" method="post">
				<dl>
					<dt>ニックネーム</dt>
					<dd><?php echo h($form['name']); ?></dd>
					<dt>メールアドレス</dt>
					<dd><?php echo h($form['email']); ?></dd>
					<dt>パスワード</dt>
					<dd>
						【表示されません】
					</dd>
					<dt>写真など</dt>
					<dd>
						<img src="../member_picture/<?php echo h($form['image']); ?>" width="100" alt="" />
					</dd>
				</dl>
				<div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する" /></div>
			</form>
		</div>

	</div>
</body>

</html>
