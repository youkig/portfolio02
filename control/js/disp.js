
function button_re(e) {
	return e.replace("button_","");
}
$(document).ready(function(){
	$('.block').mouseover(function(){
		for(z=1;z<2;z++){
			$('.button'+z).each(function() {
				var button = $('.button'+z), interval;
				var deftext;
				var key="";
				var sid = $("#id").val();
				var fco = 0;
				if(sid){
					if(key==""){key="?"}else{key+="&"}
					key += 'sid='+sid;
				};
				
				new AjaxUpload(button, {
					action: 'js/upload.php'+key+"&key="+(button_re(button.attr("id"))),
					name: 'userfile',
					onSubmit : function(file, ext){
						this.disable();
						fsize2=0;
						interval = window.setInterval(function(){
							var text = button.text();
						}, 200);
					},
					onComplete: function(file, response){
						window.clearInterval(interval);
						this.enable();
						if(response.indexOf("error") >= 0){
							alert(response);
						}else{
							var arr_res = response.split(',');
							$('img#imgsrc_'+arr_res[1]).attr('src', 'photo/goods_pro/' + arr_res[0]);
							$('#fpath_'+arr_res[1]).val(arr_res[0]);
							$('#fpath_'+arr_res[1]).after("※変更・追加は登録ボタンを押すまで確定しません。");
						}
					}
				});
			});
		}
	});
	
	$(".kanrenBtn").click(function(){
		var a = $(this).attr("id");
		a = a.replace("kanrenBtn_","");
		var id = $("#id").val();
		var b = $("#kanrenidset").val();
		window.open("goodslist.php?kanrenid="+id+"&c="+ a + "&idset=" + b,"kanrenWindow", 'width=600, height=400, menubar=no, toolbar=no, scrollbars=yes');
	});
	
	kanrendel();
});

function signup(thisform){
	var errms = 0;
	$(".errmes").remove();
	
	if($("#sname").val() == ""){
		$("#sname").after("<p class='errmes'><em>商品名を入力してください。</em></p>");
		errms = 1;
	};
	if($("#price").val() == ""){
		$("#price").after("<p class='errmes'><em>販売価格を入力してください。</em></p>");
		errms = 1;
	}else{
		if(gf_Hankaku($("#price").val())){
		}else{
			$("#price").after("<p class='errmes'><em>販売価格は半角数字のみで入力してください。</em></p>");
			errms = 1;
		}
	};
	if($("#title").val() == ""){
		$("#title").after("<p class='errmes'><em>キャッチコピーを入力してください。</em></p>");
		errms = 1;
	};
	if($("#comment").val() == ""){
		$("#comment").after("<p class='errmes'><em>商品説明を入力してください。</em></p>");
		errms = 1;
	};

	if(errms==0){
		return true;
	}else{
		$("input[type='submit']").before("<span class='errmes'><em>入力エラーがあります。各必須項目を確認して下さい。</em><br /></span>")
		return false;
	}
}
