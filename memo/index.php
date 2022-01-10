<?php

require_once('dbconnect.php');

// 最大ページ数を求める
$counts = $db->query('select count(*) as cnt from memos');
$count = $counts->fetch_assoc();
$max_page = floor(($count['cnt'] + 1) / 5 + 1);

// ？のところにbind_paramで指定した値を割り当てる
// ？はスタート位置の番号
$stmt = $db->prepare('select * from memos order by id desc limit ?, 5');
if (!$stmt) {
    die($db->error);
}

//URLを利用してページネーションを作成する
//URLパラメータから数字しか受け取れないようにする
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
// URLのページ数が省略されると最初のページを表示するようにする
$page = ($page ?: 1);
//URLから受け取ったページ数からスタート位置の番号を計算
$start = ($page - 1) * 5;
$stmt->bind_param('i', $start);
$result = $stmt->execute();
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メモ帳 </title>
</head>

<body>
    <h1>メモ帳</h1>
    <p>→<a href="input.html">新しいメモ</a></p>
    <?php if (!$result) : ?>
        <p>表示するメモがありません</p>
    <?php endif; ?>
    <!-- 変数に割り当てて、fetchで取得 -->
    <?php $stmt->bind_result($id, $memo, $created); ?>
    <?php while ($stmt->fetch()) : ?>
        <div>
            <!-- メモの内容を50文字以内で表示 -->
            <!-- idは数字しか入らないのでhtmlspecialcharsはいらない -->
            <h2><a href="memo.php?id=<?php echo $id; ?>"><?php echo htmlspecialchars(mb_substr($memo, 0, 50)); ?></a></h2>
            <time><?php echo htmlspecialchars($created); ?></time>
        </div>
        <hr>
    <?php endwhile; ?>

    <p>
        <?php if ($page > 1) : ?>
            <a href="?page=<?php echo $page - 1; ?>"><?php echo $page - 1; ?>ページ目へ</a> |
        <?php endif; ?>
        <!-- 最大ページ数より小さい時だけ表示させる -->
        <?php if ($page < $max_page) : ?>
            <a href="?page=<?php echo $page + 1; ?>"><?php echo $page + 1; ?>ページ目へ</a>
        <?php endif; ?>
    </p>
</body>

</html>
