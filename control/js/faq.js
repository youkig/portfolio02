function signup(thisform){
	var errms = 0;
	$(".errmes").remove();

	if($("#title").val() == ""){
		$("#title").after("<p class='errmes'><em>Q�i����j����͂��Ă��������B</em></p>");
		errms = 1;
	}else{
		if((($("#title").val().length)+nCount($("#title"))) > 300){
		$("#title").after("<p class='errmes'><em>���������������܂��B</em></p>");
		errms = 1;
		}
	};
	
	if($("#naiyou").val() == ""){
		$("#naiyou").after("<p class='errmes'><em>A�i�񓚁j����͂��Ă��������B</em></p>");
		errms = 1;
	}else{
		if((($("#naiyou").val().length)+nCount($("#naiyou"))) > 1000){
		$("#naiyou").after("<p class='errmes'><em>���������������܂��B</em></p>");
		errms = 1;
		}
	};
	
	if($("input[name='disp']:checked").size() == 0){
		$("#disp1").parent().get(1).after("<p class='errmes'><em>���J�ݒ��I�����Ă��������B</em></p>");
		errms = 1;
	};
	
	if(errms==0){
		return true;
	}else{
		$("input[type='submit']").before("<span class='errmes'><em>���̓G���[������܂��B�e�K�{���ڂ��m�F���ĉ������B</em><br /></span>")
		return false;
	}
}
