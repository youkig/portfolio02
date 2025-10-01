<?php $siteid=78?>
<?php include("include/autometa.php");?>
<?php
session_start();
?>
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
<script type="text/javascript" src="js/reserved_chk.js"></script>

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
	<div id="cnt" class="company cart">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 注文フォーム（入力内容確認）</p>
	<div class="block">
	<h2>注文フォーム（入力内容確認）</h2>

<?php
			$errch=0;
			
			if ($_POST["name"]==""){$errch++;}
			if ($_POST["furigana"]==""){$errch++;}
			if ($_POST["email"]==""){$errch++;}
			if ($_POST["zip1"]=="" || $_POST["zip2"]==""){$errch++;}
			if ($_POST["month"]=="" || $_POST["day"]==""){$errch++;}
		
			if ($errch>0){
			echo "<p>入力内容に不備があります。必須項目をご確認ください。</p>";
			}else{
			echo "<p>以下内容でよろしければ、送信ボタンを押してください。</p>";
			}
?>

</div>



<form action="<?=$esurl?>reserved03" method="post">
<div class="block">
<h3>注文フォーム</h3>


<!--スタート買い物明細-->
					
					<table summary="購入商品">
									<thead>
										<tr>
											<th>商品名</th>
											<th>商品単価</th>
											<th>数量</th>
											<th>金額</th>
											
										</tr>
									</thead>
					
					<tbody>
					<?php
					$cnt=0;
					$SUM = 0;
					$OPSEL_COUNT = 3;
					$tyumon=0;
					
					
					foreach($_COOKIE as $key=>$val){

						if(strpos($key,"okamotofarm")!==false){
							
						$tyumon=1;
						$cnt++;
					
							$sql="SELECT * From t_master Where id=:id";
							$p = $dbh->prepare($sql);
							$p->bindValue(":id",str_replace("okamotofarm_","",$key),PDO::PARAM_INT);
							$p->execute();
							$rss = $p->fetch(PDO::FETCH_ASSOC);
							if (!empty($rss)){
					?>
							<tr>
					
							<td class="one"><?=$rss["item"] ?></td>
							<td class="righting">￥<?= number_format($rss["price"]) ?></td>
							<td class="centering"><?=$val?><?=$rss["unit"]?></td>
							<td class="righting">￥<?= number_format($rss["price"]*$val)?></td>

							</tr>
					<?php
								$SUM += cnum($rss["price"])*$val;
							}
						}
					}
					
					$zei = 0;
					
					?>
					
					</tbody>

<tfoot>
					
						<tr>
							<td colspan="3" class="one">合計金額</td>
								   <td class="righting">￥<?= number_format($SUM)?></td>
								
						</tr>
					</tfoot>
					</table>
	
	



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
<dd><?=$_POST["zip1"]?>-<?=$_POST["zip2"]?></dd>
</dl>

<dl>
	<dt>都道府県</dt>
<dd><?=$_POST["state"]?></dd>
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
	<dt>ご来店予定日&nbsp;<em>[必須]</em></dt>
<dd><?=$_POST["month"]?>月<?=$_POST["day"]?>日
				
</dd>
</dl>


<dl>
	<dt>ご質問・ご要望など</dt>
<dd><?=nl2br($_POST["comment"])?>
				
</dd>
</dl>


</div>

<?php
		if ($errch==0){
		?>
<div class="block">
<p>上記内容でよろしければ、送信ボタンを押してください。</p>
<p class="centering"><input type="submit" name="submit" value="送　信">&nbsp;&nbsp;<input type="button" value="戻　る" onClick="history.back()" onKeyPress="history.back()"></p>
</div>
<?php
		}else{
		?>
<div class="block">

<p class="centering"><input type="button" value="戻　る" onClick="history.back()" onKeyPress="history.back()"></p>
</div>
<?php
		}


		foreach($_POST as $key=>$val){
		?>
	<input type="hidden" name="<?=$key?>" value="<?=$val?>">
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
