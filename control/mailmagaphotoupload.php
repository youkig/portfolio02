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

<script type="text/javascript" src="js/exif-js.js"></script>
<script>
function dispThumbnail(){
    var select_file = document.getElementById("uploadFile");
    var canvas = document.getElementById("dispPhoto");
    var file = select_file.files;
    var reader = new FileReader();
    //dataURL形式でファイルを読み込む
    reader.readAsDataURL(file[0]);
    //ファイルの読込が終了した時の処理
    reader.onload = function(){
        readDrawImg(reader, canvas, 0, 0);
    }
}

function readDrawImg(reader, canvas, x, y){
    var img = readImg(reader);
    var canvasDefW = canvas.width;    // canvasの初期幅
    img.onload = function(){
	
	
        var w = img.width;
        var h = img.height;
		
		
        var resize = resizeWidthHeight(canvasDefW, w, h);
        drawImgOnCav(canvas, img, x, y, resize.w , resize.h );
		
        // CanvasImageのBASE64URIへの変換
        //document.getElementById("base64area").value = canvas.toDataURL("image/png");
		document.getElementById("base64area").value = canvas.toDataURL("image/jpeg");
		
    }
	
	
}
//ファイルの読込が終了した時の処理
function readImg(reader){
    //ファイル読み取り後の処理
    var result_dataURL = reader.result;
    var img = new Image();
    img.src = result_dataURL;
    return img;
	
	
}
//キャンバスにImageを表示
function drawImgOnCav(canvas, img, x, y, w, h) {
    var ctx = canvas.getContext("2d");
    canvas.width = w;
    canvas.height = h;
	
	EXIF.getData(img, function () {
       
		var rotate = 0;
        // 横幅を基準としてリサイズする
		
		// 回転方向の読み取り
              if (EXIF.pretty(this)) {
                if (EXIF.getAllTags(this).Orientation == 6) {
                  rotate = 90;
                } else if (EXIF.getAllTags(this).Orientation == 3) {
                  rotate = 180;
                } else if (EXIF.getAllTags(this).Orientation == 8) {
                  rotate = 270;
                }
              }
			  
			
		if (rotate == 90 || rotate == 270) {
		  canvas.width = h;
		  canvas.height = w;
		} else {
		  canvas.width = w;
		  canvas.height = h;
		}	  
			  
		// 画像の回転
              if (rotate && rotate > 0) {
                ctx.rotate(rotate * Math.PI / 180);
                if (rotate == 90)
                  ctx.translate(0, -h);
                else if (rotate == 180)
                  ctx.translate(-w, -h);
                else if (rotate == 270)
                  ctx.translate(-w, 0);
              }	 
    ctx.drawImage(img, x, y, w, h);
	});
}




// リサイズ後のwidth, heightを求める
function resizeWidthHeight(target_length_px, w0, h0){
    //リサイズの必要がなければ元のwidth, heightを返す
    if(w0 <= target_length_px){
        return{
            flag: false,
            w: w0,
            h: h0
        };
    }
    // 横幅を基準としたリサイズの計算
    var w1;
    var h1;
    w1 = target_length_px;
    h1 = h0 * target_length_px / w0;
    return {
        flag: true,
        w: w1,
        h: h1
    };
}
</script>



<title>メルマガ画像アップロード【<?=$kanriname?>】</title>
</head>
<body>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
	
		<div id="cnt">
			<h2>画像アップロード</h2>
            
            <div class="block">
            
            </div>
			
            <div class="block" style="text-align:left;">
            <p>アップロードする写真を選択してください。<br />
            アップロードされる写真は自動的に縮小されます。</p>
            
            <form action="mailmagaphotoupload_com.php" enctype="multipart/form-data" method="post">
				<p>画像選択：<input type="file" accept="image/*" name="image" id="imageInput" /></p>
                <input type="hidden" name="MAX_FILE_SIZE" value="5000000"><br />
                
                
          
                <p>タイトル（任意）：<input type="text" name="title" id="title" value="" size="20" /></p>
            <p>コメント（任意）：<textarea name="comment" id="comment" cols="30" rows="5"></textarea></p>
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
<p><input type="submit" value="送信" /></p>
 </form>   
			</div>
			
			
			
		</div>
<?php include("include/leftpane.php")?>
	</div>
</div>

</body>
</html>
