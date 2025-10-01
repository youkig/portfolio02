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


<script>

function delebtn(){
	if(window.confirm('本当に削除してよろしいですか？')){

		return true;

	}else{
		window.alert('キャンセルされました'); // 警告ダイアログを表示
		return false;
	}
}
</script>

<?php
$id = cnum($_GET["id"]);

if ($id !== 0){
	$sql = "select * from t_photoalbum where id = :id";
    $p = $dbh->prepare($sql);
    $p -> bindValue(":id",$id,PDO::PARAM_INT);
    $p->execute();
    $rs = $p->fetch(PDO::FETCH_ASSOC);
	$title = "写真集画像詳細";

}
?>

<title><?=$title?>【<?=$kanriname?>】</title>
</head>

<body>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
	
		<div id="cnt">
			<h2><?=$title?></h2>

<form action="mailmagaImagedisp2.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=$id?>" id="id" />
<div class="block">
<p><a href="mailmagaImagelist.php">一覧へ戻る</a></p>
	<table>
		<tbody>
			
            <tr>
            	<th>登録日</th>
                <td><?=$rs["in_date"]?></td>
            </tr>
            <tr>
            	<th>表示/非表示</th>
                <td><input type="checkbox" name="disp" value="1"<?=checked($rs["disp"],true)?> /></td>
            </tr>
            
            <tr>
            	<th>表示順</th>
                <td><input type="text" name="order" value="<?=$rs["print_order"]?>" size="5" /></td>
            </tr>
            
            <tr>
            	<th>ページURL</th>
                <td><a href="<?="http://www.okamoto-farm.co.jp/photoalbum_details.php?id=".$rs["dateid"]?>" target="_blank"><?="http://www.okamoto-farm.co.jp/photoalbum_details.php?id=".$rs["dateid"]?></a><input type="text" name="url" value="<?="http://www.okamoto-farm.co.jp/photoalbum_details.php?id=".$rs["dateid"]?>" size="60" style="width:80%;" /></td>
            </tr>
            
            <tr>
            	<th>タイトル</th>
                <td><input type="text" name="title" id="title" value="<?=$rs["title"]?>" style="width:80%;" /></td>
            </tr>
			<tr>
				<th>画像</th>
				<td>
					
			<?php
			 if (!empty($rs["image"])){
			 ?>		
			<img src="<?=$photoimg?>photoimg/<?=$rs["image"]?>" id="dispPhoto" />		
					<input type="hidden" name="image" value="<?=$rs["image"]?>" />
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
			if ($id!==0){
			if (!empty($rs["image"])){
                echo '<br /><label for="mailimagedel"><input type="checkbox" name="mailimagedel" id="mailimagedel" value="1" /> 画像を削除</label><input type="hidden" value="'. $rs["id"] .'" name="mailimgname" id="mailimgname" />';
            }
        }
			?>
            
				</td>
			</tr>
            
            <tr>
            	<th>説明文</th>
                <td><textarea name="comment" id="comment" cols="60" rows="10" style="width:80%;"><?=$rs["naiyo"]?></textarea></td>
            </tr>
			
		</tbody>
	</table>
	<p><input type="submit" name="regist" value="更新する" /></p>
    <input type="hidden" name="delimage" value="<?=$rs["image"]?>" />
    <p><input type="submit" name="delete" value="このデータを削除する" onclick="delebtn()" /></p>
</div>

</form>


		</div>
   <?php include("include/leftpane.php")?>
	</div>
</div>

</body>
</html>
