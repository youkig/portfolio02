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

<title>マイページログアウト／農産物直売所 千葉【太陽と野菜の直売所】貸し農園 一宮町／野菜狩り／農業体験</title>

<link rel="stylesheet" href="../css/base.css" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

<script src="../js/jquery-1.5.2.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../js/jquery.ui.css" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="../js/jquery.bgswitcher.js"></script>
<script src="../js/pagetop.js"></script>

<script src="../js/topslide.js"></script>


</head>

<%
for Each Key In Request.Cookies(cookiename_userlogin)
Response.Cookies(cookiename_userlogin)(key) = ""
next
Response.Cookies(cookiename_userlogin).Expires = DateAdd("d",-1,Date())
Response.Cookies(cookiename_userlogin).Domain = domname
Response.Cookies(cookiename_userlogin).path = "/"

Session("setid") = ""
Session("username") = ""
Session("logid") = ""
Session("pass") = ""
session("companyname")=""
Session.Abandon

%>
<body>

<div id="box">

<div id="header">
	<h1>新鮮野菜 直売所／千葉 一宮町</h1>


<!--#include file="../include/header.inc"-->

<div id="main" class="container">
	<div id="cnt" class="company">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">トップページ</a> | マイページログアウト</p>
	<div class="block">

<h2>マイページログアウト</h2>

					<p>ログアウトが完了しました。</p>
					<p><a href="<%=sslurl%>farmer/login.asp" class="underline">ログイン</a></p>
				</div>





<p id="page-top"><a href="#box"><img src="../img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<!--#include file="../include/leftpane.inc"-->
	

<!-- id main end --></div>

<!--#include file="../include/footer.inc"-->


<!-- id box end --></div>
</body>
</html>
