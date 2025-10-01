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
			registEnd("news.php");
		});
	</script>
	<?php
	if (!empty($_POST['submit'])) {
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
		$starttime2 = $_POST['starttime2'];
		$endtime2 = $_POST['endtime2'];

		if (!empty($starttime) && !empty($endtime) && !empty($starttime2) && !empty($endtime2)) {

			$sql = "UPDATE t_bhours SET starttime=:starttime, endtime=:endtime WHERE id=1";
			$h = $dbh->prepare($sql);
			$h->bindParam(':starttime', $starttime, PDO::PARAM_STR);
			$h->bindParam(':endtime', $endtime, PDO::PARAM_STR);
			$h->execute();

			$sql = "UPDATE t_bhours SET starttime=:starttime, endtime=:endtime WHERE id=2";
			$h = $dbh->prepare($sql);
			$h->bindParam(':starttime', $starttime2, PDO::PARAM_STR);
			$h->bindParam(':endtime', $endtime2, PDO::PARAM_STR);
			$h->execute();

			echo "<script>alert('営業時間を更新しました。');</script>";
			echo "<script>location.href='bisiness_hours.php';</script>";
			exit;
		} else {
			echo "<script>alert('営業時間の入力が不完全です。');</script>";
		}
	}
	?>
	<title>HP管理 &gt; 営業時間 編集【<?= $kanriName ?>】</title>
</head>

<body>
	<div id="box" class="kanri">
		<?php include("include/header.php") ?>

		<div id="main">
			<?php include("include/leftpane.php") ?>
			<div id="cnt">

				<h2>営業時間 編集</h2>

				<?php
				if ($_SERVER["REQUEST_METHOD"] !== "POST") {
				?>
					<div class="block">
						<p>営業時間の編集を行うことができます。</p>
					</div>


					<h3>営業時間設定</h3>
					<form method="post" action="bisiness_hours.php">
						<div class="block">

							<table>
								<tbody>

									<?php
									$sql = "SELECT * From t_bhours Where id=1";
									$h = $dbh->prepare($sql);
									$h->execute();
									$hrs = $h->fetch(PDO::FETCH_ASSOC);
									?>
									<tr>
										<th>トップページに表示させる営業時間</th>
										<td>
											<input type="text" name="starttime" value="<?= $hrs['starttime'] ?>" size="20" maxlength="20" /> ～
											<input type="text" name="endtime" value="<?= $hrs['endtime'] ?>" size="20" maxlength="20" />　<a href="<?= $esurl ?>" target="_blank" class="underline">トップページ表示確認</a>
										</td>
									</tr>
									<?php
									$sql = "SELECT * From t_bhours Where id=2";
									$h = $dbh->prepare($sql);
									$h->execute();
									$hrs = $h->fetch(PDO::FETCH_ASSOC);
									?>

									<tr>
										<th>野菜狩りのページに表示させる営業時間</th>
										<td>
											<input type="text" name="starttime2" value="<?= $hrs['starttime'] ?>" size="20" maxlength="20" /> ～
											<input type="text" name="endtime2" value="<?= $hrs['endtime'] ?>" size="20" maxlength="20" />　<a href="<?= $esurl ?>yoyakuform01" target="_blank" class="underline">表示確認</a>
										</td>
									</tr>

								</tbody>
							</table>
							<p><input value="この内容で登録する" type="submit" name="submit" /></p>
						</div>
					</form>



				<?php

				}
				?>
			</div>

		</div>
	</div>


</body>

</html>