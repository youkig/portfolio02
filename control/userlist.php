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

$sql = "select * from t_user";
$u = $dbh->prepare($sql);
$u -> execute();
$result = $u -> fetchAll(PDO::FETCH_ASSOC);
if ($result){
	$sql = "select max(indate) as max from t_user";
	$u = $dbh->prepare($sql);
	$u -> execute();
	$rsmax = $u -> fetch(PDO::FETCH_ASSOC);
	$year1 = date('Y',strtotime($rsmax["max"]));

	$sql = "select min(indate) as min from t_user";
	$u = $dbh->prepare($sql);
	$u -> execute();
	$rsmin = $u -> fetch(PDO::FETCH_ASSOC);
	$year2 = date('Y',strtotime($rsmin["min"]));
}else{
	$year1 = date('Y');
	$year2 = $year1;
}

	$title = "会員一覧";

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
	<form action="userlist.php">
		<table>
			<tbody>
			<tr>
				<th>登録日</th>
				<td>
				<?php
				for ($x=1;$x<=2;$x++){
				?>
				<select name="year<?=$x?>" id="year<?=$x?>">
					<option value="">----</option>
					<?php
					for ($i=$year2;$i<=$year1;$i++){
					?>
					<option value="<?=$i?>"<?=selected(cnum($_GET["year".$x]),$i)?>><?=$i?></option>
					<?php
					}
					?>
				</select>年 <select name="month<?=$x?>" id="month<?=$x?>">
				<option value="">--</option>
				<?php
				for($i=1;$i<=12;$i++){
				?>
				<option value="<?=$i?>"<?=selected(cnum($_GET["month".$x]),$i)?>><?=$i?></option>
				<?php
					}
					?>
				</select>月 <select name="day<?=$x?>" id="day<?=$x?>">
				<option value="">--</option>
				<?php
				for($i=1;$i<=31;$i++){
				?>
				<option value="<?=$i?>"<?=selected(cnum($_GET["day".$x]),$i)?>><?=$i?></option>
				<?php
					}
					?>
				</select>日
				<<?php
				if ($x == 1){echo " ～ ";}
				}
				?>
				</td>
                <th>種別</th>
                <td><input type="radio" name="membersyubetsu" id="membersyubetsu1" value="法人"<?=checked($_REQUEST["membersyubetsu"],"法人");?> /><label for="membersyubetsu1">法人</label>&nbsp;&nbsp;<input type="radio" name="membersyubetsu" id="membersyubetsu2" value="個人"<?=checked($_REQUEST["membersyubetsu"],"個人");?> /><label for="membersyubetsu2">個人</label>&nbsp;&nbsp;<input type="radio" name="membersyubetsu" id="membersyubetsu3" value="全て"<?=checked($_REQUEST["membersyubetsu"],"全て")?> /><label for="membersyubetsu3">全て</label>
				
			</td>
			</tr>
			
			<tr>
				<th>キーワード</th>
				<td><input name="keyword" type="text" id="keyword" size="50" value="<?=$_REQUEST["keyword"]?>" style="width:100%;" /></td>
                </td>
                <th>都道府県</th>
				<td>
					<select name="state">
						<option value="">すべて</option>
						<?php
						$sql = "SELECT * From t_state";
						$s = $dbh->prepare($sql);
						$s -> execute();
						$result = $s -> fetchAll(PDO::FETCH_ASSOC);
						foreach($result as $rsstate){
						?>
                        <option value="<?=$rsstate["id"]?>"<?=selected($rsstate["id"],cnum($_REQUEST["state"]))?>><?=$rsstate["state"]?></option>
                        <?php
						}
						?>
					</select>
				</td>
			</tr>
			  
			</tbody>
		</table>
		<p><input type="submit" value="検索" />　<a href="userlist.php">全件表示</a></p>
		<input type="hidden" name="goodsadd" value="<?=$goodsadd?>" />
		
	</form>
    
        
</div>



<div class="block">
<?php

$webmax=20;
$nowpoint = cnum($_REQUEST["point"]);
$maxco=$nowpoint+10;

// '------------------------------------------------------------------------------------------------
$sql = "select t_user.*,t_state.state as statename ";
$sqlf = " From t_user left join t_state on t_user.state=t_state.id";

$sqlw = " Where t_user.id<>0"; 
if (!empty($_REQUEST["keyword"])){
$sqlw .= " and (t_user.name like :keyword or t_user.furigana like :keyword or t_user.company like :keyword or t_user.busyo like :keyword or t_user.email like :keyword or t_user.tel like :keyword or t_state.state like :keyword or t_user.address like :keyword or t_user.address2 like :keyword or t_user.zip like :keyword)";
}

if (cnum($_REQUEST["state"])!==0){
	$sqlw .= " and t_user.state = :state";
}

if (isset($_REQUEST["membersyubetsu"])){

if ($_REQUEST["membersyubetsu"]=="法人"){ 
	$sqlw .= " and t_user.company IS NOT NULL AND t_user.company!=''";
}elseif ($_REQUEST["membersyubetsu"]=="個人"){ 
	$sqlw .= " and t_user.company=''";
}
}

$sqlo = " order by indate desc";
$sqll = " LIMIT ".$nowpoint.",".$webmax;

$u = $dbh->prepare($sql.$sqlf.$sqlw.$sqlo.$sqll);

if (!empty($_REQUEST["keyword"])){
	$u -> bindValue(":keyword",'%'.$_REQUEST["keyword"].'%',PDO::PARAM_STR);
}
if (cnum($_REQUEST["state"])!==0){
	$u -> bindValue(":state",$_REQUEST["state"],PDO::PARAM_INT);
}
$u -> execute();
$result = $u -> fetchAll(PDO::FETCH_ASSOC);

$sql = "select count(t_user.id) as co " . $sqlf .$sqlw;
$c = $dbh->prepare($sql);
if (!empty($_REQUEST["keyword"])){
	$c -> bindValue(":keyword",'%'.$_REQUEST["keyword"].'%',PDO::PARAM_STR);
}
if (cnum($_REQUEST["state"])!==0){
	$c -> bindValue(":state",$_REQUEST["state"],PDO::PARAM_INT);
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
//'------------------------------------------------------------------------------------------------

	if (!$result){
		echo "<p>該当がありません。</p>";
	}else{
		echo "<p>{$count}件の該当がありました。</p>";
		$cnt = 0;
	}
	?>
<p><?php
if($nowpoint-$webmax>=0){
	echo '<a href="userlist.php?point='.$nowpoint-$webmax.'">前のページへ　</a>';
}
if($nowpoint+$webmax<$count){
	echo '<a href="userlist.php?point='.$nowpoint+$webmax.'">次のページへ</a>';
}
?></p>
	<table>
	<thead>
		<tr>
			<?php
			if ($goodsadd == 0){
				echo '<th style="width:50px;">編集</th>';
			}else{
				echo '<th style="width:50px;"></th>';
			}?>

	
			<th style="width:80px;">法人/個人</th>
            
			<th>名前/会社名/</th>

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
		
		if ($rs["taikai"]==1){
		$classname=" style='background-color:#ccc;'";
		}else{
        $classname="";
		}
		
		?>
		<tr<?=$classname?>>
			
			<td class="centering"><a href="userdisp.php?id=<?=$id?>">編集</a><input type="hidden" name="userids" value="<?=$id?>" /></td>
		
			<td class="centering"><?= (!empty($rs["company"])) ? "法人" : "個人"?></td>

			<td><a href="userdisp.php?id=<?=$id?>">
			<?php
			if (!empty($rs["name"])){
			echo $rs["name"];
			
			}
			echo (!empty($rs["company"])) ? "<br />" . $rs["company"] : '';
			?></a><?= ($rs["taikai"]==1) ? "<span class='red'>（退会済み）</span>" : "";?>
            </td>
           
            
			<td class="centering"><?=$rs["statename"]?></td>
			<td><?php
			echo date('Y-m-d',strtotime($in_date));
			
			?>
			</td>
           
          
			
		</tr>
		<?php
		
		if ($cnt==$webmax){break;}
		}
		
		?>
	</tbody>
	</table>

<p><?php
if($nowpoint-$webmax>=0){
	echo '<a href="userlist.php?point='.$nowpoint-$webmax.'">前のページへ　</a>';
}
if($nowpoint+$webmax<$count){
	echo '<a href="userlist.php?point='.$nowpoint+$webmax.'">次のページへ</a>';
}
?></p>
</div>
</div>
</body>
</html>
