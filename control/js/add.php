<?php include("../../config.php");?>
<?php


$id = $_GET["id"];
$oid= $_GET["oid"];
$num= $_GET["num"];
$str = "";
if ($id !== 0){
	$sql = "select * from t_master where id = :id";
	$m = $dbh->prepare($sql);
	$m -> bindValue(":id",$id,PDO::PARAM_INT);
	$m -> execute();
	$rs = $m->fetch(PDO::FETCH_ASSOC);
	if ($rs["ischk_stock"]){
	$sql="UPDATE t_master set stock=stock-1 Where id=:id";
	$m = $dbh->prepare($sql);
	$m -> bindValue(":id",$id,PDO::PARAM_INT);
	$m -> execute();
	
	
	$sql="UPDATE t_order set num=num+1 Where id=:oid";
	$m = $dbh->prepare($sql);
	$m -> bindValue(":oid",$oid,PDO::PARAM_INT);
	$m -> execute();
	}
	
	$str=$num+1;
	

}
echo $str;

?>
