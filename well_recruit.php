<?php $siteid=89?>
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
	<div id="cnt" class="mrecruit">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 求人・アルバイト募集 | 井戸掘り職人を募集しています！</p>
	<div class="block">
	<h2>井戸掘り職人を募集しています！</h2>

<p class="catch">【太陽と野菜の直売所】（東浪見岡本農園）では、<br class="br-sp">井戸掘り職人を募集しています！</p>

</div>

<div class="block">
<p>仕事は毎日ある訳ではないので、依頼があったときだけ土日にかかわらず「スポット作業」として、井戸掘りだけでなく、井戸ポンプの設置、配管作業まで行っていただきます。</p>

<p>基本的に、農園のある近隣ということになりますので、道具、工具をお持ちの方は優遇させていただきます。</p>

<p>※農園ですべて用意するつもりでおりますが、自作の電動機器をお持ちの方は面接時に持参してください。</p>


</div>

<div class="block">
<h3>募集要項</h3>
	<dl class="fl">
	<dt>・給与</dt>
<dd>1日3万円以上　（半日のときは別途相談）</dd>
</dl>

<dl class="fl">
	<dt>・年齢</dt>
<dd>不問</dd>
</dl>

</div>









<div class="block">
	

<p>移動用のクルマは、農園で用意します。</p>

<p>ご応募をお待ちしています！</p>


<p>メール：<a href="mailto:torami@okamoto-farm.co.jp" class="underline">torami@okamoto-farm.co.jp</a></p>

<p>電話：<?=$mobile?>（農園管理人：岡本直通）</p>


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
