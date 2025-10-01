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

	<link rel="canonical" href="<?= $esurl ?>faq_list.php">
	<meta name="keywords" content="野菜狩り,野菜収穫体験,レンタル農園,貸し農園,レンタル農機具,レンタルキッチン,レンタル厨房,完全有機栽培,野菜直売所,井戸掘り,耕運代行,ソーラー,太陽光,非常用電源,千葉県,長生郡,一宮町,東浪見,外房,九十九里,とらみスイート">

	<meta name="description" content="千葉県長生郡一宮町、サーフィンのメッカでも釣ヶ崎海岸にほど近いエリアで、完全有機栽培で野菜を作っている【太陽と野菜の直売所】（東浪見岡本農園）ホームページでは、観光農園として野菜狩り・農業体験サービスのほか、期間貸しのレンタル農園のご紹介や、農機・農機具レンタル、レンタル厨房のご案内をしております。停電時にいつも電気のある災害避難所としてもご利用になれます。">

	<title>農業のよくある質問集／野菜狩り 千葉県【太陽と野菜の直売所】レンタル農園 一宮町／野菜収穫体験 九十九里</title>

	<link rel="stylesheet" href="css/base.css?<?= str_replace(":", "", date("H:i:s")); ?>" type="text/css">
	<?php include("include/js.php") ?>

	<script>
		$(function() {
			$("a.gotolink").click(function() {
				var a1 = $(this).attr("href");
				var a2 = a1.split("#");
				var a3 = a2[1];
				var a = parseInt($('#' + a3).offset().top);
				$(this).blur();
				$('html,body').animate({
					scrollTop: a
				}, 'slow');
				return false;
			});

			// $("#searchBtn").click(function() {
			// 	var b = $("#keyword").val();
			// 	window.location.href = "faq_list.php?keyword=" + b + "#result";

			// });
		});
	</script>

</head>

<body>


	<div id="box">

		<div id="header">
			<h1>野菜狩り 千葉県／レンタル農園 一宮町／農機具レンタル 長生郡</h1>

			<?php include("include/header.php") ?>


			<div id="main" class="container">
				<?php include("include/leftpane.php") ?>

				<div id="cnt" class="productlist">

					<p class="pankuzu"><a href="<?= $esurl ?>">トップページ</a> | 農業のよくある質問集</p>
					<div class="block">
						<h2>農業のよくある質問集</h2>
					</div>

					<div class="block">
						<p>当ページでは、これまで【太陽と野菜の直売所】（東浪見岡本農園）に寄せられたご相談、ご質問の中から、社会的に周知されていない農業委員会の立ち位置や、農業コンサルタント事業から得られた知見を含めて、誰もが農業参入しやすくなるような疑問をQ＆Aのカタチでご紹介しています。</p>
					</div>

					<div class="block" id="result" style="margin-bottom: 3em;">
						<h3>絞込・検索</h3>
						<dl class="category">
							<dt>カテゴリ検索</dt>
							<dd>
								<ul>
									<?php
									$sql = "select * From t_faq_category order by print_order";
									$b2 = $dbh->prepare($sql);
									$b2->execute();
									$rsb2 = $b2->fetchAll(PDO::FETCH_ASSOC);
									if (!empty($rsb2)) {
										foreach ($rsb2 as $row) {


									?>
											<li><a href="faq_list#<?= $row["id"] ?>" class="gotolink"><?= $row["name"] ?></a></li>
									<?php

										}
									}
									?>
								</ul>
							</dd>
						</dl>
						<form method="post" action="faq_list.php#result">
							<dl class="search">
								<dt>キーワード検索</dt>
								<dd><input type="text" name="keyword" id="keyword" value="<?= $_POST["keyword"] ?>" /> <button type="submit" id="searchBtn">検索</button>&nbsp;&nbsp;<a href="faq_list" class="underline">全件表示</a></dd>
							</dl>
						</form>
					</div>

					<?php


					$sql = "select t_faq_category.name,t_faq.* From t_faq_category inner join t_faq on t_faq_category.id = t_faq.bunrui1id ";
					$sql .= " Where t_faq.id>0";


					if (!empty($_POST["keyword"])) {
						$sql .= " and (t_faq_category.name like :keyword";
						$sql .= " or t_faq.q like :keyword";
						$sql .= " or t_faq.a like :keyword)";
					}
					$sql .= " order by t_faq_category.print_order, t_faq.print_order";
					$p = $dbh->prepare($sql);

					if (!empty($_POST['keyword'])) {

						$kensaku = '%' . trim($_POST['keyword']) . '%';

						$p->bindValue(':keyword', $kensaku, PDO::PARAM_STR);
					}

					$p->execute();

					$result = $p->fetchAll(PDO::FETCH_ASSOC);

					$sql = "select count(t_faq.id) as co From t_faq inner join t_faq_category on t_faq.bunrui1id = t_faq_category.id";
					$sql .= " Where t_faq.id>0";



					if (!empty($_POST["keyword"])) {
						$sql .= " and (t_faq_category.name like :keyword";
						$sql .= " or t_faq.q like :keyword";
						$sql .= " or t_faq.a like :keyword)";
					}

					$c = $dbh->prepare($sql);

					if (!empty($_POST['keyword'])) {

						$kensaku = '%' . trim($_POST['keyword']) . '%';

						$c->bindValue(':keyword', $kensaku, PDO::PARAM_STR);
					}

					$c->execute();

					$count = $c->fetch(PDO::FETCH_ASSOC);

					$count = $count["co"];

					?>

					<div class="block">
						<?php
						if ($count == 0) {
						?>
							<p>該当するQ&Aacute;が見つかりませんでした。</p>
						<?php
						} else {
						?>


							<?php
							$c = 0;
							if (!empty($result)) {
								foreach ($result as $key => $row) {
									if ($result[$key]["bunrui1id"] !== $c) {
										$c = $result[$key]["bunrui1id"];
							?>

										<div class="block faqcategory" id="<?= $result[$key]["bunrui1id"] ?>">
											<h4 id="<?= $result[$key]["bunrui1id"] ?>"><?= $result[$key]["name"] ?></h4>
											<ul>
											<?php
										}
											?>
											<li><a href="faq_detail?id=<?= $result[$key]["id"] ?>">Q. <?= nl2br(htmlspecialchars($result[$key]["q"], ENT_QUOTES, "UTF-8")) ?></a></li>
											<?php
											if ($key === array_key_last($result)) {
												echo "</ul>";
												echo "</div>";
											} else {
												if ($result[$key + 1]["bunrui1id"] !== $c) {
													echo "</ul>";
													echo "</div>";
												}
											}
											?>

								<?php
								}
							}
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