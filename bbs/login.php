<?php
session_start();
require_once('./library.php');

// 変数、配列は初期化しておく
$error = [];
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 入力されたメールアドレス、パスワードを受け取る
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    if ($email === '' || $password === '') {
        // 配列にエラーの内容を入れることでエラーの制御がやりやすくなる
        $error['login'] = 'blank';
    } else {
        // ログインチェック
        $db = dbconnect();
        // limit 1を入れておくことでデータが1件しか取得できないようにしておく（セキュリティのため）
        $stmt = $db->prepare('select id, name, password from members where email=? limit 1');
        if (!$stmt) {
            die($db->error);
        }
        $stmt->bind_param('s', $email);
        $success = $stmt->execute();
        if (!$success) {
            die($db->error);
        }

        $stmt->bind_result($id, $name, $hash);
        $stmt->fetch();

        // 入力されたパスワードとハッシュ化されているパスワードを照合する
        if (password_verify($password, $hash)) {
            // ログイン成功
            // 安全性のためセッションIDを生成し直す
            session_regenerate_id();
            // idとnameをセッションに記録しておく
            $_SESSION['id'] = $id;
            $_SESSION['name'] = $name;
            header('Location: index.php');
            exit();
        } else {
            $error['login'] = 'failed';
        }
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>ログインする</title>
</head>

<body>
    <div id="wrap">
        <div id="head">
            <h1>ログインする</h1>
        </div>
        <div id="content">
            <div id="lead">
                <p>メールアドレスとパスワードを記入してログインしてください。</p>
                <p>入会手続きがまだの方はこちらからどうぞ。</p>
                <p>&raquo;<a href="join/">入会手続きをする</a></p>
            </div>
            <!-- action属性が空だったら自分自身が呼ばれる -->
            <form action="" method="post">
                <dl>
                    <dt>メールアドレス</dt>
                    <dd>
                        <!-- value属性に値を入れることで、入力された値を再現する -->
                        <input type="text" name="email" size="35" maxlength="255" value="<?php echo h($email); ?>" />
                        <?php if (isset($error['login']) && $error['login'] === 'blank') : ?>
                            <p class="error">* メールアドレスとパスワードをご記入ください</p>
                        <?php endif; ?>

                        <?php if (isset($error['login']) && $error['login'] === 'failed') : ?>
                            <p class="error">* ログインに失敗しました。正しくご記入ください。</p>
                        <?php endif; ?>

                    </dd>
                    <dt>パスワード</dt>
                    <dd>
                        <input type="password" name="password" size="35" maxlength="255" value="<?php echo h($password); ?>" />
                    </dd>
                </dl>
                <div>
                    <input type="submit" value="ログインする" />
                </div>
            </form>
        </div>
    </div>
</body>

</html>
