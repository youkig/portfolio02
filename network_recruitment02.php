<?php $siteid=63?>
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

<script src="js/recruitment_chk.js"></script>
</head>


<div id="box">

<div id="header">
<h1><?=$n_h1?></h1>


<?php include("include/header.php")?>


<div id="main" class="container">
	<?php include("include/leftpane.php")?>
	<div id="cnt" class="recruitment farm company">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 有事の際の「疎開先ネットワーク」募集のお願い（入力内容確認）</p>
	<div class="block">
	<h2><img src="img/recruitment/h2.jpg" alt="有事の際の「疎開先ネットワーク」募集のお願い" width="780" height="205"></h2>

</div>

<div class="block">

<p>以下の内容でよろしいでしょうか？</p>
</div>


<?php
if (!empty($_POST["userid"])){
$sql="SELECT * From t_user Where id=:userid AND dele=0 AND taikai=0";
$user = $dbh->prepare($sql);
$user -> bindValue(":userid",$_POST["userid"],PDO::PARAM_INT);
$user -> execute();
$rs = $user->fetch(PDO::FETCH_ASSOC);

if (!empty($rs)){
?>
<form action="<?=$esurl?>network_recruitment03" method="post" onSubmit="return signup(this)">
<div class="block">
<h3>応募要項</h3>
<dl>
<dt>お名前</dt>
<dd>
<?php
if (!empty($rs["name"])){
echo $rs["name"]."<br>";
}
?>
<?php
if (!empty($_POST["name_open"])){
echo "（公開可）";
}else{
echo "（非公開）";
}
?>
</dd>
</dl>
<dl>
<dt>公開名</dt>
<dd>
<?php
if (!empty($_POST["penname"])){
echo $_POST["penname"];
}else{
echo "ペンネームなし";
}
?>
</dd>
</dl>
<dl>
<dt>法人名</dt>
<dd><?php
if (!empty($rs["company"])){
echo $rs["company"]."<br>";
if (!empty($_POST["company_open"])){
echo "（公開可）";
}else{
echo "（非公開）";
}
}
?>
</dd>
</dl>
<dl>
<dt>郵便番号<em>（必須）</em></dt>
<dd><?php
if (!empty($rs["zip"])){
$zip=explode("-",$rs["zip"]);
$zip1=$zip[0];
$zip2=$zip[1];
}
?>
〒<?=$_POST["zip1"]?> - <?=$_POST["zip2"]?>

</dl>
<dl>
<dt>都道府県<em>（必須）</em></dt>
<dd><?php
$sql = "SELECT * From t_state Where id=:state";
$state = $dbh->prepare($sql);
$state->bindValue(":state",$_POST["state"],PDO::PARAM_INT);
$state->execute();
$rss = $state->fetch(PDO::FETCH_ASSOC);
?>
<?=$rss["state"]?>
<input type="hidden" name="statename" value="<?=$rss["state"]?>">
</dd>
</dl>
<dl>
<dt>市区町村名<em>（必須）</em></dt>
<dd><?=$rs["address"]?></dd>


</dl>
<dl>
<dt>以下住所<em>（必須）</em></dt>
<dd><?=$rs["address2"]?></dd>
</dl>

<dl>
<dt>対象住所<em>（必須）</em></dt>
<dd><?=$_POST["address3"]?>
</dd>
</dl>

<dl>
<dt>連絡先電話番号<em>（必須）</em></dt>
<dd><?=$_POST["tel"]?></dd>
</dl>

<dl>
<dt>メールアドレス<em>（必須）</em></dt>
<dd><?=$_POST["email"]?></dd>
</dl>

<dl>
<dt>提供可能種別<em>（必須）</em></dt>
<dd>
<?=implode("、",$_POST["syubetsu"])?>
</dd>
</dl>

<dl>
<dt>広さ<em>（必須）</em></dt>
<dd>
<?php
if (!empty($_POST["breadth"])){
echo $_POST["breadth"]."㎡<br>";
}
if(!empty( $_POST["heya"])){
echo $_POST["heya"]."部屋<br>";
}
if ($_POST["ikken"]==1){
echo "一軒家";
}
?>
</dd>
</dl>

<dl>
<dt>受入れ人数<em>（必須）</em></dt>
<dd><?=$_POST["ninzu"]?> 人まで
</dd>
</dl>

<dl>
<dt>受入れ性別<em>（必須）</em></dt>
<dd><?=$_POST["sex"]?>
</dd>
</dl>

<dl>
<dt>食料の有無<em>（必須）</em></dt>
<dd><?=implode("、",$_POST["food"])?>
</dd>
</dl>

<dl>
<dt>自家発電システム設置の有無<em>（必須）</em></dt>
<dd><?=$_POST["power"]?>
<?php
if ($_POST["power"]=="あり"){
echo "<br>". $_POST["solar"];
}
?>

</dd>
</dl>

<dl>
<dt>飲料水の有無<em>（必須）</em></dt>
<dd>
<?=$_POST["well"]?>
<?php
if ($_POST["well"]=="あり"){
echo "<br>". $_POST["water"];
}
?>

</dd>
</dl>

<dl>
<dt>ペット同居の有無<em>（必須）</em></dt>
<dd><?=$_POST["pet"]?>
</dd>
</dl>

<dl>
<dt>ペットの受入れ<em>（必須）</em></dt>
<dd><p><?=$_POST["petok"]?></p>

<?php
if ($_POST["petok"]=="可"){
?>
<p>・受入れ可の場合<br><?=$_POST["petplace"]?></p>
<p>・ペットのサイズ<br><?=$_POST["petsize"]?></p>
<?php
}
?>
</dd>
</dl>

<dl>
<dt>宿泊費の有償・無償<em>（必須）</em></dt>
<dd><p><?=$_POST["price"]?></p>

<?php
if ($_POST["price"]=="有償"){
?>
<p>・有償の場合<br>1泊 <?=$_POST["fee"]?> 円　～　ご相談</p>
<?php
}
?>
</dd>
</dl>

<dl>
<dt>食事の提供<em>（必須）</em></dt>
<dd><p><?=$_POST["meal"]?></p>
<?php
if ($_POST["price"]=="有償"){
?>
<p>・有償の場合<br>1食 <?=$_POST["mealfee"]?> 円　～　ご相談</p>
<?php
}
?>

</dd>
</dl>
<?php
foreach($_POST as $key=>$val){
	if(is_array($val)){
?>
	<input type="hidden" name="<?=$key?>" value="<?=implode("、",$val)?>">
<?
	}else{
?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>">
<?php
	}
}
?>

</div>
<p>上記の内容でよろしければ、「登録」ボタンをクリックしてください。</p>
<p class="centering"><input type="submit" value="登　録">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="訂　正" onclick="history.back();"></p>
</form>
<?php
}else{
?>
<p>ログインをし直してください。</p>
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
