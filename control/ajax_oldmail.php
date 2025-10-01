
<?php
include("../config.php");
$id = cnum($_GET["id"]);


$sql = "SELECT * From t_mailmaga_history Where id=:id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($result);
?>