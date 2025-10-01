$(function () {
	var openid = '';
	if($.cookie('slide')!=null){openid = $.cookie('slide')};

	$(".categorymenu dd").css("display","none");

	if(openid != ''){
		var ddid="";
		ddid = openid.replace('menu','submenu');
		var dtClass = $(".categorymenu dt#"+openid).attr("class");
		if(dtClass=="last-child"){
			$(".categorymenu dt#"+openid).removeClass("last-child");
			$(".categorymenu dt#"+openid).addClass("last-child2");
		}
		$(".categorymenu dd#"+ddid).css("display","block");
	}else{
		$(".categorymenu dd#submenu_1").css("display","block");
	};
	
	$(".categorymenu dt").click(function(){
		$.cookie("slide",null,{ expires: -1 }); //cookie削除
		$.cookie('slide',$(this).attr("id"), { expires: 3 }); //dtのidをcookieにセット
		var thisClass = $(this).attr("class");
		if(thisClass=="last-child"){
			$(this).removeClass("last-child");
			$(this).addClass("last-child2");
		}else{
			$(".categorymenu dt.last-child2").removeClass("last-child2").addClass("last-child");
		};
		var next = $(this).next();
		$(".categorymenu dd").not(next).slideUp("fast");
		
		if(next.is(':visible')){
			next.slideUp("fast");
		}else{
			next.slideDown("fast");
		}
	});
	
	$(".lencount").bind("keyup",function(){
		lencount($(this));
	});
	$(".lencount").change(function(){
		lencount($(this));
	}).change();

    $('.popwindow').click(function () {
		var a = $(this).attr("href");
		window.open(a,"popwin", 'width=400, height=400, menubar=no, toolbar=no, scrollbars=yes');
		return false;
    });
    
	$("#getStrong").click(function(){
		$('textarea.naiyou')
			.insertBeforeSelection('{{strong}}')
			.insertAfterSelection('{{/strong}}');
		lencount($("textarea.naiyou"));
	});
	$("#getItalic").click(function(){
		$('textarea.naiyou')
			.insertBeforeSelection('{{italic}}')
			.insertAfterSelection('{{/italic}}');
		lencount($("textarea.naiyou"));
	});
	$("#getLine").click(function(){
		$('textarea.naiyou')
			.insertBeforeSelection('{{underline}}')
			.insertAfterSelection('{{/underline}}');
		lencount($("textarea.naiyou"));
	});
	$("#getLink").click(function(){
		var a = $('textarea.naiyou').getSelection();
		var b = window.prompt("リンク先のURLを入力してください。", "http://");
		$('textarea.naiyou')
			.insertBeforeSelection('<a href="')
			.replaceSelection(b)
			.insertAfterSelection('" target="_blank">'+ a + '</a>');
		lencount($("textarea.naiyou"));
	});
	$("#getLink2").click(function(){
		var a = $('textarea.naiyou').getSelection();
		var b = window.prompt("リンク先のURLを入力してください。", "http://");
		$('textarea.naiyou')
			.insertBeforeSelection('<a href="')
			.replaceSelection(b)
			.insertAfterSelection('" target="_self">'+ a + '</a>');
		lencount($("textarea.naiyou"));
	});
	$(".getEmoji").click(function(){
		var a = $(this).attr("id");
		var b = "{{"+a+"}}"
		$('textarea.naiyou')
			.insertAfterSelection(b);
		lencount($("textarea.naiyou"));
	});
	$(".picColor").click(function(){
		var a = $(this).attr("style");
		a = a.replace("color:","");
		$('textarea.naiyou')
			.insertBeforeSelection('{{color:'+a+'}}')
			.insertAfterSelection('{{/color}}');
		lencount($("textarea.naiyou"));
	});
	$("#getColor").click(function(){
		var a = $('textarea.naiyou').getSelection();
		var b = window.prompt("16進数を直接入力してください。（#不要）", "");
		$('textarea.naiyou')
			.insertBeforeSelection('{{color:#')
			.replaceSelection(b)
			.insertAfterSelection('}}'+ a + '{{/color}}');
		lencount($("textarea.naiyou"));
	});
	$(".delbtn").click(function(){
		alert();						
		var a = $(this).attr("id");
		a = a.replace("delid","");
		var b = $(this).attr("title");
		var c = $(this).attr("class");
		if(c.indexOf("newdel") > 0){
			var d = "タイトル";
			var f = "newid";	
		}else if(c.indexOf("faqdel") > 0){
			var d = "Q（質問）";
			var f = "faqid";
		}else if(c.indexOf("b1del") > 0){
			var d = "商品カテゴリ";
			var f = "b1id";
		}else if(c.indexOf("b2del") > 0){
			var d = "商品カテゴリ";
			var f = "b2id";
		}else if(c.indexOf("syouhindel") > 0){
			var d = "商品";
			var f = "sid";
		}else if(c.indexOf("o1del") > 0){
			var d = "オプション名";
			var f = "oid1";
		}else if(c.indexOf("o2del") > 0){
			var d = "オプション内容";
			var f = "oid2";
		}else if(c.indexOf("goodsdel") > 0){
			var d = "商品";
			var f = "goodsid";
		}else if(c.indexOf("memdel") > 0){
			var d = "顧客";
			var f = "memid";
		};
		if(window.confirm(d + '：'+b+'を削除してよろしいですか？')){
			$.ajax({
				type: "get",
				url: "./js/news_del.asp",
				data: f + "=" + a,
				success: function(str){
					if(str == "success"){
						setTimeout(ReloadAddr,100);
						alert("削除されました。");
					}else{
						alert(str + "エラーが起こりました。\n削除は完了していない可能性があります。");
					}
				}
			});
		};
		lencount($("textarea.naiyou"));
	});
	
	$(".delEmoji").click(function(){
		var a = $(this).attr("id");
		if(window.confirm("削除しますか？")){
			$.ajax({
				type: "get",
				url: "./js/delEmoji.asp",
				data: "name=" + a,
				success: function(str){
					if(str == "success"){
						setTimeout(ReloadAddr,100);
						alert("削除されました。");
					}else{
						alert(str + "エラーが起こりました。\n削除は完了していない可能性があります。");
					}
				}
			});
		};
	});

});

function lencount(x){
	var a1 = x.val();
	var a2 = a1.split("\n");
	var a3 = (a2.length) - 1;
	var a = a1.length;
	var b = x.attr("class");
	var b1 = b.split(" ");
	var c = 0;
	for(i=0;i<b1.length;i++){
		if(b1[i].indexOf("countset",0) >= 0){
			c = b1[i].replace("countset","");
			c = parseInt(c);
			break;
		}
	}
	var d = c - (a+a3);
	var e = x.attr("id");
	$("#"+e+"_set").text("あと"+d+"文字");
}

function ReloadAddr(){
	window.location.reload();
}

function registEnd(r){
	if($("#registendEco").size() > 0){
		$("#header").before("<div id='registend'><p>登録されました</p></div>");
	};
	setTimeout(registEndremove,3000);
}
function registEndremove(){
	$("#registend").fadeTo('normal',0,registEndremove2);
	function registEndremove2(){
		$("#registend").remove();
		$("#registendEco").remove();
	}
}
function redirectTo(e){
	location.href = e;
}
function getQueryAll(e){
	var a = e.split("?");
	return a[1];
}
function getQuery(e,q){
	var a = e.split("?");
	var b = a[1].split("&");
	for(i in b){
		var c = b[i].split("=");
		if(c[0] == q){
			return c[1];
			break;
		}
	}
}

function nCount(x){
	var a1 = x.val();
	var a2 = a1.split("\n");
	var a3 = (a2.length) - 1;
	return a3;
}

function kanrendel(){
	$(".kanrendel").click(function(){
		var a = $(this).attr("id");
		a = a.replace("kanrendel_","");
		var a2 = $("#kid_"+a).val();
		var b = $("#kanrenidset").val();
		b = b.replace(a2,"0");
		$("#kanrendiv_"+a).remove();
		$("#kanren_"+a).val("");
		$("#kanrenidset").val(b);
		alert("削除は確定していません。\n「この内容で登録する」を押すと確定します。");
	});
}


//-----------------------------------------------
// 全角文字のみか？のチェック処理
//-----------------------------------------------
function checkAllFullStringData(str_Data){
 	var str_Check = str_Data;
 	var int_flg = 0;
	//文字列のチェック
	for (var int_i = 0; int_i < str_Check.length; int_i++) {
        	var chr_chk = str_Check.charCodeAt(int_i);
		//  文字が半角だった場合
		if (chr_chk < 256 || (chr_chk >= 0xff61 && chr_chk <= 0xff9f)) {
			int_flg = 1;
			break;
		}
	}
	//全角文字のみのデータだった場合
	if(int_flg == 0){
		return true;
	}
	//全角文字と半角文字が混在する場合
	else {
		return false;
	}
}
//-----------------------------------------------
// 半角文字のみか？のチェック処理
//-----------------------------------------------
function checkAllHalfStringData(str_Data){
	var str_Check = str_Data;
 	var int_flg = 0;

	//文字列のチェック
	for(var int_i = 0; int_i < str_Check.length; int_i++){
        	var chr_chk = str_Check.charCodeAt(int_i);
		//  文字が半角の場合
		if (chr_chk < 256 || (chr_chk >= 0xff61 && chr_chk <= 0xff9f)) {
			int_flg = 0;
		}else{
			int_flg = 1;
			break;
		}
	}
	//半角文字のみのデータだった場合
	if(int_flg == 0){
		return true;
	}
	//全角文字と半角文字が混在する場合
	else {
		return false;
	}
}
//-----------------------------------------------
// 全角英数字を半角に変換する処理
//-----------------------------------------------
function checkAllHalfStringData(str_Data){
	var str_Check = str_Data;
 	var int_flg = 0;

	//文字列のチェック
	for(var int_i = 0; int_i < str_Check.length; int_i++){
        	var chr_chk = str_Check.charCodeAt(int_i);
		//  文字が半角の場合
		if (chr_chk < 256 || (chr_chk >= 0xff61 && chr_chk <= 0xff9f)) {
			int_flg = 0;
		}else{
			int_flg = 1;
			break;
		}
	}
	//半角文字のみのデータだった場合
	if(int_flg == 0){
		return true;
	}
	//全角文字と半角文字が混在する場合
	else {
		return false;
	}
}
//-----------------------------------------------
// 全角英数字を半角に変換する処理
//-----------------------------------------------
	function getunicode(str){
		
		var moji;
		var uni = "";
		for( var i=0;i<str.length;i++){
			moji = str.charCodeAt(i);
			if(moji <= 255){ //ascii文字
				if(moji <=15){
					//CRLF（改行コード）・tabなど。CRなら「0D」と返ってくると
					//思いきや「d」が返ってくる
					uni = uni + "%0" + moji.toString(16);
				} else if(moji >=48 && moji <=57){ //半角数字
					//そのまま表示
					uni = uni + str.charAt(i);
				} else if(moji >=65 && moji <=90){ //アルファベット大文字
					//そのまま表示
					uni = uni + str.charAt(i);
				} else if(moji >=97 && moji <=122){ //アルファベット小文字
					//そのまま表示
					uni = uni + str.charAt(i);
				} else {
					//「<」「>」「&」などは変換
					uni = uni + "%" + moji.toString(16);
				}
			} else {
				//16進数に変換
				uni = uni + "%u" + moji.toString(16);
			}
		}
		return uni;
	}


//文字定義
half = "0123456789";
half += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
half += "abcdefghijklmnopqrstuvwxyz";
half += "-+_@., ";
half += "アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲンァィゥェォッャュョー";
halfArr = new Array("ヴ","ガ","ギ","グ","ゲ","ゴ","ザ","ジ","ズ","ゼ","ゾ","ダ","ヂ","ヅ","デ","ド","バ","ビ","ブ","ベ","ボ","パ","ピ","プ","ペ","ポ");

full = "０１２３４５６７８９";
full += "ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺ";
full += "ａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚ";
full += "－＋＿＠．，　";
full += "ｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖﾗﾘﾙﾚﾛﾜｦﾝｧｨｩｪｫｯｬｭｮｰ";
fullArr = new Array("ｳﾞ","ｶﾞ","ｷﾞ","ｸﾞ","ｹﾞ","ｺﾞ","ｻﾞ","ｼﾞ","ｽﾞ","ｾﾞ","ｿﾞ","ﾀﾞ","ﾁﾞ","ﾂﾞ","ﾃﾞ","ﾄﾞ","ﾊﾞ","ﾋﾞ","ﾌﾞ","ﾍﾞ","ﾎﾞ","ﾊﾟ","ﾋﾟ","ﾌﾟ","ﾍﾟ","ﾎﾟ");


function kaigyo(){

//if(document.chgForm.kaigyo.checked){
//  while(messOut.indexOf("\r",0) >= 0 || messOut.indexOf("\n",0) >= 0){
//    messOut = messOut.replace("\r","");
//    messOut = messOut.replace("\n","");
 // }
//}

}//end kaigyo


function chgMessHalf(inel,outel){

  messIn = inel.value;
  messOut = "";

  //半角カナ用
  for(i=0; i<halfArr.length; i++){
    reg = new RegExp(fullArr[i],"g"); 
    messIn = messIn.replace(reg, halfArr[i]);
  }

  for(i=0; i<messIn.length; i++){
    oneStr = messIn.charAt(i);
    num = full.indexOf(oneStr,0);
    oneStr = num >= 0 ? half.charAt(num) : oneStr;
    messOut += oneStr;
  }

  //改行コード削除
  kaigyo();

  outel.value = messOut;
}//end chgMessHalf


function chgMessFull(){

  messIn = document.chgForm.messIn.value;
  messOut = "";

  //半角カナ用
  for(i=0; i<fullArr.length; i++){
    reg = new RegExp(halfArr[i],"g"); 
    messIn = messIn.replace(reg, fullArr[i]);
  }

  for(i=0; i<messIn.length; i++){
    oneStr = messIn.charAt(i);
    num = half.indexOf(oneStr,0);
    oneStr = num >= 0 ? full.charAt(num) : oneStr;
    messOut += oneStr;
  }

  //改行コード削除
  kaigyo();

  document.chgForm.messOut.value = messOut;
}//end chgMessFull


function copyJs(copyObj, NAME) {
  theObj = eval("document.chgForm." + NAME);
  theObj.focus();
  theObj.select();

  if(copyObj == "yes"){
    theRange = theObj.createTextRange();
    theRange.execCommand("copy");
  }

}//end copyJs


first = "on";
function txtClear(){
  if(first == "on"){
    document.chgForm.messIn.value = "";
    first = "off";
  }
}//end txtClear

function convertFullToHalfNum(str_Data){
chgMessHalf(str_Data,str_Data)
//	var str_Dummy = str_Data.value;
// str.value=str_CnvertData;
}
//-----------------------------------------------
// 一括メールチェック
//-----------------------------------------------

////////////////////////////////////////
//strMsgには、"お届け先の～"といった場合に
//"お届け先の"を引数としてわたしてあげてください。
////////////////////////////////////////
function mailch(in_wpd_mail,strMsg)
{
	var errms="";
	// メールアドレスの未入力チェック
	if (in_wpd_mail.length == 0){
		errms=errms+strMsg+"メールアドレスを記入してください。\n";
	}else if(!checkAllHalfStringData(in_wpd_mail)){// メールアドレスの入力データチェック
		errms=errms+strMsg+"メールアドレスは半角で記入してください。\n";
	}else{
	var emailStr = in_wpd_mail
	var emailPat=/^(.+)@(.+)$/
	var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
	var validChars="\[^\\s" + specialChars + "\]"
	var quotedUser="(\"[^\"]*\")"
	var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
	var atom=validChars + '+'
	var word="(" + atom + "|" + quotedUser + ")"
	var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
	var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")
	var matchArray=emailStr.match(emailPat)
  	if (matchArray == null) {
		errms=errms+strMsg+"メールアドレスが正しくありません。\n"
	}else{

	var user=matchArray[1]
	var domain=matchArray[2]
  	if (user.match(userPat)==null) {
		errms=errms+strMsg+"メールアドレスが正しくありません。\n";
	}else{

	var IPArray=domain.match(ipDomainPat)
	if (IPArray!=null) {
		for (var i=1;i<=4;i++) {
			if (IPArray[i]>255) {
			      errms=errms+strMsg+"メールアドレスが正しくありません";
			}
		}
	}else{

	var domainArray=domain.match(domainPat)
	if (domainArray==null) {
		errms=errms+strMsg+"メールアドレスにドメイン名がありません。\n";
		return false;
	}else{

	var atomPat=new RegExp(atom,"g")
	var domArr=domain.match(atomPat)
	var len=domArr.length
	if (domArr[domArr.length-1].length<2 ||
		domArr[domArr.length-1].length>3) {
		errms=errms+strMsg+"メールアドレスが正しくありません。\n";
	}else if (len<2) {
		var errStr=+strMsg+"メールアドレスにドメイン名がありません。\n"
		errms=errms+errStr;
	}}}}}}
return errms;
}

////////////////////////////////////////////////////////////////////////////
// 内容が空かどうかの処理（入力式）
//name:お名前、電話番号、郵便番号など
//in_name:受け取る入力フォーム変数（value値）
////////////////////////////////////////////////////////////////////////////
function missch(in_name,name){
var errms="";
	if (in_name.length == 0){
		errms=name+"を記入してください。\n";
	}
return errms
}
////////////////////////////////////////////////////////////////////////////
// 内容が空かどうかの処理(プルダウン式)
//name:都道府県、職業、など
//in_name:受け取る入力フォーム変数（value値）
////////////////////////////////////////////////////////////////////////////
function missch2(in_name,name){
var errms="";
	if (in_name.length == 0){
		errms=name+"を選択してください。\n";
	}
return errms
}

////////////////////////////////////////////////////////////////////////////
// 電話番号処理
//name:お届け先の
//telorfax:電話、またわFAX
//in_name:受け取る入力フォーム変数（value値）
////////////////////////////////////////////////////////////////////////////
function phonech(in_phone_num,name,telorfax){
var errms="";
	if (in_phone_num.length == 0)
	{
		errms=errms+name+telorfax+"番号又は携帯番号を記入してください。\n";
	}else if(in_phone_num.length > 15){
		errms=errms+name+telorfax+"番号が長すぎます。\n";
	}else if (in_phone_num.match(/^[0-9]+\-[0-9]+\-[0-9]+$/) == null)
	{
		errms=errms+name+"正しい"+telorfax+"番号を記入してください。\n";
	}

return errms
}
////////////////////////////////////////////////////////////////////////////
// 郵便番号処理
//name:お届け先の
//in_zip:受け取る入力フォーム変数（value値）
////////////////////////////////////////////////////////////////////////////

function zipch(in_zip,name){
var errms="";

	if (in_zip.length == 0)
	{
		errms=errms+"郵便番号を記入してください。\n";
	}else{
	var chkvalue = in_zip.split('-').join('') // - を除去
		if ( (in_zip.length - chkvalue.length) >1 ){
		oksubmit = false ;
		errms=errms+"郵便番号の - が多すぎます\n";
		}else if (chkvalue.length != 7) {
		oksubmit = false ;
		errms=errms+"郵便番号の数字の桁数は半角文字で7桁にしてください\n";
		}else if (chkvalue.match(/^[0-9]+[0-9]+$/) == null){
		oksubmit = false ;
		errms=errms+"正しい郵便番号を入力してください\n";
		}
	}

return errms
}

////////////////////////////////////////////////////////////////////////////
// チェックボックス/ラジオボタン処理
//name:選択されていないときのメッセージ
//in_radio:受け取る入力フォーム変数(フォーム値1,フォーム値２,フォーム値3,…)
////////////////////////////////////////////////////////////////////////////

function buttonch(in_radio,name){
var errms="";
var countx=0;
for(chlist in in_radio) {
	if(chlist){if(chlist.checked){countx++;}}
}
if(countx>0){errms=name+"\n"}

return errms
}

function gf_Hankaku(e){
  if(e.match(/[^0-9]+/) == null){
    return true;
  }else{
    return false;
  }
}

function checkDate(year,month,day){
    var dt = new Date(year, month - 1, day);
    if(dt == null || dt.getFullYear() != year || dt.getMonth() + 1 != month || dt.getDate() != day) {
        return false;
    }
    return true;
}