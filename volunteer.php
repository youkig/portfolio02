<?php $siteid=88?>
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
<link rel="canonical" href="<?=$esurl?>volunteer">
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
	<div id="cnt" class="volunteer farm">

	<p class="pankuzu"><a href="<?=$esurl?>index">トップページ</a> | 農業ボランティア・農作業体験をしたい方大募集です！</p>
	<div class="block">
	<h2><img src="img/volunteer/h2.jpg" alt="農業ボランティア・農作業体験をしたい方大募集です！" width="780" height="205"></h2>

</div>

<div class="block">
<p>【太陽と野菜の直売所】（東浪見岡本農園）では、週末だけ農業体験をしてみたいと思っている方、燦然と輝くお天道様の下で「いい汗をかいてみたい」とお考えの方々に、農業ボランティア・農作業体験をしてみたいという方々を大募集しています。</p>

<p>当農園では、「人手」「人件費削減」としてのボランティア募集をしている訳ではありませんので、あくまでも無償作業となり給与や交通費の支給はありません。</p>

<p>また、応募いただいた方々には、農園管理人と電話で応募動機をお尋ねしますので、氏名やお住いを秘匿したり、動機を偽って申告したりする方はお断りすることがあります。</p>

<p>平日の応募も可能ですが、基本的に農業は終日作業となりますので、午前中の2時間だけとか、最初の応募のときに「1日だけ体験したい」という方は、応募をお控えくださいますようお願いいたします。</p>

<p>ボランティアの参加日数が増えれば、耕運機の操縦体験もできるでしょうし、大型特殊免許をお持ちであれば、トラクターやユンボの操縦機会もあるでしょう。</p>
</div>

<div class="block">
<h3>応募要項</h3>
<dl class="volunteer">
<dt>応募フォームから</dt>
<dd><a href="<?=$esurl?>inquire01?v=1" class="underline">応募フォーム</a></dd>
</dl>
<dl class="volunteer">
<dt>男女・年齢</dt>
<dd>問いません</dd>
</dl>
<dl class="volunteer">
<dt>昼食</dt>
<dd>時間があればご一緒に（基本的に持参または自費）</dd>
</dl>
<dl class="volunteer">
<dt>給与・交通費</dt>
<dd>支給しません</dd>
</dl>
<dl class="volunteer">
<dt>体験日数</dt>
<dd>最低5日以上から</dd>
</dl>
<dl class="volunteer">
<dt>応募動機</dt>
<dd>具体的な理由をお尋ねします</dd>
</dl>




</div>

<div class="block">
<p>以上、新鮮な空気を吸い込み、気力、体力ともにリセットしたい方のご応募をお待ちしています。</p>

<p>農園管理人：岡本　洋</p>
</div>


<div class="block">
<dl class="volunteer">
<dt>電話連絡先</dt>
<dd><?=$mobile?>（管理人直通）</dd>
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
