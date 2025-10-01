<?php include("config.php");?>
<?php

//ユーザーの生パスワードを暗号化
$sql = "select id,password2 From t_user";
$u = $dbh->prepare($sql);
$u->execute();

$rs = $u->fetchAll(PDO::FETCH_ASSOC);

foreach($rs as $row){
	$id = $row["id"];
	$pass = $row["password2"];
	echo $id."<br>".$pass."<br>";
	$sql = "UPDATE t_user set password=:password2 Where id=:id";
	$u = $dbh->prepare($sql);
	$u -> bindValue(":password2",password_hash($pass,PASSWORD_DEFAULT),PDO::PARAM_STR);
	$u -> bindValue(":id",$id,PDO::PARAM_INT);
	$u -> execute();
}

?>