<?php $siteid=65?>
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
	<div id="cnt" class="ordermade about farm rentallow">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">トップページ</a> | オーダーメイド野菜の少量栽培に対応しています</p>
	<div class="block">
	<h2><img src="img/ordermade/h2.jpg" alt="オーダーメイド野菜の少量栽培に対応しています" width="780" height="205"></h2>



<p>【太陽と野菜の直売所】（東浪見岡本農園）では、高級フレンチ、イタリアン料理だけでなく、中華料理などに使う、わが国ではあまり知られていない野菜や、世界的なコロナ禍で輸入がなくなってしまった野菜を、当農園では「完全有機栽培」によるオーダーメイド栽培を行っています。</p>

<p>本来は、当農園で定番として栽培している「旬の野菜」を継続購入していただきたいところではありますが、コロナ禍の終息が見え始めた最近は、「こんな珍しいイタリア特産の野菜だけどサラダ用に少量栽培してもらえないか？」という要望を多くいただくようになりました。</p>


</div>

<div class="block">
<h3>季節（旬）の野菜の少量栽培にも対応します</h3>

<p>東浪見岡本農園は、基本的に「少量多品種栽培」ですから、大量のオーダーメイド栽培には応じられませんが、農業ハウスの一棟単位程度までであれば、季節ごとの旬の野菜を、数種類指定いただき、複数回に分けて収穫期間中分納することも可能です。また、栽培期間中の生育状況を見ながら、少量ずつを宅配便で分納することも可能です。</p>

</div>

<div class="block">
<h3>完全有機栽培野菜という高付加価値について</h3>

<p>料理のプロであれば、最近の有機栽培野菜（オーガニック野菜）の価格が、一般的なスーパーマーケットで販売されている「普通の野菜」（実はそのほとんどが化学肥料栽培ですが）と比較して、極端に高価になってきているという事実を、すでにご存じの調理師方々も多くいらっしゃるはずです。</p>

<p>それも当然で、有機栽培には多くの栽培作業工数だけでなく、土壌を長く健康に維持するために、高価な微生物資材を1年をとおして使っていて、化学肥料栽培の5倍以上「人手とコストを必要とする栽培手法」を用いています。</p>


<p>有機栽培野菜というと、誰でも100％有機資材、有機肥料で栽培していると思われがちですが、実際には半分以上に化学肥料が使われていたり、ごくわずかの有機肥料しか投入していない畑で作られた野菜を「オーガニック栽培」と詐称したりしている場合も少なくありません。</p>
<div class="block2nd container">
	<div class="leftbox">
	<p>【太陽と野菜の直売所】（東浪見岡本農園）では、そんな化学肥料を一切使用せず、一部の栽培期間（春先のモンシロチョウが飛ぶ季節）以外は、農薬類すら一切使用しませんので、真の意味における「完全有機栽培」を実現している数少ない農家です。</p>
<p>また、依頼されるほとんどのお店では、当農園で栽培されていることを、お店でポスター等を貼って紹介していいか？と確認されますが、もちろん喜んでそのお申し出は承諾しております。</p>
</div>

<div class="rightbox">
	<p><img src="img/ordermade/img01.jpg" alt="完全有機栽培された野菜のイメージ写真です" width="316" height="237"></p>
</div>

</div>

<p>みなさまのお店で、安全かつ高付加価値の「完全有機栽培野菜」を使っているというだけで、きっと心豊かで、心優しいお客様が殺到するはずです。</p>

<p>興味をお持ちのお店の経営者様は、ぜひ一度農園見学に訪れていただいて、清潔に整備された農園をその目で見ていただき、さっそく商談に移ることができることを期待しています。</p>
</div>




<div class="block">
<dl>
<dt>電話連絡先</dt>
<dd><?=$mobile?>　（岡本直通）</dd>
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
