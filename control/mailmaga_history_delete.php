
<?php
include("../config.php");
$id = cnum($_GET["id"]);


$sql = "DELETE FROM t_mailmaga_history WHERE id=:id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->execute();

echo "success";
?>