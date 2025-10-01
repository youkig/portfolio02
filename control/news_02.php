<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<?php include("../config.php");?>

<?php
$userid2 = $_COOKIE["adminlogin"];
$password2 = $_COOKIE["adminpasswd"];
if(control_login($userid2,$password2)===false){
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
<?php include("include/js.php");?>
<script src="js/news.js" type="text/javascript"></script>
<script type="text/javascript">
$(function () {
	var q = getQueryAll(document.URL);
	registEnd("news_02.php?"+q);
});
</script>

<?php
		// if (!empty($_POST)){
			if (!empty($_POST["title"]) && !empty($_POST["naiyou"])){

			$id = cnum($_POST["id"]);
			$sql = "UPDATE t_news set title=:title,naiyo=:naiyo,indate=:indate,disp=:disp Where id=:id";
			$n = $dbh->prepare($sql);
			$n -> bindValue(":title",$_POST["title"],PDO::PARAM_STR);
			$n -> bindValue(":naiyo",$_POST["naiyou"],PDO::PARAM_STR);
			$n -> bindValue(":indate",date('Y-m-d',strtotime($_POST["year"]."-".$_POST["month"]."-".$_POST["day"])),PDO::PARAM_STR);
			$n -> bindValue(":disp",$_POST["disp"],PDO::PARAM_INT);
			$n -> bindValue(":id",$id,PDO::PARAM_INT);
			$n -> execute();

			header("location:news_02.php?id=".$id);
			}
		// }
		?>


<?php
$id = cnum($_REQUEST["id"]);
$sql="select * from t_news where id = :id";
$n = $dbh->prepare($sql);
$n -> bindValue(":id",$id,PDO::PARAM_INT);
$n -> execute();
$rs = $n->fetch(PDO::FETCH_ASSOC);

if (empty($rs)){
	header("location:news.php");
}

$y = date('Y',strtotime($rs["indate"]));
$m = date('m',strtotime($rs["indate"]));
$d = date('d',strtotime($rs["indate"]));

?>
<title>HP管理 &gt; お知らせ編集【<?=$kanriName?>】</title>
</head>
<body>

<div id="box" class="kanri">
<?php include("include/header2.php")?>

	<div id="main">
	<?php include("include/leftpane.php")?>
		<div id="cnt">
		
			<h2>お知らせ編集</h2>
			
			<div class="block">
			<p>既存のお知らせの編集を行います。</p>
			<p><a href="news.php">お知らせ一覧に戻る</a></p>
			</div>

			<h3>お知らせの編集</h3>
			<form method="post" action="news_02.php" onsubmit="return signup(this)">
			<div class="block">
			<table>
				<tbody>
					<tr>
					<th>日付</th>
					<td><p>西暦<input name="year" id="year" type="text" size="10" value="<?=$y?>" />年
					　<input name="month" id="month" type="text" size="10" value="<?=$m?>" />月
					　<input name="day" id="day" type="text" size="10" value="<?=$d?>" />日</p></td>
					</tr>
					<tr>
					<th>タイトル</th>
					<td><input name="title" id="title" type="text" size="60" value="<?=$rs["title"]?>" /></td>
					</tr>
					<tr>
					<th>内容</th>
					<td>
					<!--#include file="include/textarea_select.inc"-->
					<textarea name="naiyou" id="naiyou" class="naiyou" cols="50" rows="6" style="width:100%"><?=$rs["naiyo"]?></textarea></td>
					</tr>
					<tr>
					<th>公開設定</th>
					<td>
					<ul class="inline">
						<li><label for="disp1"><input type="radio" value="1" name="disp" id="disp1"<?=checked($rs["disp"],true)?> /> 公開</label></li>
						<li><label for="disp0"><input type="radio" value="0" name="disp" id="disp0"<?=checked($rs["disp"],false)?> /> 下書き</label></li>
						
					</ul>
					</td>
					</tr>
				</tbody>
			</table>
			<p><input value="この内容で登録する" type="submit" /></p>
			<input type="hidden" name="id" value="<?=$id?>" />
			</div>
			</form>
		
		</div>

	</div>
</div>

</body>
</html>
