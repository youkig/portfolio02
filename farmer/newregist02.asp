<!DOCTYPE html>
<html lang="ja">
<!--#include file="../config.inc"-->
<%
if not loginch(Session("logid"),Session("pass")) then response.redirect sslurl & "farmer/login.asp"
%>

<head>

<meta name="robots" content="all">
<meta property="og:title" content="‘¾—z‚Æ–ìØ‚Ì’¼”„Šy“Œ˜QŒ©‰ª–{”_‰€z">
<meta property="og:type" content="website">
<meta property="og:url" content="index.asp">
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="canonical" href="https://www.okamoto-farm.co.jp/index.asp">
<meta name="keywords" content="–ìØ,”_Y•¨,’¼”„Š,Y’¼–ìØ,“yY,’Ê”Ì,‘İ‚µ”_‰€,ƒŒƒ“ƒ^ƒ‹”_‰€,–ìØë‚è,”_‹Æ‘ÌŒ±,ç—tŒ§,’·¶ŒS,ˆê‹{’¬">

<meta name="description" content="Š”®‰ïĞ“Œ˜QŒ©‰ª–{”_‰€iç—tŒ§’·¶ŒSˆê‹{’¬j‚ªŒo‰c‚·‚éy‘¾—z‚Æ–ìØ‚Ì’¼”„Šzƒz[ƒ€ƒy[ƒW‚Å‚ÍA”_‰€‚É•¹İ‚µ‚Ä‚¢‚é”_Y•¨’¼”„Š‚Ì‚²Ğ‰î‚ÆAƒŒƒ“ƒ^ƒ‹”_‰€i‘İ‚µ”_‰€jA–ìØë‚è‘ÌŒ±‚Ì‚Ù‚©A’¼”„Š‚Éo‰×‚·‚é”_‰Æ‚³‚ñ‚Ö‚Ì‚²ˆÄ“à‚ğs‚Á‚Ä‚¢‚Ü‚·B">

<title>–ìØi¤•ijV‹K“o˜^i“o˜^Š®—¹j^”_Y•¨’¼”„Š ç—ty‘¾—z‚Æ–ìØ‚Ì’¼”„Šz‘İ‚µ”_‰€ ˆê‹{’¬^–ìØë‚è^”_‹Æ‘ÌŒ±</title>

<link rel="stylesheet" href="../css/base.css" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

<script src="../js/jquery-1.5.2.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../js/jquery.ui.css" />

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
//dataURLŒ`®‚Åƒtƒ@ƒCƒ‹‚ğ“Ç‚İ‚Ş
reader.readAsDataURL(file[0]);
//ƒtƒ@ƒCƒ‹‚Ì“Ç‚ªI—¹‚µ‚½‚Ìˆ—
reader.onload = function(){
readDrawImg(reader, canvas, 0, 0);
}
}

function readDrawImg(reader, canvas, x, y){
var img = readImg(reader);
var canvasDefW = canvas.width;    // canvas‚Ì‰Šú•
img.onload = function(){
	
	
var w = img.width;
var h = img.height;
		
		
var resize = resizeWidthHeight(canvasDefW, w, h);
drawImgOnCav(canvas, img, x, y, resize.w , resize.h );
		
// CanvasImage‚ÌBASE64URI‚Ö‚Ì•ÏŠ·
//document.getElementById("base64area").value = canvas.toDataURL("image/png");
		document.getElementById("base64area").value = canvas.toDataURL("image/jpeg");
		
}
	
	
}
//ƒtƒ@ƒCƒ‹‚Ì“Ç‚ªI—¹‚µ‚½‚Ìˆ—
function readImg(reader){
//ƒtƒ@ƒCƒ‹“Ç‚İæ‚èŒã‚Ìˆ—
var result_dataURL = reader.result;
var img = new Image();
img.src = result_dataURL;
return img;
	
	
}
//ƒLƒƒƒ“ƒoƒX‚ÉImage‚ğ•\¦
function drawImgOnCav(canvas, img, x, y, w, h) {
var ctx = canvas.getContext("2d");
canvas.width = w;
canvas.height = h;
	
	EXIF.getData(img, function () {

		var rotate = 0;
// ‰¡•‚ğŠî€‚Æ‚µ‚ÄƒŠƒTƒCƒY‚·‚é
		
		// ‰ñ“]•ûŒü‚Ì“Ç‚İæ‚è
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
			
		// ‰æ‘œ‚Ì‰ñ“]
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




// ƒŠƒTƒCƒYŒã‚Ìwidth, height‚ğ‹‚ß‚é
function resizeWidthHeight(target_length_px, w0, h0){
//ƒŠƒTƒCƒY‚Ì•K—v‚ª‚È‚¯‚ê‚ÎŒ³‚Ìwidth, height‚ğ•Ô‚·
if(w0 <= target_length_px){
return{
flag: false,
w: w0,
h: h0
};
}
// ‰¡•‚ğŠî€‚Æ‚µ‚½ƒŠƒTƒCƒY‚ÌŒvZ
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
		window.location.href = "imageRegi01.asp?id=" + ids + "&number="+ num
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
	<h1>V‘N–ìØ ’¼”„Š^ç—t ˆê‹{’¬</h1>


<!--#include file="../include/header.inc"-->

<div id="main" class="container">
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">ƒgƒbƒvƒy[ƒW</a> | <a href="<%=ESURL%>farmer/mypage.asp">¶Y”_‰Æ‰ïˆõƒ}ƒCƒy[ƒW</a> | –ìØi¤•ijV‹K“o˜^i“o˜^Š®—¹j</p>
	<div class="block">
	<h2>–ìØi¤•ijV‹K“o˜^i“o˜^Š®—¹j</h2>


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

if s_objBasp21.Form(s_getBinary, "sname")<>"" then

	if s_objBasp21.Form(s_getBinary, "base64area")<>"" then
		nowtime =now()
		imgname="img_" & replace(replace(replace(nowtime," ",""),"/",""),":","")
		
		
		s_strBase64 = s_objBasp21.Form(s_getBinary, "base64area")
	's_result = ImportCanvas(s_strSaveMapFilePass, s_strBase64)
	
	
	'Function ImportCanvas(param_strFilePass, param_strBase64)
		Const adTypebinary = 1    ' ƒoƒCƒiƒŠƒf[ƒ^
		Const adTypeText = 2    ' ƒeƒLƒXƒgƒf[ƒ^
	
		Dim stream, xmldom, node
		Dim strBase64
		Set xmldom = Server.CreateObject("Microsoft.XMLDOM")
		Set node = xmldom.CreateElement("base64")
		node.DataType = "bin.base64"
	
		strBase64 = Replace(s_strBase64, "data:image/png;base64,","") 'Base64‚Ì•¶š—ñ‚ğ“n‚·
		kaucyo = ".png"
			If InStr(strBase64, "data:image/") <> 0 Then
				strBase64 = Replace(s_strBase64, "data:image/jpeg;base64,","") 'Base64‚Ì•¶š—ñ‚ğ“n‚·
				kaucyo = ".jpg"
			End If
		
		
		
		param_strFilePass = server.MapPath("../photo/goods/" & imgname & kaucyo)
		node.text = strBase64
		Set stream = Server.CreateObject("ADODB.Stream")
		stream.Type = adTypeBinary
		stream.Open
		stream.write node.NodeTypedValue
		stream.saveToFile param_strFilePass, 1 'ƒtƒ@ƒCƒ‹‚ğì¬
		stream.Close
		Set stream = Nothing
	
		Set node = Nothing
		Set xmldom = Nothing
	
		ImportCanvas = 0
	
	else
	
		Set fs = CreateObject("Scripting.FileSystemObject")
	
	
		if cint2(s_objBasp21.Form(s_getBinary,"imagedel"))=1 then
			imgnames = ""
			
				if cint2(s_objBasp21.Form(s_getBinary, "id")) <> 0 then
					sql = "select *"
					sql = sql & " from t_master"
					sql = sql & " where id = " & cint2(s_objBasp21.Form(s_getBinary, "id"))
					set rs2 = db.execute(sql)
					imgnames = rs2("image1")
				end if
			
			strpath= Server.MapPath("../photo/goods")
			strpath = strpath & "\"&imgnames
		'response.write(strpath)
			if fs.fileExists(strpath) then
				fs.deletefile strpath
			end if
			setimgname = null
	
		end if
	
	end if
	
	
	'Set objImg = Server.CreateObject("ImageMagickObject.MagickImage.1")
	'objImg.Convert param_strFilePass,"-strip", param_strFilePass
'End Function

set rs=server.CreateObject("adodb.recordset")
if cint2(s_objBasp21.Form(s_getBinary, "id"))<>0 then
ids = cint2(s_objBasp21.Form(s_getBinary, "id"))
rs.open "SELECT * From t_master Where id=" & ids,db,3,3
else
rs.open "SELECT * From t_master",db,3,3
rs.addnew
rs("indate") = nowtime
rs("print_order")=0
end if

rs("uid") = clng2(s_objBasp21.Form(s_getBinary, "uid"))
'rs("¶YÒ–¼") = renull(s_objBasp21.Form(s_getBinary, "seisansya"))

rs("¤•i–¼") = renull(s_objBasp21.Form(s_getBinary, "sname"))
rs("‰¿Ši") = renull(s_objBasp21.Form(s_getBinary, "price"))
rs("”—Ê") = renull(s_objBasp21.Form(s_getBinary, "num"))
rs("’PˆÊ") = renull(s_objBasp21.Form(s_getBinary, "tani"))
rs("ƒRƒƒ“ƒg") = renull(s_objBasp21.Form(s_getBinary, "comment"))

if s_objBasp21.Form(s_getBinary, "base64area")<>"" then
rs("image1") = imgname & kaucyo
elseif cint2(s_objBasp21.Form(s_getBinary,"imagedel"))=1 then
rs("image1") = NULL
end if

rs("disp") = cint2(s_objBasp21.Form(s_getBinary, "disp"))


rs.update
rs.close

'V‹K“o˜^ŠÇ—Ò‚Öƒ[ƒ‹‘—M
if clng2(s_objBasp21.Form(s_getBinary, "uid"))>0 and clng2(s_objBasp21.Form(s_getBinary, "id"))=0 then
	SQL="SELECT * From t_cuser Where id=" & clng2(s_objBasp21.Form(s_getBinary, "uid"))
	set rsu=db.execute(SQL)
	Application.Lock
	'****************************************************************
	' ‘—MƒƒbƒZ[ƒWì¬(ŠÇ—Ò‚Ö)
	'****************************************************************
	send_msg_manager = Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "yV‹K¤•i“o˜^z" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "------------------------------------------------------" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "y¶Y”_‰Æz" & Chr(13) & Chr(10)
	if rsu("company")<>"" then
	send_msg_manager = send_msg_manager & "‰ïĞ–¼F" & rsu("company") & Chr(13) & Chr(10)
	end if
	if rsu("company")<>"" then
	send_msg_manager = send_msg_manager & "‚¨–¼‘OF" & rsu("name") & Chr(13) & Chr(10)
	end if

	
	send_msg_manager = send_msg_manager & "y¤•i–¼z" & s_objBasp21.Form(s_getBinary, "sname") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "y‰¿Šiz" & s_objBasp21.Form(s_getBinary, "price") & "‰~" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "y”—Êz" & s_objBasp21.Form(s_getBinary, "num") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "y’PˆÊz" & s_objBasp21.Form(s_getBinary, "tani") & Chr(13) & Chr(10)

	send_msg_manager = send_msg_manager & "------------------------------------------------------" & Chr(13) & Chr(10)
	SQL="SELECT max(id) as mid From t_master"
	set maxid=db.execute(SQL)
	send_msg_manager = send_msg_manager & "Ú×‚ÍŠÇ—‰æ–Ê‚©‚ç‚²Šm”F‚­‚¾‚³‚¢B" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & SSLURL & "control/disp.asp?id=" & maxid("mid") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & Chr(13) & Chr(10)
	
	'****************************************************************
	' ƒ[ƒ‹‘—M
	'****************************************************************
	Set objBasp = Server.CreateObject("basp21")
	server_name = "127.0.0.1:25"
	'****************************************************************
	' ŠÇ—Ò‚Ö
	'****************************************************************
	mailfrom = "‚¨‹q—l" & "<" & rsu("email") & ">"
	subj = "y‘¾—z‚Æ–ìØ‚Ì’¼”„ŠzV‹K¤•i“o˜^‚Ì‚¨’m‚ç‚¹"
	'mailto = "<" & "torami@okamoto-farm.co.jp" & ">"
	'mailto = mailto & vbtab & "bcc" & vbtab & "<" & "at-okamoto@softbank.ne.jp" & ">"
	mailto =  "<" & "ishibashi@autumn-tec.co.jp" & ">"
	If rsu("name") <> "" Then
		send_msg = rsu("name") & "—l‚©‚çV‹K¤•i“o˜^‚ª‚ ‚è‚Ü‚µ‚½B" _
			 & Chr(13) & Chr(10) & Chr(13) & Chr(10) & send_msg_manager
	Else
		send_msg = rsu("email") & "—l‚©‚çV‹K¤•i“o˜^‚ª‚ ‚è‚Ü‚µ‚½B" _
			 & Chr(13) & Chr(10) & Chr(13) & Chr(10) & send_msg_manager
	End If


	rc_manager = objBasp.SendMail(server_name,mailto,mailfrom,subj,send_msg,files)

end if

response.write("<p>“o˜^‚ªŠ®—¹‚¢‚½‚µ‚Ü‚µ‚½I</p>")
if ids<>"" then
response.write("<p><a href='newregist01.asp?id=" & ids & "' class='underline'>¤•iÚ×‚Ö</a></p>")
else
SQL="SELECT max(id) as co From t_master"
set rsm=db.execute(SQL)
response.write("<p><a href='newregist01.asp?id=" & rsm("co") & "' class='underline'>¤•iÚ×‚Ö</a></p>")
end if
response.write("<p><a href='list.asp' class='underline'>¤•iˆê——‚Ö</a></p>")


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
