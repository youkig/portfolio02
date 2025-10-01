<!DOCTYPE html>
<html lang="ja">
<!--#include file="../config.inc"-->

<head>

<meta name="robots" content="all">
<meta property="og:title" content="太陽と野菜の直売所【東浪見岡本農園】">
<meta property="og:type" content="website">
<meta property="og:url" content="index.asp">
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="canonical" href="https://www.okamoto-farm.co.jp/index.asp">
<meta name="keywords" content="野菜,農産物,直売所,産直野菜,土産,通販,貸し農園,レンタル農園,野菜狩り,農業体験,千葉県,長生郡,一宮町">

<meta name="description" content="株式会社東浪見岡本農園（千葉県長生郡一宮町）が経営する【太陽と野菜の直売所】ホームページでは、農園に併設している農産物直売所のご紹介と、レンタル農園（貸し農園）、野菜狩り体験のほか、直売所に出荷する農家さんへのご案内を行っています。">

<title>生産農家会員様ログイン／農産物直売所 千葉【太陽と野菜の直売所】貸し農園 一宮町／野菜狩り／農業体験</title>

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
		SQL="SELECT * From t_cuser Where email='"&username&"' AND 審査=1"
		set rs=db.execute(SQL)
		if rs.eof then
			errmes="登録されていません"
			rs.close
		else
			if rs("審査")<>1 or rs("退会") = true then
				errmes="ログインできません"
				rs.close
			else
				if rs("password")<>password then
					errmes="パスワードが違います"
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
		errmes = "ログインIDを入力してください"
	end if

end if
%>
<body>

<div id="box">

<div id="header">
	<h1>新鮮野菜 直売所／千葉 一宮町</h1>


<!--#include file="../include/header.inc"-->

<div id="main" class="container">
	<div id="cnt" class="company">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">トップページ</a> | 生産農家会員様ログイン</p>
	<div class="block">
	<h2>生産農家会員様ログイン</h2>

<p>こちらのページは【太陽と野菜の直売所】の生産農家会員へご登録いただいた、会員様のログインページです。</p>

<p>ユーザーIDとパスワードを入力してログインしてください。</p>

</div>



<form action="<%=SSLURL%>farmer/login.asp" method="post" onSubmit="return signup(this)">
<div class="block">
<h3>会員ログインフォーム</h3>
	

<p><%=errmes%></p>


	<dl>
	<dt>ユーザーID</dt>
<dd><input type="text" name="loginid" id="loginid" value=""></dd>
</dl>

<dl>
	<dt>パスワード</dt>
<dd><input type="password" name="password" id="password" value=""></dd>
</dl>



</div>

<div class="block">

<p class="centering"><input type="submit" name="submit" value="ログイン"></p>
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
