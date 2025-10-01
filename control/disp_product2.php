<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<?php include("../config.php");?>

<?php
$userid2 = $_COOKIE["adminlogin"];
$password2 = $_COOKIE["adminpasswd"];
if(control_login($userid2,$password2)===false){
	header("location:login.php");
	exit;
}
?>
<head>
<meta name="robots" content="all">
<meta property="og:title" content="太陽と野菜の直売所【東浪見岡本農園】">
<meta property="og:type" content="website">
<meta property="og:url" content="index.php">
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="robots" content="none" />

<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include("include/js.php");?>



<title>商品登録・編集（登録完了）【<?=$kanriname?>】</title>
</head>
<body>
<div id="box" class="kanri">
<!--#include file="include/header.inc"-->
	<div id="main">
	
		<div id="cnt">
			<h2>商品登録・編集（登録完了）</h2>
			<div class="block">
<?php
if($_SERVER["REQUEST_METHOD"] === "POST"){


	if(isset($_FILES["image"])){

		$fileTmpPath = $_FILES["image"]["tmp_name"];
		$filename = $_FILES["image"]["name"];
		$filesize = $_FILES["image"]["size"];
		$fileType = $_FILES["image"]["type"];
		$extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
		
		$uploadFolder = "photo/product/";
		$allowedTypes = ["image/jpeg","image/png","image/gif"];

		//ファイルタイプチェック
		if(!in_array($fileType,$allowedTypes)){

			$error = "JPEG / PNG / GIF の画像のみアップロードできます。";
		}else{
			//ファイル名の重複を避けるための処理
			$newFilename = uniqid("img_")."_".date('YmdHis').".".$extension;
			$destPath = $uploadFolder.$newFilename;

			if(move_uploaded_file($fileTmpPath,$destPath)){
				$success = 1;
			}else{
				$error = "ファイルの保存に失敗しました。";
			}
		}

	// }else{
	// 	$error = "ファイルが選択されていないか、アップロードエラーです。";
	}

	if (!empty($_POST["image"])){
		$newFilename = $_POST["image"];
	}

	if(!empty($_POST["imagedel"])){
		$image_path = "photo/product/".$_POST["imagename"];
		if(unlink($image_path)){
			$newFilename = "";
		}
	}
	


	if(cnum($_POST["id"])!==0){
		$ids = $_POST["id"];
		$sql = "UPDATE t_product set bunrui2=:bunrui2,sname=:sname,modelnumber=:modelnumber,freeword=:freeword,freeword2=:freeword2,price1=:price1,price2=:price2,";
		$sql .= "cleaning=:cleaning,energy=:energy,energy2=:energy2,consultation=:consultation,comment=:comment,memo=:memo,image1=:image1,disp=:disp";
		$sql .= " Where id=:ids";
		$p = $dbh->prepare($sql);
		$p -> bindValue(":bunrui2",$_POST["b2id"],PDO::PARAM_INT);
		$p -> bindValue(":sname",renull($_POST["sname"]),PDO::PARAM_STR);
		$p -> bindValue(":modelnumber",renull($_POST["modelnumber"]),PDO::PARAM_STR);
		$p -> bindValue(":freeword",renull($_POST["freeword"]),PDO::PARAM_STR);
		$p -> bindValue(":freeword2",renull($_POST["freeword2"]),PDO::PARAM_STR);
		$p -> bindValue(":price1",renull($_POST["price1"]),PDO::PARAM_INT);
		$p -> bindValue(":price2",renull($_POST["price2"]),PDO::PARAM_INT);
		$p -> bindValue(":cleaning",$_POST["cleaning"],PDO::PARAM_INT);
		$p -> bindValue(":energy",renull($_POST["energy"]),PDO::PARAM_STR);
		$p -> bindValue(":energy2",renull($_POST["energy2"]),PDO::PARAM_STR);
		$p -> bindValue(":consultation",$_POST["consultation"],PDO::PARAM_INT);
		$p -> bindValue(":comment",renull($_POST["comment"]),PDO::PARAM_STR);
		$p -> bindValue(":memo",renull($_POST["memo"]),PDO::PARAM_STR);
		$p -> bindValue(":image1",renull($newFilename),PDO::PARAM_STR);
		$p -> bindValue(":disp",$_POST["disp"],PDO::PARAM_INT);
		$p -> bindValue(":ids",$ids,PDO::PARAM_INT);
		$p -> execute();
	}else{
		$sql = "INSERT into t_product (bunrui2,sname,modelnumber,freeword,freeword2,price1,price2,cleaning,energy,energy2,consultation,comment,memo,image1,disp,in_date,print_order)";
		$sql .= " values (:bunrui2,:sname,:modelnumber,:freeword,:freeword2,:price1,:price2,:cleaning,:energy,:energy2,:consultation,:comment,:memo,:image1,:disp,:in_date,:print_order)";
		$p = $dbh->prepare($sql);
		$p -> bindValue(":bunrui2",$_POST["b2id"],PDO::PARAM_INT);
		$p -> bindValue(":sname",renull($_POST["sname"]),PDO::PARAM_STR);
		$p -> bindValue(":modelnumber",renull($_POST["modelnumber"]),PDO::PARAM_STR);
		$p -> bindValue(":freeword",renull($_POST["freeword"]),PDO::PARAM_STR);
		$p -> bindValue(":freeword2",renull($_POST["freeword2"]),PDO::PARAM_STR);
		$p -> bindValue(":price1",renull($_POST["price1"]),PDO::PARAM_INT);
		$p -> bindValue(":price2",renull($_POST["price2"]),PDO::PARAM_INT);
		$p -> bindValue(":cleaning",renull($_POST["cleaning"]),PDO::PARAM_INT);
		$p -> bindValue(":energy",renull($_POST["energy"]),PDO::PARAM_STR);
		$p -> bindValue(":energy2",renull($_POST["energy2"]),PDO::PARAM_STR);
		$p -> bindValue(":consultation",renull($_POST["consultation"]),PDO::PARAM_INT);
		$p -> bindValue(":comment",renull($_POST["comment"]),PDO::PARAM_STR);
		$p -> bindValue(":memo",renull($_POST["memo"]),PDO::PARAM_STR);
		$p -> bindValue(":image1",renull($newFilename),PDO::PARAM_STR);
		$p -> bindValue(":disp",$_POST["disp"],PDO::PARAM_INT);
		$p -> bindValue(":in_date",date('Y-m-d H:i:s'),PDO::PARAM_STR);
		$p -> bindValue(":print_order",0,PDO::PARAM_INT);
		$p -> execute();

	}



echo "<p>登録が完了いたしました！</p>";
if (!empty($error)){
		echo "<p>{$error}</p>";
}
if (!empty($ids)){
echo '<p><a href="disp_product.php?id=' . $ids . '">商品詳細へ</a></p>';
}else{
$sql="SELECT max(id) as co From t_product";
$m = $dbh->prepare($sql);
$m -> execute();
$rsm= $m->fetch(PDO::FETCH_ASSOC);
echo '<p><a href="disp_product.php?id=' . $rsm["co"] . '">商品詳細へ</a></p>';
}
echo '<p><a href="productlist.php">商品一覧へ</a></p>';
}
?>
			
			
			
		</div>

	</div>
    <?php include("include/leftpane.php")?>
</div>

</body>
</html>
