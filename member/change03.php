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

<title>会員情報編集（登録完了）／農産物直売所 千葉【太陽と野菜の直売所】貸し農園 一宮町／野菜狩り／農業体験</title>

<link rel="stylesheet" href="../css/base.css" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

<script src="../js/jquery-1.5.2.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../js/jquery.ui.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="../js/jquery.bgswitcher.js"></script>
<script src="../js/pagetop.js"></script>

<script src="../js/topslide.js"></script>
<script src="../js/regist_chk.js"></script>

</head>

<body>

<div id="box">

<div id="header">
	<h1>新鮮野菜 直売所／千葉 一宮町</h1>


<?php include("../include/header.php")?>


<div id="main" class="container">
	<?php include("../include/leftpane.php")?>
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | <a href="<?=$esurl?>member/mypage">会員マイページ</a> | 会員情報編集（登録完了）</p>
	<div class="block">
	<h2>会員情報編集（登録完了）</h2>

</div>

<?php
if(empty($_SESSION['crsf_token'])){
echo "<p>アクセスが不正です。</p>";
}elseif($_SESSION['crsf_token'] == filter_input(INPUT_POST,"token")){


		$sql = "UPDATE t_user set company=:company,busyo=:busyo,name=:name,furigana=:furigana,zip=:zip,state=:state,address=:address,address2=:address2,";
		$sql .= "tel=:tel,email=:email,mailmaga=:mailmaga";
		if(!empty($_POST["password"])){
			$sql .= ",password=:password,password2=:password2";
		}
		$sql .= " Where id=:id";
		$user = $dbh->prepare($sql);
		$user -> bindValue(":company",$_POST["company"],PDO::PARAM_STR);
		$user -> bindValue(":busyo",$_POST["busyo"],PDO::PARAM_STR);
		$user -> bindValue(":name",$_POST["name"],PDO::PARAM_STR);
		$user -> bindValue(":furigana",$_POST["furigana"],PDO::PARAM_STR);
		$user -> bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);
		$user -> bindValue(":state",$_POST["state"],PDO::PARAM_INT);
		$user -> bindValue(":address",$_POST["address"],PDO::PARAM_STR);
		$user -> bindValue(":address2",$_POST["address2"],PDO::PARAM_STR);
		$user -> bindValue(":tel",$_POST["tel"],PDO::PARAM_STR);
		$user -> bindValue(":email",$_POST["email"],PDO::PARAM_STR);
		if(!empty($_POST["password"])){
			$user -> bindValue(":password",password_hash($_POST["password"],PASSWORD_DEFAULT),PDO::PARAM_STR);
			$user -> bindValue(":password2",$_POST["password2"],PDO::PARAM_STR);
		}
		$user -> bindValue(":mailmaga",$_POST["mailmaga"],PDO::PARAM_INT);
		$user -> bindValue(":id",$_POST["id"],PDO::PARAM_INT);
		$user -> execute();
		
	// '****************************************************************
	// ' 送信メッセージ作成(管理者へ)
	// '****************************************************************
	$send_msg_manager = "\n";
	$send_msg_manager .= "【会員登録内容】\n";
	$send_msg_manager .= "------------------------------------------------------\n";
	
if(!empty($_POST["company"])){
	$send_msg_manager .= "【法人名】" . $_POST["company"] . "\n";
	$send_msg_manager .= "【部署名】" . $_POST["busyo"] . "\n";	
}
$send_msg_manager .= "【お名前】" . $_POST["name"] . "\n";
	$send_msg_manager .= "【ふりがな】" . $_POST["furigana"] . "\n";

	$send_msg_manager .= "【郵便番号】" . $_POST["zip1"] . "-" . $_POST["zip2"] . "\n";
	$send_msg_manager .= "【住所】" . $_POST["statename"] . $_POST["address"] . $_POST["address2"] . "\n";
	
	$send_msg_manager .= "【電話番号】" . $_POST["tel"] . "\n";
	
	$send_msg_manager .= "【メールアドレス】" . $_POST["email"] . "\n";
	
	if(!empty($_POST["password"])){
	$send_msg_manager .= "【パスワード】" . $_POST["password"] . "\n";
	}

	if(!empty($_POST["mailmaga"])){
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
	if(!empty($_POST["name"])){
		$send_msg_visitor .= $_POST["name"] . " 様\n";
	}else{
		$send_msg_visitor .= $_POST["email"] . " 様\n";
	}
	$send_msg_visitor .= "【太陽と野菜の直売所】を運営しております、東浪見岡本農園です。\n";
	$send_msg_visitor .= "下記の会員登録情報にて変更完了いたしました。\n";
	
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
	$subj = "【太陽と野菜の直売所】会員登録情報 変更のお知らせ";
	$to = "<torami@okamoto-farm.co.jp>";
    $header .= "Bcc: <okamotofarm@docomo.ne.jp>\r\n";
	//$header .= "Content-Type: text/plain; charset=UTF-8\r\n";
	if(!empty($_POST["name"])){
		$send_msg = $_POST["name"] . "様から会員登録情報 変更のお知らせです。\n\n";
		$send_msg .= $send_msg_manager;
	}else{
		$send_msg = $_POST["email"] ."様から会員登録情報 変更のお知らせです。\n\n";
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
	$subj2 = "会員登録情報 変更受付完了のお知らせ【太陽と野菜の直売所】";
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

	<p>送信に失敗しました。<br>メールアドレスに誤りがある可能性があります。<br>
何度も送信に失敗する場合は、torami@okamoto-farm.co.jpへ直接メールをお送り頂くか、お電話にてご連絡ください。
</p>

<p class="centering"><a href="<?=$esurl?>member/mypage.php" class="underline">会員マイページへ戻る</a></p>
</div>

<?php
	 }else{
		$_SESSION['crsf_token']="";
?>


<div class="block">

	<p>会員登録変更メールが送信されました。</p>

<p class="centering"><a href="<?=$esurl?>member/mypage.php" class="underline">会員マイページへ戻る</a></p>
</div>
<?php

	 }
}

?>

<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("../include/rightpane.php")?>

<!-- id main end --></div>

<?php include("../include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
