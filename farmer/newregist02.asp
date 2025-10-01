<!DOCTYPE html>
<html lang="ja">
<!--#include file="../config.inc"-->
<%
if not loginch(Session("logid"),Session("pass")) then response.redirect sslurl & "farmer/login.asp"
%>

<head>

<meta name="robots" content="all">
<meta property="og:title" content="���z�Ɩ�؂̒������y���Q�����{�_���z">
<meta property="og:type" content="website">
<meta property="og:url" content="index.asp">
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="canonical" href="https://www.okamoto-farm.co.jp/index.asp">
<meta name="keywords" content="���,�_�Y��,������,�Y�����,�y�Y,�ʔ�,�݂��_��,�����^���_��,��؎��,�_�Ƒ̌�,��t��,�����S,��{��">

<meta name="description" content="������Г��Q�����{�_���i��t�������S��{���j���o�c����y���z�Ɩ�؂̒������z�z�[���y�[�W�ł́A�_���ɕ��݂��Ă���_�Y���������̂��Љ�ƁA�����^���_���i�݂��_���j�A��؎��̌��̂ق��A�������ɏo�ׂ���_�Ƃ���ւ̂��ē����s���Ă��܂��B">

<title>��؁i���i�j�V�K�o�^�i�o�^�����j�^�_�Y�������� ��t�y���z�Ɩ�؂̒������z�݂��_�� ��{���^��؎��^�_�Ƒ̌�</title>

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
//dataURL�`���Ńt�@�C����ǂݍ���
reader.readAsDataURL(file[0]);
//�t�@�C���̓Ǎ����I���������̏���
reader.onload = function(){
readDrawImg(reader, canvas, 0, 0);
}
}

function readDrawImg(reader, canvas, x, y){
var img = readImg(reader);
var canvasDefW = canvas.width;    // canvas�̏�����
img.onload = function(){
	
	
var w = img.width;
var h = img.height;
		
		
var resize = resizeWidthHeight(canvasDefW, w, h);
drawImgOnCav(canvas, img, x, y, resize.w , resize.h );
		
// CanvasImage��BASE64URI�ւ̕ϊ�
//document.getElementById("base64area").value = canvas.toDataURL("image/png");
		document.getElementById("base64area").value = canvas.toDataURL("image/jpeg");
		
}
	
	
}
//�t�@�C���̓Ǎ����I���������̏���
function readImg(reader){
//�t�@�C���ǂݎ���̏���
var result_dataURL = reader.result;
var img = new Image();
img.src = result_dataURL;
return img;
	
	
}
//�L�����o�X��Image��\��
function drawImgOnCav(canvas, img, x, y, w, h) {
var ctx = canvas.getContext("2d");
canvas.width = w;
canvas.height = h;
	
	EXIF.getData(img, function () {

		var rotate = 0;
// ��������Ƃ��ă��T�C�Y����
		
		// ��]�����̓ǂݎ��
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
			
		// �摜�̉�]
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




// ���T�C�Y���width, height�����߂�
function resizeWidthHeight(target_length_px, w0, h0){
//���T�C�Y�̕K�v���Ȃ���Ό���width, height��Ԃ�
if(w0 <= target_length_px){
return{
flag: false,
w: w0,
h: h0
};
}
// ��������Ƃ������T�C�Y�̌v�Z
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
	<h1>�V�N��� �������^��t ��{��</h1>


<!--#include file="../include/header.inc"-->

<div id="main" class="container">
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">�g�b�v�y�[�W</a> | <a href="<%=ESURL%>farmer/mypage.asp">���Y�_�Ɖ���}�C�y�[�W</a> | ��؁i���i�j�V�K�o�^�i�o�^�����j</p>
	<div class="block">
	<h2>��؁i���i�j�V�K�o�^�i�o�^�����j</h2>


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
		Const adTypebinary = 1    ' �o�C�i���f�[�^
		Const adTypeText = 2    ' �e�L�X�g�f�[�^
	
		Dim stream, xmldom, node
		Dim strBase64
		Set xmldom = Server.CreateObject("Microsoft.XMLDOM")
		Set node = xmldom.CreateElement("base64")
		node.DataType = "bin.base64"
	
		strBase64 = Replace(s_strBase64, "data:image/png;base64,","") 'Base64�̕������n��
		kaucyo = ".png"
			If InStr(strBase64, "data:image/") <> 0 Then
				strBase64 = Replace(s_strBase64, "data:image/jpeg;base64,","") 'Base64�̕������n��
				kaucyo = ".jpg"
			End If
		
		
		
		param_strFilePass = server.MapPath("../photo/goods/" & imgname & kaucyo)
		node.text = strBase64
		Set stream = Server.CreateObject("ADODB.Stream")
		stream.Type = adTypeBinary
		stream.Open
		stream.write node.NodeTypedValue
		stream.saveToFile param_strFilePass, 1 '�t�@�C�����쐬
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
'rs("���Y�Җ�") = renull(s_objBasp21.Form(s_getBinary, "seisansya"))

rs("���i��") = renull(s_objBasp21.Form(s_getBinary, "sname"))
rs("���i") = renull(s_objBasp21.Form(s_getBinary, "price"))
rs("����") = renull(s_objBasp21.Form(s_getBinary, "num"))
rs("�P��") = renull(s_objBasp21.Form(s_getBinary, "tani"))
rs("�R�����g") = renull(s_objBasp21.Form(s_getBinary, "comment"))

if s_objBasp21.Form(s_getBinary, "base64area")<>"" then
rs("image1") = imgname & kaucyo
elseif cint2(s_objBasp21.Form(s_getBinary,"imagedel"))=1 then
rs("image1") = NULL
end if

rs("disp") = cint2(s_objBasp21.Form(s_getBinary, "disp"))


rs.update
rs.close

'�V�K�o�^���Ǘ��҂փ��[�����M
if clng2(s_objBasp21.Form(s_getBinary, "uid"))>0 and clng2(s_objBasp21.Form(s_getBinary, "id"))=0 then
	SQL="SELECT * From t_cuser Where id=" & clng2(s_objBasp21.Form(s_getBinary, "uid"))
	set rsu=db.execute(SQL)
	Application.Lock
	'****************************************************************
	' ���M���b�Z�[�W�쐬(�Ǘ��҂�)
	'****************************************************************
	send_msg_manager = Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y�V�K���i�o�^�z" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "------------------------------------------------------" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y���Y�_�Ɓz" & Chr(13) & Chr(10)
	if rsu("company")<>"" then
	send_msg_manager = send_msg_manager & "��Ж��F" & rsu("company") & Chr(13) & Chr(10)
	end if
	if rsu("company")<>"" then
	send_msg_manager = send_msg_manager & "�����O�F" & rsu("name") & Chr(13) & Chr(10)
	end if

	
	send_msg_manager = send_msg_manager & "�y���i���z" & s_objBasp21.Form(s_getBinary, "sname") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y���i�z" & s_objBasp21.Form(s_getBinary, "price") & "�~" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y���ʁz" & s_objBasp21.Form(s_getBinary, "num") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y�P�ʁz" & s_objBasp21.Form(s_getBinary, "tani") & Chr(13) & Chr(10)

	send_msg_manager = send_msg_manager & "------------------------------------------------------" & Chr(13) & Chr(10)
	SQL="SELECT max(id) as mid From t_master"
	set maxid=db.execute(SQL)
	send_msg_manager = send_msg_manager & "�ڍׂ͊Ǘ���ʂ��炲�m�F���������B" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & SSLURL & "control/disp.asp?id=" & maxid("mid") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & Chr(13) & Chr(10)
	
	'****************************************************************
	' ���[�����M
	'****************************************************************
	Set objBasp = Server.CreateObject("basp21")
	server_name = "127.0.0.1:25"
	'****************************************************************
	' �Ǘ��҂�
	'****************************************************************
	mailfrom = "���q�l" & "<" & rsu("email") & ">"
	subj = "�y���z�Ɩ�؂̒������z�V�K���i�o�^�̂��m�点"
	'mailto = "<" & "torami@okamoto-farm.co.jp" & ">"
	'mailto = mailto & vbtab & "bcc" & vbtab & "<" & "at-okamoto@softbank.ne.jp" & ">"
	mailto =  "<" & "ishibashi@autumn-tec.co.jp" & ">"
	If rsu("name") <> "" Then
		send_msg = rsu("name") & "�l����V�K���i�o�^������܂����B" _
			 & Chr(13) & Chr(10) & Chr(13) & Chr(10) & send_msg_manager
	Else
		send_msg = rsu("email") & "�l����V�K���i�o�^������܂����B" _
			 & Chr(13) & Chr(10) & Chr(13) & Chr(10) & send_msg_manager
	End If


	rc_manager = objBasp.SendMail(server_name,mailto,mailfrom,subj,send_msg,files)

end if

response.write("<p>�o�^�������������܂����I</p>")
if ids<>"" then
response.write("<p><a href='newregist01.asp?id=" & ids & "' class='underline'>���i�ڍׂ�</a></p>")
else
SQL="SELECT max(id) as co From t_master"
set rsm=db.execute(SQL)
response.write("<p><a href='newregist01.asp?id=" & rsm("co") & "' class='underline'>���i�ڍׂ�</a></p>")
end if
response.write("<p><a href='list.asp' class='underline'>���i�ꗗ��</a></p>")


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
