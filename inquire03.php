<?php $siteid=54?>
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
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

<script src="js/jquery-1.5.2.min.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" href="js/jquery.ui.css" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="js/jquery.bgswitcher.js"></script>
<script src="js/pagetop.js"></script>

<script src="js/topslide.js"></script>

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
	
	<div id="cnt" class="company">

	<p class="pankuzu"><a href="<?=$esurl?>index.php">トップページ</a> | お問合せ・お申込み（送信完了）</p>
	<div class="block">
	<h2>お問合せ・お申込み（送信完了）</h2>

	</div>

<?php
if(empty($_SESSION['crsf_token'])){
echo "<p>アクセスが不正です。</p>";
}elseif($_SESSION['crsf_token'] == filter_input(INPUT_POST,"token")){

	// '****************************************************************
	// ' 送信メッセージ作成(管理者へ)
	// '****************************************************************
	$send_msg_manager = "\n";
	$send_msg_manager .=  "【お問合せ内容】\n";
	$send_msg_manager .=  "------------------------------------------------------\n";
	$send_msg_manager .=  "【お問合せ項目】" . $_POST["koumoku"] ."\n";
if (!empty($_POST["sname"])){
	$send_msg_manager .=  "【問合せしたい商品】" . $_POST["sname"] ."\n";
}
	$send_msg_manager .=  "【法人・個人】" . $_POST["person"] ."\n";
if ($_POST["person"]=="法人"){
	$send_msg_manager .=  "【法人名】" . $_POST["company"] ."\n";
	$send_msg_manager .=  "【部署名】" . $_POST["busyo"] ."\n";
}
	$send_msg_manager .=  "【お名前】" . $_POST["name"] ."\n";
	$send_msg_manager .=  "【ふりがな】" . $_POST["furigana"] ."\n";
	$send_msg_manager .=  "【メールアドレス】" . $_POST["email"] ."\n";
	$send_msg_manager .=  "【電話番号】" . $_POST["tel"] ."\n";
	$send_msg_manager .=  "【郵便番号】" . $_POST["zip1"] & "-" & $_POST["zip2"] ."\n";
	$send_msg_manager .=  "【住所】" . $_POST["state"] .$_POST["address"] .$_POST["address2"]."\n";
	
	
	$send_msg_manager .=  "【お問合せ内容】".$_POST["comment"] ."\n";
	$send_msg_manager .=  "------------------------------------------------------\n";
	$send_msg_manager .=  "\n";
	$send_msg_manager .=  "\n";
	// '****************************************************************
	// ' 送信メッセージ作成(お客様へ)
	// '****************************************************************
	$send_msg_visitor = "\n";
	$send_msg_visitor .= "このメールは自動的に配信されております。" ."\n\n";
	if (!empty($_POST["name"])){
		$send_msg_visitor .= $_POST["name"] . " 様\n";
	}else{
		$send_msg_visitor .= $_POST["email"] . " 様\n";
	}
	$send_msg_visitor .= "【太陽と野菜の直売所】を運営しております、 株式会社 東浪見岡本農園です。\n";
	$send_msg_visitor .= "下記のお問合せメールをお預かり致しました。\n";
	$send_msg_visitor .= "弊社担当者から1営業日以内にご連絡させていただきます。\n";
	$send_msg_visitor .= "\n";
	$send_msg_visitor .= "\n";
	// '****************************************************************
	// ' フッダー作成
	// '****************************************************************
	$send_msg_footer = "=====================================================\n";	
	$send_msg_footer .=  " 【太陽と野菜の直売所】東浪見岡本農園\n";
	$send_msg_footer .=  "　〒299-4303\n";
	$send_msg_footer .=  "　千葉県長生郡一宮町東浪見4721番\n";
	$send_msg_footer .=  "　TEL:".$mobile."\n";
	$send_msg_footer .=  "　E-mail：torami@okamoto-farm.co.jp\n";
	$send_msg_footer .=  "　URL：https://www.okamoto-farm.co.jp\n";
	$send_msg_footer .=  "=====================================================\n";
	$send_msg_footer .=  "\n";
	// '****************************************************************
	// ' メール送信
	// '****************************************************************
	mb_language("japanese");
    mb_internal_encoding("UTF-8");
	// '****************************************************************
	// ' 管理者へ
	// '****************************************************************
	$header = "From:".mb_encode_mimeheader("お客様")."<". $_POST["email"] .">\r\n";
	$subj = "【太陽と野菜の直売所】お問合せメールのお知らせ";
	$to = "<torami@okamoto-farm.co.jp>";
   	$header .= "Bcc: <okamotofarm@docomo.ne.jp>\r\n";

	//$header .= "Content-Type: text/plain; charset=UTF-8\r\n";
	if(!empty($_POST["name"])){
		$send_msg = $_POST["name"] ."様からのお問合せです。\n\n";
		$send_msg .= $send_msg_manager;
	}else{
		$send_msg = $_POST["email"] ."様からのお問合せです。\n\n";
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
	$subj2 = "お問合せメール受付完了のお知らせ【太陽と野菜の直売所】";
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

	<p>お問合せメールが送信されました。<br />後日担当者よりご連絡差し上げますので、今しばらくお待ちください。<br />
尚、数日経ってもご連絡が無い場合は、torami@okamoto-farm.co.jpへ直接メールをお送り頂くか、お電話にてご連絡ください。
</p>

<p class="centering"><a href="<?=$esurl?>" class="underline">トップページへ戻る</a></p>
</div>

<?php
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
