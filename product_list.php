<?php $siteid = 68 ?>
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
	if (cnum($_GET["b2id"]) !== 0) {
		$conurl = "?b2id=" . $_GET["b2id"];
	} else {
		$conurl = "";
	}

	?>
	<link rel="canonical" href="<?= $esurl ?>product_list.php<?= $conurl ?>">
	<meta name="keywords" content="<?= $n_keyword ?>">

	<meta name="description" content="<?= $n_description ?>">

	<title><?= $n_title ?></title>

	<link rel="stylesheet" href="css/base.css?<?= str_replace(":", "", date("H:i:s")); ?>" type="text/css">
	<?php include("include/js.php") ?>

	<script>
		$(function() {
			// $("#b2name").change(function() {
			// 	var a = $("#b2name").val();
			// 	var b = $("#keyword").val();
			// 	if (b.length == 0) {
			// 		window.location.href = "product_list.php?b2id=" + a + "#result";
			// 	} else {
			// 		window.location.href = "product_list.php?b2id=" + a + "&keyword=" + b + "#result";
			// 	}
			// });

			$("#searchBtn").click(function() {
				var b = $("#keyword").val();
				//var a = $("#b2name").val();
				// if (a.length === 0) {
				window.location.href = "product_list.php?keyword=" + b + "#result";
				// } else {
				// 	window.location.href = "product_list.php?keyword=" + b + "&b2id=" + a + "#result";
				// }
			});
		});
	</script>

</head>

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

				<div id="cnt" class="productlist">

					<p class="pankuzu"><a href="<?= $esurl ?>">トップページ</a> | 農機・農機具・耕運機レンタル重機　一覧</p>
					<div class="block">
						<h2>農機・農機具・耕運機レンタル重機　一覧</h2>
					</div>

					<div class="block">
						<p>【東浪見岡本農園】農機・農機具・耕運機レンタル重機一覧です。</p>
					</div>

					<div class="block" id="result">
						<h3>絞込・検索</h3>
						<dl class="search">
							<dt>カテゴリ検索</dt>
							<dd>
								<ul>
									<?php
									$sql = "select * From t_bunrui2 order by print_order";
									$b2 = $dbh->prepare($sql);
									$b2->execute();
									$rsb2 = $b2->fetchAll(PDO::FETCH_ASSOC);
									if (!empty($rsb2)) {
										foreach ($rsb2 as $row) {

											if (cnum($_GET["b2id"]) == $row["id"]) {
												$classname = " style='font-weight:600;color:red;'";
											} else {
												$classname = "";
											}
									?>
											<li><a href="product_list?b2id=<?= $row["id"] ?>#result" <?= $classname ?> class="underline"><?= $row["b2name"] ?></a></li>
									<?php

										}
									}
									?>
								</ul>
							</dd>
						</dl>

						<dl class="search">
							<dt>キーワード検索</dt>
							<dd><input type="text" name="keyword" id="keyword" value="<?= $_GET["keyword"] ?>" /> <button id="searchBtn">検索</button></dd>
						</dl>
					</div>

					<?php
					$webmax = 10;
					$max = 10;
					$pos = 0;
					$pos2 = 10;
					if (!empty($_GET['point'])) {
						$pos += $_GET['point'];
						$pos2 += $_GET['point'];
					}

					if (!empty($_GET["c"])) {
						$c = $_GET["c"];
					} else {
						$c = 0;
					}

					$sql = "select t_product.*, t_bunrui2.b2name From t_product inner join t_bunrui2 on t_product.bunrui2 = t_bunrui2.id ";
					$sql .= " Where t_product.id>0 and t_product.disp=1";

					if (cnum($_GET["b2id"]) !== 0) {
						$sql .= " and t_product.bunrui2=:b2id";
					}

					if (!empty($_GET["keyword"])) {
						$sql .= " and (t_bunrui2.b2name like :keyword";
						$sql .= " or t_product.sname like :keyword";
						$sql .= " or t_product.modelnumber like :keyword";
						$sql .= " or t_product.energy like :keyword";
						$sql .= " or t_product.energy2 like :keyword";
						$sql .= " or t_product.comment like :keyword";
						$sql .= " or t_product.memo like :keyword";
						$sql .= " or t_product.freeword2 like :keyword)";
					}
					$sql .= " Order by t_bunrui2.print_order,t_product.print_order LIMIT :pos,:pos2";

					$p = $dbh->prepare($sql);
					if (cnum($_GET["b2id"]) !== 0) {
						$p->bindValue(":b2id", $_GET["b2id"], PDO::PARAM_INT);
					}
					if (!empty($_POST['keyword']) || !empty($_GET['keyword'])) {
						if (!empty($_POST['keyword'])) {
							$kensaku = '%' . trim($_POST['keyword']) . '%';
						} elseif (!empty($_GET['keyword'])) {
							$kensaku = '%' . trim($_GET['keyword']) . '%';
						}
						$p->bindValue(':keyword', $kensaku, PDO::PARAM_STR);
					}

					$p->bindValue(':pos', $pos, PDO::PARAM_INT);
					$p->bindValue(':pos2', $pos2, PDO::PARAM_INT);
					$p->execute();

					$result = $p->fetchAll(PDO::FETCH_ASSOC);

					$sql = "select count(t_product.id) as co From t_product inner join t_bunrui2 on t_product.bunrui2 = t_bunrui2.id";
					$sql .= " Where t_product.id>0 and t_product.disp=1";

					if (cnum($_GET["b2id"]) !== 0) {
						$sql .= " and t_product.bunrui2=:b2id";
					}

					if (!empty($_GET["keyword"])) {
						$sql .= " and (t_bunrui2.b2name like :keyword";
						$sql .= " or t_product.sname like :keyword";
						$sql .= " or t_product.modelnumber like :keyword";
						$sql .= " or t_product.energy like :keyword";
						$sql .= " or t_product.energy2 like :keyword";
						$sql .= " or t_product.comment like :keyword";
						$sql .= " or t_product.memo like :keyword";
						$sql .= " or t_product.freeword2 like :keyword)";
					}

					$c = $dbh->prepare($sql);
					if (cnum($_GET["b2id"]) !== 0) {
						$c->bindValue(":b2id", $_GET["b2id"], PDO::PARAM_INT);
					}
					if (!empty($_POST['keyword']) || !empty($_GET['keyword'])) {
						if (!empty($_POST['keyword'])) {
							$kensaku = '%' . trim($_POST['keyword']) . '%';
						} elseif (!empty($_GET['keyword'])) {
							$kensaku = '%' . trim($_GET['keyword']) . '%';
						}
						$c->bindValue(':keyword', $kensaku, PDO::PARAM_STR);
					}

					$c->execute();

					$count = $c->fetch(PDO::FETCH_ASSOC);

					$count = $count["co"];

					// foreach($_GET as $name=>$val){
					// 	if($name!=="point"){
					// 		if(!empty($joken)){$joken .= "&amp;";}
					// 		$joken .= $name ."=" .$val;
					// 	}
					// }
					?>

					<div class="block">
						<?php
						if ($count == 0) {
						?>
							<p>該当するレンタル重機が見つかりませんでした。</p>
						<?php
						} else {
						?>
							<p><?= $count ?>件のレンタル重機が見つかりました。</p>

							<?php
							writeNavi("product_list", $webmax, $pos, $count, $joken);
							if (!empty($result)) {
								foreach ($result as $row) {
							?>

									<div class="item">
										<h4><?= $row["b2name"] ?> ｜ <?= $row["sname"] ?> ｜ <?= $row["modelnumber"] ?></h4>
										<dl class="product">
											<dt><a href="<?= $esurl ?>pdetails?id=<?= $row["id"] ?>">
													<?php
													if (!empty($row["image1"])) {
														$imagename = $esurl . "control/photo/product/" . $row["image1"];
													} else {
														$imagename = $esurl . "img/pdetails/noimage.png";
													}
													?>
													<img src="<?= $imagename ?>" width="240" style="height:auto;">
												</a></dt>
											<dd>
												<h5 class="ptxt">レンタル料金</h5>
												<?php
												if ($row["consultation"] == 0) {
												?>
													<p class="price"><span class="oneday">1日　　：</span><?= number_format($row["price1"]) ?>円<br>
														<span class="twoday">2日以上：</span><?= number_format($row["price2"]) ?>円
													</p>
												<?php
												} else {
												?>
													<p class="price">要相談</p>
												<?php
												}
												?>
												<p class="txt">燃料の種類:<?php (!empty($row["energy"])) ? $row["energy"] : $row["energy2"] ?></p>
												<a href="<?= $esurl ?>pdetails?id=<?= $row["id"] ?>" class="detail"> 詳 細 </a>
											</dd>
										</dl>

									</div>
							<?php
								}
							}
							writeNavi("product_list", $webmax, $pos, $count, $joken);
							?>
						<?php
						}
						?>
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