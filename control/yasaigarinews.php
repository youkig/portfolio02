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

<script type="text/javascript">
$(function () {
	registEnd("news.php");
});
</script>
<?php

			
			if (!empty($_POST["naiyou"])){
				$sql = "UPDATE t_yasaicomment set comment=:comment,disp=:disp Where id=1";
				$y = $dbh->prepare($sql);
				$y -> bindValue(":comment",renull($_POST["naiyou"]),PDO::PARAM_STR);
				$y -> bindValue(":disp",cnum($_POST["disp"]),PDO::PARAM_INT);
				$y -> execute();
				 header("location:yasaigarinews.php");
			}
				
$sql="select * from t_yasaicomment Where id=1";
$y = $dbh->prepare($sql);
$y -> execute();
$rs=$y -> fetch(PDO::FETCH_ASSOC); 
if ($rs){
$comment = $rs["comment"];
if ($rs["disp"]==True){
    $disp1=' checked="checked"';
    $disp0="";
	}else{
    $disp1="";
    $disp0=' checked="checked"';
    }
}
?>
<title>野菜狩りコメント &gt; お知らせ編集【<?=$kanriName?>】</title>
</head>
<body>
<div id="box" class="kanri">
<?php include("include/header.php")?>

	<div id="main">
	<?php include("include/leftpane.php")?>
		<div id="cnt">
		
			<h2>野菜狩り・野菜収穫体験サービスコメント編集</h2>
			
			<?php
			if($_SERVER["REQUEST_METHOD"] !== "POST"){
			?>
			<div class="block">
			<p>野菜狩り・野菜収穫体験サービスのコメント設定（今収穫できる野菜）を行うことができます。</p>
			</div>


			<h3>コメント設定</h3>
			<form method="post" action="yasaigarinews.php" onsubmit="return signup(this)">
			<div class="block">
			<table>
				<tbody>
					
					
					<tr>
					<th>内容</th>
					<td>
					
					<textarea name="naiyou" id="naiyou" class="naiyou" cols="50" rows="6" style="width:100%"><?=$comment?></textarea></td>
					</tr>
					<tr>
					<th>公開設定</th>
					<td>
					<ul class="inline">
                   
						<li><label for="disp1"><input type="radio" value="1" name="disp" id="disp1"<?=$disp1?> /> 公開</label></li>
						<li><label for="disp0"><input type="radio" value="0" name="disp" id="disp0"<?=$disp0?> /> 下書き</label></li>
						
					</ul>
					</td>
					</tr>
				</tbody>
			</table>
			<p><input value="この内容で登録する" type="submit" /></p>
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
