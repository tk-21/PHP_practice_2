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
    $records = $db->query('select count(*) as cnt from my_items');//カラム名を変更
    if ($records) {
        while ($record = $records->fetch_assoc()) { //連想配列のかたちで取得
            // echo $record['item_name'] . ',' . $record['price'] . '<br>';
            echo $record['cnt'];
        }
    } else {
        echo $db->error;
    }
    ?>
</body>

</html>
