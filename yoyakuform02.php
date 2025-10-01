<?php
session_start();
?>
<?php $siteid=91?>
<?php include("include/autometa.php");?>

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
<script src="js/yoyaku_chk.js"></script>

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
	<div id="cnt" class="company about">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 野菜狩り・野菜収穫体験サービス予約フォーム（内容確認）</p>
	<div class="block" id="form">
	<h2>野菜狩り・野菜収穫体験サービス予約フォーム（内容確認）</h2>

</div>

<p>以下の内容でよろしいですか？</p>

<form action="<?=$esurl?>yoyakuform03#form" method="post">
<div class="block">
<h3>予約フォーム</h3>
	


<dl>
	<dt>ご予約日</dt>
<dd><?php
if (!empty($_POST["ydate"])){
$ydate=explode("/",$_POST["ydate"]);
echo $ydate[0]."年".$ydate[1]."月" . $ydate[2]."日";
}
?></dd>
</dl>

<dl>
	<dt>開始時間</dt>
<dd>
<?=$_POST["hour"]?>時<?=$_POST["time"]?>分

</dd>
</dl>


<dl>
<dt>ご利用人数</dt>
<dd><?=$_POST["ninzu"]?> 人</dd>
</dl>

<dl>
<dt>ご利用のカゴ数</dt>
<dd><?=$_POST["kago"]?> カゴ</dd>
</dl>


<?php
if ($_POST["person"]=="法人"){
?>
	<dl class="houjin">
	<dt>法人名</dt>
<dd><?=$_POST["company"]?></dd>
</dl>

<dl class="houjin">
	<dt>部署</dt>
<dd><?=$_POST["busyo"]?></dd>
</dl>
<?php
}
?>
<dl>
	<dt>お名前&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["name"]?></dd>
</dl>

<dl>
	<dt>ふりがな&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["furigana"]?></dd>
</dl>

<dl>
	<dt>メールアドレス&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["email"]?></dd>
</dl>

<dl>
	<dt>電話番号&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["tel"]?></dd>
</dl>

<dl>
	<dt>郵便番号&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["zip1"]?> - <?=$_POST["zip2"]?></dd>
</dl>

<dl>
	<dt>都道府県&nbsp;<em>[必須]</em></dt>
<dd>
<?php
if (!empty($_POST["state"])){
$sql ="SELECT * From t_state Where id=:state";
$s = $dbh->prepare($sql);
$s -> bindValue(":state",$_POST["state"],PDO::PARAM_INT);
$s -> execute();
$rs= $s -> fetch(PDO::FETCH_ASSOC);

if (!empty($rs)){
echo $rs["state"];
?>
<input type="hidden" name="statename" value="<?=$rs["state"]?>" />
<?php
}
}
?></dd>
</dl>

<dl>
	<dt>市区町村、町名&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["address"]?></dd>
</dl>

<dl>
	<dt>以下番地、建物名、部屋番号など&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["address2"]?></dd>
</dl>
<?php
if (!empty($_POST["password"]) && $_POST["regist_chk"]){
?>
<dl>
<dt>会員登録&nbsp;[任意]</dt>
<dd>会員登録する<br />※セキュリティの為、表示しておりません</dd>
</dl>
<?php
}
?>
<dl>
	<dt>ご質問・ご要望など</dt>
<dd><?=nl2br($_POST["comment"])?></dd>
</dl>


</div>

<div class="block">
<p>上記内容でよろしければ、送信ボタンを押してください。</p>
<p class="centering"><input type="submit" name="submit" value="　送信　" />&nbsp;&nbsp;<input type="button" value="戻る" onClick="history.back();" /></p>

</div>
<?php
foreach($_POST as $key=>$val){
?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<?php
}
?>

</form>

<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88" /></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
