<?php $siteid=36?>
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

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 野菜栽培のための農地利用権利の確保サービスのご案内</p>
	<div class="block">
	<h2>野菜栽培のための農地利用権利の確保サービスのご案内</h2>



</div>

<div class="block">
<p>【太陽と野菜の直売所】（東浪見岡本農園、千葉県長生郡一宮町）では、万一発生する有事、非常時等の「国難」「食糧難」に備えるため、野菜栽培のための農地利用権利の確保サービスを、令和2年7月から開始することになりました。</p>

<p>わが国では、現時点で初めての試みとなるはずですが、有事の際、首都圏や近隣に農地のないエリアにお住いの方々は、ご家庭で必要な最低限の野菜類を確保するためには、スーパーマーケットやインターネット通販等を利用して購入する以外に手に入れる手段はありません。</p>

<div class="container">
<div class="leftbox">
<p>そこで【太陽と野菜の直売所】では、レンタル農園（貸し農園）としての利用契約だけではなく、事前に「野菜類の入手確保を目的とした農地利用権利」（月極契約）の提供サービスを開始いたします。</p>

<p>野菜の高騰に備えてもよし、いわば生命保険や損害保険に似た、万一に備える「食糧自給権利」ともいえるでしょう。</p>
</div>
<div class="rightbox">
	<p><img src="img/ensure/img01.jpg" width="278" height="194" alt="東浪見岡本農園のレンタル農園の写真です"></p>
</div>
</div>
<p>【太陽と野菜の直売所】（東浪見岡本農園）では、千葉県長生郡一宮町東浪見において、日常的に所有する農園において野菜類の生産と、当地で収穫した農産物を農園内にある直売所において販売しておりますが、契約者みなさまには、当地農園内の畑を誰にも優先して利用、または当社に栽培委託をして野菜類の入手を確保できることになります。</p>

			
<p class="catch">ぜひ、月額2,200円からの（入会金1,100円）<br class="br-sp">
「野菜確保サービス」に、ぜひ加入してみませんか？<br class="br-sp">（先着100名様限定となります）</p>

			<p class="small">※月額費用は、契約する農地面積に応じて変わります。（2,200円では2m×3m＝6平方メートル）</p>
</div>






<div class="block">
	<h3>サービス要項</h3>

<ol class="service">
	<li>契約する農地（畑）は、平時における利用申し込みがない限り、当社農園で使用しますので、特定の契約面積に応じた物理的な利用の権利が発生する訳ではありません。（いつでも見学は可能です）</li>

<li>契約者様がご自身で野菜栽培を開始する場合は、当社で用意している「レンタル農園サービス」に移行していただく必要があります。</li>

<li>契約面積に応じた「野菜栽培委託サービス」（月額1万円～）の用意もありますので、農園のある現地にお出でいただくことなく、季節に応じたお好きな野菜類の自給入手も可能です。（収穫した野菜類は宅配便でお送りします）</li>

<li>当社の農園では、基本的に完全有機栽培となっていますので、契約者様が指定した化学肥料や堆肥、微生物資材、農薬等はご使用になれません。</li>

<li>基本的に「露地栽培」（農業ハウス内ではない）における農地確保サービスです。</li>

<li>契約期間は「1年間」とさせていただき、サービス費用は「年額前受金」となります。（※月額2,200円契約の場合、入会金1,100円＋（2,200円×12か月）＝27,500円となります）</li>

<li>上記基本契約は、次年の年額費用のお振込みをいただければ自動更新となります。</li>

</ol>

<p class="righting">以上</p>
</div>


<div class="block">
<h3>ご連絡先</h3>

	<p><a href="mailto:torami@okamoto-farm.co.jp" class="underline">torami@okamoto-farm.co.jp</a> または　<?=$mobile?>　までお願いします。</p>
	<p class="righting">東浪見岡本農園<br>【太陽と野菜の直売所】<br>農園管理人　岡本　洋</p>
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
