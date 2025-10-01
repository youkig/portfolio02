
<?php
include("../config.php");
$id = cnum($_GET["id"]);
$comment = $_GET["comment"];


$sql = "UPDATE t_prose_comment set comment=:comment where id=:id";
$n = $dbh->prepare($sql);
$n->bindValue(":id", $id, PDO::PARAM_INT);
$n->bindValue(":comment", $comment, PDO::PARAM_STR);
$n->execute();

echo "success";
?>