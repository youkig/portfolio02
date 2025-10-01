<?php $siteid = 52 ?>
<?php include("include/autometa.php"); ?>
<?php
session_start();
?>
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

	<link rel="canonical" href="<?= $esurl ?>inquire01.php">
	<meta name="keywords" content="<?= $n_keyword ?>">

	<meta name="description" content="<?= $n_description ?>">

	<title><?= $n_title ?></title>

	<link rel="stylesheet" href="css/base.css?<?= str_replace(":", "", date("H:i:s")); ?>" type="text/css">
	<?php include("include/js.php") ?>

	<script src="js/form_chk.js"></script>
	<script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>
	<script>
		$(function() {

			$("#person1").click(function() {
				$(".houjin").fadeIn();
			});

			$("#person2").click(function() {
				$(".houjin").fadeOut();
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
				<div id="cnt" class="company">

					<p class="pankuzu"><a href="<?= $esurl ?>">トップページ</a> | お問合せ・お申込み</p>
					<div class="block">
						<h2>お問合せ・お申込み</h2>

						<p>【太陽と野菜の直売所】東浪見岡本農園の各種サービスへのお問合せ・ご質問等は、以下フォームよりお願いいたします。</p>

					</div>

					<div class="block">
						<h3>メールでのお問合せ</h3>
						<ul>

							<li>（管理人直通携帯電話）<?= $mobile ?></li>
							<li>（メール）torami@okamoto-farm.co.jp</li>
						</ul>

					</div>

					<?php
					$logid = $_COOKIE["logid"];
					$pass = $_COOKIE["pass"];
					if (!empty($logid) && !empty($pass)) {
						$sql = "select * From t_user Where email=:email and password=:password and dele=0 and taikai=0";
						$user = $dbh->prepare($sql);
						$user->bindValue(':email', $logid, PDO::PARAM_STR);
						$user->bindValue(':password', $pass, PDO::PARAM_STR);
						$user->execute();
						$result = $user->fetch(PDO::FETCH_ASSOC);

						if (!empty($result)) {
							$person = $result["person"];
							$company = $result["company"];
							$busyo = $result["busyo"];
							$username = $result["name"];
							$furigana = $result["furigana"];
							$email = $result["email"];
							$tel = $result["tel"];
							$zip = explode("-", $result["zip"]);
							$zip1 = $zip[0];
							$zip2 = $zip[1];

							$sql = "select state From t_state Where id=:state";
							$state = $dbh->prepare($sql);
							$state->bindValue(":state", $result["state"], PDO::PARAM_INT);
							$sta = $state->fetch(PDO::FETCH_ASSOC);

							$statename = $sta["state"];
							$address = $result["address"];
							$address2 = $result["address2"];
						}
					}
					?>

					<form action="<?= $esurl ?>inquire02" method="post" onSubmit="return signup(this)">
						<div class="block">
							<h3>お問合せフォーム</h3>

							<dl>
								<dt>お問合せ項目&nbsp;<em>[必須]</em></dt>
								<dd>
									<input type="checkbox" name="koumoku[]" id="koumoku1" value="野菜狩り・野菜収穫体験サービスについて" class="radiochk"><label for="koumoku1">野菜狩り・野菜収穫体験サービスについて</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku2" value="レンタル農園（貸し農園）について" class="radiochk"><label for="koumoku2">レンタル農園（貸し農園）について</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku23" value="新規就農者個人事業向け　レンタル農園・貸し農園" class="radiochk"><label for="koumoku23">新規就農者個人事業向け　レンタル農園・貸し農園</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku21" value="福利厚生用途の期間貸しレンタル農園サービスについて" class="radiochk"><label for="koumoku21">福利厚生用途の期間貸しレンタル農園サービスについて</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku3" value="農地耕運代行・農地復活代行サービスについて" class="radiochk"><label for="koumoku3">農地耕運代行・農地復活代行サービスについて</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku25" value="農機具 買取りサービスについて" class="radiochk"><label for="koumoku25">農機具 買取りサービスについて</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku4" value="農地利用権利の確保サービスについて" class="radiochk"><label for="koumoku4">農地利用権利の確保サービスについて</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku5" value="レンタル厨房・レンタルキッチンについて" class="radiochk"><label for="koumoku5">レンタル厨房・レンタルキッチンについて</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku14" value="料理大好きな方「名案」を大募集" class="radiochk"><label for="koumoku14">料理大好きな方「名案」を大募集</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku29" value="観光農園敷地内飲食店についてのご相談" class="radiochk"><label for="koumoku29">観光農園敷地内飲食店についてのご相談</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku6" value="農機・農機具・耕運機のレンタルサービスについて" class="radiochk"><label for="koumoku6">農機・農機具・耕運機のレンタルサービスについて</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku9" value="農地取得相談・農地選定コンサルティングサービス" class="radiochk"><label for="koumoku9">農地取得相談・農地選定コンサルティングサービス</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku32" value="農業指導・家庭菜園野菜作りサポート" class="radiochk"><label for="koumoku32">農業指導・家庭菜園野菜作りサポート</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku10" value="オーダーメイド野菜の少量栽培について" class="radiochk"><label for="koumoku10">オーダーメイド野菜の少量栽培について</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku11" value="農業ボランティア・農作業体験申込み" class="radiochk"><label for="koumoku11">農業ボランティア・農作業体験申込み</label><br>

									<?php
									if (1 == 2):
									?>
										<input type="checkbox" name="koumoku[]" id="koumoku12" value="井戸ポンプ用ソーラー蓄電システム・非常用太陽光発電システムについて" class="radiochk"><label for="koumoku12">井戸ポンプ用ソーラー蓄電システム・非常用太陽光発電システムについて</label><br>
										<input type="checkbox" name="koumoku[]" id="koumoku17" value="井戸掘り（上総掘り）の申込み・お問合せ" class="radiochk"><label for="koumoku17">井戸掘り（上総掘り）の申込み・お問合せ</label><br>
										<input type="checkbox" name="koumoku[]" id="koumoku24" value="地方自治体様向けソーラー蓄電システム利用による防災用トイレ設置に関する無料相談" class="radiochk"><label for="koumoku24">地方自治体様向けソーラー蓄電システム利用による防災用トイレ設置に関する無料相談</label><br>

									<?php
									endif;
									?>
									<input type="checkbox" name="koumoku[]" id="koumoku22" value="田んぼ買取についての問合せ" class="radiochk"><label for="koumoku22">田んぼ買取についての問合せ</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku26" value="草刈りサービスについての問合せ" class="radiochk"><label for="koumoku26">草刈りサービスについての問合せ</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku27" value="除草剤散布サービスについての問合せ" class="radiochk"><label for="koumoku27">除草剤散布サービスについての問合せ</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku30" value="別荘地のお庭・空き地の年間不動産管理サービスについての問合せ" class="radiochk"><label for="koumoku30">別荘地のお庭・空き地の年間不動産管理 サービスについての問合せ</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku28" value="災害有事の際のトイレ等生活インフラ提供サービス" class="radiochk"><label for="koumoku28">災害有事の際のトイレ等生活インフラ提供サービス</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku31" value="農園で「人生相談・恋愛相談」してみませんか？" class="radiochk"><label for="koumoku31">農園で「人生相談・恋愛相談」してみませんか？</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku13" value="求人・アルバイトについて" class="radiochk"><label for="koumoku13">求人・アルバイトについて</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku16" value="停電時の電気供給について" class="radiochk"><label for="koumoku16">停電時の電気供給について</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku15" value="生活困窮家庭の向け野菜無料配布について" class="radiochk"><label for="koumoku15">生活困窮家庭の向け野菜無料配布について</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku7" value="直売所出荷について" class="radiochk"><label for="koumoku7">直売所出荷について</label><br>
									<input type="checkbox" name="koumoku[]" id="koumoku8" value="商品のご予約" class="radiochk"><label for="koumoku8">商品のご予約</label><br>

									<input type="checkbox" name="koumoku[]" id="koumoku20" value="ご質問・お問合せ" class="radiochk"><label for="koumoku20">ご質問・お問合せ</label>

								</dd>
							</dl>

							<?php
							if (!empty($_GET["sid"])) {
								$sql = "SELECT * From t_master Where id=:sid";
								$item = $dbh->prepare($sql);
								$item->bindValue(":sid", $_GET["sid"], PDO::PARAM_INT);
								$item->execute();
								$result = $item->fetch(PDO::FETCH_ASSOC);
								if (!empty($result)) {
							?>
									<dl>
										<dt>問合せしたい商品</dt>
										<dd><?= $result["item"] ?><input type="hidden" name="sname" value="<?= $result["item"] ?>"></dd>
									</dl>
							<?php
								}
							}

							?>

							<dl>
								<dt>法人・個人&nbsp;<em>[必須]</em></dt>
								<dd><input type="radio" name="person" id="person1" value="法人" class="radiochk" <?= checked($person, 0) ?>><label for="person1">法人</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="person" id="person2" value="個人" class="radiochk" <?= checked($person, 1) ?>><label for="person2">個人</label>
								</dd>
							</dl>

							<dl class="houjin">
								<dt>法人名</dt>
								<dd>
									※上記項目で「法人」を選択した場合は、必須です<br><input type="text" name="company" id="company" value="<?= $company ?>"></dd>
							</dl>

							<dl class="houjin">
								<dt>部署</dt>
								<dd><input type="text" name="busyo" id="busyo" value="<?= $busyo ?>"></dd>
							</dl>
							<dl>
								<dt>お名前&nbsp;<em>[必須]</em></dt>
								<dd><input type="text" name="name" id="name" value="<?= $username ?>"></dd>
							</dl>

							<dl>
								<dt>ふりがな&nbsp;<em>[必須]</em></dt>
								<dd><input type="text" name="furigana" id="furigana" value="<?= $furigana ?>"></dd>
							</dl>

							<dl>
								<dt>メールアドレス&nbsp;<em>[必須]</em></dt>
								<dd><input type="text" name="email" id="email" value="<?= $email ?>"></dd>
							</dl>

							<dl>
								<dt>メールアドレス（確認）&nbsp;<em>[必須]</em></dt>
								<dd><input type="text" name="kemail" id="kemail" value="<?= $email ?>"></dd>
							</dl>

							<dl>
								<dt>電話番号&nbsp;<em>[必須]</em></dt>
								<dd><input type="text" name="tel" id="tel" value="<?= $tel ?>"></dd>
							</dl>

							<dl>
								<dt>郵便番号&nbsp;<em>[必須]</em></dt>
								<dd><input type="text" name="zip1" id="zip1" value="<?= $zip1 ?>" class="zip"> - <input type="text" name="zip2" id="zip2" value="<?= $zip1 ?>" class="zip" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','state','address','');"></dd>
							</dl>

							<dl>
								<dt>都道府県</dt>
								<dd><select name="state" id="state">
										<option value="">選択</option>
										<?php
										$sql = "SELECT * From t_state";
										$state = $dbh->prepare($sql);
										$state->execute();
										$result = $state->fetchAll(PDO::FETCH_ASSOC);
										foreach ($result as $row) {
										?>
											<option value="<?= $row["state"] ?>" <?php if ($statename == $row["state"]) {
																						echo " selected";
																					} ?>><?= $row["state"] ?></option>
										<?php
										}
										?>
									</select></dd>
							</dl>

							<dl>
								<dt>市区町村名</dt>
								<dd><input type="text" name="address" id="address" value="<?= $address ?>"></dd>
							</dl>

							<dl>
								<dt>以下番地、建物名など</dt>
								<dd><input type="text" name="address2" id="address2" value="<?= $address2 ?>"></dd>
							</dl>

							<dl>
								<dt>お問合せ内容&nbsp;<em>[必須]</em></dt>
								<dd>
									<?php
									if (!empty($_GET["purchase"])):
									?>
										※買取りサービスの場合は、買取り希望の農機具について具体的にご記載ください。（メーカー名、型番、購入時期など）<br />
									<?php
									endif;
									?>
									<textarea name="comment" id="comment" cols="20" rows="5"></textarea>
								</dd>
							</dl>


						</div>

						<div class="block">
							<p>上記内容でよろしければ、確認画面へお進みください。</p>
							<p class="red">確認ページで「入力内容に不備があります。」と表示される場合、入力したテキストに環境依存文字、機種依存文字、省略文字、予約語などが含まれている可能性があります。（例：① ㈱ ～ and or など）</p>
							<p class="centering"><input type="submit" name="submit" value="内容確認"></p>
							<?php
							function setToken()
							{
								$TOKEN_LENGTH = 32;
								$bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);

								$token = bin2hex($bytes);
								$_SESSION['crsf_token'] = $token;
								return $token;
							}
							?>
							<input type="hidden" name="token" value="<?= setToken() ?>">

						</div>

						<input type="hidden" name="inqchk" value="okamoto-nouen">

					</form>

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