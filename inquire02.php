<?php $siteid=53?>
<?php include("include/autometa.php");?>
<?php
session_start();
?>
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
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

<script src="js/jquery-1.5.2.min.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" href="js/jquery.ui.css" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="js/jquery.bgswitcher.js"></script>
<script src="js/pagetop.js"></script>

<script src="js/topslide.js"></script>

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

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | お問合せ・お申込み（入力内容確認）</p>
	<div class="block">
	<h2>お問合せ・お申込み（入力内容確認）</h2>


<?php
			$errch=0;
			if(empty($_POST["koumoku"])){$errch++;}
			if(empty($_POST["person"])){$errch++;}
			if (empty(str_replace(" ","",str_replace("　","",$_POST["name"])))){$errch++;}
			if(empty($_POST["furigana"])){$errch++;}
			if(empty($_POST["email"])){$errch++;}
			if(empty($_POST["zip1"]) || empty($_POST["zip2"])){$errch++;}
			if(empty($_POST["comment"])){$errch++;}
			if($errch>0){
			?>
<p>入力内容に不備があります。必須項目をご確認ください。</p>
            <?php
			}else{
			?>
<p>以下内容でよろしければ、送信ボタンを押してください。</p>
            <?php
			}
			?>
</div>



<form action="<?=$esurl?>inquire03" method="post">
<div class="block">
<h3>お問合せフォーム</h3>
	
<dl>
	<dt>お問合せ項目&nbsp;<em>[必須]</em></dt>
<dd>
<?=implode(",",$_POST["koumoku"])?>
				
</dd>
</dl>

        <?php
		if(!empty($_POST["sname"])):
		?>

        <dl>
            <dt>問合せしたい商品</dt>
        <dd>
        <?=$_POST["sname"]?>
        </dd>
        </dl>	
        <?php
		endif;
		?>

<dl>
	<dt>法人・個人&nbsp;<em>[必須]</em></dt>
<dd>
<?=$_POST["person"]?>
</dd>
</dl>

	<?php
		if($_POST["person"]=="法人"){
		?>
	<dl class="houjin">
	<dt>法人名</dt>
<dd><?=$_POST["company"]?></dd>
</dl>

<dl class="houjin">
	<dt>部署</dt>
<dd><?=$_POST["busyo"]?></dd>
</dl>
	<?php
		}
		?>
<dl>
	<dt>お名前&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["name"]?></dd>
</dl>

<dl>
	<dt>ふりがな&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["furigana"]?></dd>
</dl>

<dl>
	<dt>メールアドレス&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["email"]?></dd>
</dl>

<dl>
	<dt>電話番号</dt>
<dd><?=$_POST["tel"]?></dd>
</dl>

<dl>
	<dt>郵便番号&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["zip1"]?> -<?=$_POST["zip2"]?></dd>
</dl>

<dl>
	<dt>都道府県</dt>
<dd><?=$_POST["state"]?>
</dd>
</dl>

<dl>
	<dt>市区町村名</dt>
<dd><?=$_POST["address"]?></dd>
</dl>

<dl>
	<dt>以下番地、建物名など</dt>
<dd><?=$_POST["address2"]?></dd>
</dl>

<dl>
	<dt>お問合せ内容&nbsp;<em>[必須]</em></dt>
<dd><?=nl2br($_POST["comment"])?></dd>
</dl>


</div>
<?php
		if($errch==0){
		?>
<div class="block">
<p>上記内容でよろしければ、送信ボタンを押してください。</p>
<p class="centering"><input type="submit" name="submit" value="送　信" />&nbsp;&nbsp;<input type="button" value="戻　る" onClick="history.back()" onKeyPress="history.back()" /></p>
</div>
<?php
		}else{
		?>
<div class="block">

<p class="centering"><input type="button" value="戻　る" onClick="history.back()" onKeyPress="history.back()" /></p>
</div>
<?php
		}

		foreach($_POST as $key=>$row){
			if($key=="koumoku"){
			?>
		<input type="hidden" name="<?=$key?>" value="<?=implode(",",$row)?>">
			<?php
			}else{
		?>
	<input type="hidden" name="<?=$key?>" value="<?=$row?>">
		<?php
			}
		}
		
		?>
</form>

<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88" /></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
