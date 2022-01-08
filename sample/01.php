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
    $db->query('drop table if exists test');
    $db->query('create table test(id INT)');
    echo 'テーブルを作成';
    ?>
</body>
</html>
