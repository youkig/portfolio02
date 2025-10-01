<?php $siteid = 46 ?>
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
	<link rel="canonical" href="<?= $esurl ?>">

	<meta name="keywords" content="<?= $n_keyword ?>">

	<meta name="description" content="<?= $n_description ?>">

	<title><?= $n_title ?></title>

	<link rel="stylesheet" href="css/base.css?<?= date('YmdHis') ?>" type="text/css">

	<?php include("include/js.php") ?>

	<script>
		$(function() {
			$('#container').freetile({
				selector: '.item'
			});
		});

		document.addEventListener("mouseover", function(event) {
			var id = event.target.id;
			if (id) {
				id = id.replace("disp", "");
				document.getElementById("edisp" + id).classList.add("active");
			}
		}, false);

		document.addEventListener("mouseout", function(event) {
			var id = event.target.id;
			if (id) {
				id = id.replace("disp", "");
				document.getElementById("edisp" + id).classList.remove("active");
			}
		}, false);
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
				<div id="cnt" class="top">

					<div class="block">
						<p class="banner"><a href="<?= $esurl ?>rental_newfarmer"><img src="img/top/banner07.jpg" alt="新規就農者個人事業向け　レンタル農園・貸し農園"></a></p>
						<p class="banner"><a href="<?= $esurl ?>yoyakuform01"><img src="img/top/banner20240701.gif" alt="野菜狩り・野菜収穫体験サービスを始めました！"></a></p>
						<p class="banner"><a href="<?= $esurl ?>cooking_idea"><img src="img/top/banner_cooking.jpg" alt="料理大好きな方「名案」を大募集しています！"></a></p>
						<p class="banner"><a href="<?= $esurl ?>ensure_service"><img src="img/top/banner01.gif" alt="野菜栽培のための農地利用権利の確保サービスのご案内"></a></p>
						<?php
						if (1 == 2):
						?>
							<p class="banner"><a href="<?= $esurl ?>well_digging"><img src="img/ido/h2.jpg" alt="井戸掘り（上総掘り）の業務委託を開始しました！"></a></p>
						<?
						endif;
						?>
						<p class="banner"><a href="<?= $esurl ?>rental_farm_company"><img src="img/top/banner06.jpg" alt="福利厚生用途の期間貸しレンタル農園サービス"></a></p>

						<p class="banner"><a href="<?= $esurl ?>tanbo_buy"><img src="img/top/tanbo_banner.jpg" alt="田んぼ買います！（一宮町東浪見地区）"></a></p>
						<p class="banner"><a href="<?= $esurl ?>prose"><img src="img/top/banner09.jpg" alt="日々の野菜たちとの戯れとお天道様との散文詩"></a></p>
						<p class="banner"><a href="<?= $esurl ?>restaurant"><img src="img/restaurant/h2.jpg" alt="観光農園敷地内で飲食店を始めてみませんか？"></a></p>
						<p><img src="img/common/qrcode.jpg" alt="東浪見岡本農園 公式LINE"></p>
					</div>
					<div class="block toptext">

						<p>【太陽と野菜の直売所】（東浪見岡本農園）では、化学肥料を一切使わない「完全有機栽培」（いわゆる「オーガニック栽培」）で、健全かつおいしい野菜の栽培を、種まきから苗づくりから行っており、さらに春先のごく一部の季節を除く、1年をとおして農薬類も使用していません。</p>

						<p>近年世界的規模で、地球環境にやさしい「持続可能性ある農業」と言われている農業手法とは、実はわが国各地では江戸時代中後期を頂点として、それこそ「とっくの昔」に実現されていたにもかかわらず、化学肥料の発明から、また戦後（昭和22年）農協法の制定のよる食料安定供給を目的とした「農協制度」の開始から、「持続するはずのない野菜栽培の促進」が始まり、現代になってその大きな反省をしているというのが、その実態でもあります。</p>

						<p>そんな過去に遡った化学肥料栽培や農協法の制定を、今さら否定する訳ではありませんが、当農園の管理人が生まれ育った「昭和の時代」（昭和35年生まれ）には、野菜品質よりも「分量」、安全性よりも「価格」といった価値観だけが「良し」とされ、実際には野菜嫌いを多く作った時代でもありました。</p>

						<p>わが国日本においても、「飽食の時代」と言われる昭和末期、その後平成から令和に変わり、日本人の「食」に対する価値観も大きく変化してきており、「分量よりもおいしさ」「価格よりも安全」であることが、一部の「おしゃれな野菜好きたち」が、さまざまな生食文化（サラダ文化）や新しい調理方法を生み、現在に至ります。</p>

						<p>そんな「安心安全なおいしい野菜」は、当然ながら昔ながらの自然循環のある農地土壌で育まれ、また大量の化石燃料や電気を消費して作られる「化学肥料」とは、もちろん一切無縁のものでありますが、今のところ「有機栽培農法（オーガニック農法）」は、手間暇を要するものであり、スーパーマーケットで格安で売られている野菜価格の「数倍～十数倍」の栽培コストのかかるものなのです。</p>

						<div class="container">
							<div class="leftbox">
								<p>そう、有機土壌で作った完全有機栽培野菜とは、その味覚、おいしさだけではなく、わが子の身体心ともに健全に育つ成長過程と同じように、本来の野菜の生育過程を省くことなく、昔のままを維持した「自然由来の正しい生育過程」を経て生まれるものなのです。</p>

								<p>【太陽と野菜の直売所】（東浪見岡本農園）では、そんな「心のおしゃれ」（きっと他人愛だと思います）を多く持っている方々だけに、お天道様の「正のエネルギー」とともに、健全かつおいしい野菜を作り販売しています。</p>

								<p class="righting">農園管理人：岡本　洋</p>
							</div>
							<div class="rightbox">
								<img src="img/top/portrait.jpg" alt="農園管理人　岡本洋">
							</div>
						</div>
					</div>

					<div class="block">
						<p class="banner"><a href="ordermade"><img src="img/top/banner05.jpg" alt="オーダーメイド野菜の少量栽培に対応しています"></a></p>
						<?php
						if (1 == 2) {
						?>
							<ul class="container banner_rental">
								<li class="banner2"><a href="rental_farm"><img src="img/top/banner02.png" alt="太陽と野菜の直売所】レンタル農園について" width="290"></a></li>
								<li class="banner2"><a href="rental"><img src="img/top/banner03.png" alt="農機・農機具・耕運機のレンタルサービス始めました" width="290"></a></li>
							</ul>
						<?php
						}
						?>
						<!--block end-->
					</div>

					<div class="block">
						<p class="banner"><a href="<?= $esurl ?>revaluation"><img src="img/top/banner04.png" alt="農業の再評価と再定義"></a></p>
						<!--block end-->
					</div>

					<?php
					$sql = "SELECT * from t_master Where disp=1 order by print_order,id desc";
					$p = $dbh->prepare($sql);
					$p->execute();
					$result = $p->fetchAll(PDO::FETCH_ASSOC);
					$ccnt = 0;
					if (!empty($result)) {
					?>
						<div class="block">
							<h2>今週末野菜狩り、単品販売できる野菜</h2>

							<?php
							foreach ($result as $key => $rs) {
								$ccnt++;
								if ($ccnt == 1) {
							?>
									<ul class="yasai container">
									<?php
								}
									?>
									<li class="item">
										<p class="yasaimage">
											<a href="<?= $esurl ?>details?id=<?= $rs["id"] ?>">
												<?php
												if ($rs["image1"] <> "") {
												?>
													<img src="<?= $photoimg ?>goods/<?= $rs["image1"] ?>" alt="<?= $rs["item"] ?>" width="190" style="height:auto;" id="disp<?= $rs["id"] ?>" onMouseOver="txtOpen()" class="item_image">
													<?php
													if ($rs["comment"] <> "") {
													?>
														<p class="comment" id="edisp<?= $rs["id"] ?>"><?= $rs["comment"] ?></p>
													<?php
													}
												} else {
													?>
													<img src="img/top/noimage.gif" alt="NO IMAGE" width="190" style="height:auto;">
												<?php
												}
												?>
											</a>
										</p>
										<p class="icon"><?php
														if ($rs["yasaigari"]) {
														?><span class="reserve">野菜狩り</span>
												<?php
														}
												?>&nbsp;
												<?php
												if ($rs["tanpin"]) {
												?><span class="new">単品販売</span>
												<?php
												}
												?></p>
										<p class="yasainame"><?= $rs["item"] ?></p>
										<?php
										if ($rs["pricedisp"]) {
											if ($rs["price"] <> "") {
										?>
												<p class="price">
													<span class="text">販売価格</span>&nbsp;
													<?php
													if ($rs["price"] == 0) {
														//response.write("準備中")
													} else {
														echo number_format($rs["price"]);
													?>
														円
												</p>
									<?php
													}
												}
											}
									?>
									</li>


								<?php

								if ($ccnt == 3) {
									echo "</ul>";
									$ccnt = 0;
								} elseif ($ccnt < 3 && $key == array_key_last($result)) {
									echo "</ul>";
								}
							}
								?>


								<!--block end-->
						</div>
					<?php
					}
					?>

					<div class="block toptext">
						<div class="block2nd">


							<p>営業日、営業時間帯は以下のとおりとなります。 </p>


							<?php
							$sql = "SELECT * From t_bhours Where id=1";
							$h = $dbh->prepare($sql);
							$h->execute();
							$hrs = $h->fetch(PDO::FETCH_ASSOC);
							?>

							<p>
								・<?= $hrs['starttime'] ?><br>・<?= $hrs['endtime'] ?>
								<br>（2部制）
							</p>


							<p class="bold">●定休日：月曜日・金曜日</p>

						</div>



						<p>当農園では、野菜の直売だけでなく、<a href="<?= $esurl ?>rental_farm" class="underline bold">レンタル農園（6か月間の期間貸し農園）</a>や、<a href="<?= $esurl ?>rental" class="underline bold">トラクター、耕運機などの貸し出し</a>も行っており、ユンボやフォークリフトの重機のレンタル、<a href="<?= $esurl ?>agency_service" class="underline bold">農地の耕運代行サービス</a>、草木の伐採作業、農業土木関連の水路清掃、穴掘り、天地返しなど、土壌改良にかかわるサービス全般を行っています。 </p>

						<p>上記ご要望につきましては、定休日にかかわらず、いつでも電話でお問合せが可能です。（農園管理人：岡本まで　電話　<?= $mobile ?>）</p>

						<p>レンタル農園（貸し農園）では、農園管理人がいるときに限りますが、当面「無料」で農具、農業機械（耕運機を3台用意）を貸し出ししております。</p>

						<p>トイレ（新築：男女別）も併設しておりますので、約10,000平方メートルを超える農地の様子を、安心して見学にいらしてください。</p>

						<p>またご要望があれば、飲食店様にはレア野菜等の「<a href="<?= $esurl ?>ordermade" class="underline">オーダーメイド野菜の少量栽培</a>」の受注もしております。</p>

						<p>お問合せ、各種ご相談は問合せフォーム、または以下までお願いします。</p>

						<p>【太陽と野菜の直売所】（東浪見岡本農園）農園責任者：岡本　洋<br>〒299-4303　千葉県長生郡一宮町東浪見4721番（<a href="https://www.google.com/maps/place/%E5%A4%AA%E9%99%BD%E3%81%A8%E9%87%8E%E8%8F%9C%E3%81%AE%E7%9B%B4%E5%A3%B2%E6%89%80+%E6%9D%B1%E6%B5%AA%E8%A6%8B%E5%B2%A1%E6%9C%AC%E8%BE%B2%E5%9C%92/@35.3554525,140.3758902,17z/data=!3m1!4b1!4m5!3m4!1s0x6022c9a9123e1bab:0x2b1aeddfe0a7f9f5!8m2!3d35.3554481!4d140.3780789" target="_blank" class="underline">Googleマップ</a>）</p>

						<ul>
							<li>（電　話）管理人直通携帯電話：<?= $mobile ?> またはメールにてご連絡ください。</li>
							<li>（メール）<a href="mailto:torami@okamoto-farm.co.jp" class="underline">torami@okamoto-farm.co.jp</a></li>


						</ul>

						<p>今後、当ホームページでは、それぞれのサービス詳細ページを増やしてまいります。</p>

					</div>




					<?php
					$sql = "SELECT * From t_news Where disp=1 order by indate desc";
					$i = $dbh->prepare($sql);
					$i->execute();
					$result = $i->fetchAll(PDO::FETCH_ASSOC);
					if (!empty($result)) {
					?>
						<div class="block info">
							<h2>お知らせ</h2>
							<ul>
								<?php
								foreach ($result as $rs) {
									$icnt++;
								?>
									<li>（<?= date('Y/m/d', strtotime($rs["indate"])) ?>）<a href="<?= $esurl ?>information?id=<?= $rs["id"] ?>"><?= $rs["title"] ?></a></li>

								<?php

									if ($icnt >= 10) {
										break;
									}
								}
								?>
							</ul>

							<?php
							if ($icnt >= 10) {
							?>
								<p class="righting"><a href="<?= $esurl ?>infolist" class="underline">お知らせ一覧</a></p>
							<?php
							}
							?>
						</div>

					<?php
					}
					?>
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