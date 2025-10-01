$(function(){
    //$('#button').click(function(){
		$('#greet').click(function(){
        
			if(!$('#userid').val() || !$('#tid').val() || !$('#message').val()) return;
			var u = "userid";            
			var n = $('#userid').val();

			var t = "tid";
			var x = $('#tid').val();
			
			var m = "message";
			var e = $('#message').val();
            e = e.replace(/\n|\r\n|\r/g, '<br>');
            
            var i = "messageid";
			var y = $('#messageid').val();
                
				$.ajax({
					type: "get",
					url: "./js/bbs.asp",
					data: u + "=" + n + "&" + t + "=" + x + "&" + m + "=" + e + "&" + i + "=" + y,
					success: function(str){
						if(str != ""){
							$('#result').html(str);
                            $('#message').val('');
						}else{
							alert(str + "エラーが起こりました?");
						}
					}
				});
		});
    loadLog();
    logAll();
	//});
});


// ログをロードす??
function loadLog(){
	$.ajax({
		type: "get",
		url: "./js/bbs.asp",
		data: "1",
    	success: function(str){
    	$('#result').html(str);
    	// scTarget();
		}
    });
}

// 一定間隔でログをリロードす??
function logAll(){
	setTimeout(function(){
		loadLog();
		logAll();
	},5000); //リロード時間???ここで調整
}
/*
 * 画面を最下部へ移動させる
 */
function scTarget(){
var pos = $("#end").offset().top; 
$("#talkField").animate({ 
 		scrollTop:pos
 	}, 0, "swing"); //swingで0が良さそ??
 	return false;
 }