<!DOCTYPE html>
<html lang="ja">
<?php include("../config.php");?>

<head>
<meta name="robots" content="all">
<meta property="og:title" content="太陽と野菜の直売所【東浪見岡本農園】">
<meta property="og:type" content="website">
<meta property="og:url" content="index.php">
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="robots" content="none" />

<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php

setcookie("adminlogin", "", time()-3600*60*24*30);
setcookie("adminpasswd", "", time()-3600*60*24*30);

session_start();
$_SESSION = array();
unset($_SESSION['adminuser']);
unset($_SESSION['adminpassword']);
unset($_SESSION['company']);


// 4. セッション破棄
session_unset();
session_destroy();
?>

<title>ログアウト【<?=$kanriName?>】</title>
</head>
<body>

<div id="box" class="login">
	<div class="loginform logout">
		<p>ログアウトしました。</p>
		<p><a href="login.php">ログイン画面へ</a></p>
	</div>
</div>

</body>
</html>
