<!DOCTYPE html>
<html lang="ja">
<!--#include file="../config.inc"-->

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

<title>���Y�_�Ɖ���l���O�C���^�_�Y�������� ��t�y���z�Ɩ�؂̒������z�݂��_�� ��{���^��؎��^�_�Ƒ̌�</title>

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
<%
dim username,password,errmes
errmes = ""

if request.form("loginid")<>"" and request.form("password")<>"" then
	username=request.form("loginid")
	password=MDstring(request.form("password"))
	
	if username<>"" then
		SQL="SELECT * From t_cuser Where email='"&username&"' AND �R��=1"
		set rs=db.execute(SQL)
		if rs.eof then
			errmes="�o�^����Ă��܂���"
			rs.close
		else
			if rs("�R��")<>1 or rs("�މ�") = true then
				errmes="���O�C���ł��܂���"
				rs.close
			else
				if rs("password")<>password then
					errmes="�p�X���[�h���Ⴂ�܂�"
					rs.close
				else

					session("setid")=rs("id")
					session("companyname")=rs("company")
					session("username")=rs("name")
					session("logid")=rs("email")
					session("pass")=rs("password")
					'username = rs("name")
					
					Session.Timeout = 60

					Response.Cookies(cookiename_userlogin)("setid") = rs("id")
					Response.Cookies(cookiename_userlogin)("companyname") = rs("company")
					Response.Cookies(cookiename_userlogin)("username") = rs("name")
					Response.Cookies(cookiename_userlogin)("logid") = rs("email")
					Response.Cookies(cookiename_userlogin)("pass") = rs("password")
					Response.Cookies(cookiename_userlogin).Expires = DateAdd("d",1,Date())
					Response.Cookies(cookiename_userlogin).Domain = domname

					rs.close
					
					
					response.redirect esurl & "farmer/mypage.asp"
					
				end if
			end if
		end if
	else
		errmes = "���O�C��ID����͂��Ă�������"
	end if

end if
%>
<body>

<div id="box">

<div id="header">
	<h1>�V�N��� �������^��t ��{��</h1>


<!--#include file="../include/header.inc"-->

<div id="main" class="container">
	<div id="cnt" class="company">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">�g�b�v�y�[�W</a> | ���Y�_�Ɖ���l���O�C��</p>
	<div class="block">
	<h2>���Y�_�Ɖ���l���O�C��</h2>

<p>������̃y�[�W�́y���z�Ɩ�؂̒������z�̐��Y�_�Ɖ���ւ��o�^�����������A����l�̃��O�C���y�[�W�ł��B</p>

<p>���[�U�[ID�ƃp�X���[�h����͂��ă��O�C�����Ă��������B</p>

</div>



<form action="<%=SSLURL%>farmer/login.asp" method="post" onSubmit="return signup(this)">
<div class="block">
<h3>������O�C���t�H�[��</h3>
	

<p><%=errmes%></p>


	<dl>
	<dt>���[�U�[ID</dt>
<dd><input type="text" name="loginid" id="loginid" value=""></dd>
</dl>

<dl>
	<dt>�p�X���[�h</dt>
<dd><input type="password" name="password" id="password" value=""></dd>
</dl>



</div>

<div class="block">

<p class="centering"><input type="submit" name="submit" value="���O�C��"></p>
</div>

<input type="hidden" name="loginchk" value="okamoto-nouen">

</form>

<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<!--#include file="../include/leftpane.inc"-->
	

<!-- id main end --></div>

<!--#include file="../include/footer.inc"-->


<!-- id box end --></div>
</body>
</html>
