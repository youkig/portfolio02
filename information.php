<?php $siteid=48?>
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
<link rel="canonical" href="<?=$esurl?>information.php?id=<?=cnum($_GET["id"])?>">
<meta name="keywords" content="<?=$n_keyword?>">

<meta name="description" content="<?=$n_description?>">

<?php
if (cnum($_GET["id"])!==0){
	$sql="SELECT * From t_news Where disp=1 and id=:id";
	$i = $dbh->prepare($sql);
	$i->bindValue(":id",$_GET["id"],PDO::PARAM_INT);
	$i->execute();
	$result = $i->fetch(PDO::FETCH_ASSOC);
		if(empty($result)){
		header("location:index.php");
		}else{
		$titles=$result["title"];
		$naiyo =$result["naiyo"];
		}
}else{
header("location:index.php");
}
?>
<title><?=$titles?><?=$n_title?></title>

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
	<div id="cnt" class="company">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | お知らせ</p>
	<div class="block">
	<h2><?=$titles?></h2>

</div>

<div class="block">

<?= nl2br($naiyo)?>
</div>
<p class="righting"><a href="#" onClick="history.back()" class="underline">戻る</a></p>
<p class="centering"><a href="<?=$esurl?>infolist" class="underline">お知らせ一覧</a></p>

<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>

<!-- id box end --></div>
</body>
</html>
