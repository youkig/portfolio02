function signup(thisform){
	var errms = 0;
	$(".errmes").remove();
	
	var n1 = (new Date()).getFullYear();
	var n2 = (new Date()).getMonth();
	var n3 = (new Date()).getDate();
	var n = n1 + "/" + n2 + "/" + n3;
	var nn = new Date();
	
	var k1 = new Date($("#year").val() + "/" + $("#month").val() + "/" + $("#day").val());
	var k2 = new Date($("#year2").val() + "/" + $("#month2").val() + "/" + $("#day2").val() + " " + $("#hour2").val() + ":" + $("#minutes2").val() + ":00");
	
	if(checkDate($("#year").val(),$("#month").val(),$("#day").val())){
	}else{
		//alert($("#year").parent().get(0).tagName);
		$("#year").parent().after("<p class='errmes'><em>日付が存在しません。</em></p>");
		errms = 1;
	}
	
	if($("#title").val() == ""){
		$("#title").after("<p class='errmes'><em>タイトルを入力してください。</em></p>");
		errms = 1;
	};
	if($("#naiyou").val() == ""){
		$("#naiyou").after("<p class='errmes'><em>内容を入力してください。</em></p>");
		errms = 1;
	};
	if($("input[name='disp']:checked").size() == 0){
		$("#disp1").parent().get(1).after("<p class='errmes'><em>公開設定を選択してください。</em></p>");
		errms = 1;
	}else{
		if($("input[name='disp']:checked").val() == "2"){
			if(checkDate($("#year2").val(),$("#month2").val(),$("#day2").val())){
				if(k2<nn){
					$("#disp1").parents("ul").after("<p class='errmes'><em>日付が過去か、もしくは存在しません。</em></p>");
					errms = 1;
					alert("a");
				}
			}else{
				$("#disp1").parents("ul").after("<p class='errmes'><em>日付/時刻が過去か、もしくは存在しません。</em></p>");
				errms = 1;
				alert("b");
			};
		}
	}
	
	if(errms==0){
		return true;
	}else{
		$("input[type='submit']").before("<span class='errmes'><em>入力エラーがあります。各必須項目を確認して下さい。</em><br /></span>")
		return false;
	}
}
