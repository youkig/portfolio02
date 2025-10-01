<?php $siteid=81?>
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
<link rel="canonical" href="<?=$esurl?>restform02.php">
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

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | バイクツアラー向けの「無料休憩所」予約フォーム（内容確認）</p>
	<div class="block" id="form">
	<h2>バイクツアラー向けの「無料休憩所」予約フォーム（内容確認）</h2>



</div>


<?php
if(str_contains($_SERVER['HTTP_REFERER'],"restform01")==false){
echo "<p>アクセスが不正です。</p>";
}else{
?>

<form action="restform03#form" method="post">
<div class="block">
<h3>予約フォーム</h3>
	
<p>以下の内容でよろしいですか？</p>

<dl>
	<dt>ご予約日時</dt>
<dd><?php

if ($_POST["datenum"]<>"" && $_POST["timenum"]<>""){
echo  $_POST["datenum"] ."　". $_POST["timenum"]."時 頃";
}
?></dd>
</dl>



<dl>
<dt>ご利用人数</dt>
<dd><?=$_POST["ninzu"]?> 人</dd>
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
	<dt>お名前</dt>
<dd><?=$_POST["name"]?></dd>
</dl>

<dl>
	<dt>ふりがな</dt>
<dd><?=$_POST["furigana"]?></dd>
</dl>

<dl>
	<dt>メールアドレス</dt>
<dd><?=$_POST["email"]?></dd>
</dl>

<dl>
	<dt>電話番号</dt>
<dd><?=$_POST["tel"]?></dd>
</dl>

<dl>
	<dt>郵便番号</dt>
<dd><?=$_POST["zip1"]?> - <?=$_POST["zip2"]?></dd>
</dl>

<dl>
	<dt>都道府県</dt>
<dd><?=$_POST["state"]?></dd>
</dl>

<dl>
	<dt>市区町村、町名</dt>
<dd><?=$_POST["address"]?></dd>
</dl>

<dl>
	<dt>以下番地、建物名、部屋番号など</dt>
<dd><?=$_POST["address2"]?></dd>
</dl>

<dl>
	<dt>ご質問・ご要望など</dt>
<dd><?=nl2br($_POST["comment"])?></dd>
</dl>


</div>

<div class="block">
<p>上記内容でよろしければ、送信ボタンを押してください。</p>
<p class="centering"><input type="submit" name="submit" value="　送信　">&nbsp;&nbsp;<input type="button" value="戻る" onClick="history.back();"></p>

</div>
<?php
		foreach($_POST as $key=>$row){

		?>
			<input type="hidden" name="<?=$key?>" value="<?=$row?>">
		<?php
			}
		
?>

</form>
<?php
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
