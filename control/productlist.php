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
				url: "js/disp_product.php",
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
											url : "js/orderchange3.php",
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
	

	//$(".b1select").change(function(){
	//	var b1id = $(this).val();
	//	window.location.href = "productlist.php?b1id="+ b1id;
	//});

	$(".b2select").change(function(){
		var b1id = $(".b1select").val();
		var b2id = $(this).val();
		//window.location.href = "productlist.php?b2id="+ b2id + "&b1id=" + b1id;
		window.location.href = "productlist.php?b2id="+ b2id;
	});
});
</script>

<title>レンタル重機一覧【<?=$kanriname?>】</title>
</head>

<body>
<?php
if ($goodsadd == 0){
?>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
	
		<div id="cnt">
			<h2>レンタル重機一覧</h2>
<h3>新規登録</h3>
<div class="block">
	<p><a href="regist.php">新規登録</a></p>
</div>

<h3>カテゴリ絞込</h3>
<div class="block">

	<p>
		<select name="b2name" id="b2name"  class="b2select">
		<option value="">　　　　　　　　　</option>
			<?php
			$sql="select t_bunrui2.* From t_bunrui2 inner join t_bunrui1 on t_bunrui2.bunrui1id=t_bunrui1.id order by t_bunrui1.print_order,t_bunrui2.print_order";
			$b2 = $dbh->prepare($sql);
			$b2 -> execute();
			$result = $b2->fetchAll(PDO::FETCH_ASSOC);
			
			if(!empty($result)){
			foreach($result as $rsb2){
			?>
				<option value="<?=$rsb2["id"]?>"<?=selected(cnum($_GET["b2id"]),$rsb2["id"])?>><?=$rsb2["b2name"]?></option>
			<?php
			}
			}
			?>
		</select>
	</p>
</div>



<?php

if (!empty($_POST["ccnt"])){

	$ccnt = cnum($_POST["ccnt"]);
	for($a=1;$a<=$ccnt;$a++){
	$sql="UPDATE t_product set print_order =:print_order Where id=:id";
	$m = $dbh->prepare($sql);
	$m -> bindValue(":print_order",$_POST["order_".$a],PDO::PARAM_INT);
	$m -> bindValue(":id",$_POST["id_".$a],PDO::PARAM_INT);
	$m -> execute();
	}
}

$sql = "";
$sql = "select t_product.*,t_bunrui2.b2name,t_bunrui1.b1name";
$sql .= " from t_product inner join t_bunrui2 on t_product.bunrui2 = t_bunrui2.id inner join t_bunrui1 on t_bunrui2.bunrui1id = t_bunrui1.id";
$sqlw .= " Where t_product.id>0 ";
if (!empty($_GET["b1id"])){
	$sqlw .= " and t_bunrui1.id = :b1id"; //& clng2(request("b1id"))
}

if (!empty($_GET["b2id"])){
	$sqlw .= " and t_product.bunrui2 = :b2id"; //& clng2(request("b2id"))
}

	$sqlo = " order by t_product.print_order,t_bunrui1.print_order,t_bunrui2.print_order";
$b = $dbh->prepare($sql.$sqlw.$sqlo);
if (!empty($_GET["b1id"])){
	$b-> bindValue(":b1id",$_GET["b1id"],PDO::PARAM_INT);
}
if (!empty($_GET["b2id"])){
	$b-> bindValue(":b2id",$_GET["b2id"],PDO::PARAM_INT);
}
	$b-> execute();
	$result = $b->fetchAll(PDO::FETCH_ASSOC);

	$sql = "";
$sql = "select count(t_product.id) as co From t_product".$sqlw;
$c = $dbh->prepare($sql);
if (!empty($_GET["b1id"])){
	$c-> bindValue(":b1id",$_GET["b1id"],PDO::PARAM_INT);
}
if (!empty($_GET["b2id"])){
	$c-> bindValue(":b2id",$_GET["b2id"],PDO::PARAM_INT);
}
$c-> execute();
$rsco = $c -> fetch(PDO::FETCH_ASSOC);
$count = $rsco["co"];


?>

<h3>レンタル重機一覧</h3>
<div class="block">
<?php
if (empty($result)){
	echo "<p>登録はありません</p>";
}else{
	echo "<p>". $count ."件の該当がありました。</p>";
}
?>

<p class="red bold">並び替えの方法：テーブルの行を任意の場所にドラック＆ドロップしてください。</p>

<form action="productlist.php" method="post">
<input type="submit" name="update" value="更新" />
	<table id="jquery-ui-sortable">
		<thead>
			<tr>
            	<th style="width:5%;">表示</th>
            	<th style="width:5%;">詳細</th>
                <th style="width:5%;">並び順</th>
				<th style="width:10%;">画像</th>
                <th style="width:30%;" class="url">型式<br />メーカー/カテゴリ名</th>
                

			</tr>
		</thead>
		<tbody>
		<?php
		$cnt = 0;
		foreach($result as $rs){
		$cnt++;
		$id=$rs["id"];

		if (!$rs["disp"]){
			$classname=" style='background-color:#ccc;'";
		}else{
			$classname="";
		}
		?>
		<tr<?=$classname?> id="tr_<?=$id?>">
			<td class="centering">
           
			<input type="button" name="disp_btn" id="disp_<?=$id?>" class="disp_btn" value="<?($rs["disp"]==1) ? print "非表示にする" : print "表示にする"?>" />
            <input type="hidden" name="id_<?=$cnt?>" value="<?=$id?>" />
			</td>
			<td class="centering"><a href="disp_product.php?id=<?=$id?>">詳細</a></td>
            <td class="centering"><input type="text" name="order_<?=$cnt?>" id="order_<?=$cnt?>" value="<?=$rs["print_order"]?>" size="2" class="pordernumber" /></td>
			
			<td class="centering">
            <?php
			if (!empty($rs["image1"])){
				$imagename="photo/product/" . $rs["image1"];
			}else{
				$imagename="http://www.okamoto-farm.co.jp/img/top/image01.jpg";
			}
			?>
            <img src="<?=$imagename?>" width="200" /></td>
            <td class="url">
            <a href="disp_product.php?id=<?=$id?>"><?=$rs["modelnumber"]?></a><br /><?=$rs["sname"]?> &gt; <?=$rs["b2name"]?></td>
            
           
         
			
		</tr>
		<?php
		}
		?>
		</tbody>
	</table>
    
 <input type="submit" name="update" value="更新" />
 <input type="hidden" name="ccnt" value="<?=$cnt?>" />
  </form>  
<?php

	}

?>
</div>

		</div>
     <?php include("include/leftpane.php")?>
	</div>
</div>

</body>
</html>
