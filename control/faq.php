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
			registEnd("faq.php");
		});
	</script>
	<?php
	if (!empty($_POST["question"]) && !empty($_POST["answer"])) {
		$sql = "INSERT into t_faq (q,a,in_date,print_order,bunrui1id) values (:q,:a,:in_date,:print_order,:bunrui1id)";
		$n = $dbh->prepare($sql);
		$n->bindValue(":q", $_POST["question"], PDO::PARAM_STR);
		$n->bindValue(":a", $_POST["answer"], PDO::PARAM_STR);
		$n->bindValue(":in_date", date('Y-m-d H:i:s'), PDO::PARAM_STR);
		$n->bindValue(":print_order", $_POST["print_order"], PDO::PARAM_INT);
		$n->bindValue(":bunrui1id", $_POST["cateid"], PDO::PARAM_INT);
		$n->execute();
		header("location:faq.php");
	}


	$webmax = 20;
	$nowpoint = cnum($_REQUEST["point"]);
	$maxco = $nowpoint + 10;


	$sql = "SELECT * from t_faq ";
	$sql .= " order by in_date desc,id desc";
	$sql .= " LIMIT " . $nowpoint . "," . $webmax;
	$cate = $dbh->prepare($sql);
	$cate->execute();
	$result = $cate->fetchAll(PDO::FETCH_ASSOC);

	$sql = "SELECT count(*) as cnt from t_faq";
	$c = $dbh->prepare($sql);
	$c->execute();
	$rcnt = $c->fetch(PDO::FETCH_ASSOC);
	$count = $rcnt["cnt"];

	$joken = "";

	?>
	<title>FAQ登録【<?= $kanriName ?>】</title>
</head>

<body>
	<div id="box" class="kanri">
		<?php include("include/header.php") ?>

		<div id="main">
			<?php include("include/leftpane.php") ?>
			<div id="cnt">

				<h2>FAQ登録</h2>

				<?php
				if (empty($_POST)) {
				?>
					<div class="block">
						<p>FAQ登録を行うことができます。</p>
					</div>


					<h3>FAQの追加</h3>
					<form method="post" action="faq.php" onsubmit="return signup(this)">
						<div class="block">
							<table>
								<tbody>

									<tr>
										<th>カテゴリ</th>
										<td>
											<select name="cateid" id="cateid">
												<option value="">選択してください</option>
												<?php
												$sql = "select * from t_faq_category order by print_order,id";
												$cate = $dbh->prepare($sql);
												$cate->execute();
												$result2 = $cate->fetchAll(PDO::FETCH_ASSOC);
												foreach ($result2 as $rs2) {
												?>
													<option value="<?= $rs2["id"] ?>"><?= $rs2["name"] ?></option>
												<?php
												}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<th>質問</th>
										<td><textarea name="question" id="question" rows="4" cols="50" style="width:100%"></textarea></td>
									</tr>
									<tr>
										<th>回答</th>
										<td>

											<textarea name="answer" id="answer" class="naiyou" cols="50" rows="6" style="width:100%"></textarea>
										</td>
									</tr>
									<tr>
										<th>並び順</th>
										<td>
											<input name="print_order" id="print_order" type="text" size="10" value="10" />
										</td>
									</tr>
								</tbody>
							</table>
							<p><input value="この内容で登録する" type="submit" /></p>
						</div>
					</form>

					<h3>FAQ一覧</h3>

					<?= writeNavi("faq.php", $webmax, $nowpoint, $count, $joken) ?>
					<div class="block">
						<?php
						foreach ($result as $rs) {
						?>
							<table>
								<tbody>

									<tr>
										<th>登録日</th>
										<td><?= date('Y-m-d H:i:s', strtotime($rs["in_date"])) ?></td>
									</tr>
									<tr>
										<th>カテゴリ</th>
										<td>
											<?php
											$cateid = $rs["cateid"];
											$sql = "select * from t_faq_category where id = :id";
											$cate = $dbh->prepare($sql);
											$cate->bindValue(":id", $rs["bunrui1id"], PDO::PARAM_INT);
											$cate->execute();
											$rs2 = $cate->fetch(PDO::FETCH_ASSOC);
											echo $rs2["name"];
											?>
										</td>
									</tr>
									<tr>
										<th>質問</th>
										<td><?= nl2br($rs["q"]) ?></td>
									</tr>
									<tr>
										<th>回答</th>
										<td><?= nl2br($rs["a"]) ?></td>
									</tr>
									<tr>
										<td colspan="2">
											<a href="faq_02.php?id=<?= $rs["id"] ?>">編集</a>　<span class="delbtn faqdel" id="delid<?= $rs["id"] ?>" title="<?= $rs["q"] ?>">削除</span>　<span><a href="<?= $esurl ?>faq_detail.php?id=<?= $rs["id"] ?>" target="_blank" class="underline">詳細を表示</a></span>
										</td>
									</tr>
								</tbody>
							</table>
						<?php
						}
						?>
						<?= writeNavi("faq.php", $webmax, $nowpoint, $count, $joken) ?>
					</div>
				<?php
				}
				?>
			</div>

		</div>
	</div>


</body>

</html>