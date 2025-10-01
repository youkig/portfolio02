<?php $siteid=45?>
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
<script src="js/bbs_chk.js"></script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>
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
	<div id="cnt" class="fashion ichinomiya">

	<p class="pankuzu"><a href="<?=$esurl?>index.php">トップページ</a> | 千葉県一宮町へ移住をお考えの方々へ | 一宮町町政への苦情、ご意見投稿ページ（送信完了）</p>
	<div class="block">
	<h2>千葉県一宮町へ移住をお考えの方々へ</h2>

<h3><img src="img/ichinomiya/h3_02.png" alt="一宮町町政への苦情、ご意見投稿ページ" width="780" height="205"></h3>

</div>

<?php
if(empty($_SESSION['crsf_token'])){
echo "<p>アクセスが不正です。</p>";
}elseif($_SESSION['crsf_token'] == filter_input(INPUT_POST,"token")){

    $sql = "Insert into t_bbs (";
	$sql.= "name,penname,zip,state,address,address2,tel,email,category,comment,indate) values ";
	$sql.= "(:name,:penname,:zip,:state,:address,:address2,:tel,:email,:category,:comment,:indate)";
	$b = $dbh->prepare($sql);
	$b -> bindValue(":name",$_POST["name"],PDO::PARAM_STR);
	$b -> bindValue(":penname",$_POST["penname"],PDO::PARAM_STR);
	$b -> bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);
    $b -> bindValue(":state",$_POST["state"],PDO::PARAM_STR);
	$b -> bindValue(":address",$_POST["address"],PDO::PARAM_STR);
	$b -> bindValue(":address2",$_POST["address2"],PDO::PARAM_STR);  
    $b -> bindValue(":tel",$_POST["tel"],PDO::PARAM_STR);  
	$b -> bindValue(":email",$_POST["email"],PDO::PARAM_STR);  
	$b -> bindValue(":category",$_POST["category"],PDO::PARAM_STR);  
	$b -> bindValue(":comment",$_POST["comment"],PDO::PARAM_STR);  
	$b -> bindValue(":indate",date('Y-m-d H:i:s'),PDO::PARAM_STR);          
    $b->execute();
        
      
	// '****************************************************************
	// ' 送信メッセージ作成(管理者へ)
	// '****************************************************************
	$send_msg_manager = "\n";
	$send_msg_manager .= "【送信内容】\n";
	$send_msg_manager .= "------------------------------------------------------\n";
	
	$send_msg_manager .= "【お名前】" . $_POST["name"] . "\n";
    $send_msg_manager .= "【ペンネーム】" . $_POST["penname"] . "\n";
    $send_msg_manager .= "【郵便番号】" . $_POST["zip1"] . "-" . $_POST["zip2"] . "\n";
	$send_msg_manager .= "【住所】" . $_POST["state"] . $_POST["address"] . $_POST["address2"]. "\n";
	
	$send_msg_manager .= "【電話番号】" . $_POST["tel"] . "\n";
	$send_msg_manager .= "【メールアドレス】" . $_POST["email"] . "\n";
	
	$send_msg_manager .= "【対象の組織・課】" . $_POST["category"] . "\n";
	$send_msg_manager .= "【投稿内容】" . $_POST["comment"] . "\n";
	$send_msg_manager .= "------------------------------------------------------\n";
	$send_msg_manager .= "\n";
	$send_msg_manager .= "\n";
	// '****************************************************************
	// ' 送信メッセージ作成(お客様へ)
	// '****************************************************************
	$send_msg_visitor = "\n";
	$send_msg_visitor .= "このメールは自動的に配信されております。\n\n";
	if(!empty($_POST["name"])){
		$send_msg_visitor .= $_POST["name"] . " 様\n\n";
	}else{
		$send_msg_visitor .= $_POST["email"] . " 様\n\n";
	}
	$send_msg_visitor .= "【太陽と野菜の直売所】を運営しております、 東浪見岡本農園です。\n";
	$send_msg_visitor .= "下記の「一宮町町政への苦情、ご意見投稿」をお預かり致しました。\n";
	$send_msg_visitor .= "担当者が内容を確認の上、ホームページに掲載させて頂きます。\n";
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
	$subj = "【太陽と野菜の直売所】一宮町町政への苦情、ご意見投稿送信のお知らせ";
	$to = "<torami@okamoto-farm.co.jp>";
   	$header .= "Bcc: <okamotofarm@docomo.ne.jp>\r\n";
	// $to = "<ishibashi@autumn-tec.co.jp>";
   	// $header .= "Bcc: <youkiguitar@yahoo.co.jp>\r\n";
	//$header .= "Content-Type: text/plain; charset=UTF-8\r\n";

	if(!empty($_POST["name"])){
		$send_msg = $_POST["name"] ."様からの苦情、ご意見投稿送信がありました。\n\n";
		$send_msg .= $send_msg_manager;
	}else{
		$send_msg = $_POST["email"] ."様からの苦情、ご意見投稿送信がありました。\n\n";
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
	$subj2 = "一宮町町政への苦情、ご意見投稿受付完了のお知らせ【太陽と野菜の直売所】";
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

	<p>一宮町町政への苦情、ご意見投稿内容が送信されました。<br />後日担当者よりご連絡差し上げますので、今しばらくお待ちください。<br />
尚、数日経ってもご連絡が無い場合は、torami@okamoto-farm.co.jpへ直接メールをお送り頂くか、お電話にてご連絡ください。
</p>

<p class="centering"><a href="<?=$esurl?>" class="underline">トップページへ戻る</a></p>
</div>
<?php
	}
}
?>
<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
