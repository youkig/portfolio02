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
			registEnd("news.php");
		});
	</script>
	<?php
	if (!empty($_POST["title"]) && !empty($_POST["naiyou"])) {
		$sql = "INSERT into t_news (title,naiyo,indate,disp) values (:title,:naiyo,:indate,:disp)";
		$n = $dbh->prepare($sql);
		$n->bindValue(":title", $_POST["title"], PDO::PARAM_STR);
		$n->bindValue(":naiyo", $_POST["naiyou"], PDO::PARAM_STR);
		$n->bindValue(":indate", date('Y-m-d', strtotime($_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"])), PDO::PARAM_STR);
		$n->bindValue(":disp", $_POST["disp"], PDO::PARAM_INT);
		$n->execute();
		header("location:news.php");
	}



	$webmax = 20;
	$nowpoint = cnum($_REQUEST["point"]);
	$maxco = $nowpoint + 10;

	$sql = "SELECT * from t_news order by indate desc,id desc";
	$sql .= " LIMIT " . $nowpoint . "," . $webmax;
	$news = $dbh->prepare($sql);
	$news->execute();
	$result = $news->fetchAll(PDO::FETCH_ASSOC);

	$sql = "SELECT count(*) as cnt from t_news ";
	$c = $dbh->prepare($sql);
	$c->execute();
	$rcnt = $c->fetch(PDO::FETCH_ASSOC);
	$count = $rcnt["cnt"];
	$joken = "";
	?>
	<title>HP管理 &gt; お知らせ編集【<?= $kanriName ?>】</title>
</head>

<body>
	<div id="box" class="kanri">
		<?php include("include/header.php") ?>

		<div id="main">
			<?php include("include/leftpane.php") ?>
			<div id="cnt">

				<h2>お知らせ編集</h2>

				<?php
				if (empty($_POST)) {
				?>
					<div class="block">
						<p>お知らせ（新着情報）の設定を行うことができます。</p>
					</div>


					<h3>お知らせの追加</h3>
					<form method="post" action="news.php" onsubmit="return signup(this)">
						<div class="block">
							<table>
								<tbody>
									<tr>
										<th>日付</th>
										<td>
											<p>西暦<input name="year" id="year" type="text" size="10" value="<?= date('Y') ?>" />年
												　<input name="month" id="month" type="text" size="10" value="<?= date('m') ?>" />月
												　<input name="day" id="day" type="text" size="10" value="<?= date('d') ?>" />日</p>
										</td>
									</tr>
									<tr>
										<th>タイトル</th>
										<td><input name="title" id="title" type="text" size="60" /></td>
									</tr>
									<tr>
										<th>内容</th>
										<td>

											<textarea name="naiyou" id="naiyou" class="naiyou" cols="50" rows="6" style="width:100%"></textarea>
										</td>
									</tr>
									<tr>
										<th>公開設定</th>
										<td>
											<ul class="inline">
												<li><label for="disp1"><input type="radio" value="1" name="disp" id="disp1" checked="checked" /> 公開</label></li>
												<li><label for="disp0"><input type="radio" value="0" name="disp" id="disp0" /> 下書き</label></li>

											</ul>
										</td>
									</tr>
								</tbody>
							</table>
							<p><input value="この内容で登録する" type="submit" /></p>
						</div>
					</form>

					<h3>お知らせ一覧</h3>

					<?= writeNavi("news.php", $webmax, $nowpoint, $count, $joken) ?>
					<div class="block">
						<?php
						foreach ($result as $rs) {
						?>
							<table>
								<tbody>
									<tr>
										<th>公開設定</th>
										<td><?php
											if ($rs["disp"] == true) {
												echo "[公開]";
											}
											?></td>
									</tr>
									<tr>
										<th>日付</th>
										<td><?= date('Y-m-d', strtotime($rs["indate"])) ?></td>
									</tr>
									<tr>
										<th>タイトル</th>
										<td><?= $rs["title"] ?></td>
									</tr>
									<tr>
										<th>内容</th>
										<td><?= nl2br($rs["naiyo"]) ?></td>
									</tr>
									<tr>
										<td colspan="2">
											<a href="news_02.php?id=<?= $rs["id"] ?>">編集</a>　<span class="delbtn newdel" id="delid<?= $rs["id"] ?>" title="<?= $rs["title"] ?>">削除</span>
										</td>
									</tr>
								</tbody>
							</table>
						<?php
						}
						?>
						<?= writeNavi("news.php", $webmax, $nowpoint, $count, $joken) ?>
					</div>
				<?php
				}


				?>
			</div>

		</div>
	</div>


</body>

</html>