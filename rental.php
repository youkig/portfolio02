<?php $siteid=71?>
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

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 農機・農機具・耕運機のレンタルサービス始めました</p>
	<div class="block">
	<h2>農機・農機具・耕運機のレンタルサービス始めました</h2>



</div>

<div class="block">
<p>【太陽と野菜の直売所】（東浪見岡本農園）では、令和4年2月から、トラクターや耕運機などの農機・農機具のほか、フォークリフト、ミニショベル（ユンボ）等のレンタルサービスを開始しました。</p>




</div>

<div class="block">

<h3>レンタルできる農機・農機具</h3>
	
<div class="block2nd container">
<div class="leftbox">
<ol>
<li>ミニユンボ（コマツ：PC-01）※軽トラに乗ります</li>
<li>ミニユンボ（クボタ：KH-14）</li>
<li>ユンボ（コマツ：PC-28UU）</li>
<li>トラクター（ヤンマー：18馬力）</li>
<li>トラクター（クボタ：36馬力）</li>
<li>耕運機（ホンダ：FF300）</li>
<li>耕運機（ホンダ：FF500）</li>
<li>管理機（クボタ：FTR90）</li>
<li>管理機（クボタ：ウネマスター）</li>
<li>コンバイン（ヤンマー：3条刈）</li>
<li>田植え機（ヤンマー：4条植え）</li>
<li>乾燥機（9石）</li>
<li>籾摺り機（選別機）</li>
<li>計量器</li>
<li>お米のコンテナ（軽トラ共に可）</li>
<li>軽トラ：スバル：サンバー660cc</li>
<li>アルミブリッジ（軽トラ用）</li>
<li>アルミブリッジ（1.5トンまで）</li>
<li>アルミブリッジ（3トンまで　4トンダンプ用）</li>
</ol>
</div>
<div class="rightbox">
<p><img src="img/rental/image01.jpg" alt="レンタル出来る農機・農機具の写真　その1" width="298" height="222"></p>
<p><img src="img/rental/image02.jpg" alt="レンタル出来る農機・農機具の写真　その2" width="298" height="223"></p>
</div>
</div>
</div>






<div class="block">

<p>ホンダの耕運機、一部のユンボ以外は、すべて「ほぼ新品」です。また、上記にない農機、農機具については、別途ご相談ください。（動噴、肥料散布機もあります）</p>

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
