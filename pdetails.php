<?php $siteid=67?>
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
<?php
$query = "";
if (!empty($_SERVER['QUERY_STRING'])){
$query = "?" .$_SERVER['QUERY_STRING'];
}
?>
<link rel="canonical" href="<?=$esurl?>pdetails.php<?=$query?>">
<meta name="keywords" content="<?=$n_keyword?>">

<meta name="description" content="<?=$n_description?>">



<?php
if ($_GET["test"]=="disp"){
$sql="SELECT t_product.*,t_bunrui2.b2name From t_product inner join t_bunrui2 on t_product.bunrui2 = t_bunrui2.id Where t_product.id=:id";
}else{
$sql="SELECT t_product.*,t_bunrui2.b2name From t_product inner join t_bunrui2 on t_product.bunrui2 = t_bunrui2.id Where t_product.disp=1 AND t_product.id=:id";
}
$p = $dbh->prepare($sql);
$p->bindValue(":id",$_GET["id"],PDO::PARAM_INT);
$p -> execute();
$rs = $p->fetch(PDO::FETCH_ASSOC);
if(empty($rs)){
	$error = "<p>農機・農機具が見つかりません。</p>";
}else{
$b2name = $rs["b2name"];
$sname= $rs["sname"];
$modelnumber= $rs["modelnumber"];
}
?>

<title><?=$b2name . "／" . $sname . "／" . $modelnumber?><?=$n_title?></title>

<link rel="stylesheet" href="css/base.css?<?=str_replace(":", "", date("H:i:s")); ?>" type="text/css">
<?php include("include/js.php")?>

<script>
	$(function(){
		$(".rbtn").click(function(){
			var c = $(this).text();
			//var d = $("input[name='proname" + c + "']").val();
			var d = $(this).children("input").val();
			console.log(d);
			var e = $(this).attr("class");
			if(e.indexOf('active') == -1){
			$(this).addClass("active");
			$("#redate").append("<input type='hidden' name='redate' id='" + d.replace(/-/g,"") + "' class='redate' value='" + d +"' />");
			}else{
			var f = d.replace(/-/g,"") ;
			$(this).removeClass("active");
			$("#"+f).remove();
			}
		});

		$(".cartBtn").click(function(e){

			var a = $(".redate").val();
			
			if(typeof a === "undefined"){
				alert("日付が選択されておりません！");
				return false;
			}
		});
	});

</script>


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
	<div id="cnt" class="pdetails">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 農機・農機具・耕運機レンタル重機詳細 | <?=$b2name . "｜" . $sname . "｜" . $modelnumber?></p>
	<div class="block">
	<h2>農機・農機具・耕運機レンタル重機詳細</h2>


<p class="righting"><a href="product_list" class="underline">一覧へ戻る</a></a>
</div>

<div class="block container">
	<div class="leftbox">
					

					<div>
					<?php
					if (!empty($rs["image1"])):
					?>
						<p><img src="control/photo/product/<?=$rs["image1"]?>" alt="<?=$rs["modelnumber"]?>" width="420"></p>
					<?php
					else:
					?>
						<p><img src="img/pdetails/noimage.png" alt="NO IMAGE" width="420" height="315"></p>
					<?php
					endif;
					?>
					</div>

	</div>

	<div class="rightbox">
					<dl>
						<dt>機種</dt>
						<dd><?=$b2name?></dd>
					</dl>	
<?php
if (!empty($rs["sname"])){
?>
					<dl>
						<dt>メーカー名</dt>
						<dd><?=$rs["sname"]?></dd>
					</dl>
<?php
}
if (!empty($rs["modelnumber"])){
?>
					<dl>
						<dt>型番</dt>
						<dd><?=$rs["modelnumber"]?></dd>
					</dl>
					<?php
}					
					if (!empty($rs["freeword"]) && $rs["freeword2"]){
					?>
					<dl>
						<dt><?=$rs["freeword"]?></dt>
						<dd><?=$rs["freeword2"]?></dd>
					</dl>
					<?php
					}
					?>
					<dl>
						<dt>燃料の種類</dt>
						<dd><?php
						if (!empty($rs["energy"])){
						echo $rs["energy"];
						}elseif (!empty($rs["energy2"])){
						echo $rs["energy2"];
						}
						?></dd>
					</dl>	
					<div class="pricebox">
						<h4>レンタル料金</h4>
							<?php
							if ($rs["consultation"]==0){
							?>
							<dl class="price">
								<dt>1日</dt>
								<dd><span class="red price"><?=number_format($rs["price1"])?>円</span></dd>
							</dl>
							<dl class="price">	
								<dt>2日以上</dt>
								<dd><span class="red price"><?=number_format($rs["price2"])?>円/日</span></dd>
							</dl>
							<?php
							}else{
							?>
							<p class="red bold fz140">要相談</p>
							<?php
							}
							?>

							<p>清掃料金（1回）<?=number_format($rs["cleaning"])?>円</p>
						
					</div>	
			
	</div>

</div>

			<div class="block commnet">

				<?php
				if ($rs["comment"]<>""):
				?>
					<dl>
						<dt>機器説明文</dt>
						<dd><?=nl2br($rs["comment"])?></dd>
					</dl>
				<?php
				endif;
				?>
			</div>


			<div class="block commnet">

				<?php
				if ($rs["memo"]<>""):
				?>
					
					<dl>
						<dt>備考</dt>
						<dd><?=nl2br($rs["memo"])?></dd>
					</dl>
					
				<?php
				endif;
				?>
			</div>

			<div class="wrapper container">
				<div class="button">
						<a href="<?=$esurl?>inquire01?product=1">
						<div class="icon"><i class="fa-sharp fa-solid fa-envelope"></i></div>
						<span>お問合せフォーム</span>
						</a>
				</div>
			</div>


<p class="righting"><a href="product_list.php" class="underline">一覧へ戻る</a></a>
<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
