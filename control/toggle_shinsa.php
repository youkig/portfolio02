
<?php
include("../config.php");
$id = cnum($_GET["id"]);
$shinsa = $_GET["shinsa"];


$sql = "UPDATE t_prose_comment set shinsa=:shinsa where id=:id";
$n = $dbh->prepare($sql);
$n->bindValue(":id", $id, PDO::PARAM_INT);
$n->bindValue(":shinsa", $shinsa, PDO::PARAM_INT);
$n->execute();

echo "success";
?>