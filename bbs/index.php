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

$db = dbconnect();

// メッセージの投稿
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $stmt = $db->prepare('insert into posts (message, member_id) values(?, ?)');
    if (!$stmt) {
        die($db->error);
    }
    $stmt->bind_param('si', $message, $id);
    $success = $stmt->execute();
    if (!$success) {
        die($db->error);
    }

    // headerで自分自身を呼び出すことによって、POSTの内容をクリアして、再読み込みしても再送信されないようにする
    header('Location: index.php');
    exit();
}

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
            <div style="text-align: right"><a href="logout.php">ログアウト</a></div>
            <form action="" method="post">
                <dl>
                    <dt><?php echo h($name); ?>さん、メッセージをどうぞ</dt>
                    <dd>
                        <textarea name="message" cols="50" rows="5"></textarea>
                    </dd>
                </dl>
                <div>
                    <p>
                        <input type="submit" value="投稿する" />
                    </p>
                </div>
            </form>

            <!-- whereでリレーションをはっている -->
            <?php $stmt = $db->prepare('select p.id, p.member_id, p.message, p.created, m.name, m.picture from posts p, members m where m.id=p.member_id order by id desc');
            if (!$stmt) {
                die($db->error);
            }
            $success = $stmt->execute();
            if (!$success) {
                die($db->error);
            }
            $stmt->bind_result($id, $member_id, $message, $created, $name, $picture)
            ?>

            <?php while ($stmt->fetch()) : ?>
                <div class="msg">
                    <!-- 画像が登録されている場合のみ表示する -->
                    <?php if ($picture) : ?>
                        <img src="member_picture/<?php echo h($picture); ?>" width="48" height="48" alt="" />
                    <?php endif; ?>

                    <p><?php echo h($message); ?><span class="name">（<?php echo h($name); ?>）</span></p>
                    <!-- 投稿のURLパラメータにidをつける -->
                    <p class="day"><a href="view.php?id=<?php echo h($id); ?>"><?php echo h($created); ?></a>
                        [<a href="delete.php?id=" style="color: #F33;">削除</a>]
                    </p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>
