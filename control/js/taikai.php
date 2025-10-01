<?php include("../../config.php");?>
<?php
$id = cnum($_GET["id"]);

$str = "";
if ($id !== 0){
	$sql = "select * from t_user where id = :id";
	$u = $dbh->prepare($sql);
	$u -> bindValue(":id",$id,PDO::PARAM_INT);
	$u -> execute();
	$rs = $u ->fetch(PDO::FETCH_ASSOC);
	if ($rs){
    	$sql="update t_user set taikai=1,dele=1 Where id=:id";
		$u = $dbh->prepare($sql);
		$u -> bindValue(":id",$id,PDO::FETCH_ASSOC);
		$u -> execute();
    $str="success";
	}

}
echo $str;

?>
