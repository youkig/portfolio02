<?php $siteid=49?>
<?php include("include/autometa.php");?>
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<?php include("config.php");?>

<head>

<meta name="robots" content="all">
<meta property="og:title" content="太陽と野菜の直売所【東浪見岡本農園】">
<meta property="og:type" content="website">
<meta property="og:url" content="index.php">
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="keywords" content="<?=$n_keyword?>">

<meta name="description" content="<?=$n_description?>">

<title><?=$n_title?></title>


<link rel="stylesheet" href="css/base.css?<?=str_replace(":", "", date("H:i:s")); ?>" type="text/css">
<?php include("include/js.php")?>
<script src="js/inq_chk.js"></script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>

<script>
$(function () {
$("#petok").click(function(){
$("#petnaiyo").fadeToggle();
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



	<div id="cnt2">

<h2>「疎開先ネットワーク」提供者への問合せ</h2>

<form action="<?=$esurl?>login_chk" method="post">

<?php
if (empty($_SESSION["setid"])){
?>
<div class="block">

<h3>会員ログインフォーム</h3>
	<p>既に会員登録済みの場合は、ログインしてください。</p>

<p><?=$errmes?></p>


	<dl>
	<dt>ユーザーID</dt>
<dd><input type="text" name="loginid" id="loginid" value=""></dd>
</dl>

<dl>
	<dt>パスワード</dt>
<dd><input type="password" name="password" id="password" value=""></dd>
</dl>



</div>

<div class="block">

<p class="centering"><input type="submit" name="submit" value="ログイン"></p>
</div>

<?php
}
?>

<input type="hidden" name="id" value="<?=cnum($_GET["id"])?>">
</form>


<?php
if(!empty($_SESSION["logid"]) && !empty($_SESSION["pass"])){
$sql="select * From t_user Where email=:email and password=:password and dele=0 and taikai=0";
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
	$stateid = $result["state"];
    
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

<p>提供者様へのお問合せが出来ます。以下必要項目をご入力ください。</p>
<?php
$sql="SELECT t_user.name,t_user.company,t_network.* From t_user inner join t_network on t_user.id=t_network.uid Where t_network.id=:id and t_network.shinsa=1 and t_network.cancel=0";
$n = $dbh->prepare($sql);
$n -> bindValue(":id",$_GET["id"],PDO::PARAM_INT);
$n -> execute();
$rs = $n->fetch(PDO::FETCH_ASSOC);

if (!empty($rs)){
?>
<form action="<?=$esurl?>inq_02" method="post" onSubmit="return signup(this)">
<input type="hidden" name="id" value="<?=$rs["id"]?>">
<div class="block">
<dl>
<dt>お名前<em>（必須）</em></dt>
<dd><input type="text" name="name" id="name" value="<?=$username?>"></dd>
</dl>

<dl>
<dt>ふりがな<em>（必須）</em></dt>
<dd><input type="text" name="furigana" id="furigana" value="<?=$furigana?>"></dd>
</dl>

<dl>
<dt>性別<em>（必須）</em></dt>
<dd><input type="radio" name="sex" id="sex1" value="男性"><label for="sex1">男性</label>　<input type="radio" name="sex" id="sex2" value="女性"><label for="sex2">女性</label></dd>
</dl>

<dl>
<dt>郵便番号<em>（必須）</em></dt>
<dd>

〒<input type="text" name="zip1" id="zip1" value="<?=$zip1?>" class="zip" size="4"> - <input type="text" name="zip2" id="zip2" value="<?=$zip2?>" class="zip"  size="4" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','state','address','');">
</dd>
</dl>

<dl>
<dt>都道府県<em>（必須）</em></dt>
<dd><?php
$sql = "SELECT * From t_state";
$s = $dbh->prepare($sql);
$s -> execute();
$result = $s->fetchAll(PDO::FETCH_ASSOC);
?>
<select name="state" id="state">
<option value="">選　択</option>
<?php
foreach($result as $rss){
?>
<option value="<?=$rss["id"]?>"<?=selected($rss["id"],cnum($stateid))?>><?=$rss["state"]?></option>
<?php
}
?>
</select>
</dd>
</dl>
<dl>
<dt>市区町村名<em>（必須）</em></dt>
<dd>
<input type="text" name="address" id="address" value="<?=$address?>"></dd>

</dl>
<dl>
<dt>以下住所<em>（必須）</em></dt>
<dd><input type="text" name="address2" id="address2" value="<?=$address2?>"></dd>
</dl>

<dl>
<dt>連絡先電話番号<em>（必須）</em></dt>
<dd>※ハイフン（-）付きで入力してください。<br><input type="text" name="tel" id="tel" value="<?=$tel?>"></dd>
</dl>

<dl>
<dt>メールアドレス<em>（必須）</em></dt>
<dd><input type="text" name="email" id="email" value="<?=$_SESSION["logid"]?>"></dd>
</dl>
<?php
if (empty($_SESSION["logid"])){
?>
<dl>
<dt>メールアドレス（確認）<em>（必須）</em></dt>
<dd>もう一度メールアドレスをご入力ください。<br><input type="text" name="kemail" id="kemail" value=""></dd>
</dl>
<?php
}
?>
<dl>
<dt>希望利用人数<em>（必須）</em></dt>
<dd>合計：<input type="number" name="ninzu" id="ninzu" value="" size="4" min="1">人<br>
大人：<input type="number" name="adult" id="adult" value="" size="4" min="1">人<br>子供：<input type="number" name="child" id="child" value="" size="4" min="1">人</dd>
</dl>

<?php
if ($rs["petok"]=="可"){
?>
<dl>
<dt>ペットの受入れ</dt>
<dd><input type="checkbox" name="petok" id="petok" value="希望する" onclick="petok();"><label for="petok">希望する</label>

<textarea name="petnaiyo" id="petnaiyo" style="width: 95%;height: 3em;display: none;" placeholder="ペットの種類、数、大きさなどご記載ください。"></textarea>
</dd>
</dl>
<?php
}
?>

	<dl>
<dt>宿泊施設の提供</dt>
<dd><input type="checkbox" name="hotel" id="hotel" value="希望する"><label for="hotel">希望する</label>

</dd>
</dl>

<dl>
<dt>食事の提供</dt>
<dd><input type="checkbox" name="food" id="food" value="希望する"><label for="food">希望する</label>

</dd>
</dl>
<dl>
<dt>ご質問・ご希望など</dt>
<dd><textarea name="comment" id="comment" style="width:98%; height: 4em;"></textarea></dd>
</dl>

	</div>
<p>上記の内容でよろしければ、確認ボタンを押してください。</p>
<p class="centering"><input type="submit" name="submit" value=" 確 認 "> 　<input type="button" value=" 戻 る " onclick="history.back();"></p>

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
</from>
<?php

}
?>

<!-- id cnt2 end --></div>



</body>
</html>
