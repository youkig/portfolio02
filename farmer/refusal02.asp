<!DOCTYPE html>
<html lang="ja">
<!--#include file="../config.inc"-->
<%
if not loginch(Session("logid"),Session("pass")) then response.redirect sslurl & "farmer/login.asp"
%>

<head>

<meta name="robots" content="all">
<meta property="og:title" content="‘¾—z‚Æ–ìØ‚Ì’¼”„Šy“Œ˜QŒ©‰ª–{”_‰€z">
<meta property="og:type" content="website">
<meta property="og:url" content="index.asp">
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="canonical" href="https://www.okamoto-farm.co.jp/index.asp">
<meta name="keywords" content="–ìØ,”_Y•¨,’¼”„Š,Y’¼–ìØ,“yY,’Ê”Ì,‘İ‚µ”_‰€,ƒŒƒ“ƒ^ƒ‹”_‰€,–ìØë‚è,”_‹Æ‘ÌŒ±,ç—tŒ§,’·¶ŒS,ˆê‹{’¬">

<meta name="description" content="Š”®‰ïĞ“Œ˜QŒ©‰ª–{”_‰€iç—tŒ§’·¶ŒSˆê‹{’¬j‚ªŒo‰c‚·‚éy‘¾—z‚Æ–ìØ‚Ì’¼”„Šzƒz[ƒ€ƒy[ƒW‚Å‚ÍA”_‰€‚É•¹İ‚µ‚Ä‚¢‚é”_Y•¨’¼”„Š‚Ì‚²Ğ‰î‚ÆAƒŒƒ“ƒ^ƒ‹”_‰€i‘İ‚µ”_‰€jA–ìØë‚è‘ÌŒ±‚Ì‚Ù‚©A’¼”„Š‚Éo‰×‚·‚é”_‰Æ‚³‚ñ‚Ö‚Ì‚²ˆÄ“à‚ğs‚Á‚Ä‚¢‚Ü‚·B">

<title>‘Ş‰ïè‘±‚«iŠ®—¹j^”_Y•¨’¼”„Š ç—ty‘¾—z‚Æ–ìØ‚Ì’¼”„Šz‘İ‚µ”_‰€ ˆê‹{’¬^–ìØë‚è^”_‹Æ‘ÌŒ±</title>

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
	<h1>V‘N–ìØ ’¼”„Š^ç—t ˆê‹{’¬</h1>


<!--#include file="../include/header.inc"-->

<div id="main" class="container">
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">ƒgƒbƒvƒy[ƒW</a> | <a href="<%=ESURL%>farmer/mypage.asp">ƒ}ƒCƒy[ƒW</a> | ‘Ş‰ïè‘±‚«iŠ®—¹j</p>
	<div class="block">
	<h2>‘Ş‰ïè‘±‚«iŠ®—¹j</h2>


<%
	if session("setid")<>"" and request.form("refusalchk")="ok" then
		set rs = server.createObject("ADODB.RecordSet")	
		rs.Open "SELECT * FROM t_cuser Where id=" & clng2(session("setid")), db, 3, 3
		

		rs("‘Ş‰ï") = 1
		

		rs.Update
		rs.Close
		
		SQL="UPDATE t_master set disp=0 Where uid=" & clng2(session("setid"))
		db.execute(SQL)
		
			'****************************************************************
			' ‘—MƒƒbƒZ[ƒWì¬(ŠÇ—Ò‚Ö)
			'****************************************************************
			send_msg_manager = Chr(13) & Chr(10)
			send_msg_manager = send_msg_manager & "y‘Ş‰ïè‘±‚«Š®—¹‚Ì‚¨’m‚ç‚¹z" & Chr(13) & Chr(10)
			send_msg_manager = send_msg_manager & "------------------------------------------------------" & Chr(13) & Chr(10)
			send_msg_manager = send_msg_manager & "y‰ïˆõURLz" & "https://www.okamoto-farm.co.jp/control/memberdisp.asp?id=" & clng2(session("setid")) & Chr(13) & Chr(10)
			send_msg_manager = send_msg_manager & "y‚¨–¼‘Oz" & session("username") & Chr(13) & Chr(10)
			send_msg_manager = send_msg_manager & "yƒ[ƒ‹ƒAƒhƒŒƒXz" & session("logid") & Chr(13) & Chr(10)
			send_msg_manager = send_msg_manager & Chr(13) & Chr(10)
			send_msg_manager = send_msg_manager & Chr(13) & Chr(10)
			'****************************************************************
			' ƒ[ƒ‹‘—M
			'****************************************************************
			Set objBasp = Server.CreateObject("basp21")
			server_name = "127.0.0.1:25"
			'****************************************************************
			' ŠÇ—Ò‚Ö
			'****************************************************************
			mailfrom = "‚¨‹q—l" & "<" & session("logid") & ">"
			subj = "y‘¾—z‚Æ–ìØ‚Ì’¼”„Šz¶Y”_‰Æ‰ïˆõ ‘Ş‰ïè‘±‚«‚Ì‚¨’m‚ç‚¹"
			'mailto = "<" & "torami@okamoto-farm.co.jp" & ">"
			'mailto = mailto & vbtab & "bcc" & vbtab & "<" & "at-okamoto@softbank.ne.jp" & ">"
			mailto =  "<" & "ishibashi@autumn-tec.co.jp" & ">"
			If session("username") <> "" Then
				send_msg = session("username") & "—l‚©‚ç‚Ì‘Ş‰ïè‘±‚«‚Ì‚¨’m‚ç‚¹‚Å‚·B" _
					 & Chr(13) & Chr(10) & Chr(13) & Chr(10) & send_msg_manager
			Else
				send_msg = session("logid") & "—l‚©‚ç‚Ì‘Ş‰ïè‘±‚«‚Ì‚¨’m‚ç‚¹‚Å‚·B" _
					 & Chr(13) & Chr(10) & Chr(13) & Chr(10) & send_msg_manager
			End If
		
		
			rc_manager = objBasp.SendMail(server_name,mailto,mailfrom,subj,send_msg,files)
			%>
<p class="centering">‘Ş‰ïè‘±‚«‚ªŠ®—¹‚¢‚½‚µ‚Ü‚µ‚½B<br>‚Ü‚½‚Ì‚²—˜—p‚ğ‚¨‘Ò‚¿‚µ‚Ä‚¨‚è‚Ü‚·B</p>

<%
	 else
	 %>
<p>ƒAƒNƒZƒX‚ª•s³‚Å‚·I</p>
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
