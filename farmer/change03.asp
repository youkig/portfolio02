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

<title>������ҏW�i�o�^�����j�^�_�Y�������� ��t�y���z�Ɩ�؂̒������z�݂��_�� ��{���^��؎��^�_�Ƒ̌�</title>

<link rel="stylesheet" href="../css/base.css" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

<script src="../js/jquery-1.5.2.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../js/jquery.ui.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="../js/jquery.bgswitcher.js"></script>
<script src="../js/pagetop.js"></script>

<script src="../js/topslide.js"></script>
<script src="../js/regist_chk.js"></script>

</head>

<body>

<div id="box">

<div id="header">
	<h1>�V�N��� �������^��t ��{��</h1>


<!--#include file="../include/header.inc"-->

<div id="main" class="container">
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">�g�b�v�y�[�W</a> | ������ҏW�i�o�^�����j</p>
	<div class="block">
	<h2>������ҏW�i�o�^�����j</h2>

</div>

<%
If Request.Form("email")<>"" AND instr(request.ServerVariables("HTTP_REFERER"),"change02.asp")>0 and session("inqaccess")="ok" Then

	Application.Lock
	


if errmes = "" then	
		set rs = server.createObject("ADODB.RecordSet")	
		rs.Open "SELECT * FROM t_cuser Where id=" & clng2(request.form("id")), db, 3, 3
		

		rs("name") = Request.Form("name")
		rs("furigana") = Request.Form("furigana")
		rs("����") = cint2(Request.Form("sex"))
		rs("company") = renull(Request.Form("company"))
		rs("fcompany") = renull(Request.Form("fcompany"))
		rs("hname") = renull(Request.Form("hname"))
		
		rs("zip") = renull(Request.Form("zip1") & "-" & Request.Form("zip2"))
		rs("state") = cint2(Request.Form("state"))
		rs("address") = renull(Request.Form("address"))
		
		rs("tel") = renull(Request.Form("tel"))
		rs("fax") = renull(Request.Form("fax"))
		rs("mobile") = renull(Request.Form("mobile"))
		rs("email") = Request.Form("email")
		
		if request.form("password")<>"" then
		rs("password") = MDstring(request.form("password"))	
		rs("password2") = request.form("password")
		end if
		
		
		rs("�j��") = renull(Request.Form("youbi"))
		rs("URL") = renull(Request.Form("url"))
		

		rs.Update
		rs.Close
		
	'****************************************************************
	' ���M���b�Z�[�W�쐬(�Ǘ��҂�)
	'****************************************************************
	send_msg_manager = Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y����o�^���e�z" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "------------------------------------------------------" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y�����O�z" & Request.Form("name") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y�ӂ肪�ȁz" & Request.Form("furigana") & Chr(13) & Chr(10)

	
if Request.Form("company")<>"" then
	send_msg_manager = send_msg_manager & "�y�@�l���z" & Request.Form("company") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y�@�l���ӂ肪�ȁz" & Request.Form("fcompany") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y�o�^�ӔC�ҁz" & Request.Form("hname") & Chr(13) & Chr(10)
end if	

	send_msg_manager = send_msg_manager & "�y�X�֔ԍ��z" & Request.Form("zip1") & "-" & Request.Form("zip2") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y�Z���z" & Request.Form("statename") & request.form("address") & Chr(13) & Chr(10)
	
	send_msg_manager = send_msg_manager & "�y�d�b�ԍ��z" & Request.Form("tel") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�yFAX�ԍ��z" & Request.Form("fax") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y�g�ѓd�b�ԍ��z" & Request.Form("mobile") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y���[���A�h���X�z" & Request.Form("email") & Chr(13) & Chr(10)
	
	if Request.Form("password")<>"" then
	send_msg_manager = send_msg_manager & "�y�p�X���[�h�z" & Request.Form("password") & Chr(13) & Chr(10)
	end if
	'send_msg_manager = send_msg_manager & "�y�o�ח\��i�ځz" & Request.Form("comment") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y�o�ח\��j���z" & Request.Form("youbi") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "�y�z�[���y�[�WURL�z" & Request.Form("url") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "------------------------------------------------------" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & Chr(13) & Chr(10)
	'****************************************************************
	' ���M���b�Z�[�W�쐬(���q�l��)
	'****************************************************************
	send_msg_visitor = Chr(13) & Chr(10)
	send_msg_visitor = send_msg_visitor & "���̃��[���͎����I�ɔz�M����Ă���܂��B" & Chr(13) & Chr(10) & Chr(13) & Chr(10)
	If Request.Form("name") <> "" Then
		send_msg_visitor = send_msg_visitor & Request.Form("name") & " �l" & Chr(13) & Chr(10)
	Else
		send_msg_visitor = send_msg_visitor & Request.Form("email") & " �l" & Chr(13) & Chr(10)
	End If
	send_msg_visitor = send_msg_visitor & "�y���z�Ɩ�؂̒������z���^�c���Ă���܂��A������� ���Q�����{�_���ł��B" & Chr(13) & Chr(10)
	send_msg_visitor = send_msg_visitor & "���L�̐��Y�_�Ɖ���o�^�������a����v���܂����B" & Chr(13) & Chr(10)
	'send_msg_visitor = send_msg_visitor & "���e��R���̏�A���ВS���҂���1�c�Ɠ��ȓ��ɂ��A�������Ă��������܂��B" & Chr(13) & Chr(10)
	send_msg_visitor = send_msg_visitor & Chr(13) & Chr(10)
	send_msg_visitor = send_msg_visitor & Chr(13) & Chr(10)
	'****************************************************************
	' �t�b�_�[�쐬
	'****************************************************************
			  send_msg_footer = "=====================================================" & Chr(13) & Chr(10)	
	send_msg_footer = send_msg_footer & "������� ���Q�����{�_��" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "�@��299-4303" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "�@��t�������S��{�����Q��4721��" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "�@TEL:080-7356-0831" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "�@E-mail�Ftorami@okamoto-farm.co.jp" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "�@URL�Fhttp://www.okamoto-farm.co.jp" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "=====================================================" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "" & Chr(13) & Chr(10)
	'****************************************************************
	' ���[�����M
	'****************************************************************
	Set objBasp = Server.CreateObject("basp21")
	server_name = "127.0.0.1:25"
	'****************************************************************
	' �Ǘ��҂�
	'****************************************************************
	mailfrom = "���q�l" & "<" & Request.Form("email") & ">"
	subj = "�y���z�Ɩ�؂̒������z���Y�_�Ɖ���o�^��� �ύX�̂��m�点"
	mailto = "<" & "torami@okamoto-farm.co.jp" & ">"
	mailto = mailto & vbtab & "bcc" & vbtab & "<" & "at-okamoto@softbank.ne.jp" & ">"
	'mailto =  "<" & "ishibashi@autumn-tec.co.jp" & ">"
	If Request.Form("name") <> "" Then
		send_msg = Request.Form("name") & "�l���琶�Y�_�Ɖ���o�^��� �ύX�̂��m�点�ł��B" _
			 & Chr(13) & Chr(10) & Chr(13) & Chr(10) & send_msg_manager
	Else
		send_msg = Request.Form("email") & "�l���琶�Y�_�Ɖ���o�^��� �ύX�̂��m�点�ł��B" _
			 & Chr(13) & Chr(10) & Chr(13) & Chr(10) & send_msg_manager
	End If


	rc_manager = objBasp.SendMail(server_name,mailto,mailfrom,subj,send_msg,files)
	
	'sitename="���z�Ɩ�؂̒�����"
	'domain="www.okamoto-farm.co.jp"
	'on error resume next
	'call maillog(sitename,domain,server_name,mailto,mailfrom,subj,send_msg)
	'on error goto 0

	'****************************************************************
	' ���M�G���[�`�F�b�N(�Ǘ���)
	'****************************************************************
	If rc_manager <> "" Then
		'rc_manager�ɃG���[���b�Z�[�W������܂�
		Response.write(rc_manager)
	End If
	'****************************************************************
	' ���q�l��
	'****************************************************************
	mailfrom = "���Q�� ���{�_��<torami@okamoto-farm.co.jp>"
	subj = "���Y�_�Ɖ���o�^��� �ύX��t�����̂��m�点�y���z�Ɩ�؂̒������z"
	mailto = "<" & Request.Form("email") & ">"
	send_msg = send_msg_visitor & send_msg_manager & send_msg_footer
	rc_visitor = objBasp.SendMail(server_name,mailto,mailfrom,subj,send_msg,files)
	'****************************************************************
	' ���M�G���[�`�F�b�N(���q�l��)
	'****************************************************************
	If rc_visitor <> "" Then
		'rc_visitor�ɃG���[���b�Z�[�W������܂�
		Response.write(rc_visitor)
	End If
	'****************************************************************
	Application.Unlock
	
	If rc_visitor = "" and rc_manager = "" Then
%>

<div class="block">

	<p>���Y�_�Ɖ���o�^���[�������M����܂����B</p>

<p class="centering"><a href="<%=ESURL%>index.asp" class="underline">�g�b�v�y�[�W�֖߂�</a></p>
</div>
<%
	session("inqaccess")=""
else
%>
		<div class="block">

	<p>���M�Ɏ��s���܂����B<br>���[���A�h���X�Ɍ�肪����\��������܂��B<br>
���x�����M�Ɏ��s����ꍇ�́Atorami@okamoto-farm.co.jp�֒��ڃ��[���������蒸�����A���d�b�ɂĂ��A�����������B
</p>

<p class="centering"><a href="<%=ESURL%>index.asp" class="underline">�g�b�v�y�[�W�֖߂�</a></p>
</div>

<%
end if
else
%>
		<div class="block">

	<p><%=errmes%></p>

<p class="centering"><a href="<%=ESURL%>index.asp" class="underline">�g�b�v�y�[�W�֖߂�</a></p>
</div>
<%
end if
else
%>

	<div class="block">

	<p>�A�N�Z�X���s���ł��B</p>

<p class="centering"><a href="<%=ESURL%>index.asp" class="underline">�g�b�v�y�[�W�֖߂�</a></p>
</div>

<%
end if
%>

<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<!--#include file="../include/leftpane.inc"-->
	

<!-- id main end --></div>

<!--#include file="../include/footer.inc"-->


<!-- id box end --></div>
</body>
</html>
