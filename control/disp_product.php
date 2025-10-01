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
$id = $_REQUEST["id"] ?? null;

if (!empty($id)) {
    $id = filter_var($id, FILTER_VALIDATE_INT); // 整数チェック
    if ($id !== false && $id !== 0) {
        $sql = "SELECT * FROM t_product WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $rs = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$rs) {
            header("Location: productlist.php");
            exit;
        }
    }
}
?>


<title>新規登録・編集【<?=$kanriname?>】</title>
</head>
<body>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
	
		<div id="cnt">
        
        
        <h2>レンタル重機編集</h2>
        <p><a href="productlist.php">一覧へ戻る</a></p>
        
      <?php
			if (!empty($id)) {
			?>
            <p><a href="<?=$esurl?>pdetails.php?id=<?=$id?>&test=disp" target="_blank" class="underline">ホームページの表示を確認</a></p>
            <p><input type="button" value="商品を削除する" class="delbtn rentaldel" id="delid<?=$rs["id"]?>" title="<?=rers($rs,"sname","")?>" /></p>
      <?php
      }
			?>

            
        	<form action="disp_product2.php" enctype="multipart/form-data" method="post">
            
            <input type="hidden" name="id" id="id" value="<?=rers($rs,"id","")?>" />
        	
            <div class="block">
            <h3>表示/非表示</h3>
            <p><input type="checkbox" name="disp" id="disp" value="1"<?=checked(rers($rs,"disp",""),true)?> /><label for="disp">表示する場合はチェック</label></p>
            
            <h3>カテゴリ名</h3>
            <p><select name="b2id" id="b2id">
                <?php
                $sql = "select * From t_bunrui2 order by print_order";
                $b = $dbh->prepare($sql);
                $b -> execute();
                $result = $b -> fetchAll(PDO::FETCH_ASSOC);

                if(!empty($result)){
                  foreach($result as $rsb2){
                ?>
                <option value="<?=$rsb2["id"]?>"<?=selected($rsb2["id"],rers($rs,"bunrui2",$_GET["b2id"]))?>><?=$rsb2["b2name"]?></option>
                <?php
                  }
              }
                ?>
            </select> </p>
            
            <h3>メーカー名</h3>
            <p><input type="text" name="sname" id="sname" value="<?=rers($rs,"sname","")?>" /></p>

            <h3>型番</h3>
            <p><input type="text" name="modelnumber" id="modelnumber" value="<?=rers($rs,"modelnumber","")?>" /></p>

            <h3>自由項目</h3>
            <p>項目名：<input type="text" name="freeword" id="freeword" value="<?=rers($rs,"freeword","")?>" /><br />
            内容：<input type="text" name="freeword2" id="freeword2" value="<?=rers($rs,"freeword2","")?>" /></p>
            
            
            <h3>レンタル価格</h3>
            <p>1日：<input type="text" name="price1" id="price1" value="<?=rers($rs,"price1","")?>" style="width:15%;" />円（税込）</p>
            2日以上：<input type="text" name="price2" id="price2" value="<?=rers($rs,"price2","")?>" style="width:15%;" />円（税込）</p>
            
            <p><label for="consultation" style="color: #E9070A;font-weight: bold;"><input type="checkbox" name="consultation" id="consultation" value="1"<?=checked(rers($rs,"consultation",""),true)?> />価格応相談</label></p>
            
            <h3>清掃料金</h3>
            <p>1回：<input type="text" name="cleaning" id="cleaning" value="<?=rers($rs,"cleaning","")?>" style="width:15%;" />円（税込）</p>

            <h3>燃料の種類</h3>
            <p><select name="energy" id="ebergy">
              <option value=""></option>
                <option value="ガソリン"<?=selected("ガソリン",rers($rs,"energy",""))?>>ガソリン</option>
                <option value="軽油"<?=selected("軽油",rers($rs,"energy",""))?>>軽油</option>
                <option value="灯油"<?=selected("灯油",rers($rs,"energy",""))?>>灯油</option>
                <option value="充電式"<?=selected("充電式",rers($rs,"energy",""))?>>充電式</option>
            </select><br />
            上記以外：<input type="text" name="energy2" id="energy2" value="<?=rers($rs,"energy2","")?>" />
            </p>

            <h3>機器説明文</h3>
            <p><textarea name="comment" id="comment" cols="40" rows="5" style="width:100%;"><?=rers($rs,"comment","")?></textarea></p>

            <h3>備考欄</h3>
            <p><textarea name="memo" id="memo" cols="40" rows="5" style="width:100%;"><?=rers($rs,"memo","")?></textarea></p>
            </div>    


			<h2>画像アップロード</h2>
            
        
			
    <div class="block" style="text-align:left;">
            <p>アップロードする写真を選択してください。<br />
            写真は横向きを選択してください。アップロードされる写真は自動的に縮小されます。</p>
            <?php
			 if (!empty(rers($rs,"image1","")) && !empty($_GET["id"])){
			 ?>		
			<img src="photo/product/<?=rers($rs,"image1","")?>" id="dispPhoto" />		
					<input type="hidden" name="image" value="<?=rers($rs,"image1","")?>" />
            <?php
       }else{
			?> 
            
				<p>画像選択：<input type="file" name="image" id="imageInput" accept="image/*"></p>
         <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
  <br>
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
			if (!empty($rs["image1"])){ 
			echo '<br /><label for="imagedel"><input type="checkbox" name="imagedel" id="imagedel" value="1" /> 画像を削除</label><input type="hidden" value="'. rers($rs,"image1","") .'" name="imgname" id="imgname" />';
			?>
			</div>
           
            
      <?php
			}
    }

			?>
 <div class="block">     
<p class="centering"><input type="submit" value="登録" /></p>
 </div>
 </form>   


 
			</div>

			
		</div>

    
<?php include("include/leftpane.php")?>
	</div>
</div>

</body>
</html>
