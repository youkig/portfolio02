<?php include("../../config.php");?>
<?php

$id = cnum($_GET["id"]);
$str = "";
if ($id !== 0){
	$sql = "select * from t_master where id = :id";
	$m = $dbh->prepare($sql);
	$m -> bindValue(":id",$id,PDO::PARAM_INT);
	$m -> execute();
	$rs = $m->fetch(PDO::FETCH_ASSOC);

	if ($rs){
		if ($rs["disp"]==1){
		$sql = "UPDATE t_master set disp=0 Where id=:id";
		$m = $dbh->prepare($sql);
		$m -> bindValue(":id",$id,PDO::PARAM_INT);
		$m -> execute();
		$str = "success0";
		}else{
		$sql = "UPDATE t_master set disp=1 Where id=:id";
		$m = $dbh->prepare($sql);
		$m -> bindValue(":id",$id,PDO::PARAM_INT);
		$m -> execute();
		$str = "success1";
		}
		
		
	}

}
echo $str;
?>
