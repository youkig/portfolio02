
<?php
include("../config.php");
$pid = cnum($_GET["id"]);
$mid = cnum($_GET["mid"]);
$comment = $_GET["comment"];

$sql = "INSERT INTO t_prose_comment (pid, motoid, comment, penname, userid, indate, disp, shinsa) VALUES (:pid, :motoid, :comment, :penname, :userid, :indate, :disp, :shinsa)";
$n = $dbh->prepare($sql);
$n->bindValue(":pid", $pid, PDO::PARAM_INT);
$n->bindValue(":motoid", $mid, PDO::PARAM_INT);
$n->bindValue(":comment", $comment, PDO::PARAM_STR);
$n->bindValue(":penname", "農園管理人", PDO::PARAM_STR);
$n->bindValue(":userid", 0, PDO::PARAM_INT); // 管理者の返信なのでuseridは0に設定
$n->bindValue(":indate", date("Y-m-d H:i:s"), PDO::PARAM_STR);
$n->bindValue(":disp", 1, PDO::PARAM_INT); // 管理者の返信は即表示
$n->bindValue(":shinsa", 1, PDO::PARAM_INT); // 管理者の返信は審査済み
$n->execute();

$sql = "UPDATE t_prose_comment set disp=1, shinsa=1 where id=:id";
$n = $dbh->prepare($sql);
$n->bindValue(":id", $mid, PDO::PARAM_INT);
$n->execute();

echo "success";
?>