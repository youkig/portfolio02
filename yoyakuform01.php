<?php
session_start();
?>
<?php $siteid = 90 ?>
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
	<script src="js/yoyaku_chk.js"></script>
	<script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>

	<script>
		$(function() {

			$("#person1").click(function() {
				$(".houjin").fadeIn();
			});

			$("#person2").click(function() {
				$(".houjin").fadeOut();
			});

			$("#nextmonth").click(function() {
				var a = $(this).val();

				$.ajax({
					type: "get",
					url: "./js/calender.php",
					data: "month=" + a,
					success: function(str) {
						if (str != "") {
							$("#calender").html(str).hide().fadeIn();
							if (a < 3) {
								$("#nextmonth").val(parseInt(a) + 1);
							}
							$("#prevmonth").val(parseInt(a) - 1);

						} else {
							alert("予約カレンダーの取得に失敗しました");
						}
					}
				});

			});

			$("#prevmonth").click(function() {
				var a = $(this).val();
				var b = $("#nextmonth").val();
				$.ajax({
					type: "get",
					url: "./js/calender.php",
					data: "month=" + a,
					success: function(str) {
						if (str != "") {
							$("#calender").html(str).hide().fadeIn();
							if (parseInt(b) == 3 && parseInt(a) == 2) {

							} else {
								if (parseInt(b) != 1) {
									$("#nextmonth").val(parseInt(b) - 1);
								}
							}
							if (parseInt(a) != 0) {
								$("#prevmonth").val(parseInt(a) - 1);
							}
						} else {
							alert("予約カレンダーの取得に失敗しました");
						}
					}
				});

			});


			$(document).on('click', ".yoyakubtn", function() {
				var ydate = $(this).attr("id");
				var ydate2 = ydate.split("_");
				$("#yoyakuday").html(ydate2[1] + "年" + ydate2[2] + "月" + ydate2[3] + "日");
				$("#ydate").val(ydate2[1] + "/" + ydate2[2] + "/" + ydate2[3]);
				alert("予約日に" + ydate2[1] + "年" + ydate2[2] + "月" + ydate2[3] + "日が設定されました。");
			});

			$("#ninzu").change(function() {
				var n = $(this).val();
				var ninzu = parseInt(n) / 2;
				var k = Math.ceil(ninzu);
				var str = "<option value=''></option>\n";
				for (var i = k; i <= parseInt(n); i++) {
					str = str + "<option value='" + i + "'>" + i + "</option>\n";
				}
				$("#kago").html(str);
			});




		});
	</script>
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
				<div id="cnt" class="company about">

					<p class="pankuzu"><a href="<?= $esurl ?>">トップページ</a> | 野菜狩り・野菜収穫体験サービスを始めました！</p>

					<h2>野菜狩り・野菜収穫体験サービスを始めました！</h2>

					<div class="block">
						<p class="catch">【太陽と野菜の直売所】（東浪見岡本農園）では、令和３年６月１日から野菜狩り・野菜収穫体験サービスを開始することになりました。</p>

						<p class="rental_farm_catch" style="text-align: center;font-size: 140%;color: #006600;border: 1px solid #FFA713;padding: 5px;">完全予約制</p>

						<div class="container">
							<div class="leftbox w60">
								<p>当農園では、年間をとおして「完全有機栽培」「少量多品種栽培」「減農薬栽培」（ほとんどの野菜は農薬不使用）を行っており、いつの季節でも十数種類以上の葉物野菜、根菜類、果菜類が畑に定植されています。</p>
								<p>お好きな野菜を自らの手で収穫して「カゴ売り」（１カゴ：2,000円）していますので、獲れたての新鮮野菜を持ち帰ることができます。</p>


							</div>
							<div class="rightbox w35">
								<p><img src="img/yasaigari/image03.gif" alt="野菜のイメージ画像" width="211" height="208"></p>
							</div>
						</div>

						<p class="red bold">◎（基本ルール）2名まで：1カゴ（3名は2カゴとなります） </p>
						<p class="red bold">※小学生未満の幼児は人数外となります。また、特別なご事情（付き添いの高齢者、身障者等）があればご相談ください。</p>
						<p class="red bold">※3名のご来園で「1カゴでよいか」という問合せが多くなっていますが、当農園では「入場料」は頂戴しておりませんので、ぜひこの点はご理解ください。（必ず1組1名の担当者が付き添います） </p>

						<p><span class="red bold">事前予約制</span>による受付となりますので、以下予約カレンダーからご希望の日時を選んでご予約をお願いします。</p>

						<?php
						if (1 == 2) {
						?>
							<p>※予約なしにお出でいただいた場合、基本的には対応できません。入場できることもありますが、来場前に電話をいただけると幸いです。(TEL:<?= $mobile ?>　農園管理人：岡本直通)</p>
						<?php
						}
						?>
					</div>

					<div class="block">

						<dl class="fl">
							<dt>住所</dt>
							<dd>〒299-4303千葉県長生郡一宮町東浪見4721<br />TEL:<?= $mobile ?></dd>
						</dl>


						<dl class="fl">
							<dt>定休日</dt>
							<dd>月曜日・金曜日</dd>
						</dl>

						<?php
						$sql = "SELECT * From t_bhours Where id=2";
						$h = $dbh->prepare($sql);
						$h->execute();
						$hrs = $h->fetch(PDO::FETCH_ASSOC);
						$starttime = $hrs['starttime'];
						$endtime = $hrs['endtime'];
						?>

						<dl class="fl">
							<dt>営業時間</dt>
							<dd>
								・<?= $starttime ?><br>・<?= $endtime ?>
								<br>（2部制）（駐車場、トイレ完備）
							</dd>
						</dl>

						<dl class="fl">
							<dt>料金</dt>
							<dd>1カゴ2,000円[幅37 × 奥行28 × 高21cm]
								<br>※但しお二人まで1カゴ、3名は2カゴのご利用<br>
								<p class="centering"><img src="img/yasaigari/image01.jpg" alt="カゴの写真1" width="260" height="190"><img src="img/yasaigari/image02.jpg" alt="カゴの写真2" width="260" height="190"></p>
							</dd>
						</dl>


						<dl class="fl">
							<dt>ペット</dt>
							<dd>同伴可（リード着用のこと）</dd>
						</dl>

						<dl class="fl">
							<dt>雨天のとき</dt>
							<dd>基本的に営業していますが、雨具、長靴のご用意をお願いします。</dd>
						</dl>
					</div>


					<?php

					$sql = "select * from t_yasaicomment Where id=1 and disp=1";
					$y = $dbh->prepare($sql);
					$y->execute();
					$recom = $y->fetch(PDO::FETCH_ASSOC);
					if (!empty($rscom)) {
					?>
						<div class="block">
							<h3>現在収穫できる野菜</h3>
							<p class="catch2"><?= nl2br($rscom["comment"]) ?></p>
						</div>
					<?php
					}
					?>

					<div class="block" id="form">
						<h3>野菜狩り・野菜収穫体験サービス 予約フォーム</h3>

					</div>

					<div class="block">
						<h4>〇メールでのお問合せ</h4>
						<ul>

							<li>（メール）torami@okamoto-farm.co.jp</li>
						</ul>

					</div>
					<?php



					if (empty($_SESSION["setid"])) {
					?>

						<form action="<?= $esurl ?>login_chk" method="post" onSubmit="return signup(this)">
							<div class="block">
								<h3>会員ログインフォーム</h3>

								<p>登録済みの会員様は以下よりログインしてください。</p>
								<p><?= $errmes ?></p>


								<dl>
									<dt>ユーザーID</dt>
									<dd><input type="text" name="loginid" id="loginid" value=""></dd>
								</dl>

								<dl>
									<dt>パスワード</dt>
									<dd><input type="password" name="password" id="password2" value=""></dd>
								</dl>



							</div>

							<div class="block">

								<p class="centering"><input type="submit" name="submit" value="ログイン"></p>
							</div>

							<input type="hidden" name="loginchk" value="okamoto-nouen">

						</form>


					<?php
					}
					?>



					<form action="<?= $esurl ?>yoyakuform02#form" method="post" onSubmit="return signup(this)">
						<div class="block">


							<div class="block">
								<p class="red bold">※当日の来園希望または予約が出来ない方は、直接農園までお電話ください。（TEL:<?= $mobile ?>）</p>
								<h4>予約希望日</h4>
								<?php
								// 今日 + 1日
								$today = date("Y-m-d");
								$today = date("Y-m-d", strtotime($today . "1 day"));


								// 年/月（文字列形式）
								$tmonth = date('Y-m', strtotime($today));

								// 来月の初日
								$nextmonth = date("Y-m-01", strtotime($today . "1 month"));


								$lastday = date("t", strtotime($today));


								$firstweek = date("w", strtotime($tmonth . "-01"));


								?>

								<?php include("include/calender.php"); ?>
								<?php

								$loop1 = ($lastday + $firstweek) / 7;

								$amari = ($lastday + $firstweek) % 7;
								if ($amari > 0) {
									$loop1++;
								}

								?>
								<p><button type="button" id="prevmonth" name="prevmonth" value="0">前の月</button>&nbsp;&nbsp;<button type="button" id="nextmonth" name="nextmonth" value="1">次の月</button></p>
								<div id="calender">
									<p><?= str_replace("-", "年", $tmonth) ?>月</p>

									<table class="atten">
										<thead>
											<tr>
												<th abbr="日" class="first">日</th>
												<th abbr="月">月</th>
												<th abbr="火">火</th>
												<th abbr="水">水</th>
												<th abbr="木">木</th>
												<th abbr="金">金</th>
												<th abbr="土" class="last">土</th>
											</tr>
										</thead>

										<tbody>
											<?php
											$c = $lastday + $firstweek;
											$cnt = 0;
											for ($a = 1; $a <= $loop1; $a++) {

											?>
												<tr style="border:1px solid;">
													<?php
													$cnt1 = 0;
													for ($b = 1; $b <= $c; $b++) {
														$dchk = 0;
														$cnt1++;
														if ($cnt1 <= 7) {
															$classname = "";
															if ($cnt1 == 1) {
																$classname = " class='first'";
															}

															if ($cnt1 == 7) {
																$classname = " class='last'";
															}


															$dateToCheck = date('Y-m-d', strtotime(date('Y-m', strtotime($tmonth)) . '-' . $cnt));
															if ($dateToCheck < $today) {
																$classname = " class='endday'";
															}

													?>
															<td<?= $classname ?>>
																<?php
																if ($b > $firstweek || $cnt > 0) {
																	$cnt++;
																	if ($cnt <= $lastday) {
																		echo $cnt;
																		if (is_array($darray)) {
																			if (count($darray) > 0) {
																				for ($d = 0; $d < count($darray); $d++) {
																					if (!empty($darray[$d])) {
																						// 対象日（tmonth の年・月と cnt を組み合わせて日付を作成）

																						$targetDate = date('Y-m-d', strtotime('Y-m', strtotime($tmonth)) . '-' . $cnt);

																						if ($targetDate === date('Y-m-d', strtotime($darray[$d]))) {
																							// "休日 " を含んでいれば「振替休日」
																							if (strpos($sarray[$d], '休日 ') !== false) {
																								echo "<span class='red'> 振替休日</span>";
																							} else {
																								echo "<span class='red'>" . htmlspecialchars($sarray[$d], ENT_QUOTES, 'UTF-8') . "</span>";
																							}
																						}
																					}
																				}
																			}
																		}
																		//$date = DateTime::createFromFormat('Y-n-j', $tmonthDate->format('Y-n') . '-' . $cnt);
																		$date = date('Y-m-d', strtotime(date('Y-m', strtotime($tmonth)) . '-' . $cnt));
																		// 曜日を取得（VBScriptと同様に 1=日曜, 2=月曜, ..., 7=土曜にしたい場合）
																		//$week = (int)$date->format('w'); // PHP: 0=日曜, ..., 6=土曜
																		$week = date("w", strtotime($date));

																		//祝日を定休日にしない場合は「or dchk=1」を追加
																		$rkyu = 0;
																		if (strpos(',' . $r . ',', ',' . $cnt . ',') !== false && $week !== 1 && $week !== 5) {
																			$rkyu = 1;
																			echo "<br><span class='red'> 臨時休業</span>";
																		}

																		$edate =  date('Y-m-d', strtotime(date('Y-m', strtotime($tmonth)) . '-' . $cnt));
																		$sql = "SELECT * from t_temporary_sales Where edate=:edate and cancel=0";
																		$d = $dbh->prepare($sql);
																		$d->bindValue(":edate", $edate, PDO::PARAM_STR);
																		$d->execute();
																		$rse = $d->fetch(PDO::FETCH_ASSOC);

																		if (!empty($rse)) {
																			$dchk = 1;
																		}

																		$targetDate = date('Y-m-d', strtotime($tmonth . '-' . $cnt));

																		if ($targetDate > $today && $week != 1 && $week != 5 && $rkyu == 0) {
																?>
																			<br>
																			<p class="centering">

																				<button type="button" class="yoyakubtn" id="yoyaku_<?= date('Y', strtotime($tmonth)) ?>_<?= date('m', strtotime($tmonth)) ?>_<?= $cnt ?>">予約</button><br>
																			</p>
																		<?php
																		}
																		if (($week == 1 || $week == 5) && $dchk == 0) {
																		?>
																			<p class="red centering small">定休日</p>
																		<?php
																		} elseif (($week == 1 || $week == 5) && $dchk == 1) {
																		?>
																			<br>
																			<p class="centering">

																				<button type="button" class="yoyakubtn" id="yoyaku_<?= date('Y', strtotime($tmonth)) ?>_<?= date('m', strtotime($tmonth)) ?>_<?= $cnt ?>">予約</button><br>


																			</p>
																<?php
																		}
																	}
																}
																?>

																</td>

														<?php
															if ($cnt1 == 7) {
																break;
															}
														}
													} //for
														?>
												</tr>
											<?php
											} //for
											?>

										</tbody>
									</table>
								</div>
							</div>


							<dl>
								<dt>ご予約日<em>[必須]</em></dt>
								<dd id="yoyakuday"></dd>
							</dl>
							<input type="hidden" name="ydate" id="ydate" value="">
							<dl>
								<dt>開始時間<em>[必須]</em></dt>
								<dd>
									※現在の営業開始時間<br />

									・<?= $starttime ?><br>・<?= $endtime ?>
									<br>（2部制）<br>
									<select name="hour" id="hour">
										<option value="">--</option>
										<?php
										for ($h = 9; $h <= 12; $h++) {
										?>
											<option value="<?= $h ?>"><?= $h ?></option>
										<?php
										}

										for ($h = 15; $h <= 17; $h++) {
										?>
											<option value="<?= $h ?>"><?= $h ?></option>
										<?php
										}
										?>
									</select>時
									<select name="time" id="time">
										<?php
										for ($t = 0; $t <= 50; $t += 10) {
										?>
											<option value="<?= $t ?>"><?= ($t == 0) ? "00" : $t ?></option>
										<?php
										}
										?>

									</select>分
								</dd>
							</dl>

							<dl>
								<dt>ご利用人数<em>[必須]</em></dt>
								<dd><select name="ninzu" id="ninzu">
										<option value="">選択</option>
										<?php
										for ($b = 1; $b <= 40; $b++) {
										?>
											<option value="<?= $b ?>"><?= $b ?></option>
										<?php
										}
										?>
									</select> 人</dd>
							</dl>

							<dl>
								<dt>ご利用のカゴ数<em>[必須]</em></dt>
								<dd>
									※お二人まで1カゴ、3名の場合は最低2カゴからのご利用となります。<br>
									<select name="kago" id="kago">

									</select> カゴ
								</dd>
							</dl>

							<?php
							if (!empty($_SESSION["logid"]) && !empty($_SESSION["pass"])) {
								$sql = "SELECT * From t_user Where email=:login and password=:pass and dele=0 and taikai=0";
								$user = $dbh->prepare($sql);
								$user->bindValue(":login", $_SESSION["logid"], PDO::PARAM_STR);
								$user->bindValue(":pass", $_SESSION["pass"], PDO::PARAM_STR);
								$user->execute();
								$rsu = $user->fetch(PDO::FETCH_ASSOC);
								if (!empty($rsu)) {
									$person = $rsu["person"];
									$company = $rsu["company"];
									$busyo = $rsu["busyo"];
									$username = $rsu["name"];
									$furigana = $rsu["furigana"];
									$email = $rsu["email"];
									$tel = $rsu["tel"];
									$zip = explode("-", $rsu["zip"]);
									$zip1 = $zip[0];
									$zip2 = $zip[1];
									$stateid = $rsu["state"];
									$sql = "select state From t_state Where id=:stateid";
									$state = $dbh->prepare($sql);
									$state->bindValue(":stateid", $stateid, PDO::PARAM_INT);
									$state->execute();
									$rsstates = $state->fetch(PDO::FETCH_ASSOC);
									$statename = $rsstates["state"];
									$address = $rsu["address"];
									$address2 = $rsu["address2"];
								}
							}
							?>
							<dl>
								<dt>法人・個人&nbsp;<em>[必須]</em></dt>
								<dd><input type="radio" name="person" id="person1" value="法人" class="radiochk" <?= checked($person, 0) ?>><label for="person1">法人</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="person" id="person2" value="個人" class="radiochk" <?= checked($person, 1) ?>><label for="person2">個人</label>
								</dd>
							</dl>

							<dl class="houjin">
								<dt>法人名</dt>
								<dd><input type="text" name="company" id="company" value="<?= $company ?>"></dd>
							</dl>

							<dl class="houjin">
								<dt>部署</dt>
								<dd><input type="text" name="busyo" id="busyo" value="<?= $busyo ?>"></dd>
							</dl>
							<dl>
								<dt>お名前&nbsp;<em>[必須]</em></dt>
								<dd><input type="text" name="name" id="name" value="<?= $username ?>"></dd>
							</dl>

							<dl>
								<dt>ふりがな&nbsp;<em>[必須]</em></dt>
								<dd><input type="text" name="furigana" id="furigana" value="<?= $furigana ?>"></dd>
							</dl>

							<dl>
								<dt>メールアドレス&nbsp;<em>[必須]</em></dt>
								<dd><input type="text" name="email" id="email" value="<?= $email ?>"></dd>
							</dl>

							<dl>
								<dt>メールアドレス（確認）&nbsp;<em>[必須]</em></dt>
								<dd><input type="text" name="kemail" id="kemail" value="<?= $email ?>"></dd>
							</dl>

							<dl>
								<dt>電話番号&nbsp;<em>[必須]</em></dt>
								<dd><input type="text" name="tel" id="tel" value="<?= $tel ?>"></dd>
							</dl>

							<dl>
								<dt>郵便番号&nbsp;<em>[必須]</em></dt>
								<dd>※半角数字で入力してください。<br><input type="text" name="zip1" id="zip1" value="<?= $zip1 ?>" class="zip"> - <input type="text" name="zip2" id="zip2" value="<?= $zip2 ?>" class="zip" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','state','address','');"></dd>
							</dl>

							<dl>
								<dt>都道府県&nbsp;<em>[必須]</em></dt>
								<dd><select name="state" id="state">
										<option value="">選択</option>
										<?php
										$sql = "SELECT * From t_state";
										$s = $dbh->prepare($sql);
										$s->execute();
										$result = $s->fetchAll(PDO::FETCH_ASSOC);
										foreach ($result as $rsstate) {
										?>
											<option value="<?= $rsstate["id"] ?>" <?= selected($rsstate["id"], $stateid) ?>><?= $rsstate["state"] ?></option>
										<?php
										}
										?>
									</select></dd>
							</dl>

							<dl>
								<dt>市区町村、町名&nbsp;<em>[必須]</em></dt>
								<dd><input type="text" name="address" id="address" value="<?= $address ?>"></dd>
							</dl>

							<dl>
								<dt>以下番地、建物名、部屋番号など&nbsp;<em>[必須]</em></dt>
								<dd><input type="text" name="address2" id="address2" value="<?= $address2 ?>"></dd>
							</dl>
							<?php
							if (empty($_SESSION["setid"])) {
							?>
								<dl>
									<dt>会員登録&nbsp;[任意]</dt>
									<dd>このまま会員登録される方は、チェックボックスにチェックを入れてパスワードを入力してください。<br>
										<input type="checkbox" name="regist_chk" id="regist_chk" value="1" class="radiochk"><label for="regist_chk">会員登録される場合は、チェックを入れてください。</label>
										<br>※8文字以上、16文字以下の半角英数字<br><input type="password" name="password" id="password" value="">
									</dd>
								</dl>
							<?php
							}
							?>
							<dl>
								<dt>ご質問・ご要望など</dt>
								<dd><textarea name="comment" id="comment" cols="20" rows="5"></textarea></dd>
							</dl>


						</div>

						<div class="block">
							<p>上記内容でよろしければ、確認画面へお進みください。</p>
							<p class="centering"><input type="submit" name="submit" value="内容確認"></p>
						</div>
						<?php
						function setToken()
						{
							$TOKEN_LENGTH = 32;
							$bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);

							$token = bin2hex($bytes);
							$_SESSION['crsf_token'] = $token;
							return $token;
						}
						?>
						<input type="hidden" name="token" value="<?= setToken() ?>">


					</form>


					<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
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