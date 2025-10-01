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

	<meta name="keywords" content="野菜狩り,野菜収穫体験,レンタル農園,貸し農園,レンタル農機具,レンタルキッチン,レンタル厨房,完全有機栽培,野菜直売所,井戸掘り,耕運代行,ソーラー,太陽光,非常用電源,千葉県,長生郡,一宮町,東浪見,外房,九十九里,とらみスイート">

	<meta name="description" content="千葉県長生郡一宮町、サーフィンのメッカでも釣ヶ崎海岸にほど近いエリアで、完全有機栽培で野菜を作っている【太陽と野菜の直売所】（東浪見岡本農園）ホームページでは、観光農園として野菜狩り・農業体験サービスのほか、期間貸しのレンタル農園のご紹介や、農機・農機具レンタル、レンタル厨房のご案内をしております。停電時にいつも電気のある災害避難所としてもご利用になれます。">

	<title>観光農園敷地内で飲食店を始めてみませんか？／野菜狩り 千葉県【太陽と野菜の直売所】レンタル農園 一宮町／野菜収穫体験 九十九里</title>

	<link rel="stylesheet" href="css/base.css?<?= str_replace(":", "", date("H:i:s")); ?>" type="text/css">
	<?php include("include/js.php") ?>


<body>

	<div id="box">

		<div id="header">
			<h1>野菜狩り 千葉県／レンタル農園 一宮町／農機具レンタル 長生郡</h1>


			<?php include("include/header.php") ?>

			<div id="main" class="container">
				<?php include("include/leftpane.php") ?>
				<div id="cnt" class="cooking mrecruit">

					<p class="pankuzu"><a href="<?= $esurl ?>">トップページ</a> | 観光農園敷地内で飲食店を始めてみませんか？</p>
					<div class="block">
						<h2><img src="img/restaurant/h2.jpg" alt="観光農園敷地内で飲食店を始めてみませんか？" width="780" height="205"></h2>

					</div>

					<div class="block">

						<p>【太陽と野菜の直売所】（東浪見岡本農園）では、農園敷地内に食品加工場を所有しておりますが、竣工後すぐにコロナ禍が始まってしまい、現在は使っていない状況が続いています。</p>
						<div class="container">
							<div class="leftbox">


								<p>農園で栽培したおコメ、野菜類を使っていただいても良し、提供いただく素材の仕入には農園側で関与することはありません。</p>

								<p>農園レストランとして、農園敷地内でパラソル付きのテーブル等を用意していただいても構いませんし、ぶどう棚の下でバーベキューコンロを設置できるように、食品加工場からは屋外に「ガス栓」も設けてあります。</p>
							</div>

							<div class="rightbox">
								<p><img src="img/restaurant/img01.jpg" alt="農園敷地内で食事しているイメージ写真です" width="297" height="208"></p>
							</div>

						</div>

						<p>ほかのページでもご案内しているとおり、当農園では自家発電で得た電気、飲料可能な井戸水、プロパンガスボンベを使用していますので、そんな有事の際は災害避難所としての役割を持ちますが、電気代と水道料金は無料ということになります。</p>

						<p class="green bold">賃料は、ご相談に応じます。</p>

						<p>食品加工場は、いつでも見学できますので、以下問合せフォームまたは農園管理人まで直接ご連絡ください。</p>
					</div>



					<div class="block">


						<p>メール：<a href="mailto:torami@okamoto-farm.co.jp" class="underline">torami@okamoto-farm.co.jp</a></p>
						<p>電話：<?= $mobile ?>（農園管理人：岡本直通）</p>

					</div>


					<?php include("include/inquireBtn.php") ?>


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