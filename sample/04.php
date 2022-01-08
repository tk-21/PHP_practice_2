<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo</title>
</head>

<body>
    <?php

    $db = new mysqli('localhost', 'root', 'root', 'mydb');
    $message = 'フォームからのメッセージ';
    //prepareは?を入れることができ、後からそこに入れる値をbind_paramで指定することができる
    //(memo)と(?)が対応している
    $stmt = $db->prepare('insert into memos(memo) values(?)');
    if (!$stmt) :
        die($db->error); //dieはメッセージを表示してプログラムを終了させることができる
    endif;
    $stmt->bind_param('s', $message); //s:stiring  i:integer
    $ret = $stmt->execute(); //実行
    ?>
</body>

</html>
