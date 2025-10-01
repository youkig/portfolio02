<?php $siteid=87?>
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
	<div id="cnt" class="mrecruit">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 「とらみスイート」ブランドは、東浪見岡本農園の商標登録です</p>
	<div class="block">
	<h2>「とらみスイート」ブランドは、東浪見岡本農園の商標登録です</h2>
</div>

<div class="block">
<p class="catch">【太陽と野菜の直売所】（東浪見岡本農園）では、<br class="br-sp">
農園で収穫した新鮮野菜すべてを、<br class="br-sp">
完全有機栽培野菜として「とらみスイート」と<br class="br-sp">名付けてブランド化して販売しております！
</p>


</div>


<div class="block">
	<h3>ブランドロゴデザイン</h3>

<p>千葉県九十九里・一宮町東浪見（「とらみ」と読みます）地区は、知る人ぞ知るサーフィンのメッカであり、2020東京オリンピックのサーフィン競技会場となりました。（開催自体は2021年になってしまいましたが）</p>

<p class="centering"><img src="img/sweet/image01.gif" alt="とらみスイートのロゴ" width="348" height="365"></p>
</div>
<div class="block">
<div class="block2nd container">
	<div class="leftbox">
<p>キュウリをサーフボードに見立て、縦横無尽にレタス（波）を切る、真っ黒に日に焼けた赤いビキニ姿の美人さんがトレードマークです。</p>

<p>【太陽と野菜の直売所】直営の農園で収穫した野菜には、このブランドロゴをモチーフにした丸形のシールが付いています。</p>
	</div>
<div class="rightbox">
<p class="centering"><img src="img/sweet/image02.gif" alt="丸形シールのとらみスイートのロゴイメージ" width="224" height="224"></p>
</div>
</div>
</div>



<div class="block">
	<h3>このマークが「安心・安全」の印です</h3>

<div class="block2nd container">
	<div class="leftbox">
<p>ご存じのように、当農園では完全な有機栽培野菜（いわゆる完全オーガニック野菜）を作っておりますが、春先の食虫被害（モンシロチョウの青虫対策）だけに、わずかな分量の殺虫剤を使いますが、年間をとおして「90％以上の減農薬栽培」を行っています。（「アブラナ科の野菜にだけ使用します」</p>


	</div>
<div class="rightbox">
<p class="centering"><img src="img/sweet/image03.jpg" alt="とらみスイートの野菜のイメージ画像" width="283" height="212"></p>
</div>
</div>
	
	<p>そんな農薬類ですが、基本的に各野菜苗の定植時に使い、栽培期間中は「農薬不使用」ですから、野菜に残留する薬品類は「皆無」であり、露地野菜を除けばそのまま食べることのできる安心・安全な野菜です。</p>
</div>



<div class="block">
	<h3>なぜ農薬を使わなくても野菜が病気にならないのですか？</h3>

<p>答えは至極カンタンな自然の摂理、原理です。化学肥料を使った野菜栽培では、無機質のチッソ、リン酸、カリウムだけを野菜たちが大量に吸収してしまい、本来土壌を介して吸収するべき微量元素や、さまざまな微生物から分泌、また排泄されるはずの、アミノ酸類（有機化合物）から生まれる、免疫機能が働くための抗生物質系の物質が「ない」からです。</p>

<p>特に、味覚感覚では、苦さ成分（えぐみ）が化学肥料栽培の「欠点」と言われており、【太陽と野菜の直売所】で栽培された野菜たちには、そのえぐみ成分はなく、ほのかな「甘み」すら感じるほどの、今は高付加価値の乗った高級野菜ということになります。</p>

<p>ぜひ、この「とらみスイート」ブランドロゴを見かけたら、手に取って食べてみてください！</p>

<p>その理由は、食べればわかります！</p>

</div>



<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
