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




<?php
if (!empty($_REQUEST["id"])){
	if (cnum($_REQUEST["id"])!==0){
	$ids = cnum($_REQUEST["id"]);
		$sql ="SELECT * From t_master Where id=:ids";
    $p = $dbh->prepare($sql);
    $p -> bindValue(":ids",$ids,PDO::PARAM_INT);
    $p -> execute();
		$rs=$p -> fetch(PDO::FETCH_ASSOC);
	}
}

$num = cnum($_REQUEST["number"]);
?>

<title>商品画像登録・編集【<?=$kanriname?>】</title>
</head>
<body>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
	
		<div id="cnt">
        	<form action="imageRegi02.php" enctype="multipart/form-data" method="post">
            
            <input type="hidden" name="id" id="id" value="<?=$ids?>" />
        	<h2><?=rers($rs,"item","")?>の画像登録・編集</h2>
            
          
            
			<h2>画像アップロード</h2>
            
         
			
            <div class="block" style="text-align:left;">
            <p>アップロードする写真を選択してください。</p>
      <?php
			 if (!empty($rs["image".$num])){
			 ?>		
			<img src="<?=$photoimg?>goods/<?=$rs["image" . $num]?>" />		
					<input type="hidden" name="image" value="<?=$rs["image" . $num]?>" />
      <?php
       }else{
			?> 
            
			<p>画像選択：<input type="file" accept="image/*" name="image" id="imageInput" /></p>
                <input type="hidden" name="MAX_FILE_SIZE" value="5000000"><br />
			<img id="preview" src="" alt="画像プレビューがここに表示されます" width="640" style="display: none;">   
                <script>
                const imageInput = document.getElementById('imageInput');
                const preview = document.getElementById('preview');

                imageInput.addEventListener('change', function () {
                const file = this.files[0];

                if (file && file.type.startsWith("image/")) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "";
                    alert("画像ファイルを選択してください。");
                }
                });
            </script> 
			<?php
			}
			?>
      <?php
			if ($ids!==0){
			if (!empty($rs["image".$num])){ 
			echo '<br /><label for="imagedel"><input type="checkbox" name="imagedel" id="imagedel" value="'. $num . '" /> 画像を削除</label><input type="hidden" value="'. $rs["image".$num] .'" name="imgname" id="imgname" />';
			?>

            <?php
			}
			}
			?>
            <input type="hidden" name="number" value="<?=$num?>" />
            </div>
<p class="centering"><input type="submit" value="登録" /> &nbsp;<input type="button" value="戻る" onClick="history.back()" /></p>
 </form>   
			</div>
			
			
			
		</div>
 <?php include("include/leftpane.php")?>  
	</div>
</div>

</body>
</html>
