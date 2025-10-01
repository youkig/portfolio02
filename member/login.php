<!DOCTYPE html>
<html lang="ja">
<?php include("../config.php"); ?>


<?php
$logid = $_COOKIE["logid"];
$pass = $_COOKIE["pass"];

if (userloginch($logid, $pass) == 1) {
	header("location:" . $esurl . "member/mypage");
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
	<meta name="keywords" content="有機栽培,無農薬野菜,野菜狩り,収穫体験,レンタル農園,貸し農園,観光農園,農業土木,農機具レンタル,耕運代行,農産物直売所,レンタル厨房,トラクター,耕運機,ユンボ,ソーラー蓄電システム,避難場所,停電,非常用電源,とらみスイート,千葉県,長生郡,一宮町,外房,九十九里">

	<meta name="description" content="千葉県外房エリア、九十九里海岸の南端、長生郡一宮町ある、近隣唯一の完全有機栽培農家【太陽と野菜の直売所】（東浪見岡本農園）ホームページでは、観光農園として野菜狩り・農業体験サービスのほか、期間貸しのレンタル農園のご紹介や、農機・農機具レンタル、レンタル厨房のご案内をしております。停電時にいつも電気のある災害避難所としてもご利用になれます。">

	<title>会員様ログイン／農産物直売所 千葉【太陽と野菜の直売所】貸し農園 一宮町／野菜狩り／農業体験</title>

	<link rel="stylesheet" href="../css/base.css" type="text/css">


	<script src="../js/jquery-1.5.2.min.js"></script>
	<script src="../js/jquery-ui.js"></script>
	<link rel="stylesheet" href="../js/jquery.ui.css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
	<script src="../js/jquery.bgswitcher.js"></script>
	<script src="../js/pagetop.js"></script>

	<script src="../js/topslide.js"></script>

	<?php
	session_start();
	if (!empty($_POST["loginid"]) && !empty($_POST["password"])) {
		$username = $_POST["loginid"];
		$password = $_POST["password"];

		if (!empty($username)) {

			$sql = "SELECT * From t_user Where email=:username AND dele=0 AND taikai=0";
			$u = $dbh->prepare($sql);
			$u->bindValue(":username", $username, PDO::PARAM_STR);
			$u->execute();
			$rs = $u->fetch(PDO::FETCH_ASSOC);

			if (empty($rs)) {
				$errmes = "登録されていません";
			} else {
				if ($rs["dele"] == 1 || $rs["taikai"] == 1) {
					$errmes = "ログインできません";
				} else {
					if (!password_verify($password, $rs["password"])) {
						$errmes = "パスワードが違います";
					} else {


						//session_regenerate_id(true);
						$_SESSION["setid"] = $rs['id'];
						$_SESSION["logid"] = $rs['email'];
						$_SESSION["username"] = $rs['name'];
						$_SESSION["pass"] = $rs['password'];
						$_SESSION["company"] = $rs['company'];
						//cookie
						setcookie("setid", $rs['id'], time() + 3600, "/");
						setcookie("logid", $rs['email'], time() + 3600, "/");
						setcookie("pass", $rs['password'], time() + 3600, "/");


						header("location: " . $esurl . "member/mypage");
						exit();
					}
				}
			}
		} else {
			$errmes = "ログインIDを入力してください";
		}
	}
	?>
</head>

<body>

	<div id="box">

		<div id="header">
			<h1>新鮮野菜 直売所／千葉 一宮町</h1>


			<?php include("../include/header.php") ?>


			<div id="main" class="container">
				<?php include("../include/leftpane.php") ?>
				<div id="cnt" class="company">

					<p class="pankuzu"><a href="<?= $esurl ?>">トップページ</a> | 会員様ログイン</p>
					<div class="block">
						<h2>会員様ログイン</h2>

						<p>こちらのページは【太陽と野菜の直売所】へご登録頂いた会員様専用のログインページです。</p>

						<p>ユーザーIDとパスワードを入力してログインしてください。</p>

					</div>



					<form action="<?= $esurl ?>member/login" method="post" onSubmit="return signup(this)">
						<div class="block">
							<h3>会員ログインフォーム</h3>


							<p><?= $errmes ?></p>


							<dl>
								<dt>ユーザーID</dt>
								<dd><input type="text" name="loginid" id="loginid" value=""></dd>
							</dl>

							<dl>
								<dt>パスワード</dt>
								<dd><input type="password" name="password" id="password" value=""></dd>
							</dl>



						</div>

						<div class="block">

							<p class="centering"><input type="submit" name="submit" value="ログイン"></p>
						</div>

						<input type="hidden" name="loginchk" value="okamoto-nouen">

					</form>

					<p class="centering"><a href="forgot" class="underline">パスワードを忘れた方</a></p>
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