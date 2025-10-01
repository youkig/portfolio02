<?php $siteid=80?>
<?php include("include/autometa.php");?>
<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<?php include("config.php");?>


<head>

<meta name="robots" content="all">
<meta property="og:title" content="">
<meta property="og:type" content="website">
<meta property="og:url" content="index.php">
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="canonical" href="<?=$esurl?>restform01.php">
<meta name="keywords" content="<?=$n_keyword?>">

<meta name="description" content="<?=$n_description?>">

<title><?=$n_title?></title>

<link rel="stylesheet" href="css/base.css?<?=str_replace(":", "", date("H:i:s")); ?>" type="text/css">
<?php include("include/js.php")?>
<script src="js/rest_chk.js"></script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>

<script>
$(function () {
	
	$("#person1").click(function(){
		$(".houjin").fadeIn();
	});
	
	$("#person2").click(function(){
		$(".houjin").fadeOut();
	});




});
</script>
</head>

<body>
<?php
if(!empty($n_h5)){
?>
<h5 id="autochangepg"><?=$n_h5?></h5>
<?php
}
?>


<div id="box">

<div id="header">
<h1><?=$n_h1?></h1>

<?php include("include/header.php")?>


<div id="main" class="container">
	<?php include("include/leftpane.php")?>
	<div id="cnt" class="company about mrecruit">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | バイクツアラー向けの「無料休憩所」を用意しました！</p>

<h2>バイクツアラー向けの「無料休憩所」を用意しました！</h2>

<div class="block">


<div class="container rest">
<div class="leftbox">
<p>【太陽と野菜の直売所】（東浪見岡本農園）では、バイク（オートバイ）だけでなく、房総半島に遊びに来ていただいている方々に、「トイレ休憩所」として、農園に来ていただけるお客様だけでなく、コンビニ等の混雑したトイレではなく、ゆったりと綺麗なお手洗いを使っていただけるように、営業時間中であれば、いつでもお使いいただけるように用意させていただくことになりました。（令和4年9月から）</p>

</div>
<div class="rightbox">
<p><img src="img/rest/img01.jpg" alt="バイクツーリングのイメージ画像" width="376" height="217"></p>
</div>
</div>



</div>

<div class="block">

<h3>使っていただける場所と時間帯</h3>
	<dl>
	<dt>住所</dt>
<dd>〒299-4303 千葉県長生郡一宮町東浪見4721番&nbsp;<a href="https://www.google.com/maps/place/%E5%A4%AA%E9%99%BD%E3%81%A8%E9%87%8E%E8%8F%9C%E3%81%AE%E7%9B%B4%E5%A3%B2%E6%89%80+%E6%9D%B1%E6%B5%AA%E8%A6%8B%E5%B2%A1%E6%9C%AC%E8%BE%B2%E5%9C%92/@35.355378,140.375893,16z/data=!4m5!3m4!1s0x0:0x2b1aeddfe0a7f9f5!8m2!3d35.3554481!4d140.3780789?hl=ja" class="underline" target="_blank">Google mapへ</a></dd>
</dl>

<dl>
	<dt>曜日と時間帯</dt>
<dd>定休日（月、金）以外の、午前8時30分～午後5時30分<br>※午後0時～午後2時30分までは昼休みとなります。</dd>
</dl>

<dl>
	<dt>駐車できる数</dt>
<dd>バイク：約20台、クルマ：約8台</dd>
</dl>

</div>

<div class="block">
<h3>事前予約が必要です</h3>
<p>特別にバイクでの来園に限らず、お車でお越しの方も、トイレ休憩だけの用向きで来園いただいても一向に構いませんが、基本的に「前日までの事前予約制」とさせていただいております。</p>

<p>以下お申込みフォームから、概ねの到着時間を明記していただき、来園のご予約をお願いいたします。</p>
</div>




<?php
if(!empty($_SESSION["logid"]) && !empty($_SESSION["pass"])){
$sql="select * From t_user Where email=:email and password2=:password and dele=0 and taikai=0";
$user = $dbh->prepare($sql);
$user -> bindValue(':email',$_SESSION["logid"],PDO::PARAM_STR);
$user -> bindValue(':password',$_SESSION["pass"],PDO::PARAM_STR);
$user -> execute();
$result = $user->fetch(PDO::FETCH_ASSOC);
    if(!empty($result)){
    $person = $result["person"];
    $company = $result["company"];
    $busyo = $result["busyo"];
    $username=$result["name"];
    $furigana = $result["furigana"];
    $email = $result["email"];
    $tel = $result["tel"];
    $zip = explode("-",$result["zip"]);
    $zip1 = $zip[0];
    $zip2 = $zip[1];
    
    $sql="select state From t_state Where id=:state";
    $state = $dbh->prepare($sql);
    $state -> bindValue(":state",$result["state"],PDO::PARAM_INT);
    $sta = $state->fetch(PDO::FETCH_ASSOC); 
    
    $statename = $sta["state"];
    $address = $result["address"];
    $address2 = $result["address2"];
    }
}
?>

	

<form action="<?=$esurl?>restform02#form" method="post" onSubmit="return signup(this)">
<div class="block">

	

<h4>予約希望日</h4>

<dl>
	<dt>ご予約日<em>[必須]</em></dt>
<dd>※営業開始時間は「午前8時30分」からとなります<br>

<input type="date" name="datenum" id="datenum" value="" required style="width: 150px;">
<select name="timenum" id="timenum">
<option value="">選択</option>
<?php
for($a=9;$a<=16;$a++){
?>
<option value="<?=$a?>"><?=$a?></option>
<?php
}
?>
</select>時 頃</dd>
</dl>



<dl>
<dt>ご利用人数<em>[必須]</em></dt>
<dd><select name="ninzu" id="ninzu">
<option value="">選択</option>
<?php
for($b=1;$b<=40;$b++){
?>
<option value="<?=$b?>"><?=$b?></option>
<?php
}
?>
</select> 人</dd>
</dl>




<dl>
	<dt>法人・個人&nbsp;<em>[必須]</em></dt>
<dd><input type="radio" name="person" id="person1" value="法人" class="radiochk"<?=checked($person,0)?>><label for="person1">法人</label>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="person" id="person2" value="個人" class="radiochk"<?=checked($person,1)?>><label for="person2">個人</label></dd>
</dl>

	<dl class="houjin">
	<dt>法人名</dt>
<dd><input type="text" name="company" id="company" value="<?=$company?>"></dd>
</dl>

<dl class="houjin">
	<dt>部署</dt>
<dd><input type="text" name="busyo" id="busyo" value="<?=$busyo?>"></dd>
</dl>
<dl>
	<dt>お名前&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="name" id="name" value="<?=$username?>"></dd>
</dl>

<dl>
	<dt>ふりがな&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="furigana" id="furigana" value="<?=$furigana?>"></dd>
</dl>

<dl>
	<dt>メールアドレス&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="email" id="email" value="<?=$email?>"></dd>
</dl>

<dl>
	<dt>メールアドレス（確認）&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="kemail" id="kemail" value="<?=$email?>"></dd>
</dl>

<dl>
	<dt>電話番号&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="tel" id="tel" value="<?=$tel?>"></dd>
</dl>

<dl>
	<dt>郵便番号&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="zip1" id="zip1" value="<?=$zip1?>" class="zip"> - <input type="text" name="zip2" id="zip2" value="<?=$zip2?>" class="zip" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','state','address','');"></dd>
</dl>

<dl>
	<dt>都道府県&nbsp;<em>[必須]</em></dt>
<dd><select name="state" id="state">
<option value="">選択</option>
<?php
				$sql="SELECT * From t_state";
                $state = $dbh->prepare($sql);
                $state->execute();
				$result = $state->fetchAll(PDO::FETCH_ASSOC);
				foreach($result as $row){
				?>
                <option value="<?=$row["state"]?>"<?php if($statename==$row["state"]){echo " selected";}?>><?=$row["state"]?></option>
                <?php
				}
				?>
</select></dd>
</dl>

<dl>
	<dt>市区町村、町名&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="address" id="address" value="<?=$address?>"></dd>
</dl>

<dl>
	<dt>以下番地、建物名、部屋番号など&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="address2" id="address2" value="<?=$address2?>"></dd>
</dl>

<dl>
	<dt>ご質問・ご要望など</dt>
<dd><textarea name="comment" id="comment" cols="20" rows="5"></textarea></dd>
</dl>


</div>

<div class="block">
<p>上記内容でよろしければ、確認画面へお進みください。</p>
<p class="centering"><input type="submit" name="submit" value="内容確認"></p>
</div>
<?php
  function setToken(){
      $TOKEN_LENGTH = 32;
      $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
      
      $token = bin2hex($bytes);
      $_SESSION['crsf_token'] = $token;
      return $token;
  }
  ?>
    <input type="hidden" name="token" value="<?= setToken()?>">


</form>

<div class="block">
<h3>バイクのタイヤ空気圧の点検ほか工具類の無料貸し出し</h3>

<p>当農園の責任者である岡本も、60歳を過ぎてもまだ現役のバイク乗りでありますが、千葉県の外房エリアではバイクによるツーリンググループも多くいて、そんな事情からこの度「無償休憩所」としてトイレを開放することになりました。</p>

<p>バッテリーの補充電や、タイヤ空気圧の補填に使われる電気は、すべてソーラー蓄電システムで賄っており、また農園では農機、農機具、建築機械などのレンタルを業務としていますので、工具類も多く充実しています。（インチのレンチスパナもあります）</p>

<p>特に、夏季の暑い時期には、冷たい井戸水をふんだんに使い、顔を洗ったり身体を拭いたりする方も増えています。</p>

<p>ぜひ一度、いつかの農業収穫体験・野菜狩りサービスの「下見のつもり」で、ツーリングやドライブの際は、東浪見岡本農園（【太陽と野菜の直売所】）にお立寄りください。</p>

<p>「無料休憩所」にかかわるお問合せは、電話：<?=$mobile?>（農園管理人直通）までお気軽にご連絡ください。フォームからも受け付けています。</p>
</div>

<?php include("include/inquireBtn.php")?>


<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
