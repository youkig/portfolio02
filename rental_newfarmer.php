<?php $siteid=75?>
<?php include("include/autometa.php");?>
<!DOCTYPE html>
<html lang="ja">
<?php include("config.php");?>


<head>

<meta name="robots" content="all">
<meta property="og:title" content="">
<meta property="og:type" content="website">
<meta property="og:url" content="index">	
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<meta name="keywords" content="<?=$n_keyword?>">

<meta name="description" content="<?=$n_description?>">

<title><?=$n_title?></title>

<link rel="stylesheet" href="css/base.css" type="text/css">
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
	<div id="cnt" class="newfarmer">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 新規就農者個人事業向け　レンタル農園・貸し農園</p>
	<div class="block">
	<h2><img src="img/newfarmer/h2.jpg" width="780" height="205" alt="新規就農者個人事業向け　レンタル農園・貸し農園" /></h2>
</div>

<div class="block">
<div class="container">
<div class="leftbox w55">
<p>【太陽と野菜の直売所】（東浪見岡本農園）では、新規就農者や短期間だけの農地を借りたいと考えている飲食業等の事業者向けに、当農園で別途サービス提供している家庭菜園レベルの「6坪」レンタルではなく、ご要望に応じた耕作面積でのレンタル農園・貸し農園サービスを始めることになりました。</p>
</div>

<div class="rightbox w40">
    <p><img src="img/newfarmer/img01.jpg" width="220" height="146" alt="農園で収穫された野菜を持つレンタル農園利用者の写真です" /></p>
</div>
</div>
<p>令和5年の農地法の改正があり、農業従事者としての占有農地の「下限面積が撤廃」され（それまでは50アール：農地法による）ましたが、いまだに短期間での耕作を検討されている「お試し」新規就農者、飲食業を営んでいる方々には、法律上「将来的な農業を持続継続することが必要」となっており、お試し的なチャレンジ前の訓練や体験ができない状況が続いています。</p>

<p>そこで、【太陽と野菜の直売所】（東浪見岡本農園）では、そんなご要望のある方々に向けた、挑戦的な試みを支援するために、基本契約を「6か月間」とする短期のレンタル農園・貸し農園サービスを開始することになりました。</p>

<p>基本的に、法律（農地法）に抵触しない範囲の「短期貸し」となりますが、必要と思われる耕作面積に応じたレンタル料金を相談させていただきますので、まずはメールまたはフォームからご相談ください。</p>


</div>



<div class="block">
	<h3>○レンタル料金について</h3>

<p>基本的に6か月間の短期間となり、「坪単価：1,000円程度以下」を目安としてお考えください。（レンタルする耕作面積によりレンタル単価は変わります）</p>

</div>



<div class="block">
	<h3>○野菜等の水やり設備について</h3>

	<p>当農園では、すべての畑エリアに水やり用の水栓を設置してあり、水源はすべて井戸水を無料で使用することができます。</p>

</div>


<div class="block">
	<h3>○農機、農機具について</h3>

	<p>それぞれのご事情に応じてレンタル（有料）もできます。トラクター、耕運機、ユンボ等の用意もありますので、この点はご相談ください。</p>

</div>



<div class="block">
	<h3>○出入り時間帯について</h3>

<p>周辺には居宅も多い場所になりますので、真夜中など常識的な時間帯以外は、いつでも出入りが可能です。</p>

</div>	


<div class="block">
	<h3>○電気を使いたい場合</h3>

<p>当農園では、一部を除き「ソーラー蓄電システム」による自家発電の電気を使っておりますので、停電や災害時であっても電気を利用することができます。有償になるか、または無償になるかについても、ぜひ一度ご相談ください。</p>

</div>	


<div class="block">
<p>これから新規に農業への参入をお考えのご夫婦やご家族、飲食店等で自前の有機野菜の栽培メニューを作りたいとお考えの方々など、家庭菜園レベルの耕作面積では狭いが、まずは「1年程度」お試しで農業をやってみたいとお考えの方は、遠慮なく農園見学にいらしてください！</p>

<p>農園管理人の岡本が、いつでも案内差し上げます！</p>

<p>よろしくお願いいたします！</p>
<p class="righting">令和6年11月</p>

</div>


<div class="block">


<p>メール：<a href="mailto:torami@okamoto-farm.co.jp" class="underline">torami@okamoto-farm.co.jp</a></p>

<p>電話：<?=$mobile?>（農園管理人：岡本直通）まで</p>

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
