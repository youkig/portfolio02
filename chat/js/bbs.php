<?php include("../../config.php");?>
<?php


$userid = $_REQUEST["userid"];
$tid = $_REQUEST["tid"];
$message = $_REQUEST["message"];
$messageid = $_REQUEST["messageid"];

if (!empty($userid) &&  !empty($message) && !empty($tid)){

$sql = "INSERT into t_chat (uid,tid,message,messageid,indate,intime) VALUES (:uid,:tid,:message,:messageid,:indate,:intime)";
$c = $dbh->prepare($sql);

$c -> bindValue(":uid",$userid,PDO::PARAM_INT);
$c -> bindValue(":tid",$tid,PDO::PARAM_INT);
$c -> bindValue(":message",$message,PDO::PARAM_STR);
$c -> bindValue(":indate",date('Y-m-d'),PDO::PARAM_STR);
$c -> bindValue(":intime",date('H:i:s'),PDO::PARAM_STR);

if (empty($messageid)){
    $meaid = date('Ymdhis');
    $c -> bindValue(":messageid",$meaid,PDO::PARAM_STR);
    // '****************************************************************
	// ' メール送信
	// '****************************************************************
	mb_language("japanese");
    mb_internal_encoding("UTF-8");
    
    // '初めての場合、メールを送信
        $send_msg_footer = "=====================================================\n";	
        $send_msg_footer .= " 東浪見岡本農園\n";
        $send_msg_footer .= "　〒299-4303\n";
        $send_msg_footer .= "　千葉県長生郡一宮町東浪見4721番\n";
        $send_msg_footer .= "　TEL:070-5580-5496\n";
        $send_msg_footer .= "　E-mail：torami@okamoto-farm.co.jp\n";
        $send_msg_footer .= "　URL：https://www.okamoto-farm.co.jp\n";
        $send_msg_footer .= "=====================================================\n";
        $send_msg_footer .= "\n";

    $sql ="SELECT t_network.*,t_user.name From t_network inner join t_user on t_network.uid = t_user.id Where t_network.id=:tid";
    $n = $dbh->prepare($sql);
    $n -> bindValue(":tid",$tid,PDO::PARAM_INT);
    $n -> execute();
    $rst = $n->fetch(PDO::FETCH_ASSOC);
    if (!empty($rst)){
        $to = $rst["email"];
        $header = "From:".mb_encode_mimeheader("【東浪見岡本農園】")."<torami@okamoto-farm.co.jp>";
        $subj = "ユーザーからチャットの依頼がありました【東浪見岡本農園】";
    
        $tname = $rst["name"];
        $send_msg = $tname . "様\n\n";
        $send_msg .="【東浪見岡本農園】です。\n";
        $send_msg .="有事の際の「疎開先ネットワーク」提供者様へのチャット申込みをしました。\n\n";
        $send_msg .="次回から、以下URLよりチャットへ入室して、返信等行ってください。\n\n";
        $send_msg .= $esurl."chat/index.asp?messageid=" . $meaid . "&id=" . $rst["id"] . "\n\n";
        $send_msg .= $send_msg_footer;

        if(mb_send_mail($to,$subj,$send_msg,$header)){
		    $rs_manager = "";
        }else{
            $rs_manager = 1;
        }
    
    }

    if (!empty($userid)){
        $sql = "SELECT * from t_user Where id=:userid";
        $u = $dbh->prepare($sql);
        $u -> bindValue(":userid",$userid,PDO::PARAM_INT);
        $u -> execute();
        $rsu = $u -> fetch(PDO::FETCH_ASSOC);
        if (!empty($rsu)){
            $to2 = $rsu["email"];
            $header2 = "From:".mb_encode_mimeheader("【東浪見岡本農園】")."<torami@okamoto-farm.co.jp>";
            $subj2 = "提供者様にチャットの申込みをしました【東浪見岡本農園】";
        
            $tname2 = $rsu["name"];
            $send_msg2 = $tname2 . "様\n\n";
            $send_msg2 .="【東浪見岡本農園】です。\n";
            $send_msg2 .="こちらのメールは有事の際の疎開先ネットワークへご登録いただいております会員様へお送りしております。\n\n";
            $send_msg2 .="ユーザー様よりチャットのご依頼がありました。\n";
            $send_msg2 .="以下、URLよりチャットへ入室して、折り返しご返信ください。\n\n";
            $send_msg2 .= $esurl."/chat/index.asp?messageid=" . $meaid . "&id=" . $rst["id"] . "\n\n";
            $send_msg2 .= $send_msg_footer;
            
            if(mb_send_mail($to2,$subj2,$send_msg2,$header2)){
                $rs_visitor = "";
            }else{
                $rs_visitor = 1;
            }
        }
    }
     
}else{
    $c -> bindValue(":messageid",$messageid,PDO::PARAM_STR);
    
}
$c -> execute();

}



$sql ="SELECT * From t_chat Where messageid=:messateid order by indate asc"; //session("messageid")
$m = $dbh->prepare($sql);
$m -> bindValue(":messageid",$_SESSION["messageid"],PDO::PARAM_STR);
$m -> execute();
$resutl = $m->fetchAll(PDO::FETCH_ASSOC);
$str="";
$da="";
if (!empty($resutl)){
    foreach($resutl as $rsc){
    if ($da!==$rsc["indate"]){
     $str .= '<p class="indate clear_balloon">' . $rsc["indate"] . '</p>';
    $da=$rsc["indate"];
    }
	$str .= '<dl class="clear_balloon">';
    if (cnum($_SESSION["setid"])==cnum($rsc["uid"])){
        $classname1 = "intime_right";
        $classname2 = "right_balloon";
    }else{
        $classname1 = "intime_left";
        $classname2 = "left_balloon";
    }
    
    if(date('i',strtotime($rsc["intime"]))<10){
    $in_time = "0" . date('i',strtotime($rsc["intime"]));
    }else{
    $in_time = date('i',strtotime($rsc["intime"]));
    }
    
    
	$str .= '<dt class="'.$classname1.'">' . date('H',strtotime($rsc["intime"])).':'. $in_time. '</dt>';
    $str .= '<dd class="'.$classname2.'">' . nl2br($rsc["message"]). '</dd>';
	$str .= '</dl>';
}
}
echo $str;

?>