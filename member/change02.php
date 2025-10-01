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

<title>会員情報編集（入力内容確認）／農産物直売所 千葉【太陽と野菜の直売所】貸し農園 一宮町／野菜狩り／農業体験</title>

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

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | <a href="<?=$esurl?>member/mypage">会員マイページ</a> | 会員情報編集（入力内容確認）</p>
	<div class="block" id="form">
	<h2>会員情報編集（入力内容確認）</h2>

<p>以下の内容でよろしければ、登録ボタンを押してください。</p>


</div>



<form action="change03" method="post">
<div class="block">
<h3>会員情報入力内容</h3>

<dl class="houjin">
	<dt>法人名</dt>
<dd><?=$_POST["company"]?></dd>
</dl>

<dl class="houjin">
	<dt>部署</dt>
<dd><?=$_POST["busyo"]?></dd>
</dl>

	
<dl>
	<dt>お名前&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["name"]?></dd>
</dl>

<dl>
	<dt>ふりがな&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["furigana"]?></dd>
</dl>



<dl>
	<dt>郵便番号&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["zip1"]?>-<?=$_POST["zip2"]?></dd>
</dl>

<dl>
	<dt>都道府県&nbsp;<em>[必須]</em></dt>
<dd>
<?php
if (!empty($_POST["state"])){
				$sql="SELECT * From t_state Where id=:state";
				$s = $dbh->prepare($sql);
				$s -> bindValue(":state",$_POST["state"],PDO::PARAM_INT);
				$s ->execute();
				$rss = $s->fetch(PDO::FETCH_ASSOC);
				echo $rss["state"];
?>
	<input type="hidden" name="statename" value="<?=$rss["state"]?>">
<?php
	}
?>
</dd>
</dl>

<dl>
	<dt>市区町村名&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["address"]?></dd>
</dl>

<dl>
	<dt>以下番地、建物名など&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["address2"]?></dd>
</dl>

<dl>
	<dt>電話番号&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["tel"]?></dd>
</dl>



<dl>
	<dt>メールアドレス&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["email"]?></dd>
</dl>
<?php
			if (!empty($_POST["password"])){
?>
<dl>
	<dt>パスワード&nbsp;<em>[必須]</em></dt>
<dd>※セキュリティの為、表示しません。</dd>
</dl>
<?php
			}
?>


<dl>
	<dt>メールマガジン&nbsp;<em>[必須]</em></dt>
<dd><?php
if (!empty($_POST["mailmaga"])){
echo "受信する";
}else{
echo "受信しない";
}
?>
</dd>
</dl>




</div>

<div class="block">
<p>上記内容でよろしければ、登録ボタンを押してください。</p>
<p class="centering"><input type="submit" name="submit" value="登　録">&nbsp;&nbsp;&nbsp;<input type="button" value="戻　る" onClick="history.back()" onKeyPress="history.back()"></p>
</div>

<?php
		foreach($_POST as $key=>$val){
		?>
	<input type="hidden" name="<?=$key?>" value="<?=$val?>">
<?php
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
