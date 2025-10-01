<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<?php include("../config.php");?>

<?php
$userid2 = $_COOKIE["adminlogin"];
$password2 = $_COOKIE["adminpasswd"];
if(control_login($userid2,$password2)===false){
	header("location:login.php");
	exit;
}
?>
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
<?php include("include/js.php");?>


<title>管理画面TOP【<?=$kanriname?>】</title>
</head>
<body>
<div id="box" class="kanri">
<?php include("include/header2.php")?>

	<div id="main">
	
		<div id="cnt">
		
			<h2>管理画面TOP</h2>
		<!--cnt end--></div>
<?php include("include/leftpane.php")?>
	</div>
</div>

</body>
</html>
