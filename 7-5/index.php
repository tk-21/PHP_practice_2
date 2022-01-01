<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- ↓URLを入力してページを表示したときはGETなので、if文の中身は実行されない -->
    <!-- これを使うことによってsubmitボタンが押されたかどうかを判断することができる -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
        <!-- メッセージがセットされていない状態で呼び出された場合、 またはフォームは送信されたけどメッセージが空の場合にエラーメッセージを表示する-->
        <?php if (!isset($_POST['message']) || $_POST['message'] === '') : ?>
            <p style="color: red;">メッセージを入力してください</p>
        <?php endif; ?>
    <?php endif; ?>

    <form action="" method="post">
        <label for="message">メッセージをどうぞ</label>
        <input type="text" name="message" id="message">
        <button type="submit">送信する</button>
    </form>
</body>

</html>
