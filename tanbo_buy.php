<?php $siteid=86?>
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
<link rel="canonical" href="<?=$esurl?>tanbo_buy.php">
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
	<div id="cnt" class="farm welldigging">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 田んぼ買います！（一宮町東浪見地区）</p>
	<div class="block">
	<h2><img src="img/tanbo/h2.jpg" alt="田んぼ買います！（一宮町東浪見地区）" width="780" height="200"></h2>

</div>

<div class="block">
<p>東浪見岡本農園では、積極的な田んぼの買い入れを行っています。「田んぼを売りたい」「遊休になってしまった田んぼを処分したい」という方は、まずはお問合せください。</p>

<p>用水路や排水路の整備状況、日当たり具合、田んぼの形状、圃場面積によっても買い取り価格は変わりますが、当農園の所在する「東浪見地区」については、なるべく高く買い取りができるように考えております。</p>

<p>農地法3条許可申請、法務局への所有権移転登記手続きは、すべて農園側の費用負担で行いますので、それら手続きに必要となる「約10万円～15万円」の譲渡者負担は一切ありません。</p>

<p>まずは、現地調査に伺いますので、以下問合せフォームからご連絡ください。</p>


</div>




<?php include("include/inquireBtn.php")?>

<div class="block">
<p>電話によるお問い合わせは、<?=$mobile?>（農園管理人：岡本直通）までお願いします。</p>
<dl class="volunteer">
<dt>電話連絡先</dt>
<dd><?=$mobile?>（管理人直通）</dd>
</dl>
<dl class="volunteer">
<dt>メール</dt>
<dd><a href="mailto:torami@okamoto-farm.co.jp" class="underline">torami@okamoto-farm.co.jp</a></dd>
</dl>


</div>




<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
