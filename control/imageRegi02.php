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


<title>商品画像アップロード【<?=$kanriname?>】</title>
</head>
<body>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
	
		<div id="cnt">
			<h2>商品画像アップロード</h2>
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
				$newFilename = uniqid("img_")."_".$id.".".$extension;
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


		//画像削除
			if(!empty($_POST["imgname"])){
				$uploadFolder = "../photo/goods/";
				unlink($uploadFolder.$_POST["imgname"]);
				$newFilename="";
			}elseif(!empty($_POST["image"])){
					$newFilename = $_POST["image"];
			}


$num = cnum($_POST["number"]);
$sql = "UPDATE t_master set image".$num."=:imagename Where id=:id";
$m = $dbh->prepare($sql);
$m -> bindValue(":imagename",renull($newFilename),PDO::PARAM_STR);
$m -> bindValue(":id",$id,PDO::PARAM_INT);
$m -> execute();


echo "<p>完了いたしました！</p>";
echo "<p><a href='disp.php?id=" . $id . "'>商品詳細へ</a></p>";

	}else{

echo "<p>アクセスが不正です！</p>";
	}
?>
			
			
			
		</div>

	</div>

	<?php include("include/leftpane.php")?>
</div>

</body>
</html>
