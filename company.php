<?php $siteid = 27 ?>
<?php include("include/autometa.php"); ?>
<!DOCTYPE html>
<html lang="ja">
<?php include("config.php"); ?>


<head>

	<meta name="robots" content="all">
	<meta property="og:title" content="太陽と野菜の直売所【東浪見岡本農園】">
	<meta property="og:type" content="website">
	<meta property="og:url" content="index">
	<meta property="og:locale" content="jp_JP">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">

	<meta name="keywords" content="<?= $n_keyword ?>">

	<meta name="description" content="<?= $n_description ?>">

	<title><?= $n_title ?></title>

	<link rel="stylesheet" href="css/base.css" type="text/css">
	<?php include("include/js.php") ?>

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

				<div id="cnt" class="company">

					<p class="pankuzu"><a href="<?= $esurl ?>index">トップページ</a> | 会社概要</p>
					<div class="block">
						<h2>会社概要</h2>

						<p>【太陽と野菜の直売所】東浪見岡本農園の会社概要です。</p>

					</div>
					<p class="banner"><img src="img/common/qrcode.jpg" alt="東浪見岡本農園 公式LINE"></p>
					<div class="block">
						<dl>
							<dt>会社名</dt>
							<dd>東浪見岡本農園</dd>
						</dl>

						<dl>
							<dt>代表者氏名</dt>
							<dd>岡本 洋</dd>
						</dl>

						<dl>
							<dt>代表者似顔絵</dt>
							<dd><img src="img/top/portrait.jpg" alt="岡本 洋の似顔絵" style="width:50%;"></dd>
						</dl>
						<dl>
							<dt>会社住所</dt>
							<dd>〒299-4303　千葉県長生郡一宮町東浪見4721番</dd>
						</dl>

						<dl>
							<dt>電話番号</dt>
							<dd>管理人直通携帯電話：<?= $mobile ?> またはメールにてご連絡ください。</dd>
						</dl>

						<dl>
							<dt>メールアドレス</dt>
							<dd>torami@okamoto-farm.co.jp</dd>
						</dl>

						<dl>
							<dt>古物商許可番号</dt>
							<dd>第441210001842号 千葉県公安委員会 許可</dd>
						</dl>
					</div>

					<div class="block centering map">
						<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3254.010801258324!2d140.37589266546595!3d35.35537825538069!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1z5p2x5rWq6KaL5bKh5pys6L6y5ZyS!5e0!3m2!1sja!2sjp!4v1545717351064" width="600" height="450" class="googlemapbox"></iframe>
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