<?php
session_start();
session_regenerate_id();
$account = 'to';
$_SESSION['account'] = $account;
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
    <p>ようこそ、<?php echo htmlspecialchars($account, ENT_QUOTES | ENT_HTML5); ?>さん</p>
    <p><a href="page02.php">次のページへ</a></p>
</body>

</html>
