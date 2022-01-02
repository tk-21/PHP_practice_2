<?php
session_start();

if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
} else {
    $account = '';
}

//セッションを破棄する
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
session_destroy();
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
    <p><?php echo htmlspecialchars($account, ENT_QUOTES | ENT_HTML5); ?>さん</p>
</body>

</html>
