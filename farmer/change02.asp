<!DOCTYPE html>
<html lang="ja">
<!--#include file="../config.inc"-->
<%
if not loginch(Session("logid"),Session("pass")) then response.redirect sslurl & "farmer/login.asp"
%>

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

<title>会員情報編集（入力内容確認）／農産物直売所 千葉【太陽と野菜の直売所】貸し農園 一宮町／野菜狩り／農業体験</title>

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
	<h1>新鮮野菜 直売所／千葉 一宮町</h1>


<!--#include file="../include/header.inc"-->

<div id="main" class="container">
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">トップページ</a> | 会員情報編集（入力内容確認）</p>
	<div class="block" id="form">
	<h2>会員情報編集（入力内容確認）</h2>

<p>以下の内容でよろしければ、登録ボタンを押してください。</p>


</div>



<form action="change03.asp" method="post">
<div class="block">
<h3>会員情報入力内容</h3>
	
<dl>
	<dt>お名前&nbsp;<em>[必須]</em></dt>
<dd><%=request.form("name")%></dd>
</dl>

<dl>
	<dt>ふりがな&nbsp;<em>[必須]</em></dt>
<dd><%=request.form("furigana")%></dd>
</dl>



	<dl class="houjin">
	<dt>法人名</dt>
<dd><%=request.form("company")%></dd>
</dl>

<dl class="houjin">
	<dt>法人名ふりがな</dt>
<dd><%=request.form("fcompany")%></dd>
</dl>

<dl>
	<dt>登録責任者&nbsp;<em>※法人のみ</em></dt>
<dd><%=request.form("hname")%></dd>
</dl>

<dl>
	<dt>郵便番号&nbsp;<em>[必須]</em></dt>
<dd><%=request.form("zip1")%>-<%=request.form("zip2")%></dd>
</dl>

<dl>
	<dt>都道府県&nbsp;<em>[必須]</em></dt>
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
	<dt>以下住所&nbsp;<em>[必須]</em></dt>
<dd><%=request.form("address")%></dd>
</dl>

<dl>
	<dt>電話番号&nbsp;<em>[必須]</em></dt>
<dd><%=request.form("tel")%></dd>
</dl>

<dl>
	<dt>FAX番号</dt>
<dd><%=request.form("fax")%></dd>
</dl>


<dl>
	<dt>携帯電話番号</dt>
<dd><%=request.form("mobile")%>
</dd>
</dl>

<dl>
	<dt>メールアドレス&nbsp;<em>[必須]</em></dt>
<dd><%=request.form("email")%></dd>
</dl>
<%
			if request.form("password")<>"" then
			%>
<dl>
	<dt>パスワード&nbsp;<em>[必須]</em></dt>
<dd>※セキュリティの為、表示しません。</dd>
</dl>
<%
			end if
			%>


<dl>
	<dt>出荷予定曜日&nbsp;<em>[必須]</em></dt>
<dd><%=request.form("youbi")%>
</dd>
</dl>

<dl>
	<dt>ホームページURL</dt>
<dd><%=request.form("url")%>
</dd>
</dl>


</div>

<div class="block">
<p>上記内容でよろしければ、登録ボタンを押してください。</p>
<p class="centering"><input type="submit" name="submit" value="登　録">&nbsp;&nbsp;&nbsp;<input type="button" value="戻　る" onClick="history.back()" onKeyPress="history.back()"></p>
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
