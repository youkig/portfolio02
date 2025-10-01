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


<script type="text/javascript">
$(function(){
	
	$(".imageregibtn").click(function(){
		var num = $(this).attr("id");
		num = num.replace("image","");
		var ids = $("#id").val();
		window.location.href = "imageRegi01.php?id=" + ids + "&number="+ num
	});
	


})

</script>

<?php
if (!empty($_GET["id"])){
	if (cnum($_GET["id"])!==0){
	$ids = cnum($_GET["id"]);
		$sql = "SELECT * From t_master Where id=:ids";
		$m = $dbh->prepare($sql);
        $m -> bindValue(":ids",$ids,PDO::PARAM_INT);
        $m -> execute();
        $rs = $m->fetch(PDO::FETCH_ASSOC);
		if (!$rs){
            header("location:list.php");
        }
	}
}
?>

<title>今週末野菜狩りのできる野菜登録・編集【<?=$kanriname?>】</title>
</head>
<body>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
	
		<div id="cnt">
        
        
        <h2>野菜編集</h2>
        <p><a href="list.php">一覧へ戻る</a></p>
        
        	<?php
			if (!empty($_GET["id"])){
			?>
            <p><a href="<?=$esurl?>details.php?id=<?=$ids?>&test=disp" target="_blank" class="underline">ホームページの表示を確認</a></p>
            <p><input type="button" value="商品を削除する" class="delbtn syouhindel" id="delid<?=$rs["id"]?>" title="<?=rers($rs,"item","")?>" /></p>
         	<?php
            }
			?>
            
            
        	<form action="disp2.php" enctype="multipart/form-data" method="post">
            
            <input type="hidden" name="id" id="id" value="<?=rers($rs,"id","")?>" />
        	
            
            <h3>表示/非表示</h3>
            <p><input type="checkbox" name="disp" id="disp" value="1"<?=checked(rers($rs,"disp",""),true)?> /><label for="disp">表示する場合はチェック</label></p>
            
            <h3>生産者</h3>
            <?php
			if (empty($_GET["id"])){
			$seisansya="東浪見岡本農園";
            }else{
			$seisansya="";
            }
			if (cnum(rers($rs,"uid",""))==0 && is_null(rers($rs,"farmer",""))){
			$seisansya="東浪見岡本農園";
            }elseif (cnum(rers($rs,"uid",""))!==0){
			$sql="SELECT * From t_cuser Where id=:uid";
            $u = $dbh->prepare($sql);
            $u -> bindValue(":uid",rers($rs,"uid",""),PDO::PARAM_INT);
            $u -> execute();
            $rssei = $u -> fetch(PDO::FETCH_ASSOC);
			
				if ($rssei){
					if (!empty($rssei["company"])){
					$seisansya=$rssei["company"];
                    }else{
					$seisansya=$rssei["name"];
                    }
				}
            }
			
			if (!empty($seisansya)){
			?>
            <p class="bold"><?=$seisansya?></p>
            
            <?php
            }
			?>
            
           
            
            <p>生産者を編集する場合は以下へ記入してください。<br /><input type="text" name="seisansya" id="seisansya" value="<?=rers($rs,"farmer","")?>" size="40" /></p>
          
            
            <h3>商品名</h3>
            <p><input type="text" name="item" id="item" value="<?=rers($rs,"item","")?>" /></p>
            
            
            <h3>販売価格</h3>
            <p><input type="text" name="price" id="price" value="<?=rers($rs,"price","")?>" style="width:20%;" />円（税込）&nbsp;&nbsp;&nbsp;&nbsp;<br><input type="checkbox" name="price_disp" id="price_disp" value="1"<?=checked(rers($rs,"pricedisp",""),true)?> />
            <label for="price_disp" style="color: #E9070A;font-weight: bold;">販売価格をホームページへ表示する場合はチェックを入れてください。</label></p>
            
            <h3>販売数量</h3>
            <p><input type="text" name="num" id="num" value="<?=rers($rs,"num","")?>" style="width:20%;" /></p>
            
            <h3>単位</h3>
       		<p>例）個、セットなど<br />
            <input type="text" name="tani" id="tani" value="<?=rers($rs,"unit","")?>" style="width:20%;" /></p>
            
            <h3>バナー表示</h3>
            <p><input type="checkbox" name="yasaigari" id="yasaigari" value="1"<?=checked(rers($rs,"yasaigari",""),True)?> /><label for="yasaigari">野菜狩り</label><br />
            <input type="checkbox" name="tanpinhanbai" id="tanpinhanbai" value="1"<?=checked(rers($rs,"tanpin",""),True)?> /><label for="tanpinhanbai">単品販売</label></p>
            <h3>コメント</h3>
            <p><textarea name="comment" id="comment" cols="40" rows="5" style="width:100%;"><?=rers($rs,"comment","")?></textarea></p>
            
			<h2>画像アップロード</h2>
            
        
			
            <div class="block" style="text-align:left;">
            <p>アップロードする写真を選択してください。<br />
            写真は横向きを選択してください。アップロードされる写真は自動的に縮小されます。</p>
            <?php
			if (empty($_GET["id"])){
			echo "<p class='red'>新規登録の時は、画像は1枚だけの登録となります。編集ページで合計4枚まで登録出来ます。</p>";
            }
			
			 if (!empty(rers($rs,"image1","")) && !empty($_GET["id"])){
			 ?>		
			<img src="<?=$photoimg?>goods/<?=rers($rs,"image1","")?>" id="dispPhoto" />		
					<input type="hidden" name="image" value="<?=rers($rs,"image1","")?>" />
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
			
			if ($ids!==0){
			if (!empty($rs["image1"])){ 
			echo '<br /><label for="imagedel"><input type="checkbox" name="imagedel" id="imagedel" value="1" /> 画像を削除</label><input type="hidden" value="'. $rs["image1"].'" name="imgname" id="imgname" />';
			?>
			</div>
            <div class="block">
            <?php
			for ($a=2;$a<=4;$a++){
			if (!empty($rs["image".$a])){ 
			$txt="編集・削除";
            }else{ 
			$txt="登録";
            }
			?>
            <h4>○画像<?=$a?></h4>
			<p><input type="button" name="image<?=$a?>" id="image<?=$a?>" value="画像<?=$a?>を<?=$txt?>する" class="imageregibtn" />
            <?if (!empty($rs["image".$a]))
            {
            ?>
            <br /><img src="<?=$photoimg?>goods/<?=rers($rs,"image".$a,"")?>" width="150" />
            <?php
            }
			?>
            </p>
            
            <?php
            }
			?>
            </div>
            
            <?php
			}
			}
			?>
<p class="centering"><input type="submit" value="登録" /></p>
 </form>   
			</div>
			
			
			
		</div>
 <?php include("include/leftpane.php")?>  
	</div>
</div>

</body>
</html>
