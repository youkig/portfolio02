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

<title>野菜（商品）新規登録／農産物直売所 千葉【太陽と野菜の直売所】貸し農園 一宮町／野菜狩り／農業体験</title>

<link rel="stylesheet" href="../css/base.css" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

<script src="../js/jquery-1.5.2.min.js"></script>
<script src="../js/jquery-ui.js"></script>
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

<script>
$(function(){
	
	$(".imageregibtn").click(function(){
		var num = $(this).attr("id");
		num = num.replace("image","");
		var ids = $("#id").val();
		window.location.href = "imageRegist01.asp?id=" + ids + "&number="+ num
	});
	
	$(".delbtn").click(function(){
						
		var a = $(this).attr("id");
		a = a.replace("delid","");
		var b = $(this).attr("title");
		var c = $(this).attr("class");
		
			if(c.indexOf("syouhindel") > 0){
				var d = "商品";
				var f = "sid";
			}
		
		if(window.confirm(d + '：'+b+'を削除してよろしいですか？')){
		
			$.ajax({
				type: "get",
				url: "/js/news_del.asp",
				data: f + "=" + a,
				success: function(str){
					if(str == "success"){
						//setTimeout(ReloadAddr,100);
						alert("削除されました。");
						location.href = 'https://www.okamoto-farm.co.jp/farmer/mypage.asp';
					}else{
						alert(str + "エラーが起こりました。\n削除は完了していない可能性があります。");
					}
				}
			});
		};
		lencount($("textarea.naiyou"));
	});

})

</script>
</head>
<%
if request("id")<>"" then
	if clng2(request("id"))<>0 then
	ids = clng2(request("id"))
		SQL="SELECT * From t_master Where id=" & ids
		set rs=db.execute(SQL)
		if rs.eof then response.Redirect("mypage.asp")
	end if
end if
%>
<body>

<div id="box">

<div id="header">
	<h1>新鮮野菜 直売所／千葉 一宮町</h1>


<!--#include file="../include/header.inc"-->

<div id="main" class="container">
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">トップページ</a> | <a href="<%=ESURL%>farmer/mypage.asp">生産農家会員マイページ</a> | 野菜（商品）新規登録</p>
	<div class="block">
	<h2>野菜（商品）新規登録</h2>


</div>

	<%
			if request("id")<>"" then
			%>
<p><a href="<%=ESURL%>details.asp?id=<%=ids%>&test=disp" target="_blank" class="underline">ホームページの表示を確認</a></p>
<p><input type="button" value="商品を削除する" class="delbtn syouhindel" id="delid<%=rs("id")%>" title="<%=rers(rs,"商品名","")%>"></p>
	<%
			end if
			%>


	<form action="newregist02.asp" enctype="multipart/form-data" method="post">

<input type="hidden" name="id" id="id" value="<%=rers(rs,"id","")%>">
	
<div class="block">
<h3>表示/非表示</h3>
<p><input type="checkbox" name="disp" id="disp" value="1"<%=checked(rers(rs,"disp",""),True)%>><label for="disp">表示する場合はチェック</label></p>



<h3>商品名</h3>
<p><input type="text" name="sname" id="sname" value="<%=rers(rs,"商品名","")%>"></p>


<h3>販売価格</h3>
<p><input type="text" name="price" id="price" value="<%=rers(rs,"価格","")%>" style="width:20%;">円（税込）</p>

<h3>販売数量</h3>
<p><input type="text" name="num" id="num" value="<%=rers(rs,"数量","")%>" style="width:20%;"></p>

<h3>単位</h3>
		<p>例）個、セットなど<br>
<input type="text" name="tani" id="tani" value="<%=rers(rs,"単位","")%>" style="width:20%;"></p>


<h3>商品コメント</h3>
<p><textarea name="comment" id="comment" cols="40" rows="5" style="width:100%;"><%=rers(rs,"コメント","")%></textarea></p>

			
</div>

			
<div class="block" style="text-align:left;">
<h3>画像アップロード</h3>
<p>アップロードする写真を選択してください。<br>
写真は<span class="red">「横向き」</span>を選択してください。アップロードされる写真は自動的に縮小されます。</p>
<%
			if request("id")="" then
			response.Write("<p class='red'>新規登録の時は、画像は1枚だけの登録となります。編集ページで合計4枚まで登録出来ます。</p>")
			end if
			
			 if not isnull(rers(rs,"image1","")) and request("id")<>"" then
			 %>		
			<img src="<%=photoimg%>goods/<%=rers(rs,"image1","")%>" id="dispPhoto">		
					<input type="hidden" name="image" value="<%=rers(rs,"image1","")%>">
<%
			else
			%>

				<p>画像選択：<input type="file" accept="image/*" name="uploadFile" id="uploadFile" onChange="dispThumbnail()"></p>
<input type="hidden" name="base64area" id="base64area" value=""><br>



			<canvas id="dispPhoto" name="dispPhoto" width="640" height="480" style="width:100%;"></canvas>
			<%
			end if
			%>

<%
			if ids<>0 then
			if rs("image1") <> "" then
			response.write "<br><label for=""imagedel""><input type=""checkbox"" name=""imagedel"" id=""imagedel"" value=""1""> 画像を削除</label><input type=""hidden"" value="""& rs("id") &""" name=""imgname"" id=""imgname"">"
			%>
			</div>
<div class="block">
<%
			for a=2 to 4
			if isnull(rs("image"&a)) then
			txt="登録"
			else
			txt="編集・削除"
			end if
			%>
<h4>○画像<%=a%></h4>
			<p><input type="button" name="image<%=a%>" id="image<%=a%>" value="画像<%=a%>を<%=txt%>する" class="imageregibtn">

<%if rs("image"&a)<>"" then%>
<br><img src="<%=photoimg%>goods/<%=rers(rs,"image"&a,"")%>" width="150">
<%
			end if
			%>
</p>

<%
			next
			%>


<%
			end if
			end if
			%>
<p class="centering"><input type="submit" value="登録"></p>

	<input type="hidden" name="uid" value="<%=session("setid")%>">
</form>
			
</div>


<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<!--#include file="../include/leftpane.inc"-->
	

<!-- id main end --></div>

<!--#include file="../include/footer.inc"-->


<!-- id box end --></div>
</body>
</html>
