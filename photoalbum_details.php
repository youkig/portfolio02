<!DOCTYPE html>
<html lang="ja">
<?php include("config.php");?>
<?php
$sql="SELECT * From t_photoalbum Where disp=1 and dateid=:detailid";
$p = $dbh->prepare($sql);
$p -> bindValue(":detailid",$_GET["id"],PDO::PARAM_STR);
$p -> execute();
$rs = $p->fetch(PDO::FETCH_ASSOC);
if(empty($rs)){
	header("location:".$esurl."photoalbum");
}
?>


<head>

<meta name="robots" content="all">
<meta property="og:title" content="太陽と野菜の直売所【東浪見岡本農園】">
<meta property="og:type" content="website">
<meta property="og:url" content="index.php">
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="canonical" href="<?=$esurl?>photoalbum_details?id=<?=$_GET["id"]?>">
<meta name="keywords" content="有機栽培,無農薬野菜,野菜狩り,収穫体験,レンタル農園,貸し農園,観光農園,農業土木,農機具レンタル,耕運代行,農産物直売所,レンタル厨房,トラクター,耕運機,ユンボ,ソーラー蓄電システム,避難場所,停電,非常用電源,とらみスイート,千葉県,長生郡,一宮町,外房,九十九里">

<meta name="description" content="千葉県長生郡一宮町、サーフィンのメッカでも釣ヶ崎海岸にほど近いエリアで、完全有機栽培で野菜を作っている【太陽と野菜の直売所】（東浪見岡本農園）ホームページでは、観光農園として野菜狩り・農業体験サービスのほか、期間貸しのレンタル農園のご紹介や、農機・農機具レンタル、レンタル厨房のご案内をしております。停電時にいつも電気のある災害避難所としてもご利用になれます。">

<title><?=$rs["title"]?>／野菜狩り 千葉県【太陽と野菜の直売所】レンタル農園 一宮町／野菜収穫体験 九十九里</title>


<link rel="stylesheet" href="css/base.css?<?=str_replace(":", "", date("H:i:s")); ?>" type="text/css">
<?php include("include/js.php")?>

<body>


<div id="box">

<div id="header">
	<h1>有機野菜 直売所／千葉 一宮町</h1>


<?php include("include/header.php")?>


<div id="main" class="container">
	<?php include("include/leftpane.php")?>
	<div id="cnt" class="album">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | <a href="<?=$esurl?>photoalbum">農園紹介の写真集</a> | <?=$rs["title"]?></p>
	<div class="block">
	<h2>農園紹介の写真集</h2>


<h3><?=$rs["title"]?></h3>
<p class="righting"><?=date('Y/m/d',strtotime($rs["in_date"]))?></p>
</div>

<div class="block">
<p class="centering"><img src="<?=$photoimg?>photoimg/<?=$rs["image"]?>" alt="<?=$rs["title"]?>の画像です"></p>
<?=nl2br($rs["naiyo"])?>


</div>

		<div class="block">
	<p class="righting"><a href="<?=$esurl?>photoalbum" class="underline">一覧へ戻る</a></p>
</div>


<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
