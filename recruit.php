<?php $siteid=70?>
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

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 求人・アルバイト募集 | 【太陽と野菜の直売所】求人・アルバイト募集</p>
	<div class="block">
	<h2>【太陽と野菜の直売所】求人・アルバイト募集　<span>募集中！</span></h2>

<p class="catch">【太陽と野菜の直売所】（東浪見岡本農園）では、<br class="br-sp">
農業や野菜栽培が大好きな方（男女問わず）の<br class="br-sp">
アルバイト、パートタイマーさんを募集しています。
</p>

</div>

<div class="block">
<p>（一宮町東浪見にある、完全有機栽培による野菜を作っている農園です）<br class="br-sp">
基本的にカンタンな農作業を中心にして、以下の曜日、時間帯から選択いただき、応募するみなさまの体力に応じたお小遣い稼ぎを、楽しく愉快にやってみてください。
</p>




</div>

<div class="block">
	<dl class="fl">
	<dt>・時給</dt>
<dd>1,100円～（昇給制度あり）</dd>
</dl>

<dl class="fl">
	<dt>・曜日</dt>
<dd>火、水、木、土、日</dd>
</dl>

<dl class="fl">
<dt>・時間帯</dt>
<dd>（冬季）午前8時00分～正午、午後2時00分～午後4時30分<br>
（夏季）午前8時30分～正午、午後2時30分～午後5時00分
</dd>
</dl>

<dl class="fl">
	<dt>・休暇</dt>
<dd>お正月休み、夏休み、お盆休み</dd>
</dl>

<dl class="fl">
	<dt>・年齢</dt>
<dd>基本的に「不問」です</dd>
</dl>
</div>






<div class="block">
	<h3>有機栽培の勉強のために</h3>

<p>【太陽と野菜の直売所】（東浪見岡本農園）では、田畑を「1町歩」（約3,000坪）を所有しており、農業の第6次産業化を目指していて、地元の雇用促進だけでなく、最終的に「農家が農家として生活できる農業」を目標としています。</p>

<p>農園に設置している農産物直売所、農業倉庫、トイレ、食品加工場には、それぞれソーラーパネルを設置しており、脱炭素社会に向けた取組みだけでなく、これから農業を目指す方々の有機栽培法の指導、また付加価値の大きい無農薬栽培、特に誰もがおいしいと言ってくれるような野菜栽培を種まきから行っています。</p>

<p>令和4年現在、農業ハウスは4棟あり、今後はソーラー発電によるハウス内冷暖房システムの確立により、持続可能な低コストでありながら、大きな付加価値の乗った野菜栽培を目指しています。</p>
</div>



<div class="block">
	<h3>ぜひ一度見学にいらっしゃってください！</h3>

<p>最も重労働と思われる農作業は「施肥作業」です。最大20kg程度のホームセンター等で販売されている肥料袋から、施肥桶に移す作業となります。</p>

<p>苗の定植、また収穫時の楽しみは、何よりも楽しみであり、お天道様と植物を愛する心さえ持っている方であれば、特に夏の季節にかく汗は無上のものではないでしょうか？</p>

<p>収穫して姿カタチが悪く販売できないものは、間違いなく持ち帰ることもできますし、今はレンタル食品加工場（レンタルキッチン）となっている厨房で、お弁当販売、野菜販売に向けた新しい企画に参加することもできます。※当農園では飲食業許可を得ています。</p>

<p>シャインマスカットのブドウ棚の下で、焼き肉パーティをできる場所も用意していて、働いていただけるみなさまが、さまざまな企画を持ち寄っていただき、重労働の農業イメージを払拭いただくような働き方も「あり」です。</p>

<p>農園管理人の、わたくし岡本がお待ちしております！</p>


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
