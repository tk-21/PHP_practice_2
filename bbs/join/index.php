<?php
// noticeやwarningは初期化やissetをきちんとすることで抑えられる
// 配列の中の値を初期化しておくことで、初回表示したときのnoticeを抑える
$form = [
    'name' => '',
    'email' => '',
    'password' => ''
];
$error = [];

function h($value)
{
    return htmlspecialchars($value, ENT_QUOTES);
}

// フォームが送信されたとき（POSTで渡ってきたとき）に実行される
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    //エラーを記録しておく
    if ($form['name'] === '') {
        $error['name'] = 'blank';
    }

    $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if ($form['email'] === '') {
        $error['email'] = 'blank';
    }

    $form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    // 空のときは空のチェックだけ行っている（4文字以上かどうかのチェックは行っていない）
    if ($form['password'] === '') {
        $error['password'] = 'blank';
    } elseif (strlen($form['password']) < 4) { //パスワードが4文字以下であれば
        $error['password'] = 'length';
    }
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
            <p>次のフォームに必要事項をご記入ください。</p>
            <!-- actionを空にすると自分自身が呼ばれる -->
            <form action="" method="post" enctype="multipart/form-data">
                <dl>
                    <dt>ニックネーム<span class="required">必須</span></dt>
                    <dd>
                        <!-- value属性に値を入れることによって、入力した情報を保ったまま次の画面に行くことができる -->
                        <input type="text" name="name" size="35" maxlength="255" value="<?php echo h($form['name']); ?>" />
                        <!-- エラーが記録されていれば、エラーメッセージを出す -->
                        <!-- 配列や変数を使うときはissetで入っているかどうか確認する必要がある -->
                        <?php if (isset($error['name']) && $error['name'] === 'blank') : ?>
                            <p class="error">* ニックネームを入力してください</p>
                        <?php endif; ?>
                    </dd>

                    <dt>メールアドレス<span class="required">必須</span></dt>
                    <dd>
                        <input type="text" name="email" size="35" maxlength="255" value="<?php echo h($form['email']); ?>" />
                        <?php if (isset($error['email']) && $error['email'] === 'blank') : ?>
                            <p class="error">* メールアドレスを入力してください</p>
                        <?php endif; ?>
                        <p class="error">* 指定されたメールアドレスはすでに登録されています</p>

                    <dt>パスワード<span class="required">必須</span></dt>
                    <dd>
                        <input type="password" name="password" size="10" maxlength="20" value="<?php echo h($form['password']); ?>" />
                        <?php if (isset($error['password']) && $error['password'] === 'blank') : ?>
                            <p class="error">* パスワードを入力してください</p>
                        <?php endif; ?>
                        <?php if (isset($error['password']) && $error['password'] === 'length') : ?>
                            <p class="error">* パスワードは4文字以上で入力してください</p>
                        <?php endif; ?>
                    </dd>

                    <dt>写真など</dt>
                    <dd>
                        <input type="file" name="image" size="35" value="" />
                        <p class="error">* 写真などは「.png」または「.jpg」の画像を指定してください</p>
                        <p class="error">* 恐れ入りますが、画像を改めて指定してください</p>
                    </dd>
                </dl>
                <div><input type="submit" value="入力内容を確認する" /></div>
            </form>
        </div>
</body>

</html>
