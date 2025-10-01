<?php $siteid=55?>
<?php include("include/autometa.php");?>
<!DOCTYPE html>
<html lang="ja">
<?php include("config.php");?>

<head>

<meta name="robots" content="all">
<meta property="og:title" content="太陽と野菜の直売所【東浪見岡本農園】">
<meta property="og:type" content="website">
<meta property="og:url" content="index">
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

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | レンタル厨房・レンタルキッチンのご案内</p>
	<div class="block">
	<h2>レンタル厨房・レンタルキッチンのご案内</h2>



</div>

<div class="block">


<div class="container">
<div class="leftbox">
<p>【太陽と野菜の直売所】（東浪見岡本農園）では、農園内にある食品加工場の厨房（キッチン）を1日単位、半日、時間単位でレンタルしています。</p>

<p>法人様の運動会や社員研修、イベント等で大量のお弁当を作ろうと思っているが、それなりの規模のキッチンを確保できない、また料理教室を定期的に開催したいが、近くに適当なレンタルキッチンやレンタル厨房がないという方は、お気軽にご相談ください。</p>
</div>
<div class="rightbox">
	<p><img src="img/kitchen/img01.jpg" width="278" alt="東浪見岡本農園のレンタル厨房の写真です"></p>
</div>
</div>
<dl class="fl">
	<dt>住所</dt>
<dd style="font-weight: normal;">〒299-4303千葉県長生郡一宮町東浪見4721<br>（駐車場完備、男女別トイレあり）</dd>
</dl>

<dl class="fl">
	<dt>面積</dt>
<dd style="font-weight: normal;">約9坪　（ほか6坪のテラス付き）<br>
※新築建屋（令和3年竣工）で「飲食業」「お惣菜販売業」の許可証取得済み</dd>
</dl>



<dl class="fl">
	<dt>用意してある厨房機器</dt>
<dd>
<ul>
<li>業務用カステーブル</li>
<li>業務用ガスフライヤー（18L）</li>
<li>業務用ガス魚焼き器　（上下焼）</li>
<li>ガス炊飯器</li>
<li>超低温冷凍庫　（－60℃まで設定可）</li>
<li>業務用大型冷蔵庫</li>
<li>業務用大型冷凍庫</li>
<li>業務用製氷機</li>
<li>調理台　（3台）</li>
<li>1回搗き電気精米機</li>
<li>WiFiインターネット完備　（BOSEサウンドシステムあり）</li>
<li>テーブル・椅子レンタル可</li>
</ul>
</dd>
</dl>
		</div>	

<div class="block">
<p>当農園には、合計3棟の建屋があり、すべての屋根上にはソーラーパネル（約7,000W）が載っていて、電気は地球にやさしい「自然エネルギー発電」で賄っています。</p>

<p>レンタル使用料金は、基本的に「1時間：1,100円」で算出しますが、1日単位、半日単位、料理教室等で定期的に利用を検討されている方は、メールフォームまたは電話でお問合せください。</p>


</div>




<div class="block">
<h3>ご連絡・お問合せ先</h3>

	<p>メール：<a href="mailto:torami@okamoto-farm.co.jp" class="underline">torami@okamoto-farm.co.jp</a></p>
<p>電話：<?=$mobile?>（農園管理人：岡本直通）</p>

</div>


<div class="block">
<p>レンタルサービス開始に伴い、「こんな厨房機器があったら借りるぞ！」というご要望がありましたら、どうか遠慮なく申し出ください。（購入して用意します）</p>

<p>早速のご相談、ご要望をお待ちしています！</p>
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
