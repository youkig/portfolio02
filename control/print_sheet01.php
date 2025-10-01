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

	<?php
	if (1 == 2) {
	?>
		<!--#include file="include/js.inc"-->
		<script src="https://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3-https.js" charset="UTF-8"></script>
	<?php
	}
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script type="text/javascript">
		$(function() {
			$(document).on('click', "#addBtn", function() {
				var i = "";
				i = $("#counttr").val();
				i = parseInt(i, 10) + 1
				var ht = "";
				ht = "<tr>\n";
				ht = ht + "<th>" + i + "</th>\n";
				ht = ht + "<td><input type='text' name='hinmei" + i + "' id='hinmei" + i + "' value='' /></td>\n";
				ht = ht + "<td><input type='text' name='kazu" + i + "' id='kazu" + i + "' value='' size='2' class='kazu_cal' /></td>\n";
				ht = ht + "<td><input type='text' name='tani" + i + "' id='tani" + i + "' value='' size='2' /></td>\n";
				ht = ht + "<td>\\<input type='text' name='tanka" + i + "' id='tanka" + i + "' value='' size='4' class='tanka_cal' /></td>\n";
				ht = ht + "<td>\\<input type='text' name='goukei" + i + "' id='goukei" + i + "' value='' size='4' class='goukei_cal' /></td>\n";
				ht = ht + "</tr>"
				//alert(ht);
				$("#lasttr").before(ht);
				$("#counttr").val(i);
			});


			$(document).on("change", ".kazu_cal", function() {
				var kid = $(this).attr("id");
				kid = kid.replace('kazu', '');
				var kazu = $(this).val();
				var tanka = $("#tanka" + kid).val();

				var goukei = parseFloat(kazu, 10) * parseInt(tanka, 10);
				if (goukei) {
					$("#goukei" + kid).val(goukei);
				};
				var cal = 0;
				var cal2 = 0;
				$(".goukei_cal").each(function(i, o) {
					cal = $(o).val()
					if (cal) {
						cal2 = cal2 + parseInt(cal, 10);
					}
				});

				$("#syokei").val(cal2);
				//$("#zei").val(cal2 * 0.1);
				//$("#total_price").val(cal2 + cal2 * 0.1);
				$("#total_price").val(cal2);
				var total = $("#total_price").val();
				$("#price").html("\\" + Number(total).toLocaleString());
			});

			$(document).on("change", ".tanka_cal", function() {
				var kid = $(this).attr("id");
				kid = kid.replace('tanka', '');
				var tanka = $(this).val();
				var kazu = $("#kazu" + kid).val();
				var goukei = parseFloat(kazu, 10) * parseInt(tanka, 10);

				if (goukei) {
					$("#goukei" + kid).val(goukei);
				};
				var cal = 0;
				var cal2 = 0;
				$(".goukei_cal").each(function(i, o) {
					cal = $(o).val()
					if (cal) {
						cal2 = cal2 + parseInt(cal, 10);
					}
				});

				$("#syokei").val(cal2);
				//$("#zei").val(cal2 * 0.1);
				//$("#total_price").val(cal2 + cal2 * 0.1);
				$("#total_price").val(cal2);
				var total = $("#total_price").val();
				$("#price").html("\\" + Number(total).toLocaleString());
			});

		});
	</script>

	<?php

	$id = cnum($_REQUEST["id"]);
	$uid = cnum($_REQUEST["uid"]);
	if ($id !== 0) {
		$sql = "select * from t_cuser where id = :id";
		$c = $dbh->prepare($sql);
		$c->bindValue(":id", $id, PDO::PARAM_INT);
		$c->execute();
		$rs = $c->fetch(PDO::FETCH_ASSOC);
	} elseif ($uid !== 0) {
		$sql = "select * from t_user where id = :uid";
		$c = $dbh->prepare($sql);
		$c->bindValue(":uid", $uid, PDO::PARAM_INT);
		$c->execute();
		$rs = $c->fetch(PDO::FETCH_ASSOC);
	}

	$errorm = "";
	if (!empty($_REQUEST["pid"])) {
		$sql = "SELECT t_receipt_master.*,t_receipt_sub.id as id2,t_receipt_sub.sname,t_receipt_sub.num,t_receipt_sub.unit,t_receipt_sub.tanka,t_receipt_sub.total as total2 From t_receipt_master inner join t_receipt_sub on t_receipt_master.id = t_receipt_sub.mid Where t_receipt_master.id=:pid"; //& clng2(request("pid"))
		$r = $dbh->prepare($sql);
		$r->bindValue(":pid", cnum($_REQUEST["pid"]), PDO::PARAM_INT);
		$r->execute();

		$rsp = $r->fetch(PDO::FETCH_ASSOC);

		if (!$rsp) {
			$errorm = "<p>該当のデータがありません</p>";
		}
	}


	//'重機レンタル
	if (cnum($_REQUEST["r"] !== 0)) {
		$sql = "SELECT t_productorder.*,t_proreserved.price,t_proreserved.cleaning,t_product.sname,t_product.modelnumber,t_product.cleaning as cleaningprice";
		$sql .= " From t_productorder inner join t_proreserved on t_productorder.id = t_proreserved.uid inner join t_product on t_proreserved.sid = t_product.id";
		$sql .= " Where t_productorder.id=:r";
		$p = $dbh->prepare($sql);
		$p->bindValue(":r", $_REQUEST["r"], PDO::PARAM_INT);
		$p->execute();

		$res = $p->fetch(PDO::FETCH_ASSOC);
		if ($res) {
			$id = cnum($_REQUEST["r"]);
			$company = $rs["company"];
			$name = $rs["name"];
			$subject = "レンタル農機代金";
			foreach ($res as $rs) {
				$total += $rs["price"];
				if ($rs["cleaning"] == 1) {
					$total += $rs["cleaningprice"];
				}
			}
		}
	}
	?>

	<title>帳票印刷【<?= $kanriName ?>】</title>
</head>

<body>
	<div id="box3" class="kanri">



		<div id="cnt3" class="print_sheet">
			<h2>帳票印刷</h2>



			<?php
			if (!empty($errorm)) {
				echo $errorm;
			} else {
				$mainid = rers($rsp, "id", "");
				$syokei = rers($rsp, "subtotal", "");
				$zei = rers($rsp, "tax", "");
				if (!empty(rers($rsp, "total", ""))) {
					$total = rers($rsp, "total", "");
				}
				$biko = rers($rsp, "memo", "");
				$gyosu = rers($rsp, "numberlines", 8);

				if (cnum($_REQUEST["t"]) == 2) {
					$chohyou = "納品書";
					$text = "下記の通り、納品いたします。";
				} elseif (cnum($_REQUEST["t"]) == 1) {
					$chohyou = "請求書";
					$Atext = "下記の通り、ご請求申し上げます。";
				} elseif (cnum($_REQUEST["t"]) == 3) {
					$chohyou = "見積書";
					$Atext = "下記の通り、お見積書をご提出いたします。";
				} else {
					$chohyou = "領収書";
					$text = "下記、正に領収いたしました。";
				}
			?>

				<h3><?= $chohyou ?></h3>

				<form action="print_sheet02.php" method="post">
					<input type="hidden" name="id" value="<?= $id ?>" />
					<input type="hidden" name="uid" value="<?= $uid ?>" />
					<input type="hidden" name="mid" value="<?= $mainid ?>" />
					<input type="hidden" name="t" value="<?= $_REQUEST["t"] ?>" />
					<div class="block container">
						<div class="leftbox">
							<?php
							if (!empty(rers($rsp, "address", ""))) {
								$names = rers($rsp, "address", "");
							} elseif (!empty(rers($rs, "company", ""))) {
								$names = rers($rs, "company", "");
							} else {
								$names = rers($rs, "name", "");
							}
							?>
							<p class="cname"><input type="text" name="name" id="name" size="17" value="<?= $names ?>" /> 様</p>

							<p style="margin-bottom:20px;"><?= $text ?></p>

							<table class="titles">
								<tr>
									<th>件名</th>
									<td><input type="text" name="subtitle" id="subtitle" value="<?= rers($rsp, "subj", $subject) ?>" /></td>
								</tr>
							</table>

							<table class="totalprice">
								<tr>
									<th>合計金額</th>
									<td class="price" id="price">￥<?= number_format(cnum($total)) ?></td>
									<td class="zei">（税込）</td>
								</tr>
							</table>
							<p>※合計金額は自動計算されます</p>
						</div>

						<div class="rightbox">
							<p><?= $chohyou ?>No. <?php if (!empty(rers($rsp, "NO", ""))) {
														echo sprintf('%06d', rers($rsp, "NO", ""));
													} ?><input type="hidden" name="rno" value="<?php if (!empty(rers($rsp, "NO", ""))) {
																									echo sprintf('%06d', rers($rsp, "NO", ""));
																								} ?>" /><br />
								発行日:<input type="text" name="indate" value="<?= date('Y/m/d', strtotime(rers($rsp, "indate", date('Y-m-d')))) ?>" /></p>

							<p class="address">〒299-4303<br />
								千葉県長生郡一宮町東浪見4721番<br />
								（東浪見岡本農園）【太陽と野菜の直売所】<br />
								農園責任者：岡本　洋<br />
								TEL：0475-40-0831

							</p>

							<?php
							if (cnum($_REQUEST["t"]) == 1) {
							?><p>[振込先口座]<br />・<span style="font-size:80%;">房総信用組合 一宮支店 普通 2140004<br />株式会社 東浪見岡本農園</span></p>
							<?php
							}
							?>

						</div>
						<!--block-->
					</div>

					<p><input type="button" name="add" id="addBtn" value="明細の行を追加" /></p>

					<div class="block">
						<table class="meisai" id="meisai">
							<thead>
								<tr>
									<th>　</th>
									<th>品名</th>
									<th>数量</th>
									<th>単位</th>
									<th>単価（税抜）</th>
									<th>合計（税抜）</th>
								</tr>
							</thead>

							<tbody>
								<?php
								$ccount = 8;
								if (!empty(rers($rsp, "", ""))) {
									$ccount = rers($rsp, "numberlines", "");
								}

								if (cnum(rers($rsp, "id", "")) !== 0) {
									$b = 0;
									$sql = "SELECT * From t_receipt_sub Where mid=:pid";
									$r = $dbh->prepare($sql);
									$r->bindValue(":pid", cnum($_REQUEST["pid"]), PDO::PARAM_INT);
									$r->execute();
									$result = $r->fetchAll(PDO::FETCH_ASSOC);
									if ($result) {
										foreach ($result as $rsr) {

											$b++;
								?>
											<tr>
												<th><?= $b ?><input type="hidden" name="subid<?= $b ?>" value="<?= $rsr["id"] ?>" /></th>
												<td><input type="text" name="hinmei<?= $b ?>" id="hinmei<?= $b ?>" value="<?= $rsr["sname"] ?>" /></td>
												<td><input type="text" name="kazu<?= $b ?>" id="kazu<?= $b ?>" value="<?= $rsr["num"] ?>" size="2" class="kazu_cal" /></td>
												<td><input type="text" name="tani<?= $b ?>" id="tani<?= $b ?>" value="<?= $rsr["unit"] ?>" size="2" /></td>
												<td>\<input type="text" name="tanka<?= $b ?>" id="tanka<?= $b ?>" value="<?= $rsr["tanka"] ?>" size="4" class="tanka_cal" /></td>
												<td>\<input type="text" name="goukei<?= $b ?>" id="goukei<?= $b ?>" value="<?= $rsr["total2"] ?>" size="4" class="goukei_cal" /></td>
											</tr>

										<?php

										}
									}
								} else {
									for ($i = 1; $i <= 8; $i++) {
										?>
										<tr>
											<th><?= $i ?></th>
											<td><input type="text" name="hinmei<?= $i ?>" id="hinmei<?= $i ?>" value="" /></td>
											<td><input type="text" name="kazu<?= $i ?>" id="kazu<?= $i ?>" value="" size="2" class="kazu_cal" /></td>
											<td><input type="text" name="tani<?= $i ?>" id="tani<?= $i ?>" value="" size="2" /></td>
											<td>\<input type="text" name="tanka<?= $i ?>" id="tanka<?= $i ?>" value="" size="4" class="tanka_cal" /></td>
											<td>\<input type="text" name="goukei<?= $i ?>" id="goukei<?= $i ?>" value="" size="4" class="goukei_cal" /></td>
										</tr>
								<?php
									}
								}
								?>
								<tr id="lasttr">
									<td colspan="6" style="border:none; padding:4px 0;"></td>
								</tr>
							</tbody>

							<tfoot>

								<tr>
									<th colspan="4"></th>
									<th class="second">小計</th>
									<td>\<input type="text" name="syokei" id="syokei" value="<?= $syokei ?>" size="4" /></td>
								</tr>

								<tr>
									<th colspan="4"></th>
									<th class="second">消費税</th>
									<td>\<input type="text" name="zei" id="zei" value="<?= $zei ?>" size="4" /></td>
								</tr>

								<tr>
									<th colspan="4"></th>
									<th class="second">合計金額</th>
									<td>\<input type="text" name="total_price" id="total_price" value="<?= $total ?>" size="4" /></td>
								</tr>
							</tfoot>
						</table>
						<input type="hidden" name="counttr" id="counttr" value="<?= $gyosu ?>" />
					</div>


					<div class="block">
						<p>備考<br />

							<textarea name="comment" id="comment" cols="50" rows="5"><?= $biko ?></textarea>
						</p>
					</div>

					<?php
					if (!empty($mainid)) {
					?>
						<p class="centering"><input type="checkbox" name="newregi" id="newregi" value="1" /><label for="newregi">今日の日付にして新規に印刷する場合はチェックを入れてください</label></p>
					<?php
					}
					?>
					<p class="centering"><input type="submit" name="submit" value="　印刷画面へ　" /></p>
				</form>


			<?php
			}
			?>
		</div>

	</div>

	</div>


</body>

</html>