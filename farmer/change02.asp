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

<title>������ҏW�i���͓��e�m�F�j�^�_�Y�������� ��t�y���z�Ɩ�؂̒������z�݂��_�� ��{���^��؎��^�_�Ƒ̌�</title>

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
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">�g�b�v�y�[�W</a> | ������ҏW�i���͓��e�m�F�j</p>
	<div class="block" id="form">
	<h2>������ҏW�i���͓��e�m�F�j</h2>

<p>�ȉ��̓��e�ł�낵����΁A�o�^�{�^���������Ă��������B</p>


</div>



<form action="change03.asp" method="post">
<div class="block">
<h3>��������͓��e</h3>
	
<dl>
	<dt>�����O&nbsp;<em>[�K�{]</em></dt>
<dd><%=request.form("name")%></dd>
</dl>

<dl>
	<dt>�ӂ肪��&nbsp;<em>[�K�{]</em></dt>
<dd><%=request.form("furigana")%></dd>
</dl>



	<dl class="houjin">
	<dt>�@�l��</dt>
<dd><%=request.form("company")%></dd>
</dl>

<dl class="houjin">
	<dt>�@�l���ӂ肪��</dt>
<dd><%=request.form("fcompany")%></dd>
</dl>

<dl>
	<dt>�o�^�ӔC��&nbsp;<em>���@�l�̂�</em></dt>
<dd><%=request.form("hname")%></dd>
</dl>

<dl>
	<dt>�X�֔ԍ�&nbsp;<em>[�K�{]</em></dt>
<dd><%=request.form("zip1")%>-<%=request.form("zip2")%></dd>
</dl>

<dl>
	<dt>�s���{��&nbsp;<em>[�K�{]</em></dt>
<dd>
<%if request.form("state")<>"" then
				SQL="SELECT * From t_state Where id=" & cint2(request.form("state"))
				set rss=db.execute(SQL)
				response.Write(rss("state"))
				%>
	<input type="hidden" name="statename" value="<%=rss("state")%>">
<%
				end if
				%>
</dd>
</dl>

<dl>
	<dt>�ȉ��Z��&nbsp;<em>[�K�{]</em></dt>
<dd><%=request.form("address")%></dd>
</dl>

<dl>
	<dt>�d�b�ԍ�&nbsp;<em>[�K�{]</em></dt>
<dd><%=request.form("tel")%></dd>
</dl>

<dl>
	<dt>FAX�ԍ�</dt>
<dd><%=request.form("fax")%></dd>
</dl>


<dl>
	<dt>�g�ѓd�b�ԍ�</dt>
<dd><%=request.form("mobile")%>
</dd>
</dl>

<dl>
	<dt>���[���A�h���X&nbsp;<em>[�K�{]</em></dt>
<dd><%=request.form("email")%></dd>
</dl>
<%
			if request.form("password")<>"" then
			%>
<dl>
	<dt>�p�X���[�h&nbsp;<em>[�K�{]</em></dt>
<dd>���Z�L�����e�B�ׁ̈A�\�����܂���B</dd>
</dl>
<%
			end if
			%>


<dl>
	<dt>�o�ח\��j��&nbsp;<em>[�K�{]</em></dt>
<dd><%=request.form("youbi")%>
</dd>
</dl>

<dl>
	<dt>�z�[���y�[�WURL</dt>
<dd><%=request.form("url")%>
</dd>
</dl>


</div>

<div class="block">
<p>��L���e�ł�낵����΁A�o�^�{�^���������Ă��������B</p>
<p class="centering"><input type="submit" name="submit" value="�o�@�^">&nbsp;&nbsp;&nbsp;<input type="button" value="�߁@��" onClick="history.back()" onKeyPress="history.back()"></p>
</div>

<%
		for each x in request.form
		%>
	<input type="hidden" name="<%=x%>" value="<%=request.form(x)%>">
<%
		next
		session("inqaccess")="ok"
		%>

</form>

<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<!--#include file="../include/leftpane.inc"-->
	

<!-- id main end --></div>

<!--#include file="../include/footer.inc"-->


<!-- id box end --></div>
</body>
</html>
