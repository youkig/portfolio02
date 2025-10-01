<?php $siteid=39?>
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

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 生活困窮家庭の方々に野菜を無料配布しています</p>
	<div class="block">
	<h2><img src="img/freedist/h2.jpg" alt="生活困窮家庭の方々に野菜を無料配布しています" width="782" height="207"></h2>
</div>

<div class="block">

<div class="container block2nd">
<div class="leftbox">
<p>【太陽と野菜の直売所】では、生活困窮家庭のみなさまに野菜類の無料配布を行っています。当農園の近隣にお住いの方であれば、定期的にご来園いただき、お好きな野菜を畑エリアから収穫してお持ちいただいて結構です。</p>


</div>

<div class="rightbox">
<p><img src="img/freedist/img01.jpg" alt="曲がったキュウリのイメージ写真です" width="360" height="202"></p>
</div>
</div>
	
<p>基本的に「余った野菜」「曲がったキュウリ」「虫食い野菜」となってしまうかも知れませんが、農薬を使わず有機栽培された野菜の「おいしさ」を間違いなく実感できるはずです。</p>	
<p>また、お名前、ご住所等の身分を明かしていただく必要がありますので、匿名を希望する方は、残念ながら対象からは外させていただきます。</p>

<p>生活困窮は、決してみなさまの責任ではなく、この国の社会保障制度は不充実であることが原因であり、どうか胸を張ってお名前を明らかにしてご来園ください。</p>

<p>まずは、ホームページからお申込みいただくか、農園管理人まで直接電話してください！</p>

<p>遠慮はいりません。ご連絡をお待ちしています！</p>
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
