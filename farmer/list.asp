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

<title>���i�ꗗ�^�_�Y�������� ��t�y���z�Ɩ�؂̒������z�݂��_�� ��{���^��؎��^�_�Ƒ̌�</title>

<link rel="stylesheet" href="../css/base.css" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

<script src="../js/jquery-1.5.2.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../js/jquery.ui.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="../js/jquery.bgswitcher.js"></script>
<script src="../js/pagetop.js"></script>

<script src="../js/topslide.js"></script>
</head>

<body>

<div id="box">

<div id="header">
	<h1>�V�N��� �������^��t ��{��</h1>


<!--#include file="../include/header.inc"-->



<div id="main" class="container">
	<div id="cnt" class="plist">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">�g�b�v�y�[�W</a> | <a href="<%=SSLURL%>farmer/mypage.asp">���Y�_�Ɖ���}�C�y�[�W</a> | ���i�ꗗ</p>
	<div class="block">
	<h2>���i�ꗗ</h2>

<p>�o�^���ꂽ���i�̈ꗗ�ł��B�ҏW�͊e�ڍ׃y�[�W���s���Ă��������B</p>

</div>

<div class="block">
<h3>���i�ꗗ</h3>
<%
		   SQL="SELECT * From t_master Where uid=" & clng2(session("setid")) & " order by id desc"
		   set rs=db.execute(SQL)
		   if not rs.eof then
		   Do until rs.eof
		   %>
		<dl>
	<dt><%if rs("image1")<>"" then imagename=photoimg & "goods/" & rs("image1") else imagename="http://www.okamoto-farm.co.jp/img/top/image01.jpg"%>
<img src="<%=imagename%>" width="100"></dt>
<dd class="one"><a href="newregist01.asp?id=<%=rs("id")%>" class="underline"><%=rs("���i��")%></a></dd>
<dd class="two"><%=rs("���i")%> �~</dd>
<dd class="two centering"><%if rs("disp") then response.write("<span class='red'>�\����</span>") else response.write("��\��")%></dd>
</dl>
<%
		   rs.movenext
		   loop
		   else
		   %>
<p>���݁A�o�^�͂���܂���B</p>

<%
		   end if
		   %>
</div>


<p class="centering"><a href="<%=sslurl%>farmer/mypage.asp" class="underline">�}�C�y�[�W�֖߂�</a></p>

<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<!--#include file="../include/leftpane.inc"-->
	

<!-- id main end --></div>

<!--#include file="../include/footer.inc"-->


<!-- id box end --></div>
</body>
</html>
