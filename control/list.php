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


			$(".disp_btn").click(function() {

				var yid = $(this).attr("id");

				id = yid.replace("disp_", "");

				$.ajax({
					type: "get",
					url: "js/disp.php",
					data: "id=" + id,
					success: function(str) {
						if (str == "success0") {
							$("#disp_" + id).val("表示にする");
							$("#tr_" + id).css("background-color", "#ccc");
						} else {
							$("#disp_" + id).val("非表示にする");
							$("#tr_" + id).css("background-color", "#fff");
						}
					}
				});
			});


			$('#jquery-ui-sortable > tbody').sortable({
				cursor: 'move',
				opacity: 0.7,
				placeholder: 'ui-state-highlight',


				update: function(ev, ui) {
					var Arraytr = $("#jquery-ui-sortable > tbody").sortable("toArray");
					var num = Arraytr.length;

					var newch = 0;
					if ($("#news_chk").is(":checked")) {
						newch = 1;

					}
					var idnames;
					var idn = new String();
					var onum = "";
					var coun = 0;
					for (var i = 0; i < num; i++) {

						idn = Arraytr[i].replace("tr_", "");


						idnames = $("#" + Arraytr[i]).find(".pordernumber").attr("id");

						$("#" + idnames).val(coun);
						$.ajax({
							type: "get",
							url: "js/orderchange.php",
							data: "id=" + idn + "&num=" + coun,
							success: function(str) {
								if (str == "success") {
									//alert("成功");
								} else {
									//alert("エラーが起こりました。\n登録は完了していない可能性があります。");
								}
							}
						});
						coun = coun + 10;
					}


				},
				stop: function(ev, ui) {

					ui.item.children('td').effect('highlight');
				}

			}).bind('click.sortable mousedown.sortable', function(ev) {
				ev.target.focus();
			});
			//$('#jquery-ui-sortable > tbody').disableSelection();

		});
	</script>

	<title>今週末野菜狩りのできる野菜一覧【<?= $kanriname ?>】</title>
</head>

<body>
	<?php
	if ($goodsadd == 0) {
	?>
		<div id="box" class="kanri">
			<?php include("include/header.php") ?>
			<div id="main">

				<div id="cnt">
					<h2>今週末野菜狩りのできる野菜一覧</h2>
					<h3>新規野菜登録</h3>
					<div class="block">
						<p><a href="disp.php">新規登録</a></p>
					</div>






					<?php

					if (isset($_POST["update"])) {

						$ccnt = cnum($_POST["ccnt"]);

						for ($a = 1; $a <= $ccnt; $a++) {
							$sql = "UPDATE t_master set print_order =:orderno Where id=:id";
							$g = $dbh->prepare($sql);
							$g->bindValue(":orderno", $_POST["order_" . $a], PDO::PARAM_INT);
							$g->bindValue(":id", $_POST["id_" . $a], PDO::PARAM_INT);
							$g->execute();
						}
					}


					$sql = "select t_master.*,t_cuser.company,t_cuser.name as cname from t_master left join t_cuser on t_master.uid=t_cuser.id order by t_master.print_order,t_master.id desc";
					$m = $dbh->prepare($sql);
					$m->execute();
					$result = $m->fetchAll(PDO::FETCH_ASSOC);

					$sql = "select count(t_master.id) as co from t_master";
					$c = $dbh->prepare($sql);
					$c->execute();
					$rsco = $c->fetch(PDO::FETCH_ASSOC);
					$count = $rsco["co"];


					?>

					<h3>野菜一覧</h3>
					<div class="block">
						<?php
						if (!$result) {
							echo "<p>登録はありません</p>";
						} else {
							echo "<p>{$count}件の該当がありました。</p>";
						?>

							<p class="red bold">並び替えの方法：テーブルの行を任意の場所にドラック＆ドロップしてください。</p>

							<form action="list.php" method="post">
								<input type="submit" name="update" value="更新" />
								<table id="jquery-ui-sortable">
									<thead>
										<tr>
											<th style="width:5%;">表示</th>
											<th style="width:5%;">詳細</th>
											<th style="width:5%;">並び順</th>
											<th style="width:10%;">画像</th>
											<th style="width:30%;" class="url">商品名</th>
											<th style="width:10%;">生産者名</th>
											<th style="width:5%;">販売数量</th>
											<th style="width:5%;">販売価格</th>
											<th style="width:10%;" class="date">登録日</th>


										</tr>
									</thead>
									<tbody>
										<?php
										$cnt = 0;
										foreach ($result as $rs) {
											$cnt++;
											$id = $rs["id"];

											if (!$rs["disp"]) {
												$classname = " style='background-color:#ccc;'";
											} else {
												$classname = "";
											}
										?>
											<tr<?= $classname ?> id="tr_<?= $id ?>">
												<td class="centering">

													<input type="button" name="disp_btn" id="disp_<?= $id ?>" class="disp_btn" value="<?= ($rs["disp"] == 1) ? "非表示にする" : "表示にする" ?>" />
													<input type="hidden" name="id_<?= $cnt ?>" value="<?= $id ?>" />
												</td>
												<td class="centering"><a href="disp.php?id=<?= $id ?>">詳細</a></td>
												<td class="centering"><input type="text" name="order_<?= $cnt ?>" id="order_<?= $cnt ?>" value="<?= $rs["print_order"] ?>" size="2" class="pordernumber" /></td>

												<td class="centering">
													<?php
													if (!empty($rs["image1"])) {
														$imagename = $photoimg . "goods/" . $rs["image1"];
													} else {
														$imagename = "http://www.okamoto-farm.co.jp/img/top/image01.jpg";
													}
													?>
													<img src="<?= $imagename ?>" width="200" />
												</td>
												<td class="url">
													<a href="disp.php?id=<?= $id ?>"><?= $rs["item"] ?></a>
												</td>
												<td><? if (!empty($rs["farmer"])) {
														echo $rs["farmer"];
													} elseif ($rs["uid"] == 0 && empty($rs["farmer"])) {
														echo "東浪見岡本農園";
													} elseif (!empty($rs["company"])) {
														echo $rs["company"];
													} else {
														echo $rs["cname"];
													}
													?></td>
												<td class="centering"><?= $rs["num"] . $rs["unit"] ?></td>
												<td class="right"><?= number_format($rs["price"]) ?>円</td>
												<td class="date"><?= $rs["indate"] ?></td>

												</tr>
											<?php
										}
											?>
									</tbody>
								</table>

								<input type="submit" name="update" value="更新" />
								<input type="hidden" name="ccnt" value="<?= $cnt ?>" />
							</form>
					<?php
						}
					}
					?>
					</div>

				</div>
				<?php include("include/leftpane.php") ?>
			</div>
		</div>

</body>

</html>