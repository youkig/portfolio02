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

<title>�މ�葱���i�����j�^�_�Y�������� ��t�y���z�Ɩ�؂̒������z�݂��_�� ��{���^��؎��^�_�Ƒ̌�</title>

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

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">�g�b�v�y�[�W</a> | <a href="<%=ESURL%>farmer/mypage.asp">�}�C�y�[�W</a> | �މ�葱���i�����j</p>
	<div class="block">
	<h2>�މ�葱���i�����j</h2>


<%
	if session("setid")<>"" and request.form("refusalchk")="ok" then
		set rs = server.createObject("ADODB.RecordSet")	
		rs.Open "SELECT * FROM t_cuser Where id=" & clng2(session("setid")), db, 3, 3
		

		rs("�މ�") = 1
		

		rs.Update
		rs.Close
		
		SQL="UPDATE t_master set disp=0 Where uid=" & clng2(session("setid"))
		db.execute(SQL)
		
			'****************************************************************
			' ���M���b�Z�[�W�쐬(�Ǘ��҂�)
			'****************************************************************
			send_msg_manager = Chr(13) & Chr(10)
			send_msg_manager = send_msg_manager & "�y�މ�葱�������̂��m�点�z" & Chr(13) & Chr(10)
			send_msg_manager = send_msg_manager & "------------------------------------------------------" & Chr(13) & Chr(10)
			send_msg_manager = send_msg_manager & "�y���URL�z" & "https://www.okamoto-farm.co.jp/control/memberdisp.asp?id=" & clng2(session("setid")) & Chr(13) & Chr(10)
			send_msg_manager = send_msg_manager & "�y�����O�z" & session("username") & Chr(13) & Chr(10)
			send_msg_manager = send_msg_manager & "�y���[���A�h���X�z" & session("logid") & Chr(13) & Chr(10)
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
			mailfrom = "���q�l" & "<" & session("logid") & ">"
			subj = "�y���z�Ɩ�؂̒������z���Y�_�Ɖ�� �މ�葱���̂��m�点"
			'mailto = "<" & "torami@okamoto-farm.co.jp" & ">"
			'mailto = mailto & vbtab & "bcc" & vbtab & "<" & "at-okamoto@softbank.ne.jp" & ">"
			mailto =  "<" & "ishibashi@autumn-tec.co.jp" & ">"
			If session("username") <> "" Then
				send_msg = session("username") & "�l����̑މ�葱���̂��m�点�ł��B" _
					 & Chr(13) & Chr(10) & Chr(13) & Chr(10) & send_msg_manager
			Else
				send_msg = session("logid") & "�l����̑މ�葱���̂��m�点�ł��B" _
					 & Chr(13) & Chr(10) & Chr(13) & Chr(10) & send_msg_manager
			End If
		
		
			rc_manager = objBasp.SendMail(server_name,mailto,mailfrom,subj,send_msg,files)
			%>
<p class="centering">�މ�葱���������������܂����B<br>�܂��̂����p�����҂����Ă���܂��B</p>

<%
	 else
	 %>
<p>�A�N�Z�X���s���ł��I</p>
<%
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
