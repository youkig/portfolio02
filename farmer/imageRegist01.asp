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

<title>���i�摜�o�^�E�ҏW�^�_�Y�������� ��t�y���z�Ɩ�؂̒������z�݂��_�� ��{���^��؎��^�_�Ƒ̌�</title>

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
	<h1>�V�N��� �������^��t ��{��</h1>


<!--#include file="../include/header.inc"-->



<div id="main" class="container">
	<div id="cnt" class="mypage">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">�g�b�v�y�[�W</a> | <a href="<%=ESURL%>farmer/mypage.asp">���Y�_�Ɖ���}�C�y�[�W</a> | ���i�摜�o�^�E�ҏW</p>
	<div class="block">
	<h2><%=rers(rs,"���i��","")%>�̉摜�o�^�E�ҏW</h2>



</div>

<div class="block">
	<form action="imageRegist02.asp" enctype="multipart/form-data" method="post">

<input type="hidden" name="id" id="id" value="<%=ids%>">
	



			<h3>�摜�A�b�v���[�h</h3>


			
<div class="block" style="text-align:left;">
<p>�A�b�v���[�h����ʐ^��I�����Ă��������B<br>
�A�b�v���[�h�����ʐ^�͎����I�ɏk������܂��B</p>
<%
			 if not isnull(rs("image"&num)) then
			 %>		
			<img src="<%=photoimg%>goods/<%=rs("image" & num)%>" id="dispPhoto">		
					<input type="hidden" name="image" value="<%=rs("image" & num)%>">
<%
			else
			%>

				<p>�摜�I���F<input type="file" accept="image/*" name="uploadFile" id="uploadFile" onChange="dispThumbnail()"></p>
<input type="hidden" name="base64area" id="base64area" value=""><br>



			<canvas id="dispPhoto" name="dispPhoto" width="640" height="480" style="width:100%;"></canvas>
			<%
			end if
			%>
<%
			if ids<>0 then
			if rs("image"&num) <> "" then
			response.write "<br><label for=""imagedel""><input type=""checkbox"" name=""imagedel"" id=""imagedel"" value="""& num & """> �摜���폜</label><input type=""hidden"" value="""& rs("id") &""" name=""imgname"" id=""imgname"">"
			%>
			


<%
			end if
			end if
			%>
<input type="hidden" name="number" value="<%=num%>">
</div>
<p class="centering"><input type="submit" value="�o�^"> &nbsp;<input type="button" value="�߂�" onClick="history.back()"></p>
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
