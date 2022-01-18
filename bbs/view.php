<?php
session_start();
require_once('./library.php');

// ログインされているかどうか（セッションの情報があるか）を確認する
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
    // セッション変数をそのまま使うのは気持ち悪いので、一旦変数に入れる
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
} else {
    // セッションの情報がなければ、ログイン画面に戻す
    header('Location: login.php');
}

// URLパラメータを取得してくる
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id) {
    header('Location: index.php');
    exit();
}

$db = dbconnect();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ひとこと掲示板</title>

    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div id="wrap">
        <div id="head">
            <h1>ひとこと掲示板</h1>
        </div>
        <div id="content">
            <p>&laquo;<a href="index.php">一覧にもどる</a></p>
            <!-- whereでリレーションをはっている -->
            <?php $stmt = $db->prepare('select p.id, p.member_id, p.message, p.created, m.name, m.picture from posts p, members m where p.id=? and m.id=p.member_id order by id desc');
            if (!$stmt) {
                die($db->error);
            }
            // どのpostsのidを取るか指定する
            $stmt->bind_param('i', $id);
            $success = $stmt->execute();
            if (!$success) {
                die($db->error);
            }
            $stmt->bind_result($id, $member_id, $message, $created, $name, $picture);
            ?>

            <?php if ($stmt->fetch()) : ?>
                <div class="msg">
                    <!-- 画像が登録されている場合のみ表示する -->
                    <?php if ($picture) : ?>
                        <img src="member_picture/<?php echo h($picture); ?>" width="48" height="48" alt="" />
                    <?php endif; ?>

                    <p><?php echo h($message); ?><span class="name">（<?php echo h($name); ?>）</span></p>
                    <p class="day"><a href="view.php?id="><?php echo h($created); ?></a>
                        [<a href="delete.php?id=" style="color: #F33;">削除</a>]
                    </p>
                </div>
            <?php else : ?>
                <p>その投稿は削除されたか、URLが間違えています</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
