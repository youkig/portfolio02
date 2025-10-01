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

<title>��؁i���i�j�V�K�o�^�^�_�Y�������� ��t�y���z�Ɩ�؂̒������z�݂��_�� ��{���^��؎��^�_�Ƒ̌�</title>

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
		window.location.href = "imageRegist01.asp?id=" + ids + "&number="+ num
	});
	
	$(".delbtn").click(function(){
						
		var a = $(this).attr("id");
		a = a.replace("delid","");
		var b = $(this).attr("title");
		var c = $(this).attr("class");
		
			if(c.indexOf("syouhindel") > 0){
				var d = "���i";
				var f = "sid";
			}
		
		if(window.confirm(d + '�F'+b+'���폜���Ă�낵���ł����H')){
		
			$.ajax({
				type: "get",
				url: "/js/news_del.asp",
				data: f + "=" + a,
				success: function(str){
					if(str == "success"){
						//setTimeout(ReloadAddr,100);
						alert("�폜����܂����B");
						location.href = 'https://www.okamoto-farm.co.jp/farmer/mypage.asp';
					}else{
						alert(str + "�G���[���N����܂����B\n�폜�͊������Ă��Ȃ��\��������܂��B");
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
	<h1>�V�N��� �������^��t ��{��</h1>


<!--#include file="../include/header.inc"-->

<div id="main" class="container">
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">�g�b�v�y�[�W</a> | <a href="<%=ESURL%>farmer/mypage.asp">���Y�_�Ɖ���}�C�y�[�W</a> | ��؁i���i�j�V�K�o�^</p>
	<div class="block">
	<h2>��؁i���i�j�V�K�o�^</h2>


</div>

	<%
			if request("id")<>"" then
			%>
<p><a href="<%=ESURL%>details.asp?id=<%=ids%>&test=disp" target="_blank" class="underline">�z�[���y�[�W�̕\�����m�F</a></p>
<p><input type="button" value="���i���폜����" class="delbtn syouhindel" id="delid<%=rs("id")%>" title="<%=rers(rs,"���i��","")%>"></p>
	<%
			end if
			%>


	<form action="newregist02.asp" enctype="multipart/form-data" method="post">

<input type="hidden" name="id" id="id" value="<%=rers(rs,"id","")%>">
	
<div class="block">
<h3>�\��/��\��</h3>
<p><input type="checkbox" name="disp" id="disp" value="1"<%=checked(rers(rs,"disp",""),True)%>><label for="disp">�\������ꍇ�̓`�F�b�N</label></p>



<h3>���i��</h3>
<p><input type="text" name="sname" id="sname" value="<%=rers(rs,"���i��","")%>"></p>


<h3>�̔����i</h3>
<p><input type="text" name="price" id="price" value="<%=rers(rs,"���i","")%>" style="width:20%;">�~�i�ō��j</p>

<h3>�̔�����</h3>
<p><input type="text" name="num" id="num" value="<%=rers(rs,"����","")%>" style="width:20%;"></p>

<h3>�P��</h3>
		<p>��j�A�Z�b�g�Ȃ�<br>
<input type="text" name="tani" id="tani" value="<%=rers(rs,"�P��","")%>" style="width:20%;"></p>


<h3>���i�R�����g</h3>
<p><textarea name="comment" id="comment" cols="40" rows="5" style="width:100%;"><%=rers(rs,"�R�����g","")%></textarea></p>

			
</div>

			
<div class="block" style="text-align:left;">
<h3>�摜�A�b�v���[�h</h3>
<p>�A�b�v���[�h����ʐ^��I�����Ă��������B<br>
�ʐ^��<span class="red">�u�������v</span>��I�����Ă��������B�A�b�v���[�h�����ʐ^�͎����I�ɏk������܂��B</p>
<%
			if request("id")="" then
			response.Write("<p class='red'>�V�K�o�^�̎��́A�摜��1�������̓o�^�ƂȂ�܂��B�ҏW�y�[�W�ō��v4���܂œo�^�o���܂��B</p>")
			end if
			
			 if not isnull(rers(rs,"image1","")) and request("id")<>"" then
			 %>		
			<img src="<%=photoimg%>goods/<%=rers(rs,"image1","")%>" id="dispPhoto">		
					<input type="hidden" name="image" value="<%=rers(rs,"image1","")%>">
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
			if rs("image1") <> "" then
			response.write "<br><label for=""imagedel""><input type=""checkbox"" name=""imagedel"" id=""imagedel"" value=""1""> �摜���폜</label><input type=""hidden"" value="""& rs("id") &""" name=""imgname"" id=""imgname"">"
			%>
			</div>
<div class="block">
<%
			for a=2 to 4
			if isnull(rs("image"&a)) then
			txt="�o�^"
			else
			txt="�ҏW�E�폜"
			end if
			%>
<h4>���摜<%=a%></h4>
			<p><input type="button" name="image<%=a%>" id="image<%=a%>" value="�摜<%=a%>��<%=txt%>����" class="imageregibtn">

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
<p class="centering"><input type="submit" value="�o�^"></p>

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
