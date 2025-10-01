<?php $siteid=51?>
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


	<div id="cnt2">

<h2>「疎開先ネットワーク」提供者への問合せ（送信完了）</h2>

<?php
if(empty($_SESSION['crsf_token'])){
echo "<p>アクセスが不正です。</p>";
}elseif($_SESSION['crsf_token'] == filter_input(INPUT_POST,"token")){

// 'IPアドレスを購入者管理に追加登録（念のためエラー回避）

		$userIP = $_SERVER['REMOTE_ADDR'];
		$userHost = gethostbyaddr($userIP);

		$sql = "INSERT into t_network_inq (tid,uid,name,furigana,sex,zip,state,address,address2,tel,email,personnum,adult,child,petok,pet,stayok,foodok,comment,indate,ipaddress,hostname)";
		$sql .= " VALUES (:tid,:uid,:name,:furigana,:sex,:zip,:state,:address,:address2,:tel,:email,:personnum,:adult,:child,:petok,:pet,:stayok,:foodok,:comment,:indate,:ipaddress,:hostname)";
		
		$n = $dbh->prepare($sql);
		$n -> bindValue(":tid",$_POST["id"],PDO::PARAM_INT);
		$n -> bindValue(":uid",$_SESSION["setid"],PDO::PARAM_INT);
		$n -> bindValue(":name",$_POST["name"],PDO::PARAM_STR);
		$n -> bindValue(":furigana",$_POST["furigana"],PDO::PARAM_STR);
		$n -> bindValue(":sex",$_POST["sex"],PDO::PARAM_STR);
		$n -> bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);
		$n -> bindValue(":state",$_POST["state"],PDO::PARAM_INT);
		$n -> bindValue(":address",$_POST["address"],PDO::PARAM_STR);
		$n -> bindValue(":address2",$_POST["address2"],PDO::PARAM_STR);
		$n -> bindValue(":tel",$_POST["tel"],PDO::PARAM_STR);
		$n -> bindValue(":email",$_POST["email"],PDO::PARAM_STR);
		$n -> bindValue(":personnum",$_POST["ninzu"],PDO::PARAM_INT);
		$n -> bindValue(":adult",$_POST["adult"],PDO::PARAM_INT);
		$n -> bindValue(":child",$_POST["child"],PDO::PARAM_INT);
		$n -> bindValue(":petok",$_POST["petok"],PDO::PARAM_STR);
		$n -> bindValue(":pet",$_POST["petnaiyo"],PDO::PARAM_STR);
		$n -> bindValue(":stayok",$_POST["hotel"],PDO::PARAM_STR);
		$n -> bindValue(":foodok",$_POST["food"],PDO::PARAM_STR);
		$n -> bindValue(":comment",$_POST["comment"],PDO::PARAM_STR);
		$n -> bindValue(":indate",date('Y-m-d H:i:s'),PDO::PARAM_STR);
		$n -> bindValue(":ipaddress",$userIP,PDO::PARAM_STR);
		$n -> bindValue(":hostname",$userHost,PDO::PARAM_STR);
		$n -> execute();

$sql="SELECT t_user.name,t_user.company,t_network.* From t_user inner join t_network on t_user.id=t_network.uid Where t_network.id=:id and t_network.shinsa=1 and t_network.cancel=0";
$n = $dbh->prepare($sql);
$n -> bindValue(":id",$_POST["id"],PDO::PARAM_INT);
$n -> execute();
$rs = $n->fetch(PDO::FETCH_ASSOC);
if (!empty($rs)){

$company_name2 = $rs["company"];

if ($rs["companydisp"]==1){
$company_name = $rs["company"];
}else{
$company_name = "非公開";
}

$name_open2 = $rs["name"];
if ($rs["namedisp"]==1){
$name_open = $rs["name"];
}elseif (!empty($rs["penname"])){
$name_open = $rs["penname"];
}else{
$name_open = "非公開";
}

$petok=0;
if ($rs["petok"]=="可"){
$petok=1;
}

$temail = $rs["email"];
}
		
	// '****************************************************************
	// ' 送信メッセージ作成(管理者へ)
	// '****************************************************************
	$send_msg_manager1 = "\n";
	$send_msg_manager1 .="【提供会員情報】\n";
	$send_msg_manager1 .="------------------------------------------------------\n";
	$send_msg_manager1 .="【会社名】" . $company_name ."\n";
	$send_msg_manager1 .="【お名前】" . $name_open ."\n";

// '管理者へ
	$send_msg_manager2 = "\n";
	$send_msg_manager2 .= "【提供会員情報】\n";
	$send_msg_manager2 .= "------------------------------------------------------\n";
	$send_msg_manager2 .= "【会社名】" . $company_name2 ."\n";
	$send_msg_manager2 .= "【お名前】" . $name_open2 ."\n";
	$send_msg_manager2 .= "【URL】" . $esurl . "control/network_userdisp.php?id=". $_POST["id"]."\n";

	$send_msg_manager = "\n";
	$send_msg_manager .="【お客様情報】\n";
	$send_msg_manager .="------------------------------------------------------\n";

	$send_msg_manager .="【お名前】" . $_POST["name"]."\n";

	$send_msg_manager .="【ふりがな】" . $_POST["furigana"]."\n";
	$send_msg_manager .="【性別】" . $_POST["sex"]."\n";

	$send_msg_manager .="【郵便番号】" . $_POST["zip1"] . "-" . $_POST["zip2"]."\n";
	$send_msg_manager .="【住所】" . $_POST["statename"] . $_POST["address"] . $_POST["address2"]."\n";
	

	$send_msg_manager .="【連絡先電話番号】" . $_POST["tel"]."\n";
	$send_msg_manager .="【メールアドレス】" . $_POST["email"]."\n\n";

	$send_msg_manager .="【希望利用人数】 合計: " . $_POST["ninzu"] . "人\n";
	$send_msg_manager .="【大人】" . $_POST["adult"]. "人\n";
	$send_msg_manager .="【子供】" . $_POST["child"]. "人\n";


if ($petok==1){
if (!empty($_POST["petok"])){
$petuke = "希望する";
}else{
$petuke = "希望しない";
}
$send_msg_manager .="【ペットの受入れ】" . $petuke ."\n";
$send_msg_manager .="【ペットの種類等】" . $_POST["petnaiyo"] ."\n";
}

if (!empty($_POST["hotel"])){
	$hotel = $_POST["hotel"];
}else{
	$hotel = "希望しない";
}

$send_msg_manager .="【宿泊施設の提供】" . $hotel ."\n";

if (!empty($_POST["food"])){
$food = $_POST["food"];
}else{
$food = "希望しない";
}

$send_msg_manager .="【食事の提供】" . $food ."\n";

	$send_msg_manager .="【ご質問・ご希望など】" . $_POST["comment"] ."\n";
	$send_msg_manager .="------------------------------------------------------\n";
	$send_msg_manager .="\n";
	$send_msg_manager .="\n";
	// '****************************************************************
	// ' 送信メッセージ作成(お客様へ)
	// '****************************************************************
	$send_msg_visitor ="\n";
	$send_msg_visitor .="このメールは自動的に配信されております。\n\n";
	if (!empty($user_name)){
		$send_msg_visitor .=$_POST["name"] . " 様\n";
	}else{
		$send_msg_visitor .=$_POST["email"] . " 様\n";
	}
	$send_msg_visitor .="【太陽と野菜の直売所】を運営しております、 株式会社 東浪見岡本農園です。\n";
	$send_msg_visitor .="下記の「疎開先ネットワーク」ご提供者様へのお問合せをお預かり致しました。\n";
	$send_msg_visitor .="後日、担当者よりご連絡差し上げます。しばらくお待ちください。\n";
	$send_msg_visitor .="\n";
	$send_msg_visitor .="\n";
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
	$subj = "【太陽と野菜の直売所】「疎開先ネットワーク」ご提供者様へのお問合せ";
	$to = "<torami@okamoto-farm.co.jp>";
	$header .= "Bcc: <okamotofarm@docomo.ne.jp>\r\n";
	//$header .= "Content-Type: text/plain; charset=UTF-8\r\n";
	if(!empty($_POST["name"])){
		$send_msg = $_POST["name"] ."様から「疎開先ネットワーク」ご提供者様へのお問合せがありました。\n\n";
		$send_msg .= $send_msg_manager2 . $send_msg_manager;
	}else{
		$send_msg = $_POST["email"] ."様から「疎開先ネットワーク」ご提供者様へのお問合せがありました。\n\n";
		$send_msg .= $send_msg_manager2 . $send_msg_manager;
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
	$subj2 = "「疎開先ネットワーク」ご提供者様へのお問合せ受付完了のお知らせ【太陽と野菜の直売所】";
	$to2 = "<" . $_POST["email"] .">";
	$send_msg2 = $send_msg_visitor.$send_msg_manager1.$send_msg_manager.$send_msg_footer;

	// '****************************************************************
	// ' 送信(お客様へ)
	// '****************************************************************
	if(mb_send_mail($to2,$subj2,$send_msg2,$header2)){
		$rs_visitor = "";
	}else{
		$rs_visitor = 1;
	}	
	// '****************************************************************


// '****************************************************************
// 	'「疎開先ネットワーク」ご提供者へ
// 	'****************************************************************
	$header3 = "From:".mb_encode_mimeheader("【太陽と野菜の直売所】東浪見岡本農園")."<torami@okamoto-farm.co.jp>";
	$subj3 = "「疎開先ネットワーク」ユーザー様からお問合せ受付完了のお知らせ【太陽と野菜の直売所】";
	$to3 = "<" . $temail . ">";
	$send_msg_manager3 = "\n";
	$send_msg_manager3 .= $name_open2 . "様\n\n";

	$send_msg_manager3 .= "いつも【東浪見岡本農園】をご利用頂きまして誠にありがとうございます。\n";
	$send_msg_manager3 .= "以下、「疎開先ネットワーク」について、ユーザー様よりお問合せがありました。\n";
	$send_msg_manager3 .= "内容をご確認の上、ご対応をお願いいたします。\n\n";
	$send_msg_manager3 .= "※尚、こちらのメールに返信しても、ユーザー様への返信は出来ませんので、ご注意ください。\n\n";
	$send_msg3 = $send_msg_manager3 . $send_msg_manager . $send_msg_footer;
	
	
	if(mb_send_mail($to3,$subj3,$send_msg3,$header3)){
		$rs_user = "";
	}else{
		$rs_user = 1;
	}	

	
    if(!empty($rs_manager) || !empty($rs_visitor)){	
?>


<div class="block">

	<p>送信に失敗しました。<br>メールアドレスに誤りがある可能性があります。<br>
何度も送信に失敗する場合は、torami@okamoto-farm.co.jpへ直接メールをお送り頂くか、お電話にてご連絡ください。
</p>

<p class="centering"><a href="<%=ESURL%>index.php" class="underline">トップページへ戻る</a></p>
</div>

<?php
	}else{
		$_SESSION['crsf_token']="";
	?>
<div class="block">

	<p class="centering">「疎開先ネットワーク」ご提供者様へのお問合せメールが送信されました。<br>
自動返信メールをお送りしておりますので、内容をご確認ください。<br>
メールが届いていない場合は、迷惑メールフォルダに振り分けられた可能性があります。
</p>

<p class="centering"><a href="javascript.void(0)" class="underline" onClick="window.close()">ウィンドウを閉じる</a></p>
</div>
<?php
	}
}
?>


<!-- id cnt2 end --></div>



</body>
</html>
