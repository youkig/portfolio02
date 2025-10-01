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
	
	
	$(".disp_btn").click(function(){
	
		var yid=$(this).attr("id");
		
		id = yid.replace("disp_","");
		
			$.ajax({
				type: "get",
				url: "js/disp.php",
				data: "id=" + id,
				success: function(str){
					if(str == "success0"){
						$("#disp_"+id).val("表示にする");
						$("#tr_" + id).css("background-color","#ccc");
					}else{
						$("#disp_"+id).val("非表示にする");
						$("#tr_" + id).css("background-color","#fff");
					}
				}
			});
	});
	
	
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

<title>予約一覧【<?=$kanriName?>】</title>
</head>

<body>
<?php
if ($goodsadd == 0){
?>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
	
		<div id="cnt">
			<h2>予約一覧</h2>

<?php

$webmax=20;
$nowpoint = cnum($_REQUEST["point"]);
$maxco=$nowpoint+10;

$sql = "select * from t_reserved order by id desc Limit ".$nowpoint.",".$webmax;
$r = $dbh->prepare($sql);
$r -> execute();

$result = $r -> fetchAll(PDO::FETCH_ASSOC);

$sql = "select count(t_reserved.id) as co From t_reserved";
$c = $dbh->prepare($sql);
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

?>

<h3>商品一覧</h3>
<div class="block">
<?php
if (!$result){
	echo "<p>予約はありません</p>";
}else{
	echo "<p>{$count}件の該当がありました。</p>";
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

            	<th style="width:5%;">予約詳細</th>
             
                <th style="width:15%;" class="url">名前</th>
                <th style="width:15%;" class="url">ふりがな</th>
                <th style="width:10%;">メールアドレス</th>
                <th style="width:10%;">都道府県</th>
                <th style="width:5%;">来店予定日</th>
				<th style="width:10%;" class="date">予約日</th>
				
				
			</tr>
		</thead>
		<tbody>
		<?php
		
		$cnt = 0;
		foreach($result as $rs){
		$cnt++;
		$id= $rs["id"];

		($rs["cancel"]==1) ? $classname=' style="background-color:#ccc;"' : $classname="";
		?>
		<tr<?=$classname?> id="tr_<?=$id?>">
			
			<td class="centering"><a href="reserved.php?id=<?=$id?>">詳細</a></td>
            
			
			<td class="centering"><?=$rs["name"]?></td>
            <td class="centering"><?=$rs["furigana"]?></td>
            <td class="url"><?=$rs["email"]?></td>
            <td class="url"><?=$rs["state"]?></td>
            <td class="centering"><?=$rs["rmonth"] . "月" . $rs["rday"] . "日"?></td>
			<td class="date"><?=$rs["indate"]?></td>
			
		</tr>
		<?php
		if ($cnt==$webmax){break;}
		}
		?>
		</tbody>
	</table>
    

<?php

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
