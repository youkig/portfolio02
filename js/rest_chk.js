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
function convertFullToHalfNum(str_Data){
	var ua;
	var str_Dummy = str_Data;
	var str_CnvertData = ""; 
	var array_Data = new Array();

	// ブラウザー情報の設定
	setBrowserMedia();
	// ブラウザー情報の取得
	ua = getBrowserMedia();

	// ブラウザがInternetExplorerもしくは、Operaの場合
	if(ua.InternetExplorer || ua.Opera){  // ブラウザ判別部分
		str_Dummy = escape(str_Dummy);
	} 
	// ブラウザがNetscapeもしくは、Mozillaの場合
	else if(ua.Netscape || ua.Mozilla){
		str_Dummy = convertAscii2Unicode(str_Dummy);
	}

	array_Data['2018'] = '0060';
	array_Data['2019'] = '0027';
	array_Data['201D'] = '0022';
	array_Data['3000'] = '0020';

	str_CnvertData = str_Dummy.replace(/%uFFE5/g , '%u005c');

	while(str_CnvertData.match(/%u([A-E1-9][A-F0-9]{3})/)){
		if( re_char[ RegExp.$1 ] ){
			str_CnvertData = str_CnvertData.replace(/%u[A-E1-9][A-F0-9]{3}/, "%u" + array_Data[RegExp.$1]);
		 }else{
			return false;
		 } 
	}
	while(str_CnvertData.match(/%u(FF[A-F0-9]{2})/ )){
		str_CnvertData = str_CnvertData.replace(/%uFF[A-F0-9]{2}/, "%u00" + (("0x" + RegExp.$1).toString(10) - 65248).toString(16));
	}

	// ブラウザがNetscapeもしくは、Mozillaの場合
	if(ua.Netscape || ua.Mozilla){  // ブラウザ判別部分
		str_CnvertData = str_CnvertData.replace( /%u00/g , '%');
	}
	return(unescape(str_CnvertData));
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
		errms=errms+strMsg+"Ｅメールアドレスを記入してください。\n";
	}else if(!checkAllHalfStringData(in_wpd_mail)){// メールアドレスの入力データチェック
		errms=errms+strMsg+"Ｅメールアドレスは半角で記入してください。\n";
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
		errms=errms+strMsg+"Ｅメールアドレスが正しくありません。\n"
	}else{

	var user=matchArray[1]
	var domain=matchArray[2]
  	if (user.match(userPat)==null) {
		errms=errms+strMsg+"Ｅメールアドレスが正しくありません。\n";
	}else{

	var IPArray=domain.match(ipDomainPat)
	if (IPArray!=null) {
		for (var i=1;i<=6;i++) {
			if (IPArray[i]>255) {
			      errms=errms+strMsg+"Ｅメールアドレスが正しくありません";
			}
		}
	}else{

	var domainArray=domain.match(domainPat)
	if (domainArray==null) {

		errms=errms+strMsg+"Ｅメールアドレスにドメイン名がありません。\n";
		//return false;
	}else{

	var atomPat=new RegExp(atom,"g")
	var domArr=domain.match(atomPat)
	var len=domArr.length
	if (domArr[domArr.length-1].length<2 ||
		domArr[domArr.length-1].length>8) {
		errms=errms+strMsg+"Ｅメールアドレスが正しくありません。\n";
	}else if (len<2) {
		var errStr=+strMsg+"Ｅメールアドレスにドメイン名がありません。\n"
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
		errms=errms+name+telorfax+"番号を記入してください。\n";
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
		errms=errms+"郵便番号の - が多すぎます";
		}else if (chkvalue.length != 7) {
		oksubmit = false ;
		errms=errms+"郵便番号の数字の桁数は半角文字で7桁にしてください";
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

////////////////////////////////////////////////////////////////////////////
// 送信処理（メイン部）
////////////////////////////////////////////////////////////////////////////
function signup(formname)
{
	var errms="";
	

    
//予約日
    //if(formname.monthnum){
    //    var in_name="";
    //    in_name = formname.monthnum.value;
    //    if(in_name.length==0){
	//	errms=errms+"ご予約月を入力してください。\n";
    //    }
    //}
    
    
    //if(formname.daynum){
    //   var in_name="";
    //    in_name = formname.daynum.value;
    //    if(in_name.length==0){
	//	errms=errms+"ご予約日を入力してください。\n";
    //    }
    //}


    if(formname.timenum){
        var in_name="";
        in_name = formname.timenum.value;
        if(in_name.length==0){
		errms=errms+"ご予約時間を選択してください。\n";
        }
    }


    
//人数
    if(formname.ninzu){
        var in_name="";
        in_name = formname.ninzu.value;
        if(in_name.length==0){
		errms=errms+"ご利用人数を選択してください。\n";
        }
    }  


//法人または個人
	if(formname.person1){
		var in_name="";
		if(formname.person1.checked){
			in_name = formname.person1.value;
		}
		if(formname.person2.checked){
			in_name = formname.person2.value;
		}
		
		errms=errms+missch2(in_name,"法人または個人");
	}	
	
//法人名
	if(formname.person1.checked){
	if(formname.company){
		in_name = formname.company.value;
		errms=errms+missch(in_name,"法人名");
	}
	}

//名前のチェック
	if(formname.name){
		in_name = formname.name.value;
		errms=errms+missch(in_name,"お名前");
	}

//フリガナのチェック
	if(formname.furigana){
		in_name = formname.furigana.value;
		errms=errms+missch(in_name,"ふりがな");
	}
	

//メールチェック
	if(formname.email){//タグが存在するかチェック。存在しないならば判定しない。
		in_wpd_mail = formname.email.value;
		errms=errms+mailch(in_wpd_mail,"");
	}

     //確認用メールチェック
	if(formname.kemail){//確認用メールが存在するかチェック。
		in_name = formname.kemail.value;
		errms=errms+missch(in_name,"メールアドレス（確認用）");
	}
	if(formname.kemail&&formname.email){
		if(formname.email.value != formname.kemail.value){
			errms=errms+"メールアドレスが間違っています\n";
		}
	}
		
//郵便番号チェック
	if(formname.zip1){//タグが存在するかチェック。存在しないならば判定しない。
		in_name = formname.zip1.value;
		in_name2 = formname.zip2.value;
		if(in_name.length==0 || in_name2.length==0){
		errms=errms+"郵便番号を記入してください\n";
		}
	}
	

	

//都道府県のチェック
	if(formname.state){
		in_name = formname.state.value;
		errms=errms+missch2(in_name,"都道府県");
	}
    
//住所のチェック
	if(formname.address){
		in_name = formname.address.value;
		errms=errms+missch(in_name,"市区町村名など");
	}
    if(formname.address2){
		in_name = formname.address2.value;
		errms=errms+missch(in_name,"番地、建物名など");
	} 



  // 送信
  if(errms==""){
  return true;
  }else{
	  alert(errms);
	  return false;
  }
}

//
//