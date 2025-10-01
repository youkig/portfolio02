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
$errmes = "";

	$userid2 = $_COOKIE["adminlogin"];
	$password2 = $_COOKIE["adminpasswd"];
	$account = " checked='checked'";
	




if (empty($_POST["userid"]) || empty($_POST["password"])){
	$errmes = "ユーザー名とパスワードを入力して下さい。";
}else{
	$errmes = "";
	$userid = $_POST["userid"];
	$password = $_POST["password"];
	
	$sql = "select * from t_passwd where userid = :userid";
	$p = $dbh->prepare($sql);
	$p -> bindValue(":userid",$userid,PDO::PARAM_STR);
	$p -> execute();
	$rs = $p -> fetch(PDO::FETCH_ASSOC);
	if (empty($rs)){
		$errmes = "ユーザーが登録されていません。";
	}else{
		if(!password_verify($password,$rs["password"])){
			$errmes = "パスワードが違います。";
		}else{
			$_SESSION["adminuser"] = $rs["userid"];
			$_SESSION["adminpassword"] = $rs["password"];
			$_SESSION["company"] = $rs["company"];
			
			setcookie("adminlogin",$rs["userid"],time()+60*60*24*7);
			setcookie("adminpasswd",$rs["password"],time()+60*60*24*7);

		}
	}

	if (!empty($_POST["account"])){
		setcookie("userid2_account",$rs["userid"],time()+60*60*24*7);
		setcookie("password2_account",$rs["password"],time()+60*60*24*7);
	}else{
		setcookie("userid2_account","",time()-60*60*24*7);
		setcookie("password2_account","",time()-60*60*24*7);
	}
	header("location:kanri.php");
	exit;
}
?>
<title>ログイン【<?=$kanriname?>】</title>
</head>
<body>
<noscript>
<div class="noscript">JavascriptをONにしてください！</div>
</noscript>

<div id="box" class="login">
<div class="loginform">
	<form action="login" method="post">
		
	
		<p>ユーザー名<br />
		<input type="text" name="userid" id="userid" size="30" style="width:200px;" value="<?=$userid2?>" /></p>
		<p>パスワード<br />
		<input type="password" name="password" id="password" size="30" style="width:200px;" value="<?=$password2?>" /></p>
		<p><label for="account"><input type="checkbox" name="account" id="account" value="ON"<?=$account?> /> ログイン情報を記憶</label></p>
		<p><input type="submit" value="login" /> </a>
		</p>
		
	</form>

</div>


</div>

</body>
</html>
