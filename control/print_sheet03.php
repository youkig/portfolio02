<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<?php include("../config.php"); ?>

<?php
$userid2 = $_COOKIE["adminlogin"];
$password2 = $_COOKIE["adminpasswd"];
if (control_login($userid2, $password2) === false) {
	header("location:login.php");
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
	<meta name="robots" content="none" />

	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<?php include("include/js.php"); ?>
	<script src="https://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3-https.js" charset="UTF-8"></script>

	<script type="text/javascript">
		$(function() {
			$("#printsheet_bth").click(function() {
				window.print();
				document.printform.submit();
			});
		});
	</script>

	<?php

	$id = cnum($_REQUEST["id"]);
	if ($id !== 0) {
		$sql = "select * from t_cuser where id = :id";
		$c = $dbh->prepare($sql);
		$c->bindValue(":id", $id, PDO::PARAM_INT);
		$c->execute();
	}


	if (cnum($_REQUEST["t"]) == 2) {
		$chohyou = "納品書";
		$text = "下記の通り、納品いたします。";
	} elseif (cnum($_REQUEST["t"]) == 1) {
		$chohyou = "請求書";
		$text = "下記の通り、ご請求申し上げます。";
	} elseif (cnum($_REQUEST["t"]) == 3) {
		$chohyou = "見積書";
		$text = "下記の通り、ご見積いたします。";
	} else {
		$chohyou = "領収書";
		$text = "下記、正に領収いたしました。";
	}
	?>

	<title><?= $_POST["name"] ?>様　<?= $chohyou ?>【東浪見岡本農園】</title>
</head>

<body>
	<div id="box3" class="kanri">



		<div id="cnt3" class="print_sheet">

			<h2><?= $chohyou ?>印刷</h2>

			<div class="block">

				<?php
				$sql = "SELECT max(id) as maxid From t_receipt_master";
				$m = $dbh->prepare($sql);
				$m->execute();
				$rsm = $m->fetch(PDO::FETCH_ASSOC);

				$maxid = cnum($rsm["maxid"]) + 1;

				if (!empty($_POST["newregi"])) {
					$mainid = 0;
				} else {
					$mainid = cnum($_POST["mid"]);
				}

				if ($mainid == 0) {
					$sql = "INSERT into t_receipt_master (NO,uid,syubetsu,subj,address,indate,subtotal,tax,total,memo,numberlines) values (:NO,:uid,:syubetsu,:subj,:address,:indate,:subtotal,:tax,:total,:memo,:numberlines)";
					$r = $dbh->prepare($sql);
					$r->bindValue(":NO", sprintf('%06d', $maxid), PDO::PARAM_STR);
					$r->bindValue(":uid", $_POST["id"], PDO::PARAM_INT);
					$r->bindValue(":syubetsu", $_POST["t"], PDO::PARAM_INT);
					$r->bindValue(":subj", renull($_POST["subtitle"]), PDO::PARAM_STR);
					$r->bindValue(":address", renull($_POST["name"]), PDO::PARAM_STR);
					$r->bindValue(":indate", renull($_POST["indate"] . " " . date('H:i:s')), PDO::PARAM_STR);
					$r->bindValue(":subtotal", renull($_POST["syokei"]), PDO::PARAM_INT);
					$r->bindValue(":tax", cnum($_POST["zei"]), PDO::PARAM_INT);
					$r->bindValue(":total", cnum($_POST["total_price"]), PDO::PARAM_INT);
					$r->bindValue(":memo", renull($_POST["comment"]), PDO::PARAM_STR);
					$r->bindValue(":numberlines", cnum($_POST["counttr"]), PDO::PARAM_INT);
					$r->execute();
				} else {
					$sql = "UPDATE t_receipt_master set subj=:subj,address=:address,indate=:indate,subtotal=:subtotal,tax=:tax,total=:total,memo=:memo,numberlines=:numberlines Where id=:mainid";
					$r = $dbh->prepare($sql);
					$r->bindValue(":subj", renull($_POST["subtitle"]), PDO::PARAM_STR);
					$r->bindValue(":address", renull($_POST["name"]), PDO::PARAM_STR);
					$r->bindValue(":indate", renull($_POST["indate"] . " " . date('H:i:s')), PDO::PARAM_STR);
					$r->bindValue(":subtotal", renull($_POST["syokei"]), PDO::PARAM_INT);
					$r->bindValue(":tax", cnum($_POST["zei"]), PDO::PARAM_INT);
					$r->bindValue(":total", cnum($_POST["total_price"]), PDO::PARAM_INT);
					$r->bindValue(":memo", renull($_POST["comment"]), PDO::PARAM_STR);
					$r->bindValue(":numberlines", cnum($_POST["counttr"]), PDO::PARAM_INT);
					$r->bindValue(":mainid", cnum($mainid), PDO::PARAM_INT);
					$r->execute();
				}


				for ($a = 1; $a <= cnum($_POST["counttr"]); $a++) {

					if (cnum($_POST["subid" . $a]) == 0 || !empty($_POST["newregi"])) {
						$sql = "INSERT into t_receipt_sub (mid,sname,num,unit,tanka,total,print_order) values (:mid,:sname,:num,:unit,:tanka,:total,:print_order)";
						$r = $dbh->prepare($sql);
						$r->bindValue(":mid", $maxid, PDO::PARAM_INT);
						$r->bindValue(":sname", renull($_POST["hinmei" . $a]), PDO::PARAM_STR);
						$r->bindValue(":num", renull($_POST["kazu" . $a]), PDO::PARAM_STR);
						$r->bindValue(":unit", renull($_POST["tani" . $a]), PDO::PARAM_STR);
						$r->bindValue(":tanka", renull($_POST["tanka" . $a]), PDO::PARAM_STR);
						$r->bindValue(":total", renull($_POST["goukei" . $a]), PDO::PARAM_STR);
						$r->bindValue(":print_order", $a, PDO::PARAM_INT);
						$r->execute();
					} else {
						$sql = "UPDATE t_receipt_sub set sname=:sname,num=:num,unit=:unit,tanka=:tanka,total=:total,print_order=:print_order Where id=:subid";
						$r = $dbh->prepare($sql);
						$r->bindValue(":sname", renull($_POST["hinmei" . $a]), PDO::PARAM_STR);
						$r->bindValue(":num", renull($_POST["kazu" . $a]), PDO::PARAM_STR);
						$r->bindValue(":unit", renull($_POST["tani" . $a]), PDO::PARAM_STR);
						$r->bindValue(":tanka", renull($_POST["tanka" . $a]), PDO::PARAM_STR);
						$r->bindValue(":total", renull($_POST["goukei" . $a]), PDO::PARAM_STR);
						$r->bindValue(":print_order", $a, PDO::PARAM_INT);
						$r->bindValue(":subid", cnum($_POST["subid" . $a]), PDO::PARAM_INT);
						$r->execute();
					}
				}
				?>
				<p>登録されました。</p>



				<p><a href="receipts_list.php?t=<?= $_REQUEST["t"] ?>" class="underline"><?= $chohyou ?>履歴一覧へ戻る</a></p>
			</div>


		</div>

	</div>

	</div>


</body>

</html>