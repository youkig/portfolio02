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
	<script type="text/javascript">
		$(function() {
			registEnd("faqcate.php");

		});
	</script>
	<?php
	if (isset($_POST["submit"])) {


		if (!empty($_POST["name"])) {

			$sql = "INSERT into t_faq_category (name,print_order) values (:name,:print_order)";
			$b2 = $dbh->prepare($sql);
			$b2->bindValue(":name", renull($_POST["name"]), PDO::PARAM_STR);
			$b2->bindValue(":print_order", cnum($_POST["print_order"]), PDO::PARAM_STR);
			$b2->execute();
		}

		$cnt = cnum($_POST["cnt"]);
		for ($i = 1; $i <= $cnt; $i++) {
			$id = cnum($_POST["id_" . $i]);
			$sql = "UPDATE t_faq_category set name=:name,print_order=:print_order Where id=:id";
			$b2 = $dbh->prepare($sql);
			$b2->bindValue(":name", $_POST["name_" . $i], PDO::PARAM_STR);
			$b2->bindValue(":print_order", $_POST["print_order_" . $i], PDO::PARAM_INT);
			$b2->bindValue(":id", $id, PDO::PARAM_INT);
			$b2->execute();
		}
		header("location:faqcate.php");
	}



	$sql = "select * from t_faq_category order by print_order,id";
	$b2 = $dbh->prepare($sql);
	$b2->execute();
	$result2 = $b2->fetchAll(PDO::FETCH_ASSOC);




	$sql = "select max(print_order) as max from t_faq_category";
	$bmax = $dbh->prepare($sql);
	$bmax->execute();
	$rsmax = $bmax->fetch(PDO::FETCH_ASSOC);

	$order_max = $rsmax["max"];

	if (cnum($order_max) == 0) {
		$order_max = 1;
	} else {
		$order_max += 10;
	}

	?>
	<title>FAQカテゴリ編集 【<?= $kanriname ?>】</title>
</head>

<body>

	<div id="box" class="kanri">
		<?php include("include/header.php") ?>

		<div id="main">
			<?php include("include/leftpane.php") ?>
			<div id="cnt">

				<h2>FAQカテゴリ編集</h2>

				<div class="block">
					<p>FAQカテゴリの編集を行います。</p>

				</div>

				<h3>FAQカテゴリの新規登録・編集</h3>
				<form action="faqcate.php" method="post">
					<div class="block">
						<table>
							<thead>
								<tr>
									<th style="width:100px;">ID</th>
									<th>カテゴリ名</th>

									<th>並び順</th>

									<th>削除</th>
								</tr>
							</thead>
							<tbody>
								<tr class="regist_tr">
									<td class="centering">新規登録</td>
									<td><input type="text" size="18" name="name" id="name" value="" style="width:80%;" /></td>

									<td class="centering"><input type="text" size="4" name="print_order" id="print_order" value="<?= $order_max ?>" /></td>

									<td class="centering">　</td>
								</tr>
								<?php
								$cnt = 0;
								foreach ($result2 as $rs) {
									$cnt++;
									$id = $rs["id"];

								?>
									<tr>
										<td class="centering"><?= $id ?>
											<input type="hidden" name="id_<?= $cnt ?>" value="<?= $id ?>" />
										</td>
										<td><input type="text" size="18" name="name_<?= $cnt ?>" id="name_<?= $cnt ?>" value="<?= $rs["name"] ?>" style="width:80%;" /></td>

										<td class="centering"><input type="text" size="4" name="print_order_<?= $cnt ?>" id="print_order_<?= $cnt ?>" value="<?= $rs["print_order"] ?>" /></td>

										<td class="centering"><span class="delbtn faqcatedel" id="delid<?= $id ?>" title="<?= $rs["name"] ?>">削除</span></td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
						<p><input value="この内容で登録する" type="submit" name="submit" /></p>
					</div>

					<input type="hidden" name="cnt" id="cnt" value="<?= $cnt ?>" />
				</form>


			</div>

		</div>
	</div>


</body>

</html>