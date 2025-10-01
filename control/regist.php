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
                  rotate = -90;
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
<?php
$sql = "select t_bunrui2.id as b2id,t_bunrui1.id as b1id,t_bunrui2.b2name,t_bunrui1.b1name";
$sql .= " from t_bunrui2 inner join t_bunrui1 on t_bunrui2.bunrui1id = t_bunrui1.id";
$sql .= " order by t_bunrui1.print_order,t_bunrui1.id,t_bunrui2.print_order,t_bunrui2.id";
$b = $dbh->prepare($sql);
$b -> execute();
$result = $b -> fetchAll(PDO::FETCH_ASSOC);
?>
<title>商品管理 &gt; 新規商品登録【<?=$kanriname?>】</title>
</head>
<body>

<div id="box" class="kanri">
<?php include("include/header.php")?>

	<div id="main">
	<?php include("include/leftpane.php")?>
		<div id="cnt">
		
			<h2>新規商品登録</h2>
			
			<div class="block">
			<p>登録するカテゴリを選択してください。</p>
			</div>
			
			<?php
			if (!empty($result)){
        foreach($result as $rs){

				echo '<li class="mb5"><a href="disp_product.php?b2id='.$rs["b2id"].'">' . $rs["b2name"] . '</a></li>';
      
      }
    }
			?>
			</ul>
  </div>
			
		</div>


	</div>
</div>

</body>
</html>
