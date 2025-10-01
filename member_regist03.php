<?php $siteid=59?>
<?php include("include/autometa.php");?>
<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<?php include("config.php");?>

<head>

<meta name="robots" content="all">
<meta property="og:title" content="太陽と野菜の直売所【東浪見岡本農園】">
<meta property="og:type" content="website">
<meta property="og:url" content="index.php">
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<meta name="keywords" content="<?=$n_keyword?>">

<meta name="description" content="<?=$n_description?>">

<title><?=$n_title?></title>

<link rel="stylesheet" href="css/base.css?<?=str_replace(":", "", date("H:i:s")); ?>" type="text/css">
<?php include("include/js.php")?>


</head>

<body>
<?php
if(!empty($n_h5)){
?>
<h5 id="autochangepg"><?=$n_h5?></h5>
<?php
}
?>

<div id="box">

<div id="header">
<h1><?=$n_h1?></h1>


<?php include("include/header.php")?>


<div id="main" class="container">
	<?php include("include/leftpane.php")?>
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 【太陽と野菜の直売所】（東浪見岡本農園）会員登録（登録完了）</p>
	<div class="block">
	<h2>【太陽と野菜の直売所】（東浪見岡本農園）会員登録（登録完了）</h2>

</div>

<?php
if(empty($_SESSION['crsf_token'])){
echo "<p>アクセスが不正です。</p>";
}elseif($_SESSION['crsf_token'] == filter_input(INPUT_POST,"token")){
	
$sql = "Select * From t_user Where email=:email";
	$user = $dbh->prepare($sql);
	$user -> bindValue(":email",$_POST["email"],PDO::PARAM_STR);
	$user -> execute();
	$result = $user->fetch(PDO::FETCH_ASSOC);
	if(!empty($result)){
	$errmes  = "<p>このメールアドレスはすでに使用されております。</p>";
	}

if (!empty($errmes)){
	echo $errmes;
}else{	
		$sql = "Insert into t_user (";
		$sql .= "person,name,furigana,company,busyo,zip,state,address,address2,tel,email,password,password2,service,mailmaga,comment,indate)";
		$sql .= " values (:person,:name,:furigana,:company,:busyo,:zip,:state,:address,:address2,:tel,:email,:password,:password2,:service,:mailmaga,:comment,:indate)";
		$user = $dbh->prepare($sql);

		if ($_POST["person"]=="法人"){
		$person = 0;
		}elseif ($_POST["person"]=="個人"){
		$person = 1;
		}
		$user -> bindValue(":person",$person,PDO::PARAM_INT);
		$user -> bindValue(":name",$_POST["name"],PDO::PARAM_STR);
		$user -> bindValue(":furigana",$_POST["furigana"],PDO::PARAM_STR);
		$user -> bindValue(":company",$_POST["company"],PDO::PARAM_STR);
		$user -> bindValue(":busyo",$_POST["busyo"],PDO::PARAM_STR);
		$user -> bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);
		$user -> bindValue(":state",$_POST["state"],PDO::PARAM_INT);
		$user -> bindValue(":address",$_POST["address"],PDO::PARAM_STR);
		$user -> bindValue(":address2",$_POST["address2"],PDO::PARAM_STR);
		$user -> bindValue(":tel",$_POST["tel"],PDO::PARAM_STR);
		$user -> bindValue(":email",$_POST["email"],PDO::PARAM_STR);
		$user -> bindValue(":password",password_hash($_POST["password"],PASSWORD_DEFAULT),PDO::PARAM_STR);
		$user -> bindValue(":password2",$_POST["password"],PDO::PARAM_STR);
		$user -> bindValue(":service",$_POST["koumoku"],PDO::PARAM_STR);
		$user -> bindValue(":mailmaga",$_POST["mailmaga"],PDO::PARAM_INT);
		$user -> bindValue(":comment",$_POST["comment"],PDO::PARAM_STR);
		$user -> bindValue(":indate",date('Y-m-d H:i:s'),PDO::PARAM_STR);
		$user -> execute();
		
		
	// '****************************************************************
	// ' 送信メッセージ作成(管理者へ)
	// '****************************************************************
	$send_msg_manager = "\n";
	$send_msg_manager .= "【会員登録内容】\n";
	$send_msg_manager .= "------------------------------------------------------\n";
	$send_msg_manager .= "【ご利用予定のサービス】" . $_POST["koumoku"] ."\n";
	if ($_POST["company"]<>""){
	$send_msg_manager .= "【法人名】" . $_POST["company"] ."\n";
	$send_msg_manager .= "【部署】" . $_POST["busyo"] ."\n";
	}
	$send_msg_manager .= "【お名前】" . $_POST["name"] ."\n";
	$send_msg_manager .= "【ふりがな】" . $_POST["furigana"] ."\n";

	$send_msg_manager .= "【郵便番号】" . $_POST["zip1"] . "-" . $_POST["zip2"] ."\n";
	$send_msg_manager .= "【住所】" . $_POST["statename"] . $_POST["address"] . $_POST["address2"]."\n";
	
	$send_msg_manager .= "【電話番号】" . $_POST["tel"] ."\n";

	
	$send_msg_manager .= "【メールアドレス(ユーザーID)】" . $_POST["email"] ."\n";
	$send_msg_manager .= "【パスワード】" . $_POST["password"] ."\n";
	$send_msg_manager .= "【ご質問・ご要望など】" . $_POST["comment2"] ."\n";
	if ($_POST["mailmaga"]<>""){
	$mailmaga="希望する";
	}else{
	$mailmaga="希望しない";
	}

	$send_msg_manager .= "【メールマガジン配信希望】" . $mailmaga ."\n";
	
	$send_msg_manager .= "------------------------------------------------------\n";
	$send_msg_manager .= "\n";
	$send_msg_manager .= "\n";
	// '****************************************************************
	// ' 送信メッセージ作成(お客様へ)
	// '****************************************************************
	$send_msg_visitor = "\n";
	$send_msg_visitor .= "このメールは自動的に配信されております。\n\n";
	if ($_POST["name"]<>""){
		$send_msg_visitor .= $_POST["name"]. " 様\n";
	}else{
		$send_msg_visitor .= $_POST["email"]. " 様\n";
	}
	$send_msg_visitor .= "【太陽と野菜の直売所】を運営しております、 東浪見岡本農園です。\n";
	$send_msg_visitor .= "下記の会員登録情報をお預かり致しました。\n";
	$send_msg_visitor .= "以下URLよりログインしてください。\n";
	$send_msg_visitor .= $esulr. "member/login\n";
	$send_msg_visitor .= "\n";
	$send_msg_visitor .= "\n";
	// '****************************************************************
	// ' フッダー作成
	// '****************************************************************
	$send_msg_footer = "=====================================================\n";	
	$send_msg_footer .= " 【太陽と野菜の直売所】東浪見岡本農園\n";
	$send_msg_footer .= "　〒299-4303\n";
	$send_msg_footer .= "　千葉県長生郡一宮町東浪見4721番\n";
	$send_msg_footer .= "　TEL:".$mobile."\n";
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
	// ' 管理者へ
	// '****************************************************************
	$header = "From:".mb_encode_mimeheader("お客様")."<". $_POST["email"] .">\r\n";
	$subj = "【太陽と野菜の直売所】会員登録のお知らせ";
	$to = "<torami@okamoto-farm.co.jp>";
    $header .= "Bcc: <okamotofarm@docomo.ne.jp>\r\n";
	//$header .= "Content-Type: text/plain; charset=UTF-8\r\n";
	if(!empty($_POST["name"])){
		$send_msg = $_POST["name"] ."様からの会員登録のお知らせです。\n\n";
		$send_msg .= $send_msg_manager;
	}else{
		$send_msg = $_POST["email"] ."様からの会員登録のお知らせです。\n\n";
		$send_msg .= $send_msg_manager;
	}


	// '****************************************************************
	// ' 送信(管理者)
	// '****************************************************************
	if(mb_send_mail($to,$subj,$send_msg,$header)){
		$rs_manager = "";
	}else{
		$rs_manager = 1;
	}

	// '****************************************************************
	// ' お客様へ
	// '****************************************************************
	$header2 = "From:".mb_encode_mimeheader("【太陽と野菜の直売所】（東浪見岡本農園）")."<torami@okamoto-farm.co.jp>";
	$subj2 = "会員登録メール受付完了のお知らせ【太陽と野菜の直売所】";
	$to2 = "<" . $_POST["email"] .">";
	$send_msg2 = $send_msg_visitor.$send_msg_manager.$send_msg_footer;
	// '****************************************************************
	// ' 送信(お客様へ)
	// '****************************************************************
	if(mb_send_mail($to2,$subj2,$send_msg2,$header2)){
		$rs_visitor = "";
	}else{
		$rs_visitor = 1;
	}
	
	 if(!empty($rs_manager) || !empty($rs_visitor)){	
?>

		<div class="block">

	<p>送信に失敗しました。<br />メールアドレスに誤りがある可能性があります。<br />
何度も送信に失敗する場合は、torami@okamoto-farm.co.jpへ直接メールをお送り頂くか、お電話にてご連絡ください。
</p>

<p class="centering"><a href="<?=$esurl?>" class="underline">トップページへ戻る</a></p>
</div>

<?php
	 }else{
		$_SESSION['crsf_token']="";
?>

<div class="block">

	<p class="centering">会員登録メールが送信されました。<br />
自動返信メールをお送りしておりますので、内容をご確認ください。<br />
メールが届いていない場合は、迷惑メールフォルダに振り分けられた可能性があります。
</p>
		<?php
		if ($_POST["r"]==1 || str_contains($_POST["koumoku"],"疎開先ネットワーク")){
		?>
		<p><a href="<?=$esurl?>network_recruitment">「有事の際の「疎開先ネットワーク」募集のお願い」ページへ戻る</a>
		<?php
		}
		?>

<p class="centering"><a href="<?=$esurl?>" class="underline">トップページへ戻る</a></p>
</div>
<?php

	 }
}
} 
?>

<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88" /></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
