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

	<link rel="canonical" href="<?= $esurl ?>pdetails.php<?= $query ?>">
	<meta name="keywords" content="野菜狩り,野菜収穫体験,レンタル農園,貸し農園,レンタル農機具,レンタルキッチン,レンタル厨房,完全有機栽培,野菜直売所,井戸掘り,耕運代行,ソーラー,太陽光,非常用電源,千葉県,長生郡,一宮町,東浪見,外房,九十九里,とらみスイート">

	<meta name="description" content="千葉県長生郡一宮町、サーフィンのメッカでも釣ヶ崎海岸にほど近いエリアで、完全有機栽培で野菜を作っている【太陽と野菜の直売所】（東浪見岡本農園）ホームページでは、観光農園として野菜狩り・農業体験サービスのほか、期間貸しのレンタル農園のご紹介や、農機・農機具レンタル、レンタル厨房のご案内をしております。停電時にいつも電気のある災害避難所としてもご利用になれます。">

	<?php

	$sql = "SELECT * From t_faq  Where id=:id";

	$p = $dbh->prepare($sql);
	$p->bindValue(":id", $_GET["id"], PDO::PARAM_INT);
	$p->execute();
	$rs = $p->fetch(PDO::FETCH_ASSOC);
	if (empty($rs)) {
		$error = "<p>Q&Aが見つかりません。</p>";
	} else {
		$question = nl2br(htmlspecialchars($rs["q"], ENT_QUOTES, "UTF-8"));
		$answer = nl2br(htmlspecialchars($rs["a"], ENT_QUOTES, "UTF-8"));
	}
	?>
	<title>農業のよくある質問集／野菜狩り 千葉県【太陽と野菜の直売所】レンタル農園 一宮町／野菜収穫体験 九十九里</title>


	<link rel="stylesheet" href="css/base.css?<?= str_replace(":", "", date("H:i:s")); ?>" type="text/css">
	<?php include("include/js.php") ?>




<body>



	<div id="box">

		<div id="header">
			<h1>野菜狩り 千葉県／レンタル農園 一宮町／農機具レンタル 長生郡</h1>


			<?php include("include/header.php") ?>


			<div id="main" class="container">
				<?php include("include/leftpane.php") ?>
				<div id="cnt" class="pdetails faqdetails">

					<p class="pankuzu"><a href="<?= $esurl ?>">トップページ</a> | 農業のよくある質問集</p>
					<div class="block">
						<h2>農業のよくある質問集</h2>


						<p class="righting"><a href="faq_list" class="underline">一覧へ戻る</a></a>
					</div>

					<div class="block">

						<?php
						if (!empty($error)) {
							echo $error;
						} else {
						?>
							<h3>（ご相談内容）<br><?= $question ?></h3>
							<div class="answer">
								<p><span class="bold">（農園からの回答）</span><br><?= $answer ?></p>
							</div>
						<?php
						}
						?>


					</div>



					<p class="righting"><a href="faq_list.php" class="underline">一覧へ戻る</a></p>
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