<?php $siteid=31?>
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

<?php

$tyumon=0;
foreach($_COOKIE as $key=>$val){
	if(strpos($key,"okamotofarm")!==false){
		$tyumon = 1;
	}
}

?>



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
	<div id="cnt" class="cart">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | カート</p>
	<div class="block">
	<h2>カート</h2>

</div>



<div class="block">
<?php
			if ($tyumon == 1){
			if (empty($_POST["tyumon"])){
			?>
			<form action="<?=$esurl?>update" method="post">
				<p>カートの中身をご確認ください。</p>
				
				
					
					<!--スタート買い物明細-->
					
						<table summary="購入商品">
									<thead>
										<tr>
											<th>商品名</th>
											<th>商品単価</th>
											<th>数量</th>
											<th>金額</th>
											<th>削除</th>
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
					
							<td class="one"><a href="<?=$esurl?>details?id=<?=$rss["id"]?>" target="_self" class="underline"><?=$rss["item"] ?></a></td>
							<td class="righting">￥<?= number_format($rss["price"]) ?></td>
							<td class="centering">
							<select name="num<?=$cnt?>">
							<?php
							for ($a=1;$a<=$rss["num"];$a++){
							?>
							<option value="<?=$a?>"<?=selected(cnum($val),$a)?>><?=$a?></option>
							<?php
							}
							?>
							</select><?=$rss["unit"]?>
							</td>
							<td class="righting">￥<?= number_format($rss["price"]*$val)?></td>
							<td class="centering"><input type="checkbox" name="del<?=$cnt ?>" value="1">
							<input type="hidden" name="code<?=$cnt ?>" value="<?=str_replace("okamotofarm_","",$key)?>"></td>
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
								   <td></td>
						</tr>
					</tfoot>
					</table>
					<input type="hidden" name="cnt" value="<?=$cnt ?>">
					
					
					
					<!--エンド買い物明細-->
				
				<p class="centering fz80"><input type="submit" name="kousin" value="カートを更新">&nbsp;&nbsp;&nbsp;
				<?
				
				if (str_contains($_SERVER["HTTP_REFERER"],"cart")==0){
					$his="history.back()";
				}else{
					$his="history.go(-2)";
				}
				?><input type="button" value="購入を続ける" onClick="<?=$his?>" onKeyPress="<?=$his?>"></p>
			
				
		   </form>

		   <form action="reserved01" method="post">
				<p class="centering"><input type="submit" id="order" value="購入手続きへ"></p>

		   </form>
			   <?
			}
			
			}else{
			echo '<p class="centering">カートの中には何も入っていません。</p>';
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
