<?php 
session_start();
?>
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
<link rel="canonical" href="https://www.okamoto-farm.co.jp/index.php">
<meta name="keywords" content="有機栽培,無農薬野菜,野菜狩り,収穫体験,レンタル農園,貸し農園,観光農園,農業土木,農機具レンタル,耕運代行,農産物直売所,レンタル厨房,トラクター,耕運機,ユンボ,ソーラー蓄電システム,避難場所,停電,非常用電源,とらみスイート,千葉県,長生郡,一宮町,外房,九十九里">

<meta name="description" content="千葉県外房エリア、九十九里海岸の南端、長生郡一宮町ある、近隣唯一の完全有機栽培農家【太陽と野菜の直売所】（東浪見岡本農園）ホームページでは、観光農園として野菜狩り・農業体験サービスのほか、期間貸しのレンタル農園のご紹介や、農機・農機具レンタル、レンタル厨房のご案内をしております。停電時にいつも電気のある災害避難所としてもご利用になれます。">

<title>パスワードを忘れた方／農産物直売所 千葉【太陽と野菜の直売所】貸し農園 一宮町／野菜狩り／農業体験</title>

<link rel="stylesheet" href="../css/base.css" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

<script src="../js/jquery-1.5.2.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../js/jquery.ui.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="../js/jquery.bgswitcher.js"></script>
<script src="../js/pagetop.js"></script>

<script src="../js/topslide.js"></script>


</head>

<body>

<div id="box">

<div id="header">
	<h1>新鮮野菜 直売所／千葉 一宮町</h1>



<?php include("../include/header.php")?>


<div id="main" class="container">
	<?php include("../include/leftpane.php")?>
	<div id="cnt" class="company">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | パスワードを忘れた方</p>
	



<form action="forgot" method="post">


<?php
if (empty($_POST["loginid"])){
?>	
<div class="block">
	<h2>パスワードを忘れた方</h2>

<p>会員ログインのパスワードを忘れた方は、こちらから再発行が可能です。</p>

<p>ご登録されております、メールアドレスをご入力の上送信してください。パスワードを再発行いたします。</p>

</div>

<div class="block">
	<dl>
	<dt>メールアドレス</dt>
<dd><input type="text" name="loginid" id="loginid" value=""></dd>
</dl>

</div>

<div class="block">

<p class="centering"><input type="submit" name="submit" value="送信"></p>
<?php
  function setToken(){
      $TOKEN_LENGTH = 32;
      $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
      
      $token = bin2hex($bytes);
      $_SESSION['crsf_token'] = $token;
      return $token;
  }
  ?>
    <input type="hidden" name="token" value="<?= setToken()?>">
</div>


<?php
}elseif (!empty($_POST["loginid"])){
	if(empty($_SESSION['crsf_token'])){
	echo "<p>アクセスが不正です。</p>";
	}elseif($_SESSION['crsf_token'] == filter_input(INPUT_POST,"token")){
	$sql="select name,email,password2 From t_user Where email=:loginid AND dele=0 AND taikai=0";
	$user = $dbh->prepare($sql);
	$user -> bindValue(":loginid",$_POST["loginid"],PDO::PARAM_STR);
	$user -> execute();
	$rsu = $user->fetch(PDO::FETCH_ASSOC);
	if (empty($rsu)){
	echo '<p class="red bold">メールアドレスが登録されておりません。</p>';
	echo '<p class="centering underline"><a href"forgot">戻る</a></p>';
	}else{


	$send_msg_manager = "\n";
	$send_msg_manager .="------------------------------------------------------\n";
	$send_msg_manager .="【パスワード】" . $rsu["password2"]."\n";

	$send_msg_manager .="------------------------------------------------------\n";
	$send_msg_manager .="\n";
	$send_msg_manager .="\n";
	// '****************************************************************
	// ' 送信メッセージ作成(お客様へ)
	// '****************************************************************
	$send_msg_visitor = "\n";
	$send_msg_visitor .= "このメールは自動的に配信されております。\n\n";
	$send_msg_visitor .= $rsu["name"]. " 様\n\n";
	
	$send_msg_visitor .= "【太陽と野菜の直売所】を運営しております、 東浪見岡本農園です。\n";
	$send_msg_visitor .= "ログインパスワードを発行いたしました。\n\n";
	$send_msg_visitor .= "パスワードは大切に保管してください。\n";
	$send_msg_visitor .= "\n";
	
	// '****************************************************************
	// ' フッダー作成
	// '****************************************************************
	$send_msg_footer = "=====================================================\n";	
	$send_msg_footer .= " 【太陽と野菜の直売所】東浪見岡本農園\n";
	$send_msg_footer .= "　〒299-4303\n";
	$send_msg_footer .= "　千葉県長生郡一宮町東浪見4721番\n";
	$send_msg_footer .= "　TEL:070-5580-5496\n";
	$send_msg_footer .= "　E-mail：torami@okamoto-farm.co.jp\n";
	$send_msg_footer .= "　URL：https://www.okamoto-farm.co.jp\n";
	$send_msg_footer .= "=====================================================\n";
	$send_msg_footer .= "\n";
	// '****************************************************************
	// ' メール送信
	// '****************************************************************
	mb_language("japanese");
    mb_internal_encoding("UTF-8");
	

	// '****************************************************************
	// 	' お客様へ
	// 	'****************************************************************
	$header2 = "From:".mb_encode_mimeheader("お客様")."<". $_POST["email"] .">\r\n";
	$subj2 = "パスワード再発行のお知らせ【太陽と野菜の直売所】";
	$to2 = "<" . $rsu["email"] . ">";
	$send_msg2 = $send_msg_visitor . $send_msg_manager . $send_msg_footer;
	
	// '****************************************************************
	// ' 送信(お客様へ)
	// '****************************************************************
	if(mb_send_mail($to2,$subj2,$send_msg2,$header2)){
		$rs_visitor = "";
	}else{
		$rs_visitor = 1;
	}
	
	 if(empty($rs_visitor)){
		$_SESSION = array();
	unset($_SESSION['crsf_token']);
	session_unset();
	session_destroy();
?>

<p class="centering">ご登録のメールアドレスへパスワードを発行いたしました。</p>

<p><a href="login"></a></p>
<?php
	
	 }else{
?>
<p class="centering">メールが正しく送信されませんでした。</p>
<?php
	}
	}
	}
}
?>


</form>

<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("../include/rightpane.php")?>

<!-- id main end --></div>

<?php include("../include/footer.php")?>

<!-- id box end --></div>
</body>
</html>
