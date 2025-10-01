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

$sql = "select * from t_yasaigari01";
$y = $dbh->prepare($sql);
$y -> execute();
$result = $y ->fetchAll(PDO::FETCH_ASSOC);
if ($result){
	$sql = "select max(indate) as max from t_yasaigari01";
	$max = $dbh->prepare($sql);
	$max -> execute();
	$rsmax = $max->fetch(PDO::FETCH_ASSOC);
	$year1 = date('Y',strtotime($rsmax["max"]));
	
	$sql = "select min(indate) as min from t_yasaigari01";
	$min = $dbh->prepare($sql);
	$min -> execute();
	$rsmin = $min->fetch(PDO::FETCH_ASSOC);
	$year2 = date('Y',strtotime($rsmin["min"]));
}else{
	$year1 = date('Y');
	$year2 = $year1;
}


	$title = "野菜狩り予約一覧";

?>

<title><?=$title?>【<?=$kanriname?>】</title>
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
	<form action="yasaigarimemberlist.php">
	<input type="hidden" value="<?=$sendmail?>" name="sendmail" />
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
				for ($i=1;$i<=31;$i++){
				?>
				<option value="<?=$i?>"<?selected(cnum($_GET["day".$x]),$i)?>><?=$i?></option>
				<?php
					}
					?>
				</select>日
				<?php
				if ($x == 1){echo " ～ ";}
				}
				?>
				</td>
                <th>種別</th>
                <td><input type="radio" name="membersyubetsu" id="membersyubetsu1" value="1"<?=checked(cnum($_GET["membersyubetsu"]),1)?> /><label for="membersyubetsu1">法人</label>&nbsp;&nbsp;<input type="radio" name="membersyubetsu" id="membersyubetsu2" value="0"<?php if (!empty($_GET["membersyubetsu"])){echo checked(cnum($_GET["membersyubetsu"]),0);}?> /><label for="membersyubetsu2">個人</label>&nbsp;&nbsp;<input type="radio" name="membersyubetsu" id="membersyubetsu3" value="2"<?=checked(cnum($_GET["membersyubetsu"]),2)?> /><label for="membersyubetsu3">全て</label></td>
			</tr>
			
			<tr>
				<th>キーワード</th>
				<td><input name="keyword" type="text" id="keyword" size="50" value="<?=$_GET["keyword"]?>" style="width:100%;" /></td>
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
                        <option value="<?=$rsstate["id"]?>"<?=selected($rsstate["id"],cnum($_GET["state"]))?>><?=$rsstate["state"]?></option>
                        <?php
						}
						?>
					</select>
				</td>
			</tr>
			  
			</tbody>
		</table>
		<p><input type="submit" value="検索" />　<a href="yasaigarimemberlist.php">全件表示</a></p>
		<input type="hidden" name="goodsadd" value="<?=$goodsadd?>" />
		
	</form>
    
        
</div>

<div class="block">
<?php
            if (!empty($_GET["pdate"])){
            $today=$_GET["pdate"];
            }else{
            $today=date('Y-m-d');
            }
	        $tmonth=date('Y-m',strtotime($today));
            
            $nextmonth=date("Y-m-01",strtotime($today."1 month"));
			$lastday = date("t",strtotime($today));
			$firstweek = date("w",strtotime($tmonth."-01")); 


// '予約済みデータの集計
$yd = array_fill(0, 32, 0); // 0で初期化
$yn = array_fill(0, 32, 0);


$sql="SELECT count(ydate) as co,ydate From t_yasaigari02 Where ydate>=:tmonth and ydate<:edate and cancel=0 group by ydate order by ydate";
$y = $dbh->prepare($sql);
$y -> bindValue(":tmonth",date('Y-m-d',strtotime($tmonth.'-01')),PDO::PARAM_STR);
$y -> bindValue(":edate",date('Y-m-d', strtotime($nextmonth . '-01')),PDO::PARAM_STR);
$y -> execute();
$result = $y->fetchAll(PDO::FETCH_ASSOC);


if ($result){
	foreach($result as $rsy){
		$d=date('d',strtotime($rsy["ydate"]));
		$yd[$d]=$rsy["ydate"];

		$yn[$d]=$rsy["co"];
		
	}
}
     
            $loop1=($lastday+$firstweek) / 7;
			   
			   $amari=($lastday+$firstweek) % 7;
			   if ($amari>0){
			   $loop1++;
			   }

$prevmonth=date('Y-m-01',strtotime($today."-1 month"));
$prevmonth=date('Y-m-01',strtotime($prevmonth));

$nextmonth=date('Y-m-01',strtotime($today."1 month"));
$nextmonth=date('Y-m-01',strtotime($nextmonth));

?>

    <p><a href="yasaigarimemberlist.php?pdate=<?=$prevmonth?>">前の月</a> 　<?=date('Y年m月',strtotime($tmonth))?>　<a href="yasaigarimemberlist.php?pdate=<?=$nextmonth?>">次の月</a></p>   
          
            <table summary="予約カレンダー" class="atten">
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
				   $c=$lastday+$firstweek;
				   $cnt=0;
				   for ($a=1;$a<=$loop1;$a++){
				   
				   ?> 
                   <tr style="border:1px solid;">
                   <?php
				   $cnt1=0;
				   for ($b=1;$b<=$c;$b++){
				   $cnt1++;
				   if ($cnt1 <= 7) {
        			$classname = "";
				   if ($cnt1 == 1) {
						$classname = " class='first'";
					}

					if ($cnt1 == 7) {
						$classname = " class='last'";
					}

				   ?>
                   	 <td<?=$classname?>>
                       <?php
							if ($b>=$firstweek || $cnt>0){
							$cnt++;
                                if ($cnt<=$lastday){
								
                                if (cnum($yn[$cnt])>0){
                                echo '<a href="yasaigarimemberlist.php?ndate='. $yd[$cnt] . '&pdate=' .$today . '" style="text-decoration:underline;">' . $cnt .'</a>';
                                }else{
                                echo $cnt;
                                }
                                if ($week==2 || $week==6){
                                ?>
                                <p class="red centering small">定休日</p>
                                <?php
                                }
                                }
					   		}
				        ?>
                            
                     </td>
                           
                   <?php
				   if ($cnt1==7){break;}
						}
					}
				   ?>         
                   </tr>
                   <?php
				   }
				   ?>  
           
                </tbody>
             </table>
</div>



<div class="block">
<?php

$webmax=20;
$nowpoint = cnum($_REQUEST["point"]);
$maxco=$nowpoint+10;
//'------------------------------------------------------------------------------------------------
$sql = "select t_yasaigari01.*,t_yasaigari02.ydate,t_yasaigari02.yhour,t_yasaigari02.ytime,t_yasaigari02.num,t_yasaigari02.kago,t_yasaigari02.bento,t_state.state as statename ";
$sqlf = " From t_yasaigari01 inner join t_yasaigari02 on t_yasaigari01.id=t_yasaigari02.uid inner join t_state on t_yasaigari01.state=t_state.id";

$sqlw = " Where t_yasaigari01.id<>0";
if (!empty($_GET["ndate"])){
$sqlw .=" and t_yasaigari02.ydate=:ndate"; // & request2("ndate") 
}
if (!empty($_REQUEST["keyword"])){
	$sqlw .= " and (t_yasaigari01.name Like :keyword or t_yasaigari01.furigana Like :keyword or t_yasaigari01.company Like :keyword or t_yasaigari01.busyo Like :keyword or t_yasaigari01.email Like :keyword or t_yasaigari01.email Like :keyword or t_yasaigari01.address Like :keyword or t_yasaigari01.address2 Like :keyword)";
}

if (cnum($_REQUEST["state"])!==0){
	$sqlw .= " and t_yasaigari01.state = :state";
}

if (!empty($_REQUEST["year1"]) && !empty($_REQUEST["month1"]) && !empty($_REQUEST["day1"])){
	$idate = date('Y-m-d',strtotime(($_REQUEST["year1"]."-".$_REQUEST["month1"]."-".$_REQUEST["day1"])."1 day"));
    $sqlw .= " and t_yasaigari01.indate>=:indate";  //& dateserial(request("year1"),request("month1"),request("day1")) & "'"
}

if (!empty($_REQUEST["year2"]) && !empty($_REQUEST["month2"]) && !empty($_REQUEST["day2"])){
	$edate = date('Y-m-d',strtotime(($_REQUEST["year2"]."-".$_REQUEST["month2"]."-".$_REQUEST["day2"])."1 day"));
    $sqlw .= " and t_yasaigari01.indate<':edate";
}

if (!empty($_GET["membersyubetsu"])){
    if (cnum($_REQUEST["membersyubetsu"])==1){
    $sqlw .= " and t_yasaigari01.person='法人'";
	}elseif (cnum($_REQUEST["membersyubetsu"])==0){
    $sqlw .= " and t_yasaigari01.person='個人'";
    }
}

$sqlo = " order by t_yasaigari01.indate desc";
$sqll = " LIMIT ".$nowpoint.",".$webmax;
$y = $dbh->prepare($sql.$sqlf.$sqlw.$sqlo.$sqll);
if (!empty($_REQUEST["ndate"])){
	$y -> bindValue(":ndate",$_REQUEST["ndate"],PDO::PARAM_STR);
}
if (cnum($_REQUEST["state"])!==0){
	$y -> bindValue(":state",$_REQUEST["state"],PDO::PARAM_INT);
}

if (!empty($_REQUEST["year1"]) && !empty($_REQUEST["month1"]) && !empty($_REQUEST["day1"])){
	$y -> bindValue(":indate",date('Y-m-d',strtotime($idate)),PDO::PARAM_STR);
}

if (!empty($_REQUEST["year2"]) && !empty($_REQUEST["month2"]) && !empty($_REQUEST["day2"])){
	$y -> bindValue(":edate",date('Y-m-d',strtotime($edate)),PDO::PARAM_STR);
}
if (!empty($_REQUEST["keyword"])){
	$y -> bindValue(":keyword",'%'.trim($_REQUEST["keyword"]).'%',PDO::PARAM_STR);
}
$y -> execute();
$result = $y->fetchAll(PDO::FETCH_ASSOC);

$sqlco = "select count(t_yasaigari01.id) as co From t_yasaigari01 inner join t_yasaigari02 on t_yasaigari01.id=t_yasaigari02.uid ".$sqlw;

$y = $dbh->prepare($sqlco);
if (!empty($_GET["ndate"])){
	$y -> bindValue(":ndate",$_REQUEST["ndate"],PDO::PARAM_STR);
}
if (cnum($_REQUEST["state"])!==0){
	$y -> bindValue(":state",$_REQUEST["state"],PDO::PARAM_INT);
}

if (!empty($_REQUEST["year1"]) && !empty($_REQUEST["month1"]) && !empty($_REQUEST["day1"])){
	$y -> bindValue(":indate",date('Y-m-d',strtotime($idate)),PDO::PARAM_STR);
}
if (!empty($_REQUEST["year2"]) && !empty($_REQUEST["month2"]) && !empty($_REQUEST["day2"])){
	$y -> bindValue(":edate",date('Y-m-d',strtotime($edate)),PDO::PARAM_STR);
}
if (!empty($_REQUEST["keyword"])){
	$y -> bindValue(":keyword",'%'.trim($_REQUEST["keyword"]).'%',PDO::PARAM_STR);
}
$y -> execute();
$rsco = $y->fetch(PDO::FETCH_ASSOC);

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
	echo '<a href="yasaigarimemberlist.php?point='.$nowpoint-$webmax.'">前のページへ　</a>';
}
if($nowpoint+$webmax<$count){
	echo '<a href="yasaigarimemberlist.php?point='.$nowpoint+$webmax.'">次のページへ</a>';
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

			<th>有効</th>
			<th style="width:80px;">法人/個人</th>
            
			<th>名前/会社名/</th>

			<th>都道府県</th>
            <th>予約日</th>
            <th>予約時間</th>
            <th>人数</th>
            <th>カゴ数</th>
			<th>登録日</th>
            
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($result as $rs){
		$cnt++;
		$in_date = $rs["indate"];
		$id = $rs["id"];
		$classname="";
		if ($rs["cancel"]==1){
		$classname=" style='background-color:#ccc;'";
		}
		
		?>
		<tr<?=$classname?>>
			
			<td class="centering"><a href="yasaigarimemberdisp.php?id=<?=$rs["id"]?>">編集</a><input type="hidden" name="userids" value="<?=$id?>" /></td>
			<td class="centering"><?php if ($rs["cancel"]==1){
				echo "<span class='blue'>無効</span>";
			}else{
				echo "<span class='red'>有効</span>";
			}	
			?></td>
			<td class="centering"><?=$rs["person"]?></td>

			<td><a href="yasaigarimemberdisp.php?id=<?=$id?>">
				<?php
			if (!empty($rs["name"])){
			echo $rs["name"];
			}
			if (!empty($rs["company"])){
				echo "<br />" . $rs["company"];
			}
			?></a>
            </td>
           
            
			<td class="centering"><?=$rs["statename"]?></td>
			<td><?=$rs["ydate"]?>
			</td>
           
              
			<td>
            <?php
            if ($rs["ytime"]==0){
				$ytime="00";
			}else{
				$ytime=$rs["ytime"];
			}
			echo $rs["yhour"] . "時" . $ytime . "分";
			?>
			</td>
            
            <td><?=$rs["num"]?>人</td>
            <td><?=$rs["kago"]?>個</td>
            <td><?=$rs["indate"]?>
            
			</td>
			
		</tr>
		<?php
		if ($cnt==$webmax){break;}
		}
		
		?>
	</tbody>
	</table>

	

</div>
</div>
</body>
</html>
