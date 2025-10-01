<?php $siteid=79?>
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
	<div id="cnt" class="company cart">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 注文フォーム（送信完了）</p>
	<div class="block">
	<h2>注文フォーム（送信完了）</h2>
</div>
<?php
if(empty($_SESSION['crsf_token'])){
echo "<p>アクセスが不正です。</p>";
}elseif($_SESSION['crsf_token'] == filter_input(INPUT_POST,"token")){

//データベース登録

	//メインオーダー
	//reserveno抽出
	$sql="SELECT max(id) as mid From t_reserved";
	$r = $dbh->prepare($sql);
	$r -> execute();
	$rsm = $r->fetch(PDO::FETCH_ASSOC);
	$reservedno="RN" . sprintf('%05d',cnum($rsm["mid"])+1);
	
	$sql = "Insert into t_reserved ";
	$sql .= "(reserveno,name,furigana,zip,state,address,tel,email,rmonth,rday,comment,indate) values ";
	$sql .= "(:reserveno,:name,:furigana,:zip,:state,:address,:tel,:email,:rmonth,:rday,:comment,:indate)";
	$r = $dbh->prepare($sql);
	$r->bindValue(":reserveno",$reservedno,PDO::PARAM_STR);
	$r->bindValue(":name",$_POST["name"],PDO::PARAM_STR);
	$r->bindValue(":furigana",$_POST["furigana"],PDO::PARAM_STR);
	$r->bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);	
	$r->bindValue(":state",$_POST["state"],PDO::PARAM_STR);	
	$r->bindValue(":address",$_POST["address"].$_POST["address2"],PDO::PARAM_STR);		
	$r->bindValue(":tel",$_POST["tel"],PDO::PARAM_STR);		
	$r->bindValue(":email",$_POST["email"],PDO::PARAM_STR);			
	$r->bindValue(":rmonth",$_POST["month"],PDO::PARAM_INT);		
	$r->bindValue(":rday",$_POST["day"],PDO::PARAM_INT);
	$r->bindValue(":comment",$_POST["comment"],PDO::PARAM_STR);
	$r->bindValue(":indate",date('Y-m-d H:i:s'),PDO::PARAM_STR);	
	$r->execute();
		
					$str = "";
					$count1 = 0;
					foreach($_COOKIE as $key=>$val){
					
						if(strpos($key,"okamotofarm")!==false){
						$tyumon=1;
						$cnt++;
						$sid = str_replace("okamotofarm_","",$key);
							$sql="SELECT * From t_master Where id=:id";
							$p = $dbh->prepare($sql);
							$p->bindValue(":id",$sid,PDO::PARAM_INT);
							$p->execute();
							$rss = $p->fetch(PDO::FETCH_ASSOC);
							if (!empty($rss)){
							
							$sql = "Insert into t_reserveditem (reserveno,sid,price,num) values (:reserveno,:sid,:price,:num)";
							$r = $dbh->prepare($sql);
							$r->bindValue(":reserveno",$reservedno,PDO::PARAM_STR);
							$r->bindValue(":sid",$sid,PDO::PARAM_INT);
							$r->bindValue(":price",$rss["price"],PDO::PARAM_INT);
							$r->bindValue(":num",$val,PDO::PARAM_INT);
							$r->execute();

							$sql = "UPDATE t_master set num=num-:num Where id=:sid";
							$u = $dbh->prepare($sql);
							$u->bindValue(":num",$val,PDO::PARAM_INT);
							$u->bindValue(":sid",$sid,PDO::PARAM_INT);
							$u->execute();
							
							$count1++;
							
							$str .= $count1 . ". ". $rss["item"]. "　" . cnum($val) . $rss["unit"] . "　" . "単価：￥" . number_format($rss["price"]) . "\n\n";
							
							$SUM += cnum($rss["price"])*$val;
							}
							
						}
					}	
			

//ここまで				
	// '****************************************************************
	// ' 送信メッセージ作成(管理者へ)
	// '****************************************************************
	$send_msg_manager = "\n";
	$send_msg_manager .= "【ご注文商品】\n";
	$send_msg_manager .= "------------------------------------------------------\n";
	
	$send_msg_manager .= $str ."\n";
	$send_msg_manager .= "[合計金額] " . "￥". number_format($SUM) ."\n\n";

	
	$send_msg_manager .= "【お客様情報】\n";
	$send_msg_manager .= "------------------------------------------------------\n";
	
	$send_msg_manager .= "【お名前】" . $_POST["name"] . "\n";
	$send_msg_manager .= "【ふりがな】" . $_POST["furigana"] . "\n";
	$send_msg_manager .= "【メールアドレス】" . $_POST["email"] . "\n";
	$send_msg_manager .= "【電話番号】" . $_POST["tel"] . "\n";
	$send_msg_manager .= "【郵便番号】" . $_POST["zip1"] . "-" . $_POST["zip2"] . "\n";
	$send_msg_manager .= "【住所】" . $_POST["state"] . $_POST["address"] . $_POST["address2"]. "\n";
	
	$send_msg_manager .= "【ご来店予定日】" . $_POST["month"] . "月" . $_POST["day"] . "日" . "\n";
	$send_msg_manager .= "【ご質問・ご要望など】" . "\n". $_POST["comment"] . "\n";
	$send_msg_manager .= "------------------------------------------------------\n";
	$send_msg_manager .= "\n";
	$send_msg_manager .= "\n";
	// '****************************************************************
	// ' 送信メッセージ作成(お客様へ)
	// '****************************************************************
	$send_msg_visitor = "\n";
	$send_msg_visitor .= "このメールは自動的に配信されております。\n\n";
	If (!empty($_POST["name"])){
		$send_msg_visitor .= $_POST["name"] . " 様\n";
	}else{
		$send_msg_visitor .= $_POST["email"] . " 様\n";
	}
	$send_msg_visitor .= "【太陽と野菜の直売所】を運営しております、 東浪見岡本農園です。\n";
	$send_msg_visitor .= "下記の商品のご注文メールをお預かり致しました。\n";
	$send_msg_visitor .= "商品の注文をキャンセルされる場合、ご来店日の予定が変更になった場合は、torami@okamoto-farm.co.jpへ直接メールをお送り頂くか、お電話にてご連絡ください。\n";
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
	$subj = "【太陽と野菜の直売所】注文メールのお知らせ";
	$to = "<torami@okamoto-farm.co.jp>";
   	$header .= "Bcc: <okamotofarm@docomo.ne.jp>\r\n";
	
	//$header .= "Content-Type: text/plain; charset=UTF-8\r\n";
	if(!empty($_POST["name"])){
		$send_msg = $_POST["name"] ."様からの商品注文メールです。\n\n";
		$send_msg .= $send_msg_manager;
	}else{
		$send_msg = $_POST["email"] ."様からの商品注文メールです。\n\n";
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
	$subj2 = "注文メール受付完了のお知らせ【太陽と野菜の直売所】";
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

<p class="centering"><a href="<?=$esurl?>" class="underline">トップページへ戻る</a></p>
</div>
<?php
	}else{
		$_SESSION['crsf_token']="";
		foreach($_COOKIE as $key=>$val){
			if(strpos($key,"okamotofarm")!==false){
			setcookie($key,"",time() - 3600 * 24 * 8);
			}
		}	
	?>
<div class="block">

	<p>注文メールが送信されました。<br>
注文をキャンセルされる場合は、torami@okamoto-farm.co.jpへ直接メールをお送り頂くか、お電話にてご連絡ください。
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
