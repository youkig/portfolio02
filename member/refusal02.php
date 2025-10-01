<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<?php include("../config.php");?>
<?php
$logid = $_COOKIE["logid"];
$pass = $_COOKIE["pass"];
if (userloginch($logid,$pass)===false){
	header("location:{$esurl}member/login");
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
<link rel="canonical" href="https://www.okamoto-farm.co.jp/index.php">
<meta name="keywords" content="有機栽培,無農薬野菜,野菜狩り,収穫体験,レンタル農園,貸し農園,観光農園,農業土木,農機具レンタル,耕運代行,農産物直売所,レンタル厨房,トラクター,耕運機,ユンボ,ソーラー蓄電システム,避難場所,停電,非常用電源,とらみスイート,千葉県,長生郡,一宮町,外房,九十九里">

<meta name="description" content="千葉県外房エリア、九十九里海岸の南端、長生郡一宮町ある、近隣唯一の完全有機栽培農家【太陽と野菜の直売所】（東浪見岡本農園）ホームページでは、観光農園として野菜狩り・農業体験サービスのほか、期間貸しのレンタル農園のご紹介や、農機・農機具レンタル、レンタル厨房のご案内をしております。停電時にいつも電気のある災害避難所としてもご利用になれます。">

<title>退会手続き（完了）／農産物直売所 千葉【太陽と野菜の直売所】貸し農園 一宮町／野菜狩り／農業体験</title>

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
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<?=$esurl?>index.php">トップページ</a> | <a href="<?=$esurl?>member/mypage">マイページ</a> | 退会手続き（完了）</p>
	<div class="block">
	<h2>退会手続き（完了）</h2>



<?php
if(empty($_SESSION['crsf_token'])){
echo "<p>アクセスが不正です。</p>";
}elseif($_SESSION['crsf_token'] == filter_input(INPUT_POST,"token")){
	// if (!empty($_SESSION["setid"])){
		$sql = "UPDATE t_user set taikai=1 Where email=:setid";
		$user = $dbh->prepare($sql);
		$user -> bindValue(":setid",$logid,PDO::PARAM_STR);
		$user -> execute();
		$result = $user -> fetch(PDO::FETCH_ASSOC);
		
		
			// '****************************************************************
			// ' 送信メッセージ作成(管理者へ)
			// '****************************************************************
			$send_msg_manager = "\n";
			$send_msg_manager .= "【退会手続き完了のお知らせ】\n";
			$send_msg_manager .= "------------------------------------------------------\n";
			$send_msg_manager .= "【会員URL】" . $esurl . "control/userdisp.php?id=" . $_COOKIE["setid"] . "\n";
			// $send_msg_manager .= "【お名前】" . $_SESSION["username"] . "\n";
			$send_msg_manager .= "【メールアドレス】" . $logid. "\n";
			$send_msg_manager .= "\n";
			$send_msg_manager .= "\n";
			// '****************************************************************
			// ' メール送信
			// '****************************************************************
			mb_language("japanese");
    		mb_internal_encoding("UTF-8");
			// '****************************************************************
			// ' 管理者へ
			// '****************************************************************
			$header = "From:".mb_encode_mimeheader("お客様") . "<" . $logid. ">\r\n";
			$subj = "【太陽と野菜の直売所】会員 退会手続きのお知らせ";
			$to = "<torami@okamoto-farm.co.jp>";
			$header .= "Bcc: <okamotofarm@docomo.ne.jp>\r\n";
			// $to = "<ishibashi@autumn-tec.co.jp>";
			// $header .= "Bcc: <youkiguitar@yahoo.co.jp>\r\n";
			//$header .= "Content-Type: text/plain; charset=UTF-8\r\n";
			if(!empty($_POST["name"])){
				$send_msg = $_POST["name"] . "様からの退会手続きのお知らせです。\n\n";
				$send_msg .= $send_msg_manager;
			}else{
				$send_msg = $logid. "様からの退会手続きのお知らせです。\n\n";
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
			 if(empty($rs_manager)){
setcookie("setid", "", time()-3600*60*24*30);
setcookie("logid", "", time()-3600*60*24*30);
setcookie("pass","", time()-3600*60*24*30);
session_start();
$_SESSION = array();
unset($_SESSION['setid']);
unset($_SESSION['username']);
unset($_SESSION['logid']);
unset($_SESSION['pass']);
unset($_SESSION['company']);

// 4. セッション破棄
session_unset();
session_destroy();				
?>
<p class="centering">退会手続きが完了いたしました。<br>またのご利用をお待ちしております。</p>

			<?php
			 }else{
	 ?>
<p>退会手続きに失敗しました。再度お手続きをお願いいたします。</p>
<?php
			}
	// }
}
 ?>
</div>



<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("../include/rightpane.php")?>

<!-- id main end --></div>

<?php include("../include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
