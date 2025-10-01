<?php $siteid=58?>
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
<script src="js/member_chk.js"></script>

<script>
$(function () {
	
	$("#person1").click(function(){
		$(".houjin").fadeIn();
	});
	
	$("#person2").click(function(){
		$(".houjin").fadeOut();
	});

});
</script>
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

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 【太陽と野菜の直売所】（東浪見岡本農園）会員登録（入力内容確認）</p>
	
<h2>【太陽と野菜の直売所】（東浪見岡本農園）会員登録（入力内容確認）</h2>
<?php
	$sql = "Select * From t_user Where email=:email";
	$user = $dbh->prepare($sql);
	$user -> bindValue(":email",$_POST["email"],PDO::PARAM_STR);
	$user -> execute();
	$result = $user->fetch(PDO::FETCH_ASSOC);
	if(!empty($result)){
?>

<div class="block">
<p class="centering">このメールアドレスはすでに登録されております。</p>

<p class="centering"><input type="button" value="戻　る" onClick="history.back()" /></p>
</div>

<?php
}else{
?>
<div class="block">
<p>以下の内容でよろしいですか？</p>
</div>

<form action="<?=$esurl?>member_regist03" method="post">
<div class="block">

	
<dl>
	<dt>ご利用予定のサービス&nbsp;<em>[必須]</em></dt>
<dd>
<?=implode(",",$_POST["koumoku"])?>
</dd>
</dl>


<dl>
	<dt>法人・個人&nbsp;<em>[必須]</em></dt>
<dd>
<?=$_POST["person"]?>
</dd>
</dl>
<?php
if ($_POST["company"]<>""){
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
	<dt>パスワード&nbsp;<em>[必須]</em></dt>
<dd>※セキュリティの為、非表示</dd>
</dl>

<dl>
	<dt>電話番号&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["tel"]?></dd>
</dl>

<dl>
	<dt>郵便番号&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["zip1"]?>-<?=$_POST["zip2"]?></dd>
</dl>

<dl>
	<dt>都道府県&nbsp;<em>[必須]</em></dt>
<dd>
<?php
		if($_POST["state"]<>""){
				$sql="SELECT * From t_state Where id=:state";
				$state = $dbh->prepare($sql);
				$state->bindValue(":state",$_POST["state"],PDO::PARAM_INT);
				$state->execute();
				$result = $state->fetch(PDO::FETCH_ASSOC);
				$statename = $result["state"];
				echo $statename;
				
		}
?>
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
	<dt>ご質問・ご要望など&nbsp;[任意]</dt>
<dd><?=nl2br($_POST["comment2"])?></dd>
</dl>

<dl>
	<dt>メールマガジン受信希望</dt>
<dd>
<?php
if ($_POST["mailmaga"]<>""){
echo "希望する";
}else{
echo "希望しない";
}
?></dd>
</dl>



</div>

<div class="block">
<p>上記内容でよろしければ、登録ボタンをクリックしてください。</p>
<p class="centering"><input type="submit" name="submit" value="登　録" />&nbsp;&nbsp;&nbsp;<input type="button" value="戻　る" onClick="history.back()" /></p>
</div>
<input type="hidden" name="statename" value="<?=$statename?>" />
<?php
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
<?php
}
?>
<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88" /></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>



<!-- id box end --></div>
</body>
</html>
