<?php $siteid=50?>
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
<script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>

<script>
$(function () {
$("#petok").click(function(){
$("#petnaiyo").fadeToggle();
});

});
</script>

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

<h2>「疎開先ネットワーク」提供者への問合せ（確認）</h2>

<p>以下の内容でよろしいでしょうか？</p>
<?php
$sql="SELECT t_user.name,t_user.company,t_network.* From t_user inner join t_network on t_user.id=t_network.uid Where t_network.id=:id and t_network.shinsa=1 and t_network.cancel=0";
$n = $dbh->prepare($sql);
$n -> bindValue(":id",$_POST["id"],PDO::PARAM_INT);
$n -> execute();
$rs = $n->fetch(PDO::FETCH_ASSOC);

if (!empty($rs)){
?>
<form action="<?=$esurl?>inq_03" method="post">
<div class="block">
<p>■提供者様情報</p>
<?php
if (!empty($rs["company"])){
?>
<dl>
<dt>会社名</dt>
<dd><?php
if ($rs["companydisp"]==1){
echo $rs["company"];
}else{
echo "非公開";
}
?></dd>
</dl>
<?php
}
?>
<dl>
<dt>お名前</dt>
<dd><?php
if (!empty($rs["penname"])){
echo $rs["penname"];
}elseif ($rs["namedisp"]==1){
echo $rs["name"];
}else{
echo "非公開";
}
?>
</dd>
</dl>

</div>

<div class="block">
<p>■入力内容</p>
<dl>
<dt>お名前<em>（必須）</em></dt>
<dd><?=$_POST["name"]?></dd>
</dl>

<dl>
<dt>ふりがな<em>（必須）</em></dt>
<dd><?=$_POST["furigana"]?></dd>
</dl>

<dl>
<dt>性別<em>（必須）</em></dt>
<dd><?=$_POST["sex"]?></dd>
</dl>

<dl>
<dt>郵便番号<em>（必須）</em></dt>
<dd>
〒<?=$_POST["zip1"]?> - <?=$_POST["zip2"]?></dd>
</dl>

<dl>
<dt>都道府県<em>（必須）</em></dt>
<dd><?php
$sql = "SELECT * From t_state Where id=:state";
$s = $dbh->prepare($sql);
$s -> bindValue(":state",$_POST["state"],PDO::PARAM_INT);
$s -> execute();
$rss = $s -> fetch(PDO::FETCH_ASSOC);
echo $rss["state"];
?>
<input type="hidden" name="statename" value="<?=$rss["state"]?>">
</dd>
</dl>
<dl>
<dt>市区町村名<em>（必須）</em></dt>
<dd><?=$_POST["address"]?></dd>

</dl>
<dl>
<dt>以下住所<em>（必須）</em></dt>
<dd><?=$_POST["address2"]?></dd>
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
<dt>希望利用人数<em>（必須）</em></dt>
<dd>合計：<?=$_POST["ninzu"]?>人<br>
大人：<?=$_POST["adult"]?>人　子供：<?=$_POST["child"]?>人</dd>
</dl>

<?php
if (!empty($_POST["petok"])){
?>
<dl>
<dt>ペットの受入れ</dt>
<dd>希望する<br>
<?php
if (!empty($_POST["petnaiyo"])){echo nl2br($_POST["petnaiyo"]);}
?>

</dd>
</dl>
<?php
}
?>
<dl>
<dt>食事の提供</dt>
<dd><?php
if (!empty($_POST["food"])){echo "希望する";}
?>

</dd>
</dl>
<dl>
<dt>ご質問・ご希望など</dt>
<dd><?php
if (!empty($_POST["comment"])){echo nl2br($_POST["comment"]);}
?></dd>
</dl>

	</div>
<p>上記の内容でよろしければ、送信ボタンを押してください。</p>
<p class="centering"><input type="submit" name="submit" value=" 送　信 "> 　<input type="button" value=" 戻 る " onclick="history.back();"></p>
</from>
<?php
foreach($_POST as $key=>$val){
?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>">
<?php
}
}
?>

<!-- id cnt2 end --></div>



</body>
</html>
