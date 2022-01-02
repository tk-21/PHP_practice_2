<?php
//クッキーを削除したいときは、キーの値と空の内容、過去の時間を設定する
// setcookie('account', '', time() - 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //アカウントを受け取ってクッキーに保存
    $account = filter_input(INPUT_POST, 'account');
    setcookie('account', $account, time() + 3600);
    echo $account;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <label for="account">アカウント</label>
        <?php //$save_account = $_COOKIE['account'];
        ?>
        <?php $save_account = filter_input(INPUT_COOKIE, 'account'); ?>
        <input type="text" name="account" id="account" value="<?php echo htmlspecialchars($save_account); ?>">
        <button type="submit">ログインする</button>
    </form>
</body>

</html>
