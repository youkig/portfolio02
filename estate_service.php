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

	<title>別荘地のお庭・空き地の年間不動産管理サービス／野菜狩り 千葉県【太陽と野菜の直売所】レンタル農園 一宮町／野菜収穫体験 九十九里</title>

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

					<p class="pankuzu"><a href="<?= $esurl ?>">トップページ</a> | 別荘地のお庭・空き地の年間不動産管理サービス</p>
					<div class="block">
						<h2><img src="img/estate/h2.jpg" alt="別荘地のお庭・空き地の年間不動産管理サービス" width="780" height="205"></h2>

					</div>

					<div class="block">

						<p>【太陽と野菜の直売所】（東浪見岡本農園）では、近年多く新築された戸建別荘や、農地を含む空き地などの１年を通した不動産管理サービスを提供しています。</p>

						<p>お庭の草刈りはもちろんのこと、別荘やホテルのカギをお預かりして、突発的な宿泊予約が入った際に、農園担当者が現地に急行して、お預かりしていたサブキーをお渡しすることもできます。</p>

						<p>対応可能エリアは、以下のとおりです。（片道20㎞圏内）</p>
						<div class="container">
							<div class="leftbox">
								<ul class="estatearea">
									<li>一宮町全域</li>
									<li>睦沢町全域</li>
									<li>いすみ市（一部遠方地域はご相談）</li>
									<li>長生村</li>
									<li>白子町</li>
									<li>茂原市</li>
									<li>長南町</li>
									<li>長柄町</li>
								</ul>

							</div>

							<div class="rightbox w50">
								<p><img src="img/estate/img01.gif" alt="対応エリアのイメージ写真です"></p>
							</div>

						</div>

					</div>

					<div class="block">
						<h3>年間不動産管理サービスでお受けできること</h3>

						<ul class="estateservice">
							<li>お庭の芝生管理、雑草除去管理（除草剤散布を含む）</li>
							<li>樹木の管理、剪定作業　※</li>
							<li>カギの管理、顧客への受け渡し</li>
							<li>各種工事の立ち合い、屋内立ち入りの同伴</li>
							<li>買い物代行　※</li>
							<li>屋内清掃、外壁清掃　※</li>
							<li>粗大ごみの廃棄代行　※　清掃センター持ち込み</li>
							<li>セキュリティカメラの設定、設置　※</li>
						</ul>

						<p>※印のあるサービスは、その都度のオプションとなります。</p>

					</div>

					<div class="block">
						<p>基本的に「年間契約」（1年更新）となりますが、敷地の規模や管理する芝生の面積によって契約金額は変わってきますので、ご要望内容に応じたお見積りを差し上げます。</p>

						<p>ぜひ一度、現地確認と合わせて見積書面をご要望ください。</p>
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