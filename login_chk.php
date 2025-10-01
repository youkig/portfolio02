<?php
session_start();
include("config.php");

foreach($_REQUEST as $key=>$val){
      $query .= $key."=".$val."&";
}
$reffer = $_SERVER["HTTP_REFERER"];
if (strpos($reffer,"?")!==false){
    $e = "&";
}else{
    $e = "?";
}
if (!empty($_POST["loginid"]) && !empty($_POST["password"])){
	$username=$_POST["loginid"];
	$password=$_POST["password"];
	
	if (!empty($username)){
        
		$sql="SELECT * From t_user Where email=:username AND dele=0 AND taikai=0";
		$u = $dbh->prepare($sql);
		$u -> bindValue(":username",$username,PDO::PARAM_STR);
		$u -> execute();
		$rs = $u->fetch(PDO::FETCH_ASSOC);
        
		if (empty($rs)){
			$errmes="登録されていません";
            
            header("location: ".$reffer.$e."errmes=".$errmes);
            exit();
		}else{
			if ($rs["dele"]==1 || $rs["taikai"] == 1){
				$errmes="ログインできません";

                header("location: ".$reffer.$e."errmes=".$errmes);
                exit();
			}else{
				if(!password_verify($password,$rs["password"])){
					$errmes="パスワードが違います";

                    header("location: ".$reffer.$e."errmes=".$errmes);
                    exit();
				}else{

				
                        //session_regenerate_id(true);
                        $_SESSION["setid"] = $rs['id'];
                        $_SESSION["logid"] = $rs['email'];
                        $_SESSION["username"] = $rs['name'];
                        $_SESSION["pass"] = $rs['password'];
						$_SESSION["company"] = $rs['company'];
                        //cookie
                        setcookie("setid", $rs['id'], time()+60*60,"/");
                        setcookie("logid", $rs['email'], time()+60*60,"/");
                        setcookie("pass", $rs['password'], time()+60*60,"/");
                        $reffer = $_SERVER["HTTP_REFERER"];

                        
                        header("location: ".$reffer);
                        exit();
					
					
					
				}
			}
		}
	}else{
		$errmes = "ログインIDを入力してください";
        $reffer = $_SERVER["HTTP_REFERER"];
        foreach($_REQUEST as $key=>$val){
                            $query .= $key."=".$val."&";
                        }
        header("location: ".$reffer."?errmes=".$errmes."&".$query);
	}

}

?>