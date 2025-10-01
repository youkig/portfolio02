<!DOCTYPE html>
<html lang="ja">
<!--#include file="../config.inc"-->

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

<title>‰ïˆõî•ñ•ÒWi“o˜^Š®—¹j^”_Y•¨’¼”„Š ç—ty‘¾—z‚Æ–ìØ‚Ì’¼”„Šz‘İ‚µ”_‰€ ˆê‹{’¬^–ìØë‚è^”_‹Æ‘ÌŒ±</title>

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
	<h1>V‘N–ìØ ’¼”„Š^ç—t ˆê‹{’¬</h1>


<!--#include file="../include/header.inc"-->

<div id="main" class="container">
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">ƒgƒbƒvƒy[ƒW</a> | ‰ïˆõî•ñ•ÒWi“o˜^Š®—¹j</p>
	<div class="block">
	<h2>‰ïˆõî•ñ•ÒWi“o˜^Š®—¹j</h2>

</div>

<%
If Request.Form("email")<>"" AND instr(request.ServerVariables("HTTP_REFERER"),"change02.asp")>0 and session("inqaccess")="ok" Then

	Application.Lock
	


if errmes = "" then	
		set rs = server.createObject("ADODB.RecordSet")	
		rs.Open "SELECT * FROM t_cuser Where id=" & clng2(request.form("id")), db, 3, 3
		

		rs("name") = Request.Form("name")
		rs("furigana") = Request.Form("furigana")
		rs("«•Ê") = cint2(Request.Form("sex"))
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
		
		
		rs("—j“ú") = renull(Request.Form("youbi"))
		rs("URL") = renull(Request.Form("url"))
		

		rs.Update
		rs.Close
		
	'****************************************************************
	' ‘—MƒƒbƒZ[ƒWì¬(ŠÇ—Ò‚Ö)
	'****************************************************************
	send_msg_manager = Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "y‰ïˆõ“o˜^“à—ez" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "------------------------------------------------------" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "y‚¨–¼‘Oz" & Request.Form("name") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "y‚Ó‚è‚ª‚Èz" & Request.Form("furigana") & Chr(13) & Chr(10)

	
if Request.Form("company")<>"" then
	send_msg_manager = send_msg_manager & "y–@l–¼z" & Request.Form("company") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "y–@l–¼‚Ó‚è‚ª‚Èz" & Request.Form("fcompany") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "y“o˜^Ó”CÒz" & Request.Form("hname") & Chr(13) & Chr(10)
end if	

	send_msg_manager = send_msg_manager & "y—X•Ö”Ô†z" & Request.Form("zip1") & "-" & Request.Form("zip2") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "yZŠz" & Request.Form("statename") & request.form("address") & Chr(13) & Chr(10)
	
	send_msg_manager = send_msg_manager & "y“d˜b”Ô†z" & Request.Form("tel") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "yFAX”Ô†z" & Request.Form("fax") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "yŒg‘Ñ“d˜b”Ô†z" & Request.Form("mobile") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "yƒ[ƒ‹ƒAƒhƒŒƒXz" & Request.Form("email") & Chr(13) & Chr(10)
	
	if Request.Form("password")<>"" then
	send_msg_manager = send_msg_manager & "yƒpƒXƒ[ƒhz" & Request.Form("password") & Chr(13) & Chr(10)
	end if
	'send_msg_manager = send_msg_manager & "yo‰×—\’è•i–Úz" & Request.Form("comment") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "yo‰×—\’è—j“úz" & Request.Form("youbi") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "yƒz[ƒ€ƒy[ƒWURLz" & Request.Form("url") & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & "------------------------------------------------------" & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & Chr(13) & Chr(10)
	send_msg_manager = send_msg_manager & Chr(13) & Chr(10)
	'****************************************************************
	' ‘—MƒƒbƒZ[ƒWì¬(‚¨‹q—l‚Ö)
	'****************************************************************
	send_msg_visitor = Chr(13) & Chr(10)
	send_msg_visitor = send_msg_visitor & "‚±‚Ìƒ[ƒ‹‚Í©“®“I‚É”zM‚³‚ê‚Ä‚¨‚è‚Ü‚·B" & Chr(13) & Chr(10) & Chr(13) & Chr(10)
	If Request.Form("name") <> "" Then
		send_msg_visitor = send_msg_visitor & Request.Form("name") & " —l" & Chr(13) & Chr(10)
	Else
		send_msg_visitor = send_msg_visitor & Request.Form("email") & " —l" & Chr(13) & Chr(10)
	End If
	send_msg_visitor = send_msg_visitor & "y‘¾—z‚Æ–ìØ‚Ì’¼”„Šz‚ğ‰^‰c‚µ‚Ä‚¨‚è‚Ü‚·AŠ”®‰ïĞ “Œ˜QŒ©‰ª–{”_‰€‚Å‚·B" & Chr(13) & Chr(10)
	send_msg_visitor = send_msg_visitor & "‰º‹L‚Ì¶Y”_‰Æ‰ïˆõ“o˜^î•ñ‚ğ‚¨—a‚©‚è’v‚µ‚Ü‚µ‚½B" & Chr(13) & Chr(10)
	'send_msg_visitor = send_msg_visitor & "“à—e‚ğR¸‚ÌãA•¾Ğ’S“–Ò‚©‚ç1‰c‹Æ“úˆÈ“à‚É‚²˜A—‚³‚¹‚Ä‚¢‚½‚¾‚«‚Ü‚·B" & Chr(13) & Chr(10)
	send_msg_visitor = send_msg_visitor & Chr(13) & Chr(10)
	send_msg_visitor = send_msg_visitor & Chr(13) & Chr(10)
	'****************************************************************
	' ƒtƒbƒ_[ì¬
	'****************************************************************
			  send_msg_footer = "=====================================================" & Chr(13) & Chr(10)	
	send_msg_footer = send_msg_footer & "Š”®‰ïĞ “Œ˜QŒ©‰ª–{”_‰€" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "@§299-4303" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "@ç—tŒ§’·¶ŒSˆê‹{’¬“Œ˜QŒ©4721”Ô" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "@TEL:080-7356-0831" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "@E-mailFtorami@okamoto-farm.co.jp" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "@URLFhttp://www.okamoto-farm.co.jp" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "=====================================================" & Chr(13) & Chr(10)
	send_msg_footer = send_msg_footer & "" & Chr(13) & Chr(10)
	'****************************************************************
	' ƒ[ƒ‹‘—M
	'****************************************************************
	Set objBasp = Server.CreateObject("basp21")
	server_name = "127.0.0.1:25"
	'****************************************************************
	' ŠÇ—Ò‚Ö
	'****************************************************************
	mailfrom = "‚¨‹q—l" & "<" & Request.Form("email") & ">"
	subj = "y‘¾—z‚Æ–ìØ‚Ì’¼”„Šz¶Y”_‰Æ‰ïˆõ“o˜^î•ñ •ÏX‚Ì‚¨’m‚ç‚¹"
	mailto = "<" & "torami@okamoto-farm.co.jp" & ">"
	mailto = mailto & vbtab & "bcc" & vbtab & "<" & "at-okamoto@softbank.ne.jp" & ">"
	'mailto =  "<" & "ishibashi@autumn-tec.co.jp" & ">"
	If Request.Form("name") <> "" Then
		send_msg = Request.Form("name") & "—l‚©‚ç¶Y”_‰Æ‰ïˆõ“o˜^î•ñ •ÏX‚Ì‚¨’m‚ç‚¹‚Å‚·B" _
			 & Chr(13) & Chr(10) & Chr(13) & Chr(10) & send_msg_manager
	Else
		send_msg = Request.Form("email") & "—l‚©‚ç¶Y”_‰Æ‰ïˆõ“o˜^î•ñ •ÏX‚Ì‚¨’m‚ç‚¹‚Å‚·B" _
			 & Chr(13) & Chr(10) & Chr(13) & Chr(10) & send_msg_manager
	End If


	rc_manager = objBasp.SendMail(server_name,mailto,mailfrom,subj,send_msg,files)
	
	'sitename="‘¾—z‚Æ–ìØ‚Ì’¼”„Š"
	'domain="www.okamoto-farm.co.jp"
	'on error resume next
	'call maillog(sitename,domain,server_name,mailto,mailfrom,subj,send_msg)
	'on error goto 0

	'****************************************************************
	' ‘—MƒGƒ‰[ƒ`ƒFƒbƒN(ŠÇ—Ò)
	'****************************************************************
	If rc_manager <> "" Then
		'rc_manager‚ÉƒGƒ‰[ƒƒbƒZ[ƒW‚ª“ü‚è‚Ü‚·
		Response.write(rc_manager)
	End If
	'****************************************************************
	' ‚¨‹q—l‚Ö
	'****************************************************************
	mailfrom = "“Œ˜QŒ© ‰ª–{”_‰€<torami@okamoto-farm.co.jp>"
	subj = "¶Y”_‰Æ‰ïˆõ“o˜^î•ñ •ÏXó•tŠ®—¹‚Ì‚¨’m‚ç‚¹y‘¾—z‚Æ–ìØ‚Ì’¼”„Šz"
	mailto = "<" & Request.Form("email") & ">"
	send_msg = send_msg_visitor & send_msg_manager & send_msg_footer
	rc_visitor = objBasp.SendMail(server_name,mailto,mailfrom,subj,send_msg,files)
	'****************************************************************
	' ‘—MƒGƒ‰[ƒ`ƒFƒbƒN(‚¨‹q—l‚Ö)
	'****************************************************************
	If rc_visitor <> "" Then
		'rc_visitor‚ÉƒGƒ‰[ƒƒbƒZ[ƒW‚ª“ü‚è‚Ü‚·
		Response.write(rc_visitor)
	End If
	'****************************************************************
	Application.Unlock
	
	If rc_visitor = "" and rc_manager = "" Then
%>

<div class="block">

	<p>¶Y”_‰Æ‰ïˆõ“o˜^ƒ[ƒ‹‚ª‘—M‚³‚ê‚Ü‚µ‚½B</p>

<p class="centering"><a href="<%=ESURL%>index.asp" class="underline">ƒgƒbƒvƒy[ƒW‚Ö–ß‚é</a></p>
</div>
<%
	session("inqaccess")=""
else
%>
		<div class="block">

	<p>‘—M‚É¸”s‚µ‚Ü‚µ‚½B<br>ƒ[ƒ‹ƒAƒhƒŒƒX‚ÉŒë‚è‚ª‚ ‚é‰Â”\«‚ª‚ ‚è‚Ü‚·B<br>
‰½“x‚à‘—M‚É¸”s‚·‚éê‡‚ÍAtorami@okamoto-farm.co.jp‚Ö’¼Úƒ[ƒ‹‚ğ‚¨‘—‚è’¸‚­‚©A‚¨“d˜b‚É‚Ä‚²˜A—‚­‚¾‚³‚¢B
</p>

<p class="centering"><a href="<%=ESURL%>index.asp" class="underline">ƒgƒbƒvƒy[ƒW‚Ö–ß‚é</a></p>
</div>

<%
end if
else
%>
		<div class="block">

	<p><%=errmes%></p>

<p class="centering"><a href="<%=ESURL%>index.asp" class="underline">ƒgƒbƒvƒy[ƒW‚Ö–ß‚é</a></p>
</div>
<%
end if
else
%>

	<div class="block">

	<p>ƒAƒNƒZƒX‚ª•s³‚Å‚·B</p>

<p class="centering"><a href="<%=ESURL%>index.asp" class="underline">ƒgƒbƒvƒy[ƒW‚Ö–ß‚é</a></p>
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
