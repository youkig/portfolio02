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

<title>���Y�_�Ɖ���}�C�y�[�W�^�_�Y�������� ��t�y���z�Ɩ�؂̒������z�݂��_�� ��{���^��؎��^�_�Ƒ̌�</title>

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
	<div id="cnt" class="mypage">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">�g�b�v�y�[�W</a> | ���Y�_�Ɖ���}�C�y�[�W</p>
	<div class="block">
	<h2>���Y�_�Ɖ���}�C�y�[�W</h2>

<p>�y���z�Ɩ�؂̒������z���Y�_�Ɖ���l��p�̃}�C�y�[�W�ł��B<br>
������̃y�[�W����؁i���i�j�̓o�^�������̕ҏW���s���܂��B</p>

</div>

<div class="block">
<h3>��؁i���i�j�V�K�o�^�E�ҏW</h3>
		 <ul>
	<li><a href="<%=SSLURL%>farmer/newregist01.asp">��؁i���i�j�V�K�o�^</a></li>
<li><a href="<%=SSLURL%>farmer/list.asp">�o�^��؁i���i�j�ꗗ</a></li>
</ul>
</div>


<div class="block">
<h3>������ҏW</h3>
		<ul>
	<li><a href="<%=SSLURL%>farmer/change01.asp">�o�^���ҏW</a></li>
<li><a href="<%=SSLURL%>farmer/refusal.asp">�މ�葱��</a></li>
</ul>

</div>

<div class="block">
<h3>���O�A�E�g</h3>
		<ul>
	<li><a href="<%=SSLURL%>farmer/logout.asp">�}�C�y�[�W���O�A�E�g</a></li>

</ul>

</div>

<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<!--#include file="../include/leftpane.inc"-->
	

<!-- id main end --></div>

<!--#include file="../include/footer.inc"-->


<!-- id box end --></div>
</body>
</html>
