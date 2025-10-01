<?php
session_start();
?>
<?php $siteid = 92 ?>
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

	<meta name="keywords" content="<?= $n_keyword ?>">

	<meta name="description" content="<?= $n_description ?>">

	<title><?= $n_title ?></title>

	<link rel="stylesheet" href="css/base.css?<?= str_replace(":", "", date("H:i:s")); ?>" type="text/css">
	<?php include("include/js.php") ?>
	<script src="js/reserved_chk.js"></script>

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
				<div id="cnt" class="company about cart">

					<p class="pankuzu"><a href="<?= $esurl ?>">トップページ</a> | 野菜狩り予約フォーム（送信完了）</p>
					<div class="block">
						<h2 id="form">野菜狩り予約フォーム（送信完了）</h2>
					</div>
					<?php

					if (empty($_SESSION['crsf_token'])) {
						echo "<p>アクセスが不正です。</p>";
					} else
						
					if ($_SESSION['crsf_token'] == filter_input(INPUT_POST, "token")) {

						//データベース登録
						//会員登録
						$uid  = "";
						$maid = "";
						if (!empty($_POST["password"]) && $_POST["regist_chk"]) {
							// 入力値取得と加工
							$person = $_POST['person'] ?? '';
							$person_val = ($person === '法人') ? 0 : (($person === '個人') ? 1 : null);

							// パスワード暗号化
							$password_raw = $_POST['password'] ?? '';
							$password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);

							// SQL文（プレースホルダ）
							$sql = "INSERT INTO t_user (
								person, name, furigana, company, busyo, zip, state,
								address, address2, tel, email, password, password2,
								mailmaga, indate
							) VALUES (
								:person, :name, :furigana, :company, :busyo, :zip, :state,
								:address, :address2, :tel, :email, :password, :password2,
								:mailmaga, :indate
							)";

							$stmt = $pdo->prepare($sql);

							// 値のバインド（bindValue 使用）
							$stmt->bindValue(':person', $person_val, PDO::PARAM_INT);
							$stmt->bindValue(':name', $_POST['name'] ?? '', PDO::PARAM_STR);
							$stmt->bindValue(':furigana', $_POST['furigana'] ?? '', PDO::PARAM_STR);
							$stmt->bindValue(':company', renull($_POST['company'] ?? ''), PDO::PARAM_NULL | PDO::PARAM_STR);
							$stmt->bindValue(':busyo', renull($_POST['busyo'] ?? ''), PDO::PARAM_NULL | PDO::PARAM_STR);

							$zip = ($_POST['zip1'] ?? '') . '-' . ($_POST['zip2'] ?? '');
							$stmt->bindValue(':zip', $zip, PDO::PARAM_STR);

							$stmt->bindValue(':state', cnum($_POST['state'] ?? ''), PDO::PARAM_INT);
							$stmt->bindValue(':address', $_POST['address']  ?? '', PDO::PARAM_STR);
							$stmt->bindValue(':address2', $_POST['address2'] ?? '', PDO::PARAM_STR);
							$stmt->bindValue(':tel', $_POST['tel'] ?? '', PDO::PARAM_STR);
							$stmt->bindValue(':email', $_POST['email'] ?? '', PDO::PARAM_STR);

							$stmt->bindValue(':password',  $password_hashed, PDO::PARAM_STR);
							$stmt->bindValue(':password2', $password_raw,    PDO::PARAM_STR); // 元のパスワードそのまま保存（注意：推奨されません）

							$stmt->bindValue(':mailmaga',  cnum($_POST['mailmaga'] ?? ''), PDO::PARAM_INT);
							$stmt->bindValue(':indate',    date('Y-m-d H:i:s'), PDO::PARAM_STR);

							// 実行
							$stmt->execute();


							$sql = "SELECT max(id) as mid From t_user";
							$m = $dbh->prepare($sql);
							$m->execute();
							$mrs = $m->fetch(PDO::FETCH_ASSOC);
							$maid = $mrs["mid"];
						}

						//'メインオーダー
						if (!empty($_SESSION["setid"])) {
							$uid = $_SESSION["setid"];
						} elseif (!empty($maid)) {
							$uid = $maid;
						} else {
							$uid = "";
						}


						// 値の取得

						$person    = renull($_POST['person'] ?? '');
						$company   = renull($_POST['company'] ?? '');
						$busyo     = renull($_POST['busyo'] ?? '');
						$name      = renull($_POST['name'] ?? '');
						$furigana  = renull($_POST['furigana'] ?? '');
						$email     = renull($_POST['email'] ?? '');
						$tel       = renull($_POST['tel'] ?? '');
						$zip       = ($_POST['zip1'] ?? '') . '-' . ($_POST['zip2'] ?? '');
						$state     = cnum($_POST['state'] ?? '');
						$address   = renull($_POST['address'] ?? '');
						$address2  = renull($_POST['address2'] ?? '');
						$comment   = renull($_POST['comment'] ?? '');
						$indate    = date('Y-m-d H:i:s');

						// SQL文
						$sql = "INSERT INTO t_yasaigari01 (
							uid, person, company, busyo, name, furigana, email, tel, zip, state, address, address2, comment, indate
						) VALUES (
							:uid, :person, :company, :busyo, :name, :furigana, :email, :tel, :zip, :state, :address, :address2, :comment, :indate
						)";

						// SQL実行
						$stmt = $dbh->prepare($sql);

						// bindValue（型を明示）
						$stmt->bindValue(':uid', $uid, PDO::PARAM_INT);
						$stmt->bindValue(':person', $person, PDO::PARAM_STR);
						$stmt->bindValue(':company', $company, PDO::PARAM_STR);
						$stmt->bindValue(':busyo', $busyo, PDO::PARAM_STR);
						$stmt->bindValue(':name', $name, PDO::PARAM_STR);
						$stmt->bindValue(':furigana', $furigana, PDO::PARAM_STR);
						$stmt->bindValue(':email', $email, PDO::PARAM_STR);
						$stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
						$stmt->bindValue(':zip', $zip, PDO::PARAM_STR);
						$stmt->bindValue(':state', $state, PDO::PARAM_INT);
						$stmt->bindValue(':address', $address, PDO::PARAM_STR);
						$stmt->bindValue(':address2', $address2, PDO::PARAM_STR);
						$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
						$stmt->bindValue(':indate', $indate, PDO::PARAM_STR);

						$stmt->execute();


						// 'ユーザーのIDを取得
						$sql = "SELECT max(id) as co From t_yasaigari01";
						$u = $dbh->prepare($sql);
						$u->execute();
						$rsco = $u->fetch(PDO::FETCH_ASSOC);
						$uid = $rsco["co"];


						$sql = "INSERT into t_yasaigari02 (uid,ydate,yhour,ytime,num,kago) VALUES (:uid,:ydate,:yhour,:ytime,:num,:kago)";
						$y = $dbh->prepare($sql);
						$y->bindValue(":uid", renull($uid), PDO::PARAM_INT);
						$y->bindValue(":ydate", $_POST["ydate"], PDO::PARAM_STR);
						$y->bindValue(":yhour", $_POST["hour"], PDO::PARAM_INT);
						$y->bindValue(":ytime", $_POST["time"], PDO::PARAM_INT);
						$y->bindValue(":num", $_POST["ninzu"], PDO::PARAM_INT);
						$y->bindValue(":kago", $_POST["kago"], PDO::PARAM_INT);
						$y->execute();



						// 'ここまで				
						// 	'****************************************************************
						// 	' 送信メッセージ作成(管理者へ)
						// 	'****************************************************************
						$send_msg_manager = "\n";
						$send_msg_manager .= "[ご予約内容]\n";
						$send_msg_manager .= "【ご予約日】" . $_POST["ydate"] . "\n";
						$send_msg_manager .= "【ご予約時間】" . $_POST["hour"] . "時" . $_POST["time"] . "分\n";
						$send_msg_manager .= "【ご予約人数】" . $_POST["ninzu"] . "人\n";
						$send_msg_manager .= "【ご利用のカゴ数】" . $_POST["kago"] . "個\n\n";


						$send_msg_manager .= "[お客様情報]\n";
						$send_msg_manager .= "------------------------------------------------------\n";
						$send_msg_manager .= "【法人/個人】" . $_POST["person"] . "\n";
						if (!empty($_POST["company"])) {
							$send_msg_manager .= "【会社名】" . $_POST["company"] . "\n";
							$send_msg_manager .= "【部署】" . $_POST["busyo"] . "\n";
						}
						$send_msg_manager .= "【お名前】" . $_POST["name"] . "\n";
						$send_msg_manager .= "【ふりがな】" . $_POST["furigana"] . "\n";
						$send_msg_manager .= "【メールアドレス】" . $_POST["email"] . "\n";
						$send_msg_manager .= "【電話番号】" . $_POST["tel"] . "\n";
						$send_msg_manager .= "【郵便番号】" . $_POST["zip1"] . "-" . $_POST["zip2"] . "\n";
						$send_msg_manager .= "【住所】" . $_POST["statename"] . $_POST["address"] . $_POST["address2"] . "\n";
						if (!empty($_POST["password"]) && $_POST["regist_chk"] == 1) {
							$send_msg_manager .= "【会員登録】会員登録あり\n";
							$send_msg_manager .= "【パスワード】" . $_POST["password"] . "\n";
						}

						$send_msg_manager .= "【ご質問・ご要望など】\n" . $_POST["comment"] . "\n";
						$send_msg_manager .= "------------------------------------------------------\n";
						$send_msg_manager .= "\n";
						$send_msg_manager .= "\n";
						// '****************************************************************
						// ' 送信メッセージ作成(お客様へ)
						// '****************************************************************
						$send_msg_visitor = "\n";
						$send_msg_visitor .= "このメールは自動的に配信されております。\n\n";
						if (!empty($_POST["name"])) {
							$send_msg_visitor .=  $_POST["name"] . " 様\n";
						} else {
							$send_msg_visitor .=  $_POST["email"] . " 様\n";
						}
						$send_msg_visitor .=  "【太陽と野菜の直売所】を運営しております、東浪見岡本農園です。\n";
						$send_msg_visitor .=  "下記の「野菜狩り・野菜収穫体験サービス」ご予約メールをお預かり致しました。\n";
						$send_msg_visitor .=  "ご予約をキャンセルされる場合、ご来店日の予定が変更になった場合は、\n";
						$send_msg_visitor .=  "torami@okamoto-farm.co.jpへ直接メールをお送り頂くか、お電話にてご連絡ください。\n";
						$send_msg_visitor .=  "\n";
						$send_msg_visitor .=  "\n";
						// '****************************************************************
						// ' フッダー作成
						// '****************************************************************
						$send_msg_footer = "=====================================================\n";
						$send_msg_footer .=  " 【太陽と野菜の直売所】東浪見岡本農園\n";
						$send_msg_footer .=  "　〒299-4303\n";
						$send_msg_footer .=  "　千葉県長生郡一宮町東浪見4721番\n";
						$send_msg_footer .=  "　TEL:" . $mobile . "\n";
						$send_msg_footer .=  "　E-mail：torami@okamoto-farm.co.jp\n";
						$send_msg_footer .=  "　URL：https://www.okamoto-farm.co.jp\n";
						$send_msg_footer .=  "=====================================================\n";
						$send_msg_footer .=  "\n";
						// '****************************************************************
						// ' メール送信
						// '****************************************************************
						mb_language("japanese");
						mb_internal_encoding("UTF-8");
						// '****************************************************************
						// ' 管理者へ
						// '****************************************************************
						$header = "From:" . mb_encode_mimeheader("お客様") . "<" . $_POST["email"] . ">\r\n";
						$subj = "【太陽と野菜の直売所】野菜狩り・野菜収穫体験サービス予約のお知らせ";
						$to = "<torami@okamoto-farm.co.jp>";
						//$to = "<ishibashi@autumn-tec.co.jp>";
						$header .= "Bcc: <okamotofarm@docomo.ne.jp>\r\n";
						//$header .= "Bcc: <ishibashi@autumn-tec.co.jp>\r\n";
						//$header .= "Content-Type: text/plain; charset=UTF-8\r\n";
						if (!empty($_POST["name"])) {
							$send_msg = $_POST["name"] . "様からの野菜狩り・野菜収穫体験サービスの予約メールです。\n\n";
							$send_msg .= $send_msg_manager;
						} else {
							$send_msg = $_POST["email"] . "様からの野菜狩り・野菜収穫体験サービスの予約メールです。\n\n";
							$send_msg .= $send_msg_manager;
						}


						// '****************************************************************
						// ' 送信(管理者)
						// '****************************************************************
						if (mb_send_mail($to, $subj, $send_msg, $header)) {
							$rs_manager = "";
						} else {
							$rs_manager = 1;
						}
						// '****************************************************************
						// ' お客様へ
						// '****************************************************************
						$header2 = "From:" . mb_encode_mimeheader("【太陽と野菜の直売所】（東浪見岡本農園）") . "<torami@okamoto-farm.co.jp>";
						$subj2 = "野菜狩り・野菜収穫体験サービス予約メール受付完了のお知らせ【太陽と野菜の直売所】";
						$to2 = "<" . $_POST["email"] . ">";
						$send_msg2 = $send_msg_visitor . $send_msg_manager . $send_msg_footer;
						// '****************************************************************
						// ' 送信(お客様へ)
						// '****************************************************************
						if (mb_send_mail($to2, $subj2, $send_msg2, $header2)) {
							$rs_visitor = "";
						} else {
							$rs_visitor = 1;
						}
						if (!empty($rs_manager) || !empty($rs_visitor)) {
					?>

							<div class="block">

								<p>送信に失敗しました。<br />メールアドレスに誤りがある可能性があります。<br />
									何度も送信に失敗する場合は、torami@okamoto-farm.co.jpへ直接メールをお送り頂くか、お電話にてご連絡ください。
								</p>

								<p class="centering"><a href="<?= $esurl ?>index.php" class="underline">トップページへ戻る</a></p>
							</div>

						<?php
						} else {
							$_SESSION['crsf_token'] = "";
						?>

							<div class="block">

								<p>メールが送信されました。<br />
									ご予約をキャンセルされる場合、ご来店日の予定が変更になった場合は、torami@okamoto-farm.co.jpへ直接メールをお送り頂くか、お電話にてご連絡ください。
								</p>

								<p class="centering"><a href="<?= $esurl ?>index.php" class="underline">トップページへ戻る</a></p>
							</div>
					<?php
						}
					}
					?>

					<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88" /></a></p>
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