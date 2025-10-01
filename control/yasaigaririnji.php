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
	registEnd("yasaigaririnji.php");
});
</script>

<?php		
			if (!empty($_POST["naiyou"])){
                if (!empty($_POST["year"]) && !empty($_POST["month"]) && !empty($_POST["day"])){
                    $sql = "INSERT into t_temporary_close (rdate,cancel) values (:rdate,:cancel)";
                    $t = $dbh->prepare($sql);
                    $t -> bindValue(":rdate",date('Y-m-d',strtotime($_POST["year"]."-".$_POST["month"]."-".$_POST["day"])),PDO::PARAM_STR);
                    $t -> bindValue(":cancel",0,PDO::PARAM_INT);
                    $t -> execute();
			    }
                
                if (!empty($_POST["cancel"])){
                $sql ="UPDATE t_temporary_close set cancel = 1 Where id in (:cancel)";
                $t = $dbh->prepare($sql);
                $t -> bindValue(":cancel",$_POST["cancel"],PDO::PARAM_STR);
                $t -> execute();
                }
                
				header("location:yasaigaririnji.php");
			
			}
       
?>

<title>臨時休業日設定 【<?=$kanriName?>】</title>
</head>
<body>
<div id="box" class="kanri">
<?php include("include/header.php")?>

	<div id="main">
	<?php include("include/leftpane.php")?>
		<div id="cnt">
		
			<h2>野菜狩り・野菜収穫体験サービス臨時休業日設定</h2>
			
			
			<div class="block">
			<p>野菜狩り・野菜収穫体験サービスの臨時休業日の設定を行います。</p>
			</div>

<?php
$sql="select * from t_temporary_close Where cancel=0 order by rdate desc";
$t = $dbh->prepare($sql);
$t->execute();
$result = $t->fetchAll(PDO::FETCH_ASSOC);
?>
			<h3>臨時休業日設定</h3>
			<form method="post" action="yasaigaririnji.php">
			<div class="block">
            <p>臨時休業日を追加</p>
            <p><select name="year" id="year">
            <option value=""></option>
            <?php
            $nyear = date('Y');
            $neyear = $nyear+1;
            for ($a=$nyear;$a<=$neyear;$a++){
            ?>
            <option value="<?=$a?>"><?=$a?></option>
            <?php
            }
            ?>
            </select>年<select name="month" id="month">
            <option value=""></option>
            <?php
            for ($b=1;$b<=12;$b++){
            ?>
            <option value="<?=$b?>"><?=$b?></option>
            <?php
            }
            ?>
            </select>月<select name="day" id="day">
            <option value=""></option>
            <?php
            for ($c=1;$c<=31;$c++){
            ?>
            <option value="<?=$c?>"><?=$c?></option>
            <?php
            }
            ?>
            </select>日</p>
            <p><input value="この内容で登録する" type="submit" name="naiyou" /></p>
            <p>登録をキャンセルする場合は、チェックを入れて「この内容で登録する」ボタンを押してください。</p>
			<table style="width: 50%;">
                <thead>
                    <tr>
                        <th>臨時休業日</th>
                        <th>キャンセル</th>
                    </tr>
                </thead>
				<tbody>
					
					<?php
                    foreach($result as $rs){
                    ?>
					<tr>
				
					<td><?=date('Y-m-d',strtotime($rs["rdate"]))?></td>
                    <td class="centering"><input type="checkbox" name="cancel" value="<?=$rs["id"]?>"></td>
					</tr>
					<?php
                    }
                    ?>
				</tbody>
			</table>
            
            
			
			</div>
			</form>
			
		
			
			
		</div>

	</div>
</div>


</body>
</html>
