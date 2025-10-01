<html lang="ja">
<?php include("../config.php");?>
<head>
	<meta charset="shift-jis" />
	<meta property="og:title" content="太陽と野菜の直売所【東浪見岡本農園】">
<meta property="og:type" content="website">
<meta property="og:url" content="index.php">
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="keywords" content="野菜狩り,野菜収穫体験,レンタル農園,貸し農園,レンタル農機具,レンタルキッチン,レンタル厨房,完全有機栽培,野菜直売所,井戸掘り,耕運代行,ソーラー,太陽光,非常用電源,千葉県,長生郡,一宮町,東浪見,外房,九十九里,とらみスイート">

<meta name="description" content="千葉県外房エリア、九十九里海岸の南端、長生郡一宮町ある、近隣唯一の完全有機栽培農家【太陽と野菜の直売所】（東浪見岡本農園）ホームページでは、観光農園として野菜狩り・農業体験サービスのほか、期間貸しのレンタル農園のご紹介や、農機・農機具レンタル、レンタル厨房のご案内をしております。停電時にいつも電気のある災害避難所としてもご利用になれます。">
	<title>【東浪見岡本農園】チャットシステム</title>
	<link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
<div id="header">
<?php
if (!empty($_REQUEST["id"])){
$_SESSION["messageid"]="";
$_SESSION["tid"]="";
$sql = "SELECT t_network.*,t_user.id as userid,t_user.name,t_user.company From t_network inner join t_user on t_network.uid = t_user.id Where t_network.id = :id";// & clng2(request2("id"))
$n = $dbh->prepare($sql);
$n -> bindValue(":id",$_REQUEST["id"],PDO::PARAM_INT);
$n -> execute();
$rs = $n->fetch(PDO::FETCH_ASSOC);

if (!empty($rs)){
$tid = $rs["userid"];
$_SESSION["tid"] = $tid;
$messageid = $_GET["messageid"]; 
?>
<h1><?php
if ($rs["companudisp"]==1){ 
echo $rs["company"];
}elseif ($rs["namedisp"]==1){
echo $rs["name"];
}elseif (!empty($rs["penname"])){
echo $rs["penname"];
}else{
echo "匿名";
}
?>様とチャット</h1>
<?php
}
}
?>
</div>

<?php

$errmes="　チャットを始めるためには、ログインが必要です。";
if(!empty($_GET["errmes"])){
	$errmes=$_GET["errmes"];
}
?>
<div id="container">
<?php
if (empty($_SESSION["setid"])){
?>
<form action="<?=$esurl?>login_chk" method="post" onSubmit="return signup(this)">
<div class="loginField">
<h2>会員ログインフォーム</h2>
	

<p><?=$errmes?></p>


	<dl>
	<dt>ユーザーID</dt>
<dd><input type="text" name="loginid" id="loginid" value="" /></dd>
</dl>

<dl>
	<dt>パスワード</dt>
<dd><input type="password" name="password" id="password" value="" /></dd>
</dl>



</div>

<div class="loginField">

<p class="centering"><input type="submit" name="submit" value="ログイン" /></p>
</div>
<input type="hidden" name="id" value="<?=$_REQUEST["id"]?>" />
<input type="hidden" name="messageid" value="<?=$_REQUEST["messageid"]?>" />

</form>
<?php
}else{
    $userid = $_SESSION["setid"];
    if (!empty($_REQUEST["messageid"])){
    $_SESSION["messageid"] = $_REQUEST["messageid"];
    $sql = "SELECT messageid,tid,uid From t_chat Where messageid=:messageid order by id";
	}else{
    $sql = "SELECT messageid,uid,tid From t_chat Where uid=:userid and tid = :tid order by id";
    }    
    $c = $dbh->prepare($sql);
	$rst = $c->fetch(PDO::FETCH_ASSOC);
    if (!empty($rst)){
        if ($_SESSION["setid"]!==$rst["uid"]){
        $tid = $rst["uid"];
        }else{
        $tid = $rst["tid"];
        }
        $_SESSION["messageid"]= $rst["messageid"];
        $messageid = $_SESSION["messageid"];
    }

?>
			<input type="hidden" name="userid" id="userid" value="<?=$userid?>">
			<input type="hidden" name="tid" id="tid" value="<?=$tid?>">
			<input type="hidden" name="messageid" id="messageid" value="<?=$messageid?>">
	
	<div id="talkField">
		<div id="result">
            
        </div>
		<br class="clear_balloon"/>
		<div id="end"></div>
	</div>
    
	<div id="inputField">
		<p>
			 <textarea name="message" id="message" rows="1"></textarea>
			<input type="button" id="greet" class="reset button-glow" value="送信">
		</p>
	</div>

<?php
}
?>    
	</div>

</body>
</html>