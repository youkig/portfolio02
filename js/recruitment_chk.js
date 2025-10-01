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
		for (var i=1;i<=6;i++) {
			if (IPArray[i]>255) {
			      errms=errms+strMsg+"メールアドレスが正しくありません";
			}
		}
	}else{

	var domainArray=domain.match(domainPat)
	if (domainArray==null) {

		errms=errms+strMsg+"メールアドレスにドメイン名がありません。\n";
		//return false;
	}else{

	var atomPat=new RegExp(atom,"g")
	var domArr=domain.match(atomPat)
	var len=domArr.length
	if (domArr[domArr.length-1].length<2 ||
		domArr[domArr.length-1].length>8) {
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
	

	


//郵便番号
	if(formname.zip1){//タグが存在するかチェック。存在しないならば判定しない。
		in_name = formname.zip1.value;
		in_name2 = formname.zip2.value;
		if(in_name.length==0 || in_name2.length==0){
		errms=errms+"郵便番号を記入してください\n";
		}
	}
	
//都道府県
	if(formname.state){
		in_name = formname.state.value;
		errms=errms+missch2(in_name,"都道府県");
	
	}
		
//住所のチェック
	if(formname.address){
		in_name = formname.address.value;
		errms=errms+missch(in_name,"市区町名");
	}	
    
//以下住所のチェック
	if(formname.address2){
		in_name = formname.address2.value;
		errms=errms+missch(in_name,"以下番地等");
	}	

//対象住所のチェック
	if(formname.address3){
		in_name = formname.address3.value;
		errms=errms+missch(in_name,"対象住所");
	}	


		
//電話番号のチェック
	if(formname.tel){
		in_phone_num = formname.tel.value;
		errms=errms+phonech(in_phone_num,"","電話");
	}


//メールチェック
	if(formname.email){//タグが存在するかチェック。存在しないならば判定しない。
		in_wpd_mail = formname.email.value;
		errms=errms+mailch(in_wpd_mail,"");
	}
	
//提供可能種別
	if(formname.syubetsu1){
		var in_name="";
		if(formname.syubetsu1.checked){
			in_name = formname.syubetsu1.value;
		}
		if(formname.syubetsu2.checked){
			in_name = formname.syubetsu2.value;
		}
		if(formname.syubetsu3.checked){
			in_name = formname.syubetsu3.value;
		}
        if(formname.syubetsu4.checked){
			in_name = formname.syubetsu4.value;
		}
        if(formname.syubetsu5.checked){
			in_name = formname.syubetsu5.value;
		}
		errms=errms+missch2(in_name,"提供可能種別");
	}
    
//広さ
    if(formname.breadth){
        var in_name="";
        if(formname.breadth.value){
            in_name=formname.breadth.value;
        }
        if(formname.heya.value){
            in_name=formname.heya.value;
        }
        if(formname.ikken.checked){
            in_name=formname.ikken.value;
        }
        errms=errms+missch2(in_name,"広さ");
    }
   
	

//受入れ人数のチェック
	if(formname.ninzu){
		in_name = formname.ninzu.value;
		errms=errms+missch(in_name,"受入れ人数");
	}
	
//受入れ性別
	if(formname.sex1){
		var in_name="";
		if(formname.sex1.checked){
			in_name = formname.sex1.value;
		}
		if(formname.sex2.checked){
			in_name = formname.sex2.value;
		}
		if(formname.sex3.checked){
			in_name = formname.sex3.value;
		}
        
		errms=errms+missch2(in_name,"受入れ性別");
	}    
    
//食料の有無
	if(formname.food1){
		var in_name="";
		if(formname.food1.checked){
			in_name = formname.food1.value;
		}
		if(formname.food2.checked){
			in_name = formname.food2.value;
		}
		if(formname.food3.checked){
			in_name = formname.food3.value;
		}
        if(formname.food4.checked){
			in_name = formname.food4.value;
		}
		errms=errms+missch2(in_name,"食料の有無");
	}   
    
//自家発電システム設置の有無
	if(formname.power1){
		var in_name="";
		if(formname.power1.checked){
			in_name = formname.power1.value;
		}
        var in_name2="";
		if(formname.power2.checked){
			in_name2 = formname.power2.value;
		}
		if(in_name.length==0 && in_name2.length==0){
		  errms=errms+"自家発電システム設置の有無を選択してください。\n";
        }
        if(in_name.length!=0){
            var in_name="";
            if(formname.solar1.checked){
			in_name = formname.solar1.value;
		      }
            if(formname.solar2.checked){
			in_name = formname.solar2.value;
		      }
              errms=errms+missch2(in_name,"太陽光発電の種類");
        }
	}   
    
//飲料水の有無
	if(formname.well1){
		var in_name="";
		if(formname.well1.checked){
			in_name = formname.well1.value;
		}
        var in_name2="";
		if(formname.well2.checked){
			in_name2 = formname.well2.value;
		}
		if(in_name.length==0 && in_name2.length==0){
		  errms=errms+"飲料水の有無を選択してください。\n";
        }
        if(in_name.length!=0){
            var in_name="";
            if(formname.water1.checked){
			in_name = formname.water1.value;
		      }
            if(formname.water2.checked){
			in_name = formname.water2.value;
		      }
              errms=errms+missch2(in_name,"井戸水の種類");
        }
	}     
	
//ペット同居の有無
	if(formname.pet1){
		var in_name="";
		if(formname.pet1.checked){
			in_name = formname.pet1.value;
		}
		if(formname.pet2.checked){
			in_name = formname.pet2.value;
		}

		errms=errms+missch2(in_name,"ペット同居の有無");
	}   
    
//ペットの受入れ
	if(formname.petok1){
		var in_name="";
		if(formname.petok1.checked){
			in_name = formname.petok1.value;
		}
        var in_name2="";
		if(formname.petok2.checked){
			in_name2 = formname.petok2.value;
		}
		if(in_name.length==0 && in_name2.length==0){
		  errms=errms+"ペットの受入れの可否を選択してください。\n";
        }
        if(in_name.length!=0){
            var in_name="";
            if(formname.petplace1.checked){
			in_name = formname.petplace1.value;
		      }
            if(formname.petplace2.checked){
			in_name = formname.petplace2.value;
		      }
              errms=errms+missch2(in_name,"屋内または屋外");
              
              var in_name2="";
            if(formname.petsize1.checked){
			in_name2 = formname.petsize1.value;
		      }
            if(formname.petplace2.checked){
			in_name2 = formname.petsize2.value;
		      }
              errms=errms+missch2(in_name2,"ペットのサイズ");
        }
	}    
    
//宿泊費の有償無償
	if(formname.price1){
		var in_name="";
		if(formname.price1.checked){
			in_name = formname.price1.value;
		}
        var in_name2="";
		if(formname.price2.checked){
			in_name2 = formname.price2.value;
		}
		if(in_name.length==0 && in_name2.length==0){
		  errms=errms+"宿泊費の有償無償を選択してください。\n";
        }
        if(in_name2.length!=0){
            var in_name="";
            if(formname.price2.checked){
			in_name = formname.fee.value;
		      }
           
              errms=errms+missch(in_name,"1泊の宿泊費");
        }
	}      
    
//食事の有償無償
	if(formname.meal1){
		var in_name="";
		if(formname.meal1.checked){
			in_name = formname.meal1.value;
		}
        var in_name2="";
		if(formname.meal2.checked){
			in_name2 = formname.meal2.value;
		}
		if(in_name.length==0 && in_name2.length==0){
		  errms=errms+"食事の提供の有償無償を選択してください。\n";
        }
        if(in_name2.length!=0){
            var in_name="";
            if(formname.meal2.checked){
			in_name = formname.mealfee.value;
		      }
           
              errms=errms+missch(in_name,"1食の食費");
        }
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