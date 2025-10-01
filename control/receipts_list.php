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
	<link rel="stylesheet" href="js/jquery.ui.css">
	<style>
		<!--
		.ui-state-highlight {
			height: 6em;
			border: dotted 2px #FF9900;
		}
		-->
	</style>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript">
		$(function() {

			//$('#jquery-ui-sortable > tbody').sortable();


			$(".delete_btn").click(function() {

				var yid = $(this).attr("id");

				id = yid.replace("delete_", "");

				if (window.confirm("本当に削除してよろしいですか？")) {
					$.ajax({
						type: "get",
						url: "js/delete_receipts.php",
						data: "id=" + id,
						success: function(str) {
							window.location.reload();
						}
					});
				}
			});



			//$('#jquery-ui-sortable > tbody').disableSelection();

		});
	</script>

	<?php
	if (cnum($_REQUEST["t"]) == 1) {
		$cyohyou = "請求";
	} elseif (cnum($_REQUEST["t"]) == 2) {
		$cyohyou = "納品";
	} elseif (cnum($_REQUEST["t"]) == 3) {
		$cyohyou = "見積";
	} else {
		$cyohyou = "領収";
	}
	?>
	<title><?= $cyohyou ?>書履歴一覧【<?= $kanriName ?>】</title>
</head>

<body>

	<div id="box" class="kanri">
		<?php include("include/header.php") ?>
		<div id="main">

			<div id="cnt">
				<h2><?= $cyohyou ?>書履歴一覧</h2>
				<h3>新規<?= $cyohyou ?>書登録</h3>
				<div class="block">
					<p><a href="print_sheet01.php?t=<?= cnum($_REQUEST["t"]) ?>" target="_blank">新規<?= $cyohyou ?>書登録（非会員）</a></p>
					<p>※会員の場合は、会員詳細ページから登録してください</p>
				</div>


				<?php
				if (!empty($_POST["update"])) {
					$ccnt = cnum($_POST["ccnt"]);
					for ($a = 1; $a <= $ccnt; $a++) {
						$sql = "UPDATE t_master set print_order = :order Where id=:id";
						$m = $dbh->prepare($sql);
						$m->bindValue(":order", $_POST["order_" . $a], PDO::PARAM_INT);
						$m->bindValue(":id", $_POST["id_" . $a], PDO::PARAM_INT);
						$m->execute();
					}
				}
				$webmax = 20;
				$nowpoint = cnum($_REQUEST["point"]);
				$maxco = $nowpoint + 10;

				$sql = "select t_receipt_master.*,t_cuser.company,t_cuser.name as cname";
				$sqlf = " from t_receipt_master left join t_cuser on t_receipt_master.uid=t_cuser.id Where (t_receipt_master.dele is null or t_receipt_master.dele=0) AND t_receipt_master.syubetsu=:tid"; //& clng2(request2("t"))

				$sqlo = " order by t_receipt_master.indate desc";
				$sqll = " LIMIT " . $nowpoint . "," . $webmax;
				$r = $dbh->prepare($sql . $sqlf . $sqlo . $sqll);
				$r->bindValue(":tid", cnum($_REQUEST["t"]), PDO::PARAM_INT);
				$r->execute();
				$result = $r->fetchAll(PDO::FETCH_ASSOC);

				$sql = "select count(t_receipt_master.id) as co" . $sqlf;
				$c = $dbh->prepare($sql);
				$c->bindValue(":tid", cnum($_REQUEST["t"]), PDO::PARAM_INT);
				$c->execute();
				$rsco = $c->fetch(PDO::FETCH_ASSOC);
				$count = $rsco["co"];

				$maxco = $nowpoint + 10;

				$nowco = 0;
				if ($maxco > $count) {
					$maxco = $count;
				}
				$maxco2 = $maxco - $nowpoint;

				foreach ($_GET as $key => $val) {
					if ($key !== "point") {
						if (!empty($joken)) {
							$joken .= "&amp;";
						}
						$joken .= $key . "=" . $val;
					}
				}


				?>

				<h3><?= $cyohyou ?>書一覧</h3>
				<div class="block">
					<?php
					if (!$result) {
						echo "<p>登録はありません</p>";
					} else {
						echo "<p>{$count}件の該当がありました。</p>";
						echo writeNavi("receipts_list.php", $webmax, $nowpoint, $count, $joken)
					?>



						<form action="receipts_list.php" method="post">
							<table id="jquery-ui-sortable">
								<thead>
									<tr>

										<th style="width:5%;">詳細</th>
										<th style="width:10%;">宛名</th>
										<th style="width:20%;">件名</th>
										<th style="width:10%;" class="date">登録日</th>
										<th style="width:5%;">削除</th>


									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($result as $rs) {
										$cnt++;
										$in_date = $rs["indate"];
										$id = $rs["id"];

										if ($rs["taikai"] == 1) {
											$classname = " style='background-color:#ccc;'";
										} else {
											$classname = "";
										}

									?>
										<tr<?= $classname ?> id="tr_<?= $id ?>">

											<td class="centering"><a href="print_sheet01.php?pid=<?= $id ?>&t=<?= $_REQUEST["t"] ?>" target="_blank">詳細</a></td>

											<td><?= $rs["address"] ?></td>
											<td><?= $rs["subj"] ?></td>
											<td class="date"><?= date('Y-m-d', strtotime($rs["indate"])) ?></td>
											<td class="centering"><input type="button" name="delete_btn" id="delete_<?= $rs["id"] ?>" class="delete_btn" value="削除する"></td>
											</tr>
										<?php

										if ($cnt == $webmax) {
											break;
										}
									}
										?>
								</tbody>
							</table>


						</form>
					<?php

					}
					?>
				</div>

			</div>
			<?php include("include/leftpane.php") ?>
		</div>
	</div>

</body>

</html>