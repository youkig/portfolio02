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



<title>農園写真集用画像アップロード【<?=$kanriname?>】</title>
</head>
<body>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
	
		<div id="cnt">
			<h2>農園写真集用画像アップロード</h2>
			<div class="block">
<?php
if($_SERVER["REQUEST_METHOD"] === "POST"){


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

    if($success == 1){
    $sql = "INSERT into t_photoalbum (title,naiyo,image,disp,in_date,dateid) values (:title,:naiyo,:image,:disp,:in_date,:dateid)";
    $p = $dbh->prepare($sql);
    $p -> bindValue(":title",$_POST["title"],PDO::PARAM_STR);
    $p -> bindValue(":naiyo",$_POST["comment"],PDO::PARAM_STR);
    $p -> bindValue(":image",$newFilename,PDO::PARAM_STR);
    $p -> bindValue(":disp",1,PDO::PARAM_INT);
    $p -> bindValue(":in_date",date('Y-m-d H:i:s'),PDO::PARAM_STR);
    $p -> bindValue(":dateid",strrev($nowdatetime),PDO::PARAM_STR);
    $p -> execute();
        }
        
    if(!empty($error)){
        echo $error;
    }else{
    echo "<p>画像アップロードが完了いたしました！</p>";
    echo "<p><a href='mailmagaImagelist.php'>写真集一覧へ</a></p>";
    }
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
