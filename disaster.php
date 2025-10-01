<?php $siteid=34?>
<?php include("include/autometa.php");?>
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
	<div id="cnt" class="solar farm disaster">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 【太陽と野菜の直売所】では停電時の電気供給を行っています</p>
	<div class="block">
	<h2><img src="img/disaster/h2.jpg" alt="【太陽と野菜の直売所】では停電時の電気供給を行っています" width="782" height="207"></h2>
</div>

<div class="block">
<div class="container block2nd">
<div class="leftbox">
<p>【太陽と野菜の直売所】（東浪見岡本農園）では、地震などの自然災害による送電線の破断時の停電、水道管の破損による水道施設による飲料水不足のときなど、「電気」「水」の供給だけでなく、お米の炊き出しや水洗トイレの無償提供などの「災害時ボランティア農園」としての社会的役割を担っています。</p>


</div>

<div class="rightbox">
<p><img src="img/disaster/img01.jpg" alt="ソーラーパネルのイメージ写真です" width="360" height="239"></p>
</div>
</div>
	
	<p>農産物直売所に併設されている農業倉庫（2棟）、食品加工場、トイレ棟には、すべてソーラー蓄電システムが設置されており、特に停電による「生命維持装置」の稼働が困難となるケースを優先して、昼夜間にかかわらず電気の無償提供を行っています。</p>
<p>有事の際は、ぜひお気軽にご連絡ください。</p>


</div>







<div class="block">
<dl class="volunteer">
<dt>電話連絡先</dt>
<dd><?=$mobile?>　（岡本直通）</dd>
</dl>
<dl class="volunteer">
<dt>メール</dt>
<dd><a href="mailto:torami@okamoto-farm.co.jp" class="underline">torami@okamoto-farm.co.jp</a></dd>
</dl>
</div>

<?php include("include/inquireBtn.php")?>


<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
