<?php $siteid=47?>
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
	<div id="cnt" class="company top">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | お知らせ一覧</p>
	<div class="block">
	<h2>お知らせ一覧</h2>

</div>

<div class="block info">
<?php
		$sql="SELECT * From t_news Where disp=1 order by indate desc";
		$i = $dbh->prepare($sql);
		$i -> execute();
		$result = $i->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($result)){
		?>
<ul>
	<?php
			foreach($result as $row){
	?>
	<li>（<?=date("Y/m/d",strtotime($row["indate"]))?>）<a href="<?=$esurl?>information?id=<?=$row["id"]?>"><?=$row["title"]?></a></li>
	<?php
			}
	?>
</ul>

<?php
		}else{
		?>
<p>現在、お知らせはありません。</p>
<?php
		}
		?>
</div>


<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
