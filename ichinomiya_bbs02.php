<?php $siteid=44?>
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
<?php include("include/js.php")?>
<script src="js/bbs_chk.js"></script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>
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
	<div id="cnt" class="fashion ichinomiya">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 千葉県一宮町へ移住をお考えの方々へ | 一宮町町政への苦情、ご意見投稿ページ（入力内容確認）</p>
	<div class="block">
	<h2>千葉県一宮町へ移住をお考えの方々へ</h2>

<h3><img src="img/ichinomiya/h3_02.png" alt="一宮町町政への苦情、ご意見投稿ページ" width="780" height="205"></h3>

<p>以下の内容でよろしいでしょうか？</p>


</div>



<form action="<?=$esurl?>ichinomiya_bbs03" method="post">
<div class="block">
    
        <dl>
            <dt>お名前&nbsp;<em>[必須]</em></dt>
            <dd><?=$_POST["name"]?></dd>
        </dl>
        <dl>
            <dt>ペンネーム&nbsp;[任意]</dt>
            <dd><?=$_POST["penname"]?></dd>
        </dl>
        <dl>
            <dt>郵便番号&nbsp;<em>[必須]</em></dt>
            <dd><?=$_POST["zip1"]?> - <?=$_POST["zip2"]?></dd>
        </dl>
        <dl>
            <dt>都道府県&nbsp;<em>[必須]</em></dt>
            <dd><?=$_POST["state"]?>
            </dd>
        </dl>
        <dl>
	        <dt>市区町村名&nbsp;<em>[必須]</em></dt>
            <dd><?=$_POST["address"]?></dd>
        </dl>

        <dl>
            <dt>以下番地、建物名など&nbsp;<em>[必須]</em></dt>
            <dd><?=$_POST["address2"]?></dd>
        </dl>
        
        <dl>
        <dt>電話番号&nbsp;<em>[必須]</em></dt>
            <dd><?=$_POST["tel"]?></dd>
        </dl>
    
        <dl>
            <dt>メールアドレス&nbsp;<em>[必須]</em></dt>
            <dd><?=$_POST["email"]?></dd>
        </dl>
        
        <dl>
            <dt>対象の組織・課&nbsp;<em>[必須]</em></dt>
            <dd><?=$_POST["category"]?></dd>
        </dl>
        
        <dl>
            <dt>投稿内容&nbsp;<em>[必須]</em></dt>
            <dd><?=nl2br($_POST["comment"])?></dd>
        </dl>

        
   
</div>
    
    <div class="block">
        <p class="centering">上記の内容でよろしければ、「送　信」ボタンをクリックしてください。</p>
        <p class="centering"><input type="submit" value="　送　信　"></p>
    </div>
<?php

		foreach($_POST as $key=>$row){
		?>
	<input type="hidden" name="<?=$key?>" value="<?=$row?>">
		<?php
			}
		
		?>
 </form>


<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
