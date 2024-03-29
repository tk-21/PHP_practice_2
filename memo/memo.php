<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メモ詳細</title>
</head>

<body>
    <?php
    require_once('dbconnect.php');

    $stmt = $db->prepare('select * from memos where id=?');
    //SQLがうまくいかなかった場合
    if (!$stmt) {
        die($db->error);
    }

    //idをURLからGETで受け取ってフィルタリング
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if (!$id) {
        echo '表示するメモを指定してください';
    }

    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($id, $memo, $created); //DBから取得した値を変数に割り当てる
    $stmt->fetch();
    ?>

    <div>
        <pre><?php echo htmlspecialchars($memo); ?></pre>
    </div>

    <p>
        <!-- URLにidをパラメータとして渡して、それぞれのページに移動させる -->
        <a href="update.php?id=<?php echo $id; ?>">編集する</a> |
        <a href="delete.php?id=<?php echo $id; ?>">削除する</a> |
        <a href="/memo">一覧へ</a>
    </p>
</body>

</html>
