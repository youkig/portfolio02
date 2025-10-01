<?php include("config.php");?>
<?php
if (cnum($_POST["num"]) !==0){
	//オプション項目をカンマで連結した文字列をcookieに代入
    setcookie("okamotofarm_".$_POST["id"],cnum($_POST["num"]),time() + 3600 * 24 * 7);
    header("location:cart?id=".$_POST["id"]);

}else{
	header("location:".$_SERVER["HTTP_REFERER"]);
}
?>                       
