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

<title>������ҏW�^�_�Y�������� ��t�y���z�Ɩ�؂̒������z�݂��_�� ��{���^��؎��^�_�Ƒ̌�</title>

<link rel="stylesheet" href="../css/base.css" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

<script src="../js/jquery-1.5.2.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../js/jquery.ui.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="../js/jquery.bgswitcher.js"></script>
<script src="../js/pagetop.js"></script>

<script src="../js/topslide.js"></script>
<script src="../js/change_chk.js"></script>
<script>
$(function () {
	
	$("#person1").click(function(){
		$(".houjin").fadeIn();
	});
	
	$("#person2").click(function(){
		$(".houjin").fadeOut();
	});

});
</script>
</head>

<body>

<div id="box">

<div id="header">
	<h1>�V�N��� �������^��t ��{��</h1>


<!--#include file="../include/header.inc"-->

<div id="main" class="container">
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">�g�b�v�y�[�W</a> | ������ҏW</p>
	<div class="block">
	<h2>������ҏW</h2>

<p>���Y�_�Ɖ���o�^�ς݂̏���������̃y�[�W����ҏW���o���܂��B</p>

<p>���A��Ж��͂�����̃y�[�W����͕ύX�o���܂���̂ŁA���[���ɂĂ��⍇�����������B</p>


</div>

<%
	  SQL="SELECT * From t_cuser Where id=" & clng2(session("setid"))
	  set rsu=db.execute(SQL)
	  %>

<form action="change02.asp#form" method="post" name="forms" id="forms" onSubmit="return signup(this)">
<input type="hidden" name="id" value="<%=clng2(session("setid"))%>">
<div class="block">
<h3>������ҏW�t�H�[��</h3>
	
<dl>
	<dt>�����O&nbsp;<em>[�K�{]</em></dt>
<dd><input type="text" name="name" id="name" value="<%=rsu("name")%>"></dd>
</dl>

<dl>
	<dt>�ӂ肪��&nbsp;<em>[�K�{]</em></dt>
<dd><input type="text" name="furigana" id="furigana" value="<%=rsu("furigana")%>"></dd>
</dl>



	<dl class="houjin">
	<dt>�@�l��</dt>
<dd><%=rsu("company")%><input type="hidden" name="company" value="<%=rsu("company")%>"></dd>
</dl>

<dl class="houjin">
	<dt>�@�l���ӂ肪��</dt>
<dd><%=rsu("fcompany")%><input type="hidden" name="fcompany" value="<%=rsu("fcompany")%>"></dd>
</dl>

<dl>
	<dt>�o�^�ӔC��&nbsp;<em>���@�l�̂�</em></dt>
<dd><input type="text" name="hname" id="hname" value="<%=rsu("hname")%>"></dd>
</dl>

<dl>
	<dt>�X�֔ԍ�&nbsp;<em>[�K�{]</em></dt>
<dd>
<%
				if rsu("zip")<>"" then
					zip=split(rsu("zip"),"-")
					zip1=zip(0)
					zip2=zip(1)
				end if
				%>
<input type="text" name="zip1" id="zip1" value="<%=zip1%>" class="zip"> - <input type="text" name="zip2" id="zip2" value="<%=zip2%>" class="zip"></dd>
</dl>

<dl>
	<dt>�s���{��&nbsp;<em>[�K�{]</em></dt>
<dd><select name="state" id="state">
<option value=""></option>
<%
				SQL="SELECT * From t_state"
				set rsstate=db.execute(SQL)
				Do until rsstate.eof
				%>
<option value="<%=rsstate("id")%>"<%=selected(rsstate("id"),rsu("state"))%>><%=rsstate("state")%></option>
<%
				rsstate.movenext
				loop
				%>
</select></dd>
</dl>

<dl>
	<dt>�ȉ��Z��&nbsp;<em>[�K�{]</em></dt>
<dd><input type="text" name="address" id="address" value="<%=rsu("address")%>"></dd>
</dl>

<dl>
	<dt>�d�b�ԍ�&nbsp;<em>[�K�{]</em></dt>
<dd><input type="text" name="tel" id="tel" value="<%=rsu("tel")%>"></dd>
</dl>

<dl>
	<dt>FAX�ԍ�</dt>
<dd><input type="text" name="fax" id="fax" value="<%=rsu("fax")%>"></dd>
</dl>


<dl>
	<dt>�g�ѓd�b�ԍ�</dt>
<dd>�����ł��A���̎���g�ѓd�b�ԍ�[�C��]<br>
<input type="text" name="mobile" id="mobile" value="<%=rsu("mobile")%>"></dd>
</dl>

<dl>
	<dt>���[���A�h���X&nbsp;<em>[�K�{]</em></dt>
<dd><input type="text" name="email" id="email" value="<%=rsu("email")%>"></dd>
</dl>

<dl>
	<dt>�p�X���[�h</dt>
<dd>���ύX���Ȃ���Γ��͂��Ȃ��ł��������B���p�p����8��������12�����ȓ�<br><input type="password" name="password" id="password" value=""></dd>
</dl>



<dl>
	<dt>�o�ח\��j��&nbsp;<em>[�K�{]</em></dt>
<dd><%if 1=2 then%><input type="checkbox" name="youbi" id="youbi1" value="���j��" class="radiochk"><label for="youbi1">���j��</label><br><%end if%>
<input type="checkbox" name="youbi" id="youbi2" value="�Ηj��" class="radiochk"<%if instr(rsu("�j��"),"�Ηj��")>0 then response.write(" checked='checked'")%>><label for="youbi2">�Ηj��</label><br>
<input type="checkbox" name="youbi" id="youbi3" value="���j��" class="radiochk"<%if instr(rsu("�j��"),"���j��")>0 then response.write(" checked='checked'")%>><label for="youbi3">���j��</label><br>
<input type="checkbox" name="youbi" id="youbi4" value="�ؗj��" class="radiochk"<%if instr(rsu("�j��"),"�ؗj��")>0 then response.write(" checked='checked'")%>><label for="youbi4">�ؗj��</label><br>
<%if 1=2 then%><input type="checkbox" name="youbi" id="youbi5" value="���j��" class="radiochk"><label for="youbi5">���j��</label><br><%end if%>
<input type="checkbox" name="youbi" id="youbi6" value="�y�j��" class="radiochk"<%if instr(rsu("�j��"),"�y�j��")>0 then response.write(" checked='checked'")%>><label for="youbi6">�y�j��</label><br>
<input type="checkbox" name="youbi" id="youbi7" value="���j��" class="radiochk"<%if instr(rsu("�j��"),"���j��")>0 then response.write(" checked='checked'")%>><label for="youbi7">���j��</label><br>
<input type="checkbox" name="youbi" id="youbi8" value="�j��" class="radiochk"<%if instr(rsu("�j��"),"�j��")>0 then response.write(" checked='checked'")%>><label for="youbi8">�j��</label><br>
<input type="checkbox" name="youbi" id="youbi9" value="����" class="radiochk"<%if instr(rsu("�j��"),"����")>0 then response.write(" checked='checked'")%>><label for="youbi9">����</label><br>
�����A���͒�x��
</dd>
</dl>

<dl>
	<dt>�z�[���y�[�WURL</dt>
<dd>���z�[���y�[�W���������̕��́A�uhttp�v���炲���͂��������B[�C��]<br>
<input type="text" name="url" id="url" value="<%=rsu("url")%>"></dd>
</dl>


</div>

<div class="block">
<p>��L���e�ł�낵����΁A�m�F��ʂւ��i�݂��������B</p>
<p class="centering"><input type="submit" name="submit" value="���e�m�F"></p>
</div>

<input type="hidden" name="inqchk" value="okamoto-nouen">

</form>

<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<!--#include file="../include/leftpane.inc"-->
	

<!-- id main end --></div>

<!--#include file="../include/footer.inc"-->


<!-- id box end --></div>
</body>
</html>
