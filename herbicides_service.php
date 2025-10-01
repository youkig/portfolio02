<?php $siteid=41?>
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
<link rel="canonical" href="<?=$esurl?>herbicides_service.php">
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
	<div id="cnt" class="grass">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 除草剤散布サービス</p>
	<div class="block">
	<h2><img src="img/herbicides/h2.jpg" alt="除草剤散布サービス" width="780" height="244"></h2>

</div>

<div class="block">
<p>【太陽と野菜の直売所】（東浪見岡本農園）では、ご自宅のお庭、家庭菜園など、田畑への除草剤散布サービスを行っております。</p>

<div class="container">

<div class="leftbox w60">
<p>使用する除草剤は、土壌に薬害を与えず根っこまでに薬効のある「ラウンドアップ」を使用して行いますので、周囲の庭木、芝生などに成長に悪影響を与えることなく、約2か月間以上にわたり、その除草効果が持続します。</p>


</div>

<div class="rightbox w35">
    <p><img src="img/herbicides/img01.jpg" width="270" height="180" alt="除草剤を散布している様子" /></p>
</div>
</div>

<p>※春先から夏の終わりにかけて、草勢の著しい季節は、約2か月程度で次の雑草が生えてきます。（いずれの薬剤も同じです）</p>

<p>料金は、ラウンドアップ入り「4リットル散布機」の1本分、散布費用を含んで<span class="bold red">5,500円</span>となります。（出張費用は、5㎞まで1,500円。一宮町から10㎞単位で2,200円となります）</p>

<p>散布する日は、できる限り晴れのお天気が続く3日間程度が適期となります。</p>

<p>除草剤散布サービスのご用命は、以下までご連絡ください。</p>

</div>




<div class="wrapper container">
<div class="button">
<a href="<?=$esurl?>inquire01.php?herbi=herbi">
<div class="icon"><i class="fa-sharp fa-solid fa-envelope"></i></div>
<span>問合せフォーム</span>
</a>
</div>
</div>

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
