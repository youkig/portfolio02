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
	<script src="js/news.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(function() {
			var q = getQueryAll(document.URL);
			registEnd("faq_02.php?" + q);
		});
	</script>

	<?php
	// if (!empty($_POST)){
	if (!empty($_POST["question"]) && !empty($_POST["answer"])) {

		$id = cnum($_POST["id"]);
		$sql = "UPDATE t_faq set q=:question,a=:answer,print_order=:print_order Where id=:id";
		$n = $dbh->prepare($sql);
		$n->bindValue(":question", $_POST["question"], PDO::PARAM_STR);
		$n->bindValue(":answer", $_POST["answer"], PDO::PARAM_STR);
		$n->bindValue(":print_order", $_POST["print_order"], PDO::PARAM_INT);
		$n->bindValue(":id", $id, PDO::PARAM_INT);
		$n->execute();

		header("location:faq_02.php?id=" . $id);
	}
	// }
	?>


	<?php
	$id = cnum($_REQUEST["id"]);
	$sql = "select * from t_faq where id = :id";
	$n = $dbh->prepare($sql);
	$n->bindValue(":id", $id, PDO::PARAM_INT);
	$n->execute();
	$rs = $n->fetch(PDO::FETCH_ASSOC);

	if (empty($rs)) {
		header("location:faq.php");
	}

	$y = date('Y', strtotime($rs["in_date"]));
	$m = date('m', strtotime($rs["in_date"]));
	$d = date('d', strtotime($rs["in_date"]));

	?>
	<title>FAQ編集【<?= $kanriName ?>】</title>
</head>

<body>

	<div id="box" class="kanri">
		<?php include("include/header2.php") ?>

		<div id="main">
			<?php include("include/leftpane.php") ?>
			<div id="cnt">

				<h2>FAQ編集</h2>

				<div class="block">
					<p>既存のFAQの編集を行います。</p>
					<p><a href="faq.php">FAQ一覧に戻る</a></p>
				</div>

				<h3>FAQの編集</h3>

				<p><a href="<?= $esurl ?>faq_detail.php?id=<?= $id ?>" target="_blank" class="underline">ホームページ詳細を表示</a></p>
				<form method="post" action="faq_02.php" onsubmit="return signup(this)">
					<div class="block">
						<table>
							<tbody>
								<tr>
									<th>カテゴリ名</th>
									<td>
										<select name="cateid" id="cateid">
											<?php
											$sql = "select * from t_faq_category order by print_order,id";
											$cate = $dbh->prepare($sql);
											$cate->execute();
											$result2 = $cate->fetchAll(PDO::FETCH_ASSOC);
											foreach ($result2 as $rs2) {
											?>
												<option value="<?= $rs2["id"] ?>" <?= selected($rs2["id"], $rs["bunrui1id"]) ?>><?= $rs2["name"] ?></option>
											<?php
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<th>質問</th>
									<td>
										<textarea name="question" id="question" rows="4" cols="50" style="width:100%"><?= $rs["q"] ?></textarea>
									</td>
								</tr>
								<tr>
									<th>回答</th>
									<td>

										<textarea name="answer" id="answer" class="naiyou" cols="50" rows="6" style="width:100%"><?= $rs["a"] ?></textarea>
									</td>
								</tr>
								<tr>
									<th>並び順</th>
									<td>
										<input name="print_order" id="print_order" type="text" size="4" value="<?= $rs["print_order"] ?>" />
									</td>
								</tr>
							</tbody>
						</table>
						<p><input value="この内容で登録する" type="submit" /></p>
						<input type="hidden" name="id" value="<?= $id ?>" />
					</div>
				</form>

			</div>

		</div>
	</div>

</body>

</html>