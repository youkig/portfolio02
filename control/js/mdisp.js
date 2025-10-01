function signup(thisform){
	var errms = 0;
	$(".errmes").remove();
	
	if($("#name").val() == ""){
		$("#name").after("<p class='errmes'><em>お名前を入力してください。</em></p>");
		errms = 1;
	};
	if($("#furigana").val() == ""){
		$("#furigana").after("<p class='errmes'><em>フリガナを入力してください。</em></p>");
		errms = 1;
	};
	
	if($("input[name='person']:checked").val() == "1"){
		if($("#company").val() == ""){
			$("#company").after("<p class='errmes'><em>会社名を入力してください。</em></p>");
			errms = 1;
		};
	}

	if($("#email").val() == ""){
		$("#email").after("<p class='errmes'><em>メールアドレスを入力してください。</em></p>");
		errms = 1;
	}else{
		var mailerr = "";
		mailerr=mailch($("#email").val(),"");
		if(mailerr != ""){
			$("#email").after("<p class='errmes'><em>"+mailerr+"</em></p>");
			errms = 1;
		};
	};
	
	if($("input[name='member']:checked").val() == "1" && $("#id").val() == "0"){
		if($("#password").val() == ""){
			$("#password").after("<p class='errmes'><em>パスワードを入力してください。</em></p>");
			errms = 1;
		}else{
			var pnum = $("#password").val().length;
			if(pnum > 12 | pnum < 6){
			$("#password").after("<p class='errmes'><em>パスワードの文字数が一致しません。</em></p>");
			errms = 1;
			}
		}
	};
	
	if($("#phone").val() == ""){
		$("#phone").after("<p class='errmes'><em>電話番号を入力してください。</em></p>");
		errms = 1;
	}else{
		var phoneerr = "";
		phoneerr=phonech($("#phone").val(),"","電話");
		if(phoneerr != ""){
			$("#phone").after("<p class='errmes'><em>"+phoneerr+"</em></p>");
			errms = 1;
		};
	};
	if($("#fax").val() == ""){
	}else{
		var faxerr = "";
		faxerr=phonech($("#fax").val(),"","FAX");
		if(faxerr != ""){
			$("#fax").after("<p class='errmes'><em>正しいFAX番号を入力してください。</em></p>");
			errms = 1;
		};
	};
	if($("#zip1").val() == "" | $("#zip2").val() == ""){
		$("#zip2").after("<p class='errmes'><em>郵便番号を入力してください。</em></p>");
		errms = 1;
	}else{
		var ziperr = "";
		ziperr=zipch($("#zip1").val() + "-" + $("#zip2").val(),"");
		if(ziperr != ""){
			$("#zip2").after("<p class='errmes'><em>"+ziperr+"</em></p>");
			errms = 1;
		};
	};
	if($("#state").val() == ""){
		$("#state").after("<p class='errmes'><em>都道府県を選択してください。</em></p>");
		errms = 1;
	};
	if($("#address").val() == ""){
		$("#address").after("<p class='errmes'><em>所在地を入力してください。</em></p>");
		errms = 1;
	};

	if(errms==0){
		return true;
	}else{
		$("input[type='submit']:eq(0)").before("<span class='errmes'><em>入力エラーがあります。各必須項目を確認して下さい。</em><br /></span>")
		return false;
	}
}
