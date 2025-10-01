<!DOCTYPE html>
<html lang="ja">
<!--#include file="../config.inc"-->

<%
if not loginch(Session("logid"),Session("pass")) then response.redirect sslurl & "farmer/login.asp"
%>

<head>

<meta name="robots" content="all">
<meta property="og:title" content="太陽と野菜の直売所【東浪見岡本農園】">
<meta property="og:type" content="website">
<meta property="og:url" content="index.asp">
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="canonical" href="https://www.okamoto-farm.co.jp/index.asp">
<meta name="keywords" content="野菜,農産物,直売所,産直野菜,土産,通販,貸し農園,レンタル農園,野菜狩り,農業体験,千葉県,長生郡,一宮町">

<meta name="description" content="株式会社東浪見岡本農園（千葉県長生郡一宮町）が経営する【太陽と野菜の直売所】ホームページでは、農園に併設している農産物直売所のご紹介と、レンタル農園（貸し農園）、野菜狩り体験のほか、直売所に出荷する農家さんへのご案内を行っています。">

<title>商品画像登録・編集（完了）／農産物直売所 千葉【太陽と野菜の直売所】貸し農園 一宮町／野菜狩り／農業体験</title>

<link rel="stylesheet" href="../css/base.css" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

<script type="text/javascript" src="../js/jquery-1.5.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../js/jquery.ui.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="../js/jquery.bgswitcher.js"></script>
<script src="../js/pagetop.js"></script>

<script src="../js/topslide.js"></script>

<script src="/js/exif-js.js"></script>
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



<%
if request("id")<>"" then
	if clng2(request("id"))<>0 then
	ids = clng2(request("id"))
		SQL="SELECT * From t_master Where id=" & ids
		set rs=db.execute(SQL)
	end if
end if

num = clng2(request("number"))
%>
</head>

<body>

<div id="box">

<div id="header">
	<h1>新鮮野菜 直売所／千葉 一宮町</h1>


<!--#include file="../include/header.inc"-->



<div id="main" class="container">
	<div id="cnt" class="mypage">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">トップページ</a> | <a href="<%=ESURL%>farmer/mypage.asp">生産農家会員マイページ</a> | 商品画像登録・編集（完了）</p>
	<div class="block">
	<h2><%=rers(rs,"商品名","")%>の画像登録・編集</h2>



</div>

<div class="block">
	 <%
Response.Buffer=True

Dim s_cntTotal
Dim s_getBinary
Dim s_objBasp21
Dim s_strBase64
Dim s_result

s_cntTotal = Request.TotalBytes
s_getBinary = Request.BinaryRead(s_cntTotal)
SET s_objBasp21 = server.createobject("basp21")


if s_objBasp21.Form(s_getBinary, "id")<>"" then
	if s_objBasp21.Form(s_getBinary, "base64area")<>"" then
		nowtime =now()
		imgname="img_" & replace(replace(replace(nowtime," ",""),"/",""),":","")
		
		
		s_strBase64 = s_objBasp21.Form(s_getBinary, "base64area")
		's_result = ImportCanvas(s_strSaveMapFilePass, s_strBase64)
	
	
	'Function ImportCanvas(param_strFilePass, param_strBase64)
		Const adTypebinary = 1    ' バイナリデータ
		Const adTypeText = 2    ' テキストデータ
	
		Dim stream, xmldom, node
		Dim strBase64
		Set xmldom = Server.CreateObject("Microsoft.XMLDOM")
		Set node = xmldom.CreateElement("base64")
		node.DataType = "bin.base64"
	
		strBase64 = Replace(s_strBase64, "data:image/png;base64,","") 'Base64の文字列を渡す
		kaucyo = ".png"
		If InStr(strBase64, "data:image/") <> 0 Then
			strBase64 = Replace(s_strBase64, "data:image/jpeg;base64,","") 'Base64の文字列を渡す
			kaucyo = ".jpg"
		End If
		

		param_strFilePass = server.MapPath("../photo/goods/" & imgname & kaucyo)
		node.text = strBase64
		Set stream = Server.CreateObject("ADODB.Stream")
		stream.Type = adTypeBinary
		stream.Open
		stream.write node.NodeTypedValue
		stream.saveToFile param_strFilePass, 1 'ファイルを作成
		stream.Close
		Set stream = Nothing
	
		Set node = Nothing
		Set xmldom = Nothing
	
		ImportCanvas = 0
	
	else
	
		
	
	end if

num = cint2(s_objBasp21.Form(s_getBinary,"number"))
ids = clng2(s_objBasp21.Form(s_getBinary,"id"))

set rs=server.CreateObject("adodb.recordset")
rs.open "SELECT * From t_master Where id=" & ids ,db,3,3


if s_objBasp21.Form(s_getBinary, "imagedel")="" then
rs("image"& num) = imgname & kaucyo
else


			Set fs = CreateObject("Scripting.FileSystemObject")

				if ids <> 0 then
					sql = "select *"
					sql = sql & " from t_master"
					sql = sql & " where id = " & ids
					set rs2 = db.execute(sql)
					imgnames = rs2("image" & num)
				end if
			
			strpath= Server.MapPath("../photo/goods")
			strpath = strpath & "\"&imgnames
		'response.write(strpath)
			if fs.fileExists(strpath) then
				fs.deletefile strpath
			end if
			
	rs("image"& num) = NULL
end if


rs.update
rs.close

response.write("<p>完了いたしました！</p>")
response.write("<p><a href='newregist01.asp?id=" & ids & "'>商品詳細へ</a></p>")

else

response.write("<p>アクセスが不正です！</p>")
end if
%>
</div>




<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<!--#include file="../include/leftpane.inc"-->
	

<!-- id main end --></div>

<!--#include file="../include/footer.inc"-->


<!-- id box end --></div>
</body>
</html>
