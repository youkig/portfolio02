<?php
session_start();
?>
<?php include("../config.php");?>

<?php
$userid2 = $_COOKIE["adminlogin"];
$password2 = $_COOKIE["adminpasswd"];
if(control_login($userid2,$password2)===false){
	header("location:login.php");
	exit;
}

if($_SERVER["REQUEST_METHOD"] === "POST"){

$id = $_POST["id"];

if(isset($_POST["delete"])){
	$sql = "DELETE from t_photoalbum Where id=:id";
	$d = $dbh->prepare($sql);
	$d -> bindValue(":id",$id,PDO::PARAM_INT);
	$d ->execute();

	//画像削除
	if(!empty($_POST["image"])){
		$uploadFolder = "../photo/photoimg/";
		unlink($uploadFolder.$_POST["delimage"]);
	}
	header ("location:mailmagaImagelist.php");
}else{

	if(isset($_FILES["image"])){

			$fileTmpPath = $_FILES["image"]["tmp_name"];
			$filename = $_FILES["image"]["name"];
			$filesize = $_FILES["image"]["size"];
			$fileType = $_FILES["image"]["type"];
			$extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			
			$uploadFolder = "../photo/photoimg/";
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

		//画像削除
		if(!empty($_POST["mailimagedel"])){
			$uploadFolder = "../photo/photoimg/";
			unlink($uploadFolder.$_POST["delimage"]);
			$newFilename="";
		}



	$sql = "UPDATE t_photoalbum set disp=:disp,print_order=:orderno,image=:image,title=:title,naiyo=:comment Where id=:id";
	$p = $dbh->prepare($sql);
	$p -> bindValue(":disp",cnum($_POST["disp"]),PDO::PARAM_INT);
	$p -> bindValue(":orderno",cnum($_POST["order"]),PDO::PARAM_INT);
	$p -> bindValue(":image",$newFilename,PDO::PARAM_STR);
	$p -> bindValue(":title",$_POST["title"],PDO::PARAM_STR);
	$p -> bindValue(":comment",$_POST["comment"],PDO::PARAM_STR);
	$p -> bindValue(":id",$id,PDO::PARAM_INT);
	$p -> execute();

	header("location:mailmagaImagedisp.php?id=".$id);
}
}

	

?>