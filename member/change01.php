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

<title>会員情報編集／農産物直売所 千葉【太陽と野菜の直売所】貸し農園 一宮町／野菜狩り／農業体験</title>

<link rel="stylesheet" href="../css/base.css" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

<script src="../js/jquery-1.5.2.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../js/jquery.ui.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="../js/jquery.bgswitcher.js"></script>
<script src="../js/pagetop.js"></script>

<script src="../js/topslide.js"></script>
<script src="../js/change_chk.js"></script>
<script>
$(function () {
	
	$("#person1").click(function(){
		$(".houjin").fadeIn();
	});
	
	$("#person2").click(function(){
		$(".houjin").fadeOut();
	});

});
</script>
</head>

<body>

<div id="box">

<div id="header">
	<h1>新鮮野菜 直売所／千葉 一宮町</h1>


<?php include("../include/header.php")?>


<div id="main" class="container">
	<?php include("../include/leftpane.php")?>
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | <a href="<?=$esurl?>member/mypage">会員マイページ</a> | 会員情報編集</p>
	<div class="block">
	<h2>会員情報編集</h2>

<p>会員登録済みの情報をこちらのページから編集が出来ます。</p>

<p>尚、会社名はこちらのページからは変更出来ませんので、メールにてお問合せください。</p>


</div>

<?php
	  $sql="SELECT * From t_user Where id=:setid";
	  $user = $dbh->prepare($sql);
	  $user -> bindValue(":setid",$_SESSION["setid"],PDO::PARAM_INT);
	  $user -> execute();
	  $rsu = $user->fetch(PDO::FETCH_ASSOC);
?>

<form action="change02#form" method="post" name="forms" id="forms" onSubmit="return signup(this)">
<input type="hidden" name="id" value="<?=$_SESSION["setid"]?>">
<div class="block">
<h3>会員情報編集フォーム</h3>

<dl class="houjin">
	<dt>法人名</dt>
<dd><?=$rsu["company"]?><input type="hidden" name="company" value="<?=$rsu["company"]?>"></dd>
</dl>

<dl class="houjin">
	<dt>部署</dt>
<dd><input type="text" name="busyo" value="<?=$rsu["busyo"]?>"></dd>
</dl>

	
<dl>
	<dt>お名前&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="name" id="name" value="<?=$rsu["name"]?>"></dd>
</dl>

<dl>
	<dt>ふりがな&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="furigana" id="furigana" value="<?=$rsu["furigana"]?>"></dd>
</dl>



<dl>
	<dt>郵便番号&nbsp;<em>[必須]</em></dt>
<dd>
<?php
				if (!empty($rsu["zip"])){
					$zip=explode("-",$rsu["zip"]);
					$zip1=$zip[0];
					$zip2=$zip[1];
				}
?>
<input type="text" name="zip1" id="zip1" value="<?=$zip1?>" class="zip"> - <input type="text" name="zip2" id="zip2" value="<?=$zip2?>" class="zip"></dd>
</dl>

<dl>
	<dt>都道府県&nbsp;<em>[必須]</em></dt>
<dd><select name="state" id="state">
<option value=""></option>
<?php
				$sql="SELECT * From t_state";
				$s = $dbh->prepare($sql);
				$s -> execute();
				$result = $s->fetchAll(PDO::FETCH_ASSOC);
				foreach($result as $rsstate){
				?>
<option value="<?=$rsstate["id"]?>"<?=selected($rsstate["id"],$rsu["state"])?>><?=$rsstate["state"]?></option>
<?php
				}
				?>
</select></dd>
</dl>

<dl>
	<dt>市区町村名&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="address" id="address" value="<?=$rsu["address"]?>"></dd>
</dl>

<dl>
	<dt>以下番地、建物名など&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="address2" id="address2" value="<?=$rsu["address2"]?>"></dd>
</dl>

<dl>
	<dt>電話番号&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="tel" id="tel" value="<?=$rsu["tel"]?>"></dd>
</dl>


<dl>
	<dt>メールアドレス&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="email" id="email" value="<?=$rsu["email"]?>"></dd>
</dl>

<dl>
	<dt>パスワード</dt>
<dd>※変更がなければ入力しないでください。<br>半角英数字8文字から12文字以内<br><input type="password" name="password" id="password" value=""></dd>
</dl>





</div>

<p><input type="checkbox" name="mailmaga" id="mailmaga" value="1"<?=checked($rsu["mailmaga"],1)?>><label for="mailmaga">メールマガジン受信希望の場合はチェックを入れてください</label></p>

<div class="block">
<p>上記内容でよろしければ、確認画面へお進みください。</p>
<p class="centering"><input type="submit" name="submit" value="内容確認"></p>
</div>

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

</form>

<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("../include/rightpane.php")?>

<!-- id main end --></div>

<?php include("../include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
