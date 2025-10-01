<?php $siteid=64?>
<?php include("include/autometa.php");?>
<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<?php include("config.php");?>


<head>
<meta name="robots" content="all">
<meta property="og:title" content="">
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
	<div id="cnt" class="recruitment farm company">

	<p class="pankuzu"><a href="<?=$esurl?>index.php">トップページ</a> | 有事の際の「疎開先ネットワーク」募集のお願い（送信完了）</p>
	<div class="block">
	<h2><img src="img/recruitment/h2.jpg" alt="有事の際の「疎開先ネットワーク」募集のお願い" width="780" height="205"></h2>

</div>


<?php
if(empty($_SESSION['crsf_token'])){
echo "<p>アクセスが不正です。</p>";
}elseif($_SESSION['crsf_token'] == filter_input(INPUT_POST,"token")){
	

	$sql = "SELECT * FROM t_user WHERE id=:userid";
	$u = $dbh->prepare($sql);
	$u -> bindValue(":userid",$_POST["userid"],PDO::PARAM_INT);
	$u -> execute();
	$rs = $u->fetch(PDO::FETCH_ASSOC);
	if(empty($rs)){
	$errmes  = "<p>会員登録されておりません。</p>";
	}else{
	$user_name = $rs["name"];
	$company_name = $rs["company"];
	}


if (!empty($errmes)){
	echo $errmes;
}else{	
		$sql = "INSERT INTO t_network (
        uid, namedisp, penname, companydisp,
        zip, state, address1, address2, address3,
        tel, email,
        syubetsu, space, roomnum, house, acceptednum, acceptesex, food, powersystem, solarsystem, drink, well,
        petliving, petok, indoor, petsize,
        stayfee, staycharge,
        meal, mealcharge,
        indate
		) VALUES (
			:uid, :namedisp, :penname, :companydisp,
			:zip, :state, :address1, :address2, :address3,
			:tel, :email,
			:syubetsu, :space, :roomnum, :house, :acceptednum, :acceptesex, :food, :powersystem, :solarsystem, :drink, :well,
			:petliving, :petok, :indoor, :petsize,
			:stayfee, :staycharge,
			:meal, :mealcharge,
			:indate
		)";

    $stmt = $dbh->prepare($sql);

    // 値のバインド
    $stmt->bindValue(':uid', $_POST['userid'],PDO::PARAM_INT);
    $stmt->bindValue(':namedisp', $_POST['name_open'],PDO::PARAM_STR);
    $stmt->bindValue(':penname', $_POST['penname'],PDO::PARAM_STR);
    $stmt->bindValue(':companydisp', $_POST['company_open'],PDO::PARAM_STR);

    $zip = $_POST['zip1'] . '-' . $_POST['zip2'];
    $stmt->bindValue(':zip', $zip,PDO::PARAM_STR);

    $stmt->bindValue(':state', $_POST['state'],PDO::PARAM_INT);
    $stmt->bindValue(':address1', $_POST['address'],PDO::PARAM_STR);
    $stmt->bindValue(':address2', $_POST['address2'],PDO::PARAM_STR);
    $stmt->bindValue(':address3', $_POST['address3'],PDO::PARAM_STR);

    $stmt->bindValue(':tel', $_POST['tel'],PDO::PARAM_STR);
    $stmt->bindValue(':email', $_POST['email'],PDO::PARAM_STR);

    $stmt->bindValue(':syubetsu', $_POST['syubetsu'],PDO::PARAM_STR);
    $stmt->bindValue(':space', $_POST['breadth'],PDO::PARAM_STR);
    $stmt->bindValue(':roomnum', intval($_POST['heya']), PDO::PARAM_INT);
    $stmt->bindValue(':house', $_POST['ikken'], PDO::PARAM_INT);
    $stmt->bindValue(':acceptednum', intval($_POST['ninzu']), PDO::PARAM_INT);
    $stmt->bindValue(':acceptesex', $_POST['sex'],PDO::PARAM_STR);
    $stmt->bindValue(':food', $_POST['food'],PDO::PARAM_STR);
    $stmt->bindValue(':powersystem', $_POST['power'],PDO::PARAM_STR);
    $stmt->bindValue(':solarsystem', $_POST['solar'],PDO::PARAM_STR);
    $stmt->bindValue(':drink', $_POST['well'],PDO::PARAM_STR);
    $stmt->bindValue(':well', $_POST['water'],PDO::PARAM_STR);

    $stmt->bindValue(':petliving', $_POST['pet'],PDO::PARAM_STR);
    $stmt->bindValue(':petok', $_POST['petok'],PDO::PARAM_STR);
    $stmt->bindValue(':indoor', $_POST['petplace'],PDO::PARAM_STR);
    $stmt->bindValue(':petsize', $_POST['petsize'],PDO::PARAM_STR);

    $stmt->bindValue(':stayfee', $_POST['price'],PDO::PARAM_STR);
    $stmt->bindValue(':staycharge', $_POST['fee'],PDO::PARAM_STR);

    $stmt->bindValue(':meal', $_POST['meal'],PDO::PARAM_STR);
    $stmt->bindValue(':mealcharge', $_POST['mealfee'],PDO::PARAM_STR);

    $stmt->bindValue(':indate', date('Y-m-d H:i:s'),PDO::PARAM_STR);

    // 実行
    $stmt->execute();
		
	// '****************************************************************
	// ' 送信メッセージ作成(管理者へ)
	// '****************************************************************
	// ユーザー情報（例: 別で取得済みの変数）
	

	// 公開・非公開判定
	$nameopen = ($_POST['name_open'] ?? '') == 1 ? '公開可' : '非公開';
	$companyopen = ($_POST['company_open'] ?? '') == 1 ? '公開可' : '非公開';

	$CRLF = "\r\n";  // 改行コード

	$send_msg_manager  = $CRLF;
	$send_msg_manager .= "【会員情報】" . $CRLF;
	$send_msg_manager .= "------------------------------------------------------" . $CRLF;

	$send_msg_manager .= "【お名前】" . $user_name . $CRLF;
	$send_msg_manager .= "【会社名】" . $company_name . $CRLF . $CRLF;

	$send_msg_manager .= "【応募内容】" . $CRLF;
	$send_msg_manager .= "------------------------------------------------------" . $CRLF;

	$send_msg_manager .= "【お名前の公開】" . $nameopen . $CRLF;
	$send_msg_manager .= "【ペンネーム】" . ($_POST['penname'] ?? '') . $CRLF;
	$send_msg_manager .= "【法人名の公開】" . $companyopen . $CRLF;

	$send_msg_manager .= "【郵便番号】" . ($_POST['zip1'] ?? '') . "-" . ($_POST['zip2'] ?? '') . $CRLF;
	$send_msg_manager .= "【住所】" . ($_POST['statename'] ?? '') . ($_POST['address'] ?? '') . ($_POST['address2'] ?? '') . $CRLF;
	$send_msg_manager .= "【対象住所】" . ($_POST['address3'] ?? '') . $CRLF;

	$send_msg_manager .= "【連絡先電話番号】" . ($_POST['tel'] ?? '') . $CRLF;
	$send_msg_manager .= "【メールアドレス】" . ($_POST['email'] ?? '') . $CRLF . $CRLF;

	$send_msg_manager .= "【提供可能種別】" . ($_POST['syubetsu'] ?? '') . $CRLF;
	$send_msg_manager .= "【広さ】" . ($_POST['breadth'] ?? '') . "㎡" . $CRLF;
	$send_msg_manager .= "【部屋数】" . ($_POST['heya'] ?? '') . "部屋" . $CRLF;

	if (!empty($_POST['ikken']) && $_POST['ikken'] == 1) {
		$send_msg_manager .= "【一軒家】あり" . $CRLF;
	}

	$send_msg_manager .= "【受入れ人数】" . ($_POST['ninzu'] ?? '') . "人" . $CRLF;
	$send_msg_manager .= "【受入れ性別】" . ($_POST['sex'] ?? '') . $CRLF;
	$send_msg_manager .= "【食料の有無】" . ($_POST['food'] ?? '') . $CRLF;
	$send_msg_manager .= "【自家発電システム設置の有無】" . ($_POST['power'] ?? '') . $CRLF;

	if (!empty($_POST['solar'])) {
		$send_msg_manager .= "【太陽光発電】" . $_POST['solar'] . $CRLF;
	}

	$send_msg_manager .= "【飲料水の有無】" . ($_POST['well'] ?? '') . $CRLF;

	if (!empty($_POST['water'])) {
		$send_msg_manager .= "【井戸水】" . $_POST['water'] . $CRLF;
	}

	$send_msg_manager .= "【ペット同居の有無】" . ($_POST['petok'] ?? '') . $CRLF;
	$send_msg_manager .= "【ペットの受入れ】" . ($_POST['pet'] ?? '') . $CRLF;

	if (($_POST['petok'] ?? '') === '可') {
		$send_msg_manager .= "【受入れ可の場合】" . ($_POST['petplace'] ?? '') . $CRLF;
		$send_msg_manager .= "【ペットのサイズ】" . ($_POST['petsize'] ?? '') . $CRLF;
	}

	$send_msg_manager .= "【宿泊費の有償・無償】" . ($_POST['price'] ?? '') . $CRLF;

	if (($_POST['price'] ?? '') === '有償') {
		$send_msg_manager .= "【宿泊費有償の場合】" . ($_POST['fee'] ?? '') . "円　～　ご相談" . $CRLF;
	}

	$send_msg_manager .= "【食事の提供】" . ($_POST['meal'] ?? '') . $CRLF;

	if (($_POST['meal'] ?? '') === '有償') {
		$send_msg_manager .= "【食事の提供有償の場合】" . ($_POST['mealfee'] ?? '') . "円　～　ご相談" . $CRLF;
	}

	$send_msg_manager .= "------------------------------------------------------" . $CRLF;
	$send_msg_manager .= $CRLF . $CRLF;




	// '****************************************************************
	// ' 送信メッセージ作成(お客様へ)
	// '****************************************************************
	$send_msg_visitor  = $CRLF;
	$send_msg_visitor .= "このメールは自動的に配信されております。" . $CRLF . $CRLF;

	if (!empty($user_name)) {
		$send_msg_visitor .= $user_name . " 様" . $CRLF;
	} else {
		$send_msg_visitor .= $email . " 様" . $CRLF;
	}

	$send_msg_visitor .= "【太陽と野菜の直売所】を運営しております、 株式会社 東浪見岡本農園です。" . $CRLF;
	$send_msg_visitor .= "下記の「疎開先ネットワーク」情報の応募内容をお預かり致しました。" . $CRLF;
	$send_msg_visitor .= "後日、担当者よりご連絡差し上げます。しばらくお待ちください。" . $CRLF;
	$send_msg_visitor .= $CRLF . $CRLF;
	// '****************************************************************
	// ' フッダー作成
	// '****************************************************************
	$send_msg_footer = "====================================================="  . $CRLF;
	$send_msg_footer .= " 【太陽と野菜の直売所】東浪見岡本農園"  . $CRLF;
	$send_msg_footer .= "　〒299-4303"  . $CRLF;
	$send_msg_footer .= "　千葉県長生郡一宮町東浪見4721番"  . $CRLF;
	$send_msg_footer .= "　TEL:".$mobile  . "\n";
	$send_msg_footer .= "　E-mail：torami@okamoto-farm.co.jp"  . $CRLF;
	$send_msg_footer .= "　URL：https://www.okamoto-farm.co.jp"  . $CRLF;
	$send_msg_footer .= "=====================================================" . $CRLF;
	$send_msg_footer .= ""  . $CRLF;
	// '****************************************************************
	// ' メール送信
	// '****************************************************************
	mb_language("japanese");
    mb_internal_encoding("UTF-8");
	// '****************************************************************
	// ' 管理者へ
	// '****************************************************************
	$header = "From:".mb_encode_mimeheader("お客様")."<". $_POST["email"] .">\r\n";
	$subj = "【太陽と野菜の直売所】「疎開先ネットワーク」情報応募のお知らせ";
	$to = "<torami@okamoto-farm.co.jp>";
    $header .= "Bcc: <okamotofarm@docomo.ne.jp>\r\n";
	// $to = "<ishibashi@autumn-tec.co.jp>";
    // $header .= "Bcc: <youkiguitar@yahoo.co.jp>\r\n";
	//$header .= "Content-Type: text/plain; charset=UTF-8\r\n";
	if (!empty($user_name)){
		$send_msg = $user_name & "様からの「疎開先ネットワーク」情報応募のお知らせです。" . $CRLF. $CRLF;
		$send_msg .= $send_msg_manager;
	}else{
		$send_msg = $_POST["email"] . "様からの「疎開先ネットワーク」情報応募のお知らせです。" . $CRLF. $CRLF;
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
	
	$header2= "From:".mb_encode_mimeheader("【太陽と野菜の直売所】（東浪見岡本農園）")."<torami@okamoto-farm.co.jp>";
	$subj2 = "「疎開先ネットワーク」情報応募メール受付完了のお知らせ【太陽と野菜の直売所】";
	$to2 = "<" . $_POST["email"] .">";
	$send_msg2 = $send_msg_visitor.$send_msg_manager.$send_msg_footer;
	// '****************************************************************
	// ' 送信エラーチェック(お客様へ)
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
何度も送信に失敗する場合は、torami@okamoto-farm.co.jpへ直接メールをお送り頂くか、お電話にてご連絡ください。</p>

<p class="centering"><a href="<?=$esurl?>index.php" class="underline">トップページへ戻る</a></p>
</div>

<?php
	 }else{
		$_SESSION['crsf_token']="";
?>

<div class="block">

	<p class="centering">「疎開先ネットワーク」情報応募メールが送信されました。<br>
自動返信メールをお送りしておりますので、内容をご確認ください。<br>
メールが届いていない場合は、迷惑メールフォルダに振り分けられた可能性があります。
</p>

<p class="centering"><a href="<?=$esurl?>index.php" class="underline">トップページへ戻る</a></p>
</div>

<?php

	 }
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
