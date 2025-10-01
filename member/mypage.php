<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<?php include("../config.php"); ?>

<?php
$logid = $_COOKIE["logid"];
$pass = $_COOKIE["pass"];

if (userloginch($logid, $pass) === false) {
	header("location:{$esurl}member/login");
	exit;
}
?>

<head>

	<meta name="robots" content="all">
	<meta property="og:title" content="太陽と野菜の直売所【東浪見岡本農園】">
	<meta property="og:type" content="website">
	<meta property="og:url" content="index.php">
	<meta property="og:locale" content="jp_JP">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link rel="canonical" href="https://www.okamoto-farm.co.jp/index.php">
	<meta name="keywords" content="有機栽培,無農薬野菜,野菜狩り,収穫体験,レンタル農園,貸し農園,観光農園,農業土木,農機具レンタル,耕運代行,農産物直売所,レンタル厨房,トラクター,耕運機,ユンボ,ソーラー蓄電システム,避難場所,停電,非常用電源,とらみスイート,千葉県,長生郡,一宮町,外房,九十九里">

	<meta name="description" content="千葉県外房エリア、九十九里海岸の南端、長生郡一宮町ある、近隣唯一の完全有機栽培農家【太陽と野菜の直売所】（東浪見岡本農園）ホームページでは、観光農園として野菜狩り・農業体験サービスのほか、期間貸しのレンタル農園のご紹介や、農機・農機具レンタル、レンタル厨房のご案内をしております。停電時にいつも電気のある災害避難所としてもご利用になれます。">

	<title>会員マイページ／農産物直売所 千葉【太陽と野菜の直売所】貸し農園 一宮町／野菜狩り／農業体験</title>

	<link rel="stylesheet" href="../css/base.css" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

	<script src="../js/jquery-1.5.2.min.js"></script>
	<script src="../js/jquery-ui.js"></script>
	<link rel="stylesheet" href="../js/jquery.ui.css" />

	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
	<script src="../js/jquery.bgswitcher.js"></script>
	<script src="../js/pagetop.js"></script>

	<script src="../js/topslide.js"></script>
</head>

<body>

	<div id="box">

		<div id="header">
			<h1>新鮮野菜 直売所／千葉 一宮町</h1>


			<?php include("../include/header.php") ?>


			<div id="main" class="container">
				<?php include("../include/leftpane.php") ?>
				<div id="cnt" class="mypage">

					<p class="pankuzu"><a href="<?= $esurl ?>">トップページ</a> | 会員マイページ</p>
					<div class="block">
						<h2>会員マイページ</h2>

						<p>【太陽と野菜の直売所】会員様専用のマイページです。</p>

					</div>



					<div class="block">
						<h3>会員情報編集</h3>
						<ul>
							<li><a href="<?= $esurl ?>member/change01">登録情報編集</a></li>
							<li><a href="<?= $esurl ?>member/refusal">退会手続き</a></li>
						</ul>

					</div>

					<div class="block">
						<h3>ログアウト</h3>
						<ul>
							<li><a href="<?= $esurl ?>member/logout">マイページログアウト</a></li>

						</ul>

					</div>

					<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
					<!-- id cnt end -->
				</div>

				<?php include("../include/rightpane.php") ?>

				<!-- id main end -->
			</div>

			<?php include("../include/footer.php") ?>


			<!-- id box end -->
		</div>
</body>

</html>