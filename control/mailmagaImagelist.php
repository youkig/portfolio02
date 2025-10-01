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
$(function () {

	//$('#jquery-ui-sortable > tbody').sortable();
	
	$('#jquery-ui-sortable > tbody').sortable({
				cursor: 'move',
				opacity: 0.7,
				placeholder: 'ui-state-highlight',
				
    			
			 	update: function(ev, ui) {
                    var Arraytr = $("#jquery-ui-sortable > tbody").sortable("toArray");
					var num = Arraytr.length;
                   	
					var newch = 0;
					if($("#news_chk").is(":checked")){
					newch = 1;
					
					}
					var idnames;
					var idn= new String();
					var onum="";
					var coun=0;
						for(var i=0;i<=num;i++){
						
							idn = Arraytr[i].replace("tr_","");
							
							
							idnames=$("#"+Arraytr[i]).find(".pordernumber").attr("id");
							
							$("#"+idnames).val(coun);
								
										$.ajax({
											type: "get",
											url : "js/orderchange2.php",
											data : "id=" + idn + "&num=" + coun,
											success: function(str){
																	if(str == "success"){
																		//alert("成功");
																	}else{
																		alert("エラーが起こりました。\n登録は完了していない可能性があります。");
																	}
											}
										});	
							coun = coun + 10;			
						}
					
					
                },
				stop: function(ev, ui){
					
				   ui.item.children('td').effect('highlight');
				   }
				
    }).bind('click.sortable mousedown.sortable',function(ev){
                ev.target.focus();
            });
    //$('#jquery-ui-sortable > tbody').disableSelection();
	
});
</script>

<title>写真集用画像一覧【<?=$kanriname?>】</title>
</head>

<body>
<?if ($goodsadd == 0){
?>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
	
		<div id="cnt">
			<h2>写真集用画像一覧</h2>
<h3>新規登録</h3>
<div class="block">
	<p><a href="mailmagaphotoupload.php">新規登録</a></p>
</div>






<?php
if (!empty($_POST["update"])){

	for ($a=1; $a<=cnum($_POST["count"]);$a++){
		$sql = "UPDATE t_photoalbum set disp=:disp,print_order=:orderno Where id=:id";
		$p = $dbh->prepare($sql);
		$p -> bindValue(":disp",cnum($_POST["disp_".$a]),PDO::PARAM_INT);
		$p -> bindValue(":orderno",$_POST["order_".$a],PDO::PARAM_INT);
		$p -> bindValue(":id",$_POST["id_".$a],PDO::PARAM_INT);
		$p -> execute();
	}
}
$webmax=10;
$nowpoint=cnum($_GET["point"]);

$maxco=$nowpoint+10;
$sql = "select * from t_photoalbum order by disp desc,print_order,id desc";

if ($nowpoint!==0){
$sql .=" LIMIT ".$nowpoint.",".$webmax;
}
$p = $dbh->prepare($sql);
$p->execute();
$result = $p->fetchAll(PDO::FETCH_ASSOC);

$sql = "select count(t_photoalbum.id) as co from t_photoalbum";
$p = $dbh->prepare($sql);
$p ->execute();
$rsco = $p ->fetch(PDO::FETCH_ASSOC);
$count = $rsco["co"];


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

?>

<h3>画像一覧</h3>
<div class="block">
<?php
if (empty($result)){
	echo "<p>画像はありません</p>";
}else{
	echo "<p>{$count}件の該当がありました。</p>";
?>

<p><?php
if($nowpoint-$webmax>=0){
	echo '<a href="mailmagaImagelist.php?point='.$nowpoint-$webmax.'">前のページへ　</a>';
}
if($nowpoint+$webmax<$count){
	echo '<a href="mailmagaImagelist.php?point='.$nowpoint+$webmax.'">次のページへ</a>';
}
?></p>
<p class="red bold">並び替えの方法：テーブルの行を任意の場所にドラック＆ドロップしてください。</p>

<form action="mailmagaImagelist.php" method="post">
<input type="submit" name="update" value="更新" />
	<table id="jquery-ui-sortable">
		<thead>
			<tr>
            	<th style="width:5%;">表示</th>
            	<th style="width:5%;">詳細</th>
                <th style="width:5%;">並び順</th>
				<th style="width:10%;">画像</th>
                <th style="width:30%;" class="url">ページURL/タイトル</th>
				<th style="width:10%;" class="date">登録日</th>
				
				
			</tr>
		</thead>
		<tbody>
		<?php
		$cnt = 0;
		foreach($result as $key=>$rs){
		$cnt++;
		$id=$rs["id"];
		$id2=$rs["dateid"];
		if ($rs["disp"]==0){
			$classname=" style='background-color:#ccc;'";
		}else{
			$classname="";
		}
		?>
		<tr<?=$classname?> id="tr_<?=$id?>">
			<td class="centering">
			<input type="checkbox" name="disp_<?=$cnt?>" value="<?=$rs["disp"]?>"<?=checked($rs["disp"],true)?> />
            <input type="hidden" name="id_<?=$cnt?>" value="<?=$id?>" />
			</td>
			<td class="centering"><a href="mailmagaImagedisp.php?id=<?=$id?>">詳細</a></td>
            <td class="centering"><input type="text" name="order_<?=$cnt?>" id="order_<?=$cnt?>" value="<?=$rs["print_order"]?>" size="2" class="pordernumber" /></td>
			
			<td class="centering"><img src="<?=$photoimg?>photoimg/<?=$rs["image"]?>" width="200" /></td>
            <td class="url"><a href="<?="http://www.okamoto-farm.co.jp/photoalbum_details.php?id=".$id2?>" target="_blank"><?="http://www.okamoto-farm.co.jp/photoalbum_details.php?id=".$id2?></a><br /><input type="text" name="url" value="<?="http://www.okamoto-farm.co.jp/photoalbum_details.php?id=".$id2?>" style="width:80%;" /><br />
            <?=$rs["title"]?></td>
			<td class="date"><?=$rs["in_date"]?></td>
			
		</tr>
		<?php
		if ($cnt==$webmax){break;}
	}
		?>
		</tbody>
	</table>
    
    <input type="submit" name="update" value="更新" />
    <input type="hidden" name="count" value="<?=$cnt?>" />
  </form>  
<?php
	echo "<p>{$count}件の該当がありました。</p>";
if($nowpoint-$webmax>=0){
	echo '<a href="mailmagaImagelist.php?point='.$nowpoint-$webmax.'">前のページへ　</a>';
}
if($nowpoint+$webmax<$count){
	echo '<a href="mailmagaImagelist.php?point='.$nowpoint+$webmax.'">次のページへ</a>';
}

}
}
?>
</div>

		</div>
     <?php include("include/leftpane.php")?>
	</div>
</div>

</body>
</html>
