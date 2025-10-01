function signup(thisform){
	var errms = 0;
	$(".errmes").remove();

	if($("#title").val() == ""){
		$("#title").after("<p class='errmes'><em>Q（質問）を入力してください。</em></p>");
		errms = 1;
	}else{
		if((($("#title").val().length)+nCount($("#title"))) > 300){
		$("#title").after("<p class='errmes'><em>文字数が多すぎます。</em></p>");
		errms = 1;
		}
	};
	
	if($("#naiyou").val() == ""){
		$("#naiyou").after("<p class='errmes'><em>A（回答）を入力してください。</em></p>");
		errms = 1;
	}else{
		if((($("#naiyou").val().length)+nCount($("#naiyou"))) > 1000){
		$("#naiyou").after("<p class='errmes'><em>文字数が多すぎます。</em></p>");
		errms = 1;
		}
	};
	
	if($("input[name='disp']:checked").size() == 0){
		$("#disp1").parent().get(1).after("<p class='errmes'><em>公開設定を選択してください。</em></p>");
		errms = 1;
	};
	
	if(errms==0){
		return true;
	}else{
		$("input[type='submit']").before("<span class='errmes'><em>入力エラーがあります。各必須項目を確認して下さい。</em><br /></span>")
		return false;
	}
}
