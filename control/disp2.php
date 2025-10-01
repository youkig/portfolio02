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
<?php include("include/header.php")?>
	<div id="main">
	
		<div id="cnt">
			<h2>商品登録・編集（登録完了）</h2>
			<div class="block">
            <?php

if($_SERVER["REQUEST_METHOD"] === "POST"){

$id = $_POST["id"];


	if(isset($_FILES["image"])){

			$fileTmpPath = $_FILES["image"]["tmp_name"];
			$filename = $_FILES["image"]["name"];
			$filesize = $_FILES["image"]["size"];
			$fileType = $_FILES["image"]["type"];
			$extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			
			$uploadFolder = "../photo/goods/";
			$allowedTypes = ["image/jpeg","image/png","image/gif"];

			//ファイルタイプチェック
			if(!in_array($fileType,$allowedTypes)){

				$error = "JPEG / PNG / GIF の画像のみアップロードできます。";
			}else{
				//ファイル名の重複を避けるための処理
				$nowdatetime = date('YmdHis');
				$newFilename = uniqid("img_")."_".$nowdatetime.".".$extension;
				$destPath = $uploadFolder.$newFilename;

				if(move_uploaded_file($fileTmpPath,$destPath)){
					$success = 1;
				}else{
					$error = "ファイルの保存に失敗しました。";
				}
			}

		}else{
			$error = "ファイルが選択されていないか、アップロードエラーです。";
		}

		


		if(!empty($_POST["id"])){
			//画像削除
			if(!empty($_POST["imagedel"])){
				$uploadFolder = "../photo/goods/";
				unlink($uploadFolder.$_POST["imgname"]);
				$newFilename="";
			}elseif(!empty($_POST["image"])){
					$newFilename = $_POST["image"];
			}
			$sql = "UPDATE t_master set farmer=:farmer,item=:item,price=:price,pricedisp=:pricedisp,num=:num,unit=:unit,comment=:comment,image1=:image1,disp=:disp,";
			$sql .= "yasaigari=:yasaigari,tanpin=:tanpin Where id=:id";
			$p = $dbh->prepare($sql);
			$p -> bindValue(":farmer",renull($_POST["seisansya"]),PDO::PARAM_STR);
			$p -> bindValue(":item",renull($_POST["item"]),PDO::PARAM_STR);
			$p -> bindValue(":price",cnum($_POST["price"]),PDO::PARAM_INT);
			$p -> bindValue(":pricedisp",cnum($_POST["price_disp"]),PDO::PARAM_INT);
			$p -> bindValue(":num",cnum($_POST["num"]),PDO::PARAM_INT);
			$p -> bindValue(":unit",renull($_POST["tani"]),PDO::PARAM_STR);
			$p -> bindValue(":comment",$_POST["comment"],PDO::PARAM_STR);
			$p -> bindValue(":image1",$newFilename,PDO::PARAM_STR);
			$p -> bindValue(":disp",cnum($_POST["disp"]),PDO::PARAM_INT);
			$p -> bindValue(":yasaigari",cnum($_POST["yasaigari"]),PDO::PARAM_INT);
			$p -> bindValue(":tanpin",cnum($_POST["tanpinhanbai"]),PDO::PARAM_INT);
			$p -> bindValue(":id",$_POST["id"],PDO::PARAM_INT);
			$p -> execute();
		}else{
			$sql = "INSERT into t_master (farmer,item,price,pricedisp,num,unit,comment,image1,disp,yasaigari,tanpin,indate,uid,print_order) values ";
			$sql .= "(:farmer,:item,:price,:pricedisp,:num,:unit,:comment,:image1,:disp,:yasaigari,:tanpin,:indate,:uid,:print_order)";
			$p = $dbh->prepare($sql);
			$p -> bindValue(":farmer",renull($_POST["seisansya"]),PDO::PARAM_STR);
			$p -> bindValue(":item",renull($_POST["item"]),PDO::PARAM_STR);
			$p -> bindValue(":price",cnum($_POST["price"]),PDO::PARAM_INT);
			$p -> bindValue(":pricedisp",cnum($_POST["price_disp"]),PDO::PARAM_INT);
			$p -> bindValue(":num",cnum($_POST["num"]),PDO::PARAM_INT);
			$p -> bindValue(":unit",renull($_POST["tani"]),PDO::PARAM_STR);
			$p -> bindValue(":comment",$_POST["comment"],PDO::PARAM_STR);
			$p -> bindValue(":image1",$newFilename,PDO::PARAM_STR);
			$p -> bindValue(":disp",cnum($_POST["disp"]),PDO::PARAM_INT);
			$p -> bindValue(":yasaigari",cnum($_POST["yasaigari"]),PDO::PARAM_INT);
			$p -> bindValue(":tanpin",cnum($_POST["tanpinhanbai"]),PDO::PARAM_INT);
			$p -> bindValue(":indate",date('Y-m-d H:i:s'),PDO::PARAM_STR);
			$p -> bindValue(":uid",0,PDO::PARAM_INT);
			$p -> bindValue(":print_order",0,PDO::PARAM_INT);
			$p -> execute();
		}

		echo "<p>登録が完了いたしました！</p>";
if (!empty($id)){
echo "<p><a href='disp.php?id=". $id . "'>商品詳細へ</a></p>";
}else{
$sql ="SELECT max(id) as co From t_master";
$m = $dbh->prepare($sql);
$m -> execute();
$rsm = $m -> fetch(PDO::FETCH_ASSOC);
echo "<p><a href='disp.php?id=". $rsm["co"] . "'>商品詳細へ</a></p>";
}
echo "<p><a href='list.php'>商品一覧へ</a></p>";
	
}


?>
			
			
			
		</div>

	</div>
     <?php include("include/leftpane.php")?>  
</div>

</body>
</html>
