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

$sql = "select * from t_bbs";
$b = $dbh->prepare($sql);
$b -> execute();
$result = $b->fetchAll(PDO::FETCH_ASSOC);

if ($result){
	$sql = "select max(indate) as max from t_bbs";
	$bm = $dbh->prepare($sql);
	$bm -> execute();

	$rsmax = $bm->fetch(PDO::FETCH_ASSOC);
	$year1 = date('Y',strtotime($rsmax["max"]));
	
	$sql = "select min(indate) as min from t_bbs";
	$bm = $dbh->prepare($sql);
	$bm -> execute();

	$rsmin = $bm->fetch(PDO::FETCH_ASSOC);
	$year2 = date('Y',strtotime($rsmin["min"]));
}else{
	$year1 = date('Y');
	$year2 = $year1;
}


	$title = "一宮町町政への苦情、ご意見投稿一覧";

?>

<title><?=$title?>【<?=$kanriName?>】</title>
</head>
<body>
<?php
if ($goodsadd == 0){
?>
<div id="box" class="kanri">
<?php include("include/header.php")?>

	<div id="main">
	<?php include("include/leftpane.php")?>
<?php
}else{
	echo '<div id="box" class="goodsaddbox"><div id="main">';
}
?>
		<div id="cnt">
			<h2><?=$title?></h2>

<div class="block">
	<form action="bbslist.php">
	<input type="hidden" value="<?=$sendmail?>" name="sendmail" />
		<table>
			<tbody>
			
			<tr>
            <th style="width:10%;">表示/非表示</th>
                <td style="width:40%;"><select name="disp" id="disp">
                <option value=""<?=selected(renull($_REQUEST["disp"]),null)?>></option>
                <option value="1"<?=selected($_REQUEST["disp"],1)?>>表示</option>
                <option value="0"<?=selected($_REQUEST["disp"],0)?>>非表示</option>
                </select></td>
           
            <th style="width:10%;">審査</th>
            <td style="width:40%;">
            <select name="shinsa" id="shinsa">
                <option value=""></option>
                <option value="0"<?=selected(cnum($_REQUEST["shinsa"]),0)?>>未審査</option>
                <option value="1"<?=selected(cnum($_REQUEST["shinsa"]),1)?>>審査済み</option>
                <option value="2"<?=selected(cnum($_REQUEST["shinsa"]),2)?>>未承認</option>
                </select>
            </td>
             </tr>
			<tr>
				<th>キーワード</th>
				<td><input name="keyword" type="text" id="keyword" size="50" value="<?=$_REQUEST["keyword"]?>" /></td>
                </td>
                
                <th>都道府県</th>
				<td>
					<select name="state">

						<option value="">すべて</option>
						<?php
						$sql ="SELECT * from t_state";
						$s = $dbh->prepare($sql);
						$s -> execute();
						$res = $s -> fetchAll(PDO::FETCH_ASSOC);
						foreach($res as $rsstate){
						?>
                        <option value="<?=$rsstate["state"]?>"<?=selected($rsstate["state"],cnum($_GET["state"]))?>><?=$rsstate["state"]?></option>
                        <?php
						}
						?>
					</select>
				</td>
			</tr>
			  
			</tbody>
		</table>
		<p><input type="submit" value="検索" />　<a href="bbslist.php">全件表示</a></p>
		<input type="hidden" name="goodsadd" value="<?=$goodsadd?>" />
		
	</form>
    
        
</div>



<div class="block">
<?php

$webmax=20;
$nowpoint = cnum($_REQUEST["point"]);
$maxco=$nowpoint+10;
//'------------------------------------------------------------------------------------------------
$sql = "select * From t_bbs";

$sqlw = " Where id<>0"; 
if (!empty($_REQUEST["keyword"])){
	$sqlw .= " and (name LIKE :keyword or email LIKE :keyword or tek LIKE :keyword or state LIKE :keyword or address LIKE :keyword or address2 LIKE :keyword or comment LIKE :keyword or zip LIKE :keywword)";
}

if (!empty($_REQUEST["state"])){
$sqlw .= " and state=:state";// &  request("state") & "'"
}

if (!empty($_REQUEST["disp"])){
$sqlw .= " and disp=:disp";// & request("disp")
}

if (isset($_REQUEST["shinsa"])){
$sqlw .= " and shinsa=:shinsa";
}

$sqlo = " order by indate desc";
$sqll = " LIMIT ".$nowpoint.",".$webmax;

$b = $dbh->prepare($sql.$sqlw.$sqlo.$sqll);

if (!empty($_REQUEST["keyword"])){
$b -> bindValue(":keyword",$_REQUEST["keyword"],PDO::PARAM_STR);
}
if (!empty($_REQUEST["state"])){
$b -> bindValue(":state",$_REQUEST["state"],PDO::PARAM_STR);
}
if (!empty($_REQUEST["disp"])){
	$b -> bindValue(":disp",$_REQUEST["disp"],PDO::PARAM_INT);
}
if (isset($_REQUEST["shinsa"])){
	$b -> bindValue(":shinsa",$_REQUEST["shinsa"],PDO::PARAM_INT);
}

$b -> execute();
$result = $b->fetchAll(PDO::FETCH_ASSOC);


$sqlco = "select count(id) as co From t_bbs ". $sqlw;
$c = $dbh->prepare($sqlco);
if (!empty($_REQUEST["keyword"])){
$c -> bindValue(":keyword",$_REQUEST["keyword"],PDO::PARAM_STR);
}
if (!empty($_REQUEST["state"])){
$c -> bindValue(":state",$_REQUEST["state"],PDO::PARAM_STR);
}
if (!empty($_REQUEST["disp"])){
	$c -> bindValue(":disp",$_REQUEST["disp"],PDO::PARAM_INT);
}
if (isset($_REQUEST["shinsa"])){
	$c -> bindValue(":shinsa",$_REQUEST["shinsa"],PDO::PARAM_INT);
}

$c -> execute();


$rsco = $c -> fetch(PDO::FETCH_ASSOC);
$count = $rsco["co"];


$maxco=$nowpoint+10;

$nowco=0;
if ($maxco > $count){
	$maxco = $count;
}
$maxco2=$maxco-$nowpoint;

foreach($_GET as $key=>$val){
	if ($key!=="point"){
		if (!empty($joken)){$joken .= "&amp;";}
		$joken .= $key."=".$val;
	}
}

foreach($_POST as $key=>$val){
	if ($key!=="point"){
		if (!empty($joken)){$joken .= "&amp;";}
		$joken .= $key."=".$val;
	}
}
// '------------------------------------------------------------------------------------------------

if (!$result){
		echo "<p>該当がありません。</p>";
	}else{
		echo "<p>{$count}件の該当がありました。</p>";
		$cnt = 0;
	}
?>

	<table>
	<thead>
		<tr>
			<?php
			if ($goodsadd == 0){
				echo '<th style="width:50px;">編集</th>';
			}else{
				echo '<th style="width:50px;"></th>';
			}
			?>

            <th>表示/非表示</th>
            <th>審査</th>
			<th>名前</th>
            <th>ペンネーム</th>
			<th>都道府県</th>
			<th>登録日</th>
            
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($result as $rs){
		$cnt++;
		$in_date = $rs["indate"];
		$id = $rs["id"];
		
		if ($rs["disp"]==0){
		$classname=' style="background-color:#ccc;"';
        }else{
        $classname="";
		}
		
		?>
		<tr<?=$classname?>>
			
			<td class="centering"><a href="bbsdisp.php?id=<?=$id?>">編集</a><input type="hidden" name="userids" value="<?=$id?>" /></td>
		
			<td class="centering"><?=($rs["disp"]==1) ? "表示中" : "非表示";?></td>
            <td class="centering"><?php
			switch($rs["shinsa"]){
			case 0:
				echo "未審査";
				break;
			case 1:
				echo "審査済み";
				break;
			case 2:
				echo "未承認";
				break;
			}
            ?></td>
			<td><a href="bbsdisp.php?id=<?=$id?>"><?php
			if (!empty($rs["name"])){
			echo $rs["name"];
			}
			?></a>
            </td>
           
            <td><?php
			if (!empty($rs["penname"])){
			echo $rs["penname"];
			}
			?>
            </td>
			<td class="centering"><?=$rs["state"]?></td>
			<td><?=$in_date?>
			</td>
           
          
			
		</tr>
		<?php
		if ($cnt==$webmax){break;}
		}
		?>
	</tbody>
	</table>

	<?php
	if ($sendmail == 1){
	echo "</form>";
	}
	
	?>

</div>
</div>
</body>
</html>
