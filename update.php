<?php include("config.php");?>
<?php

	if($_POST["cnt"]>0){
		echo $_POST["cnt"];
		for($c=1;$c<=$_POST["cnt"];$c++){
			if($_POST["del".$c]==1){
				setcookie("okamotofarm_".$_POST["code".$c],"",-time() + 3600 * 24 * 8);
			}else{
				setcookie("okamotofarm_".$_POST["code".$c],$_POST["num".$c],-time() + 3600 * 24 * 7);
			}
		}
	}
    header("location:".$esurl."cart");
?>