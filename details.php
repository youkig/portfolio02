<?php $siteid = 33 ?>
<?php include("include/autometa.php"); ?>
<!DOCTYPE html>
<html lang="ja">
<?php include("config.php"); ?>

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
	if ($_SERVER["QUERY_STRING"] !== "") {
		$query = "?" . $_SERVER["QUERY_STRING"];
	}
	?>
	<link rel="canonical" href="<?= $esurl ?>details.php<%=query%>">
	<meta name="keywords" content="<?= $n_keyword ?>">

	<meta name="description" content="<?= $n_description ?>">





	<?php
	$message = "";
	$id = cnum($_GET["id"]);
	if ($_GET["test"] == "disp") {
		$sql = "SELECT * From t_master Where id=:id";
	} else {
		$sql = "SELECT * From t_master Where disp=1 AND id=:id";
	}
	$d = $dbh->prepare($sql);
	$d->bindValue(":id", $id, PDO::PARAM_INT);
	$d->execute();
	$rs = $d->fetch(PDO::FETCH_ASSOC);
	if (empty($rs)) {
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $esurl . "index.php");
		exit;
	} else {
		$yasainame = $rs["item"];
	}
	?>

	<title><?= $yasainame ?><?= $n_title ?></title>

	<link rel="stylesheet" href="css/base.css?<?= str_replace(":", "", date("H:i:s")); ?>" type="text/css">
	<?php include("include/js.php") ?>

	<link rel="stylesheet" href="js/flexslider.css" type="text/css">
	<script src="js/jquery.flexslider.js"></script>
	<script>
		jQuery(function($) {
			$('.flexslider').flexslider({
				animation: "slide",
				animationLoop: true,
				slideshow: true,
				end: function() {
					//end:オプションでは最後までスライドしたときに発生する処理を追加できる。
					//$('.flexslider').animate({"opacity": 0},2000);
				}
			});
		});
	</script>

<body>
	<?php
	if (!empty($n_h5)) {
	?>
		<h5 id="autochangepg"><?= $n_h5 ?></h5>
	<?php
	}
	?>


	<div id="box">

		<div id="header">
			<h1><?= $n_h1 ?></h1>



			<?php include("include/header.php") ?>


			<div id="main" class="container">
				<?php include("include/leftpane.php") ?>
				<div id="cnt" class="details">


					<p class="pankuzu"><a href="<?= $esurl ?>index.php">トップページ</a> | 商品詳細 | <?= $yasainame ?></p>
					<div class="block">
						<h2>商品詳細</h2>

						<p class="catch"><?= $yasainame ?></p>
						<p class="righting">生産者：<?php
												if (!empty($rs["farmer"])) {
													echo $rs["farmer"];
												} elseif ($rs["uid"] !== 0) {
													$sql = "SELECT * From t_cuser Where id=:uid";
													$c = $dbh->prepare($sql);
													$c->bindValue(":uid", $rs["uid"], PDO::PARAM_INT);
													$c->execute();
													$result = $c->fetch(PDO::FETCH_ASSOC);
													if (!empty($result)) {
														if (!empty($result["company"])) {
															echo $result["company"];
														} else {
															echo $result["name"];
														}
													}
												} else {
													echo "東浪見岡本農園";
												}

												?></p>
					</div>

					<div class="block container">
						<div class="leftbox">
							<div class="flexslider">
								<ul class="slides">
									<?php
									for ($a = 1; $a <= 4; $a++) {

										if (!empty($rs["image" . $a])) {
									?>
											<li><img src="<?= $photoimg ?>goods/<?= $rs["image" . $a] ?>" alt="<?= $rs["item"] ?>" width="420" style="height:auto;"></li>
										<?php
										} else {
										?>
											<li><img src="img/top/noimage.gif" alt="NO IMAGE" width="420" height="315"></li>
										<?php
										}
										?>

									<?php
									}
									?>
								</ul>
							</div>

						</div>

						<div class="rightbox">
							<?php
							if ($rs["pricedisp"]) {
								if ($rs["price"] !== 0) {
							?>
									<p class="price">販売価格 <span class="red"><?= number_format($rs["price"]) ?>円</span></p>
								<?php
								}
							}

							if ($rs["num"] > 0) {
								?>
								<form action="inkago" name="inkago" method="post">
									<p>販売数量：<select name="num" id="num">
											<?php
											for ($a = 1; $a <= $rs["num"]; $a++) {
											?>
												<option value="<?= $a ?>"><?= $a ?></option>
											<?php
											}
											?>
										</select>&nbsp;<?= $rs["unit"] ?></p>

									<p class="centering"><input type="submit" name="cart" value="カートに入れる"></p>
									<input type="hidden" name="id" value="<?= $id ?>">

								</form>
							<?php
							}


							if (!empty($rs["comment"])) {
							?>
								<div class="block2nd">
									<p>コメント：<br>
										<?= nl2br($rs["comment"]) ?></p>
								</div>
							<?php
							}
							?>
						</div>

					</div>




					<div class="block">
						<p class="centering"><a href="<?= $esurl ?>inquire01?sid=<?= $id ?>" class="btn"><span>&nbsp;→&nbsp;</span>&nbsp;お問合せ</a></p>
					</div>



					<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
					<!-- id cnt end -->
				</div>

				<?php include("include/rightpane.php") ?>

				<!-- id main end -->
			</div>

			<?php include("include/footer.php") ?>


			<!-- id box end -->
		</div>
</body>

</html>