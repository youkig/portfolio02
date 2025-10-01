<?php $siteid=74?>
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

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | レンタル農園　オプション料金表</p>
	<div class="block">
	<h2>レンタル農園　オプション料金表</h2>



</div>

<div class="block">


<p>当ページでは、【太陽と野菜の直売所】（東浪見岡本農園）が提供しているレンタル農園（貸し農園）における、レンタル費用以外に必要となるオプション費用について、一覧表にして説明しています。</p>

<p>当農園では、契約者様の持ち込み資材や、野菜のタネ、または苗を他店で購入して定植することを許可していますので、以下リストにある各種費用、また代金が必ず必要になる訳ではありません。</p>

</div>


<div class="block">

<h3>1.	オプション作業費用（6平方メートル分）</h3>
<dl class="fl2">
	<dt>水やり</dt>
<dd style="font-weight: normal;">1か月　2,200円</dd>
</dl>

<dl class="fl2">
	<dt>雑草処理</dt>
<dd style="font-weight: normal;">1か月　3,300円</dd>
</dl>

<dl class="fl2">
	<dt>元肥散布＋耕運作業</dt>
<dd style="font-weight: normal;">1回　　3,300円（元肥料金を含む）</dd>
</dl>

<dl class="fl2">
	<dt>栽培完全委託</dt>
<dd style="font-weight: normal;">1か月　13,200円（タネ、苗代金は別途）</dd>
</dl>

<dl class="fl2">
	<dt>収穫＋梱包発送</dt>
<dd style="font-weight: normal;">1回　　1,100円から（宅配費、箱代は別途）</dd>
</dl>




		</div>	


<div class="block">

<h3>2.	オプション資材代金</h3>
<dl class="fl2">
	<dt>有機元肥（6平方メートル分）</dt>
<dd style="font-weight: normal;">全面散布　2,500円</dd>
</dl>

<dl class="fl2">
	<dt>有機液肥2号（多木化学）</dt>
<dd style="font-weight: normal;">1本　2,200円</dd>
</dl>

<dl class="fl2">
	<dt>有機液肥3号（多木化学）</dt>
<dd style="font-weight: normal;">1本　2,200円</dd>
</dl>

<dl class="fl2">
	<dt>微生物資材＋土壌改良資材</dt>
<dd style="font-weight: normal;">1回　2,200円から</dd>
</dl>


		</div>	

<div class="block">
<p>※「有機元肥」とは、当農園が独自にブレンドした有機肥料であり、30リットル（6平方メートルあたり）1袋の価格代金となります。微生物資材、完熟鶏ふん、完熟とんぷん、リン酸入り油粕、もみ殻、米ぬか、牡蠣殻カルシム資材など、合計10種類以上が入っている肥料です。</p>


<h3>3.	オプション種苗代金</h3>
<dl class="fl2">
	<dt>野菜のタネ（各社）</dt>
<dd style="font-weight: normal;">1袋　350円から</dd>
</dl>

<dl class="fl2">
	<dt>野菜の苗（自社製）</dt>
<dd style="font-weight: normal;">1苗　80円から250円くらいまで</dd>
</dl>



</div>




<div class="block">
<h3>ご連絡・お問合せ先</h3>

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
