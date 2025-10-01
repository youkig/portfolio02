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

<title>会員情報編集／農産物直売所 千葉【太陽と野菜の直売所】貸し農園 一宮町／野菜狩り／農業体験</title>

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
	<h1>新鮮野菜 直売所／千葉 一宮町</h1>


<!--#include file="../include/header.inc"-->

<div id="main" class="container">
	<div id="cnt" class="company regist">

	<p class="pankuzu"><a href="<%=ESURL%>index.asp">トップページ</a> | 会員情報編集</p>
	<div class="block">
	<h2>会員情報編集</h2>

<p>生産農家会員登録済みの情報をこちらのページから編集が出来ます。</p>

<p>尚、会社名はこちらのページからは変更出来ませんので、メールにてお問合せください。</p>


</div>

<%
	  SQL="SELECT * From t_cuser Where id=" & clng2(session("setid"))
	  set rsu=db.execute(SQL)
	  %>

<form action="change02.asp#form" method="post" name="forms" id="forms" onSubmit="return signup(this)">
<input type="hidden" name="id" value="<%=clng2(session("setid"))%>">
<div class="block">
<h3>会員情報編集フォーム</h3>
	
<dl>
	<dt>お名前&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="name" id="name" value="<%=rsu("name")%>"></dd>
</dl>

<dl>
	<dt>ふりがな&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="furigana" id="furigana" value="<%=rsu("furigana")%>"></dd>
</dl>



	<dl class="houjin">
	<dt>法人名</dt>
<dd><%=rsu("company")%><input type="hidden" name="company" value="<%=rsu("company")%>"></dd>
</dl>

<dl class="houjin">
	<dt>法人名ふりがな</dt>
<dd><%=rsu("fcompany")%><input type="hidden" name="fcompany" value="<%=rsu("fcompany")%>"></dd>
</dl>

<dl>
	<dt>登録責任者&nbsp;<em>※法人のみ</em></dt>
<dd><input type="text" name="hname" id="hname" value="<%=rsu("hname")%>"></dd>
</dl>

<dl>
	<dt>郵便番号&nbsp;<em>[必須]</em></dt>
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
	<dt>都道府県&nbsp;<em>[必須]</em></dt>
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
	<dt>以下住所&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="address" id="address" value="<%=rsu("address")%>"></dd>
</dl>

<dl>
	<dt>電話番号&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="tel" id="tel" value="<%=rsu("tel")%>"></dd>
</dl>

<dl>
	<dt>FAX番号</dt>
<dd><input type="text" name="fax" id="fax" value="<%=rsu("fax")%>"></dd>
</dl>


<dl>
	<dt>携帯電話番号</dt>
<dd>※いつでも連絡の取れる携帯電話番号[任意]<br>
<input type="text" name="mobile" id="mobile" value="<%=rsu("mobile")%>"></dd>
</dl>

<dl>
	<dt>メールアドレス&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="email" id="email" value="<%=rsu("email")%>"></dd>
</dl>

<dl>
	<dt>パスワード</dt>
<dd>※変更がなければ入力しないでください。半角英数字8文字から12文字以内<br><input type="password" name="password" id="password" value=""></dd>
</dl>



<dl>
	<dt>出荷予定曜日&nbsp;<em>[必須]</em></dt>
<dd><%if 1=2 then%><input type="checkbox" name="youbi" id="youbi1" value="月曜日" class="radiochk"><label for="youbi1">月曜日</label><br><%end if%>
<input type="checkbox" name="youbi" id="youbi2" value="火曜日" class="radiochk"<%if instr(rsu("曜日"),"火曜日")>0 then response.write(" checked='checked'")%>><label for="youbi2">火曜日</label><br>
<input type="checkbox" name="youbi" id="youbi3" value="水曜日" class="radiochk"<%if instr(rsu("曜日"),"水曜日")>0 then response.write(" checked='checked'")%>><label for="youbi3">水曜日</label><br>
<input type="checkbox" name="youbi" id="youbi4" value="木曜日" class="radiochk"<%if instr(rsu("曜日"),"木曜日")>0 then response.write(" checked='checked'")%>><label for="youbi4">木曜日</label><br>
<%if 1=2 then%><input type="checkbox" name="youbi" id="youbi5" value="金曜日" class="radiochk"><label for="youbi5">金曜日</label><br><%end if%>
<input type="checkbox" name="youbi" id="youbi6" value="土曜日" class="radiochk"<%if instr(rsu("曜日"),"土曜日")>0 then response.write(" checked='checked'")%>><label for="youbi6">土曜日</label><br>
<input type="checkbox" name="youbi" id="youbi7" value="日曜日" class="radiochk"<%if instr(rsu("曜日"),"日曜日")>0 then response.write(" checked='checked'")%>><label for="youbi7">日曜日</label><br>
<input type="checkbox" name="youbi" id="youbi8" value="祝日" class="radiochk"<%if instr(rsu("曜日"),"祝日")>0 then response.write(" checked='checked'")%>><label for="youbi8">祝日</label><br>
<input type="checkbox" name="youbi" id="youbi9" value="毎日" class="radiochk"<%if instr(rsu("曜日"),"毎日")>0 then response.write(" checked='checked'")%>><label for="youbi9">毎日</label><br>
※月、金は定休日
</dd>
</dl>

<dl>
	<dt>ホームページURL</dt>
<dd>※ホームページをお持ちの方は、「http」からご入力ください。[任意]<br>
<input type="text" name="url" id="url" value="<%=rsu("url")%>"></dd>
</dl>


</div>

<div class="block">
<p>上記内容でよろしければ、確認画面へお進みください。</p>
<p class="centering"><input type="submit" name="submit" value="内容確認"></p>
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
