<?php include("../../config.php");?>
<?php

$id = cnum($_GET["id"]);
$str = "";
if ($id !== 0){
	$sql = "select * from t_receipt_master where id = :id";
	$r = $dbh->prepare($sql);
	$r -> bindValue(":id",$id,PDO::PARAM_INT);
	$r -> execute();
	$rs = $r -> fetch(PDO::FETCH_ASSOC);
	if ($rs){
		$sql = "UPDATE t_receipt_master set dele=1 Where id=:id";
		$r = $dbh->prepare($sql);
		$r -> bindValue(":id",$id,PDO::PARAM_INT);
		$r -> execute();
		$str = "success1";
		
	}
}
echo $str;
?>
