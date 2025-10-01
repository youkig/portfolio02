<?php include("../../config.php");?>
<?php

$id = $_GET["id"];
$num  = $_GET["num"];

		$sql="UPDATE t_product set print_order=:num Where id=:id";
        $u = $dbh->prepare($sql);
        $u -> bindValue(":num",$num,PDO::PARAM_INT);
        $u -> bindValue(":id",$id,PDO::PARAM_INT);
		$u -> execute();

	$str="success";
echo $str;

?>