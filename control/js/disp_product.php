<?php include("../../config.php");?>
<?php


$id = cnum($_GET["id"]);
$str = "";
if ($id!==0){
	$sql = "select * from t_product where id = :id";
	$p = $dbh->prepare($sql);
	$p -> bindValue(":id",$id,PDO::PARAM_INT);
	$p -> execute();
	$rs = $p -> fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)){
		$sql = "UPDATE t_product set disp=:disp Where id=:id";
		$p = $dbh->prepare($sql);
		$p -> bindValue(":id",$id,PDO::PARAM_INT);
		if($rs["disp"]==1){
			$disp = 0;
			$str = "success0";
		}else{
			$disp = 1;
			$str = "success1";
		}		
		$p -> bindValue(":disp",$disp,PDO::PARAM_INT);	
		$p -> execute();
		
	}

}
echo $str;
?>
