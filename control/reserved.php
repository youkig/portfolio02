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


<?php
if (!empty($_POST["cancelbtn"])){
	$sql="UPDATE t_reserved set cancel=1 Where id=:id"; 
	$r = $dbh->prepare($sql);
	$r -> bindValue(":id",$_POST["id"],PDO::PARAM_INT);
	$r -> execute();

	$sql = "SELECT * From t_reserved Where id=:id";
	$r -> bindValue(":id",$_POST["id"],PDO::PARAM_INT);
	$r -> execute();
	$rsc = $r->fetch(PDo::FETCH_ASSOC);
	if ($rsc){
	$sql ="UPDATE t_reserveditem set cancel=1 Where reserveno=:reserveno"; 
	$r = $dbh->prepare($sql);
	$r -> bindValue(":reserveno",$rsc["reserveno"],PDO::PARAM_STR);
	$r -> execute();
	}

}

if (!empty($_POST["cancelbtn2"])){
	$sql="UPDATE t_reserved set cancel=0 Where id=:id"; 
	$r = $dbh->prepare($sql);
	$r -> bindValue(":id",$_POST["id"],PDO::PARAM_INT);
	$r -> execute();

	$sql = "SELECT * From t_reserved Where id=:id";
	$r -> bindValue(":id",$_POST["id"],PDO::PARAM_INT);
	$r -> execute();
	$rsc = $r->fetch(PDo::FETCH_ASSOC);
	if ($rsc){
	$sql ="UPDATE t_reserveditem set cancel=0 Where reserveno=:reserveno"; 
	$r = $dbh->prepare($sql);
	$r -> bindValue(":reserveno",$rsc["reserveno"],PDO::PARAM_STR);
	$r -> execute();
	}

}


if (!empty($_POST["update2"])){
		for ($b=1;$b<=$_POST["ccnt"];$b++){
			if (!empty($_POST["cancel".$b])){
			$sql = "UPDATE t_reserveditem set cancel=1 Where id=:canid"; //& clng2(request.form("canid"&b))
			$r = $dbh->prepare($sql);
			$r -> bindValue(":canid",$_POST["canid".$b],PDO::PARAM_INT);
			$r -> execute();
			}else{
			$sql = "UPDATE t_reserveditem set cancel=0 Where id=:canid"; //& clng2(request.form("canid"&b))
			$r = $dbh->prepare($sql);
			$r -> bindValue(":canid",$_POST["canid".$b],PDO::PARAM_INT);
			$r -> execute();
			}
		}
}
if (!empty($_POST["update"])){
		
		$sql = "UPDATE t_reserved set name=:name,furigana=:furigana,zip=:zip,state=:state,address=:address,tel=:tel,email=:email,rmonth=:rmonth,rday=:rday,comment=:comment Where id=:id"; //& clng2(request.form("id")) 
		$r = $dbh->prepare($sql);
		$r -> bindValue(":name",renull($_POST["name"]),PDO::PARAM_STR);
		$r -> bindValue(":furigana",renull($_POST["furigana"]),PDO::PARAM_STR);
		$r -> bindValue(":zip",renull($_POST["zip"]),PDO::PARAM_STR);
		$r -> bindValue(":state",renull($_POST["state"]),PDO::PARAM_STR);
		$r -> bindValue(":address",renull($_POST["address"]),PDO::PARAM_STR);
		$r -> bindValue(":tel",renull($_POST["tel"]),PDO::PARAM_STR);
		$r -> bindValue(":email",renull($_POST["email"]),PDO::PARAM_STR);
		$r -> bindValue(":rmonth",renull($_POST["month"]),PDO::PARAM_STR);
		$r -> bindValue(":rday",renull($_POST["day"]),PDO::PARAM_STR);
		$r -> bindValue(":comment",renull($_POST["comment"]),PDO::PARAM_STR);
		$r -> execute();
	
}

if (!empty($_GET["id"])){
	if (cnum($_GET["id"])!==0){
	$ids = cnum($_GET["id"]);
	
		$sql ="SELECT * From t_reserved Where id=:ids";
		$r = $dbh->prepare($sql);
		$r -> bindValue(":ids",$ids,PDO::PARAM_INT);
		$r -> execute();
		$rs = $r -> fetch(PDO::FETCH_ASSOC);
		if (!$rs){
			header("location:reservedlist.php");
		}
	}
}



?>

<title>商品予約詳細【<?=$kanriName?>】</title>
</head>
<body>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
	
		<div id="cnt">
        <h2>商品予約詳細</h2>
        <p><a href="reservedlist.php">一覧へ戻る</a></p>
        
        	
            <div class="block">
           
        	<form action="reserved.php" method="post">
            
            <input type="hidden" name="id" id="id" value="<?=rers($rs,"id","")?>" />
        	 <?php
			if ($rs["cancel"]){
			?>
            <p class="centering red bold">こちらの予約はキャンセルされました。</p>
            <p class="right"><input type="submit" name="cancelbtn2" value="キャンセルを取り消す" /></p>
            <?php
			}else{
			?>
            <p class="right"><input type="submit" name="cancelbtn" value="予約をキャンセルする" /></p>
            <?php
			}
			?>
            <h3>お客様情報</h3>
            
            
            <table>
            	<tr>
                	<th>登録日</th>
                    <td><?=$rs["indate"]?></td>
                </tr>
            	<tr>
                	<th>予約番号</th>
                    <td><?=$rs["reserveno"]?></td>
                </tr>
            	<tr>
                	<th>お名前</th>
                    <td><input type="text" name="name" id="name" value="<?=$rs["name"]?>" /></td>
                </tr>
                
                <tr>
                	<th>ふりがな</th>
                    <td><input type="text" name="furigana" id="furigana" value="<?=$rs["furigana"]?>" /></td>
                </tr>
                
                <tr>
                	<th>メールアドレス</th>
                    <td><input type="text" name="email" id="email" value="<?=$rs["email"]?>" /></td>
                </tr>
                
                <tr>
                	<th>電話番号</th>
                    <td><input type="text" name="tel" id="tel" value="<?=$rs["tel"]?>" /></td>
                </tr>
                
                <tr>
                	<th>郵便番号</th>
                    <td>〒<input type="text" name="zip" id="zip" value="<?=$rs["zip"]?>" size="8" /></td>
                </tr>
                
                <tr>
                	<th>住所</th>
                    <td>都道府県：<select name="state" id="state">
                    <option value=""></option>
                    <?php
					$sql = "SELECT * From t_state";
					$s = $dbh->prepare($sql);
					$s -> execute();
					$result = $s -> fetchAll(PDO::FETCH_ASSOC);
					
					foreach($result as $rss){
					?>
					<option value="<?=$rss["state"]?>"<?=selected($rss["state"],$rs["state"])?>><?=$rss["state"]?></option>
					<?php
					}
					?>
                    </select><br />
					
					住所：<input type="text" name="address" id="address" value="<?=$rs["address"]?>" size="60" /></td>
                </tr>
                
                <tr>
                	<th>来店予定日</th>
                    <td>
					<select name="month" id="month">
                    <?php
					for ($a=1;$a<=12;$a++){
					?>
                    <option value="<?=$a?>"<?=selected($a,$rs["rmonth"])?>><?=$a?></option>
                    <?php
					}
					?>
                    </select>月
					<select name="day" id="day">
                    <?php
					for ($b=1;$b<=31;$b++){
					?>
                    <option value="<?=$b?>"<?=selected($b,$rs["rday"])?>><?=$b?></option>
                    <?php
					}
					?>
                    </select>日</td>
                </tr>
                
                <tr>
                	<th>コメント</th>
                    <td><textarea name="comment" cols="60" rows="5"><?=$rs["comment"]?></textarea></td>
                </tr>
            </table>
          
            
           	<p><input type="submit" name="update" value="お客様情報の更新" /></p>
			 </form>   
			</div>
			
			<h3>予約商品</h3>
            
            <div class="block">
            
            <form action="reserved.php" method="post">
            	<table>
                <thead>
                	<tr>
                    	<th style="width:5%;">キャンセル</th>
                    	<th>商品名</th>
                        <th>数量</th>
                        <th>販売単価</th>
                        <th>小計</th>
                        
                    </tr>
                </thead>
                <?php
				$sql ="SELECT t_reserveditem.*,t_master.id as ids,t_master.item,t_master.unit From t_reserveditem inner join t_master on t_reserveditem.sid=t_master.id Where reserveno=:reserveno"; //&rs("reserveno") & "'"
				$r = $dbh->prepare($sql);
				$r -> bindValue(":reserveno",$rs["reserveno"],PDO::PARAM_STR);
				$r -> execute();
				$result = $r -> fetchAll(PDO::FETCH_ASSOC);
				if ($result){
				$sum=0;
				$ccnt=0;
				foreach($result as $rsr){
				
				$ccnt++;
				($rsr["cancel"]==1) ? $classname=' style="background-color:#ccc"' : $classname="";
				?>
                	<tr<?=$classname?>>
                    	<td class="centering"><input type="checkbox" name="cancel<?=$ccnt?>" id="cancel<?=$ccnt?>" value="1"<?=checked($rsr["canel"],true)?> />
                        <input type="hidden" name="canid<?=$ccnt?>" value="<?=$rsr["id"]?>" />
                        </td>
                    	<td style="width:30%;"><?=$rsr["item"]?></td>
                        <td><?=$rsr["num"].$rsr["unit"]?></td>
                        <td><?=number_format($rsr["price"])?>円</td>
                        <td><?=number_format($rsr["price"]*$rsr["num"])?>円
                        <?php
						if($rsr["cancel"]==0){
						$sum +=$rsr["price"]*$rsr["num"];
						}
						?>
                        </td>
                        
                    </tr>
                <?php
				}
			}
				?>  
               
                	<tr>
                    	<td colspan="4" class="right">合計</td>
                        <td><?=number_format($sum)?>円</td>
                        
                    </tr>
                
                </table>
                
                <input type="hidden" name="ccnt" value="<?=$ccnt?>" />
                <input type="hidden" name="id" id="id" value="<?=rers($rs,"id","")?>" />
                <p><input type="submit" name="update2" value="予約商品の更新" /></p>
                </form>
            </div>
			
		</div>
<?php include("include/leftpane.php")?>
	</div>
</div>

</body>
</html>
