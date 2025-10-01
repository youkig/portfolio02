
<?php
include("../config.php");
$id = cnum($_GET["id"]);
$disp = $_GET["disp"];


$sql = "UPDATE t_prose_comment set disp=:disp where id=:id";
$n = $dbh->prepare($sql);
$n->bindValue(":id", $id, PDO::PARAM_INT);
$n->bindValue(":disp", $disp, PDO::PARAM_INT);
$n->execute();

echo "success";
?>