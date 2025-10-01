<?php $siteid=62?>
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
<link rel="canonical" href="<?=$esurl?>network_recruitment.php">
<meta name="keywords" content="<?=$n_keyword?>">

<meta name="description" content="<?=$n_description?>">

<title><?=$n_title?></title>

<link rel="stylesheet" href="css/base.css?<?=str_replace(":", "", date("H:i:s")); ?>" type="text/css">
<?php include("include/js.php")?>
<script>
$(function () {
	
	$("#power1").click(function(){
		$(".solar").fadeIn();
	});

$("#power2").click(function(){
		$(".solar").fadeOut();
	});
	

$("#well1").click(function(){
		$(".well").fadeIn();
	});

$("#well2").click(function(){
		$(".well").fadeOut();
	});

$("#petok1").click(function(){
		$(".petok").fadeIn();
	});

$("#petok2").click(function(){
		$(".petok").fadeOut();
	});

$("#price2").click(function(){
		$(".price").fadeIn();
	});

$("#price1").click(function(){
		$(".price").fadeOut();
	});

$("#meal2").click(function(){
		$(".meal").fadeIn();
	});

$("#meal1").click(function(){
		$(".meal").fadeOut();
	});
	
	

});
</script>
<script src="js/recruitment_chk.js"></script>


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
	<div id="cnt" class="recruitment farm company">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 有事の際の「疎開先ネットワーク」募集のお願い</p>
	<div class="block">
	<h2><img src="img/recruitment/h2.jpg" alt="有事の際の「疎開先ネットワーク」募集のお願い" width="780" height="205"></h2>

</div>

<div class="block">
<p>当ページでは、戦争勃発によるミサイル着弾、大地震災害、洪水災害等で住まいを失った方々に対し、ご自宅の一部のお部屋の貸与、お風呂の利用など、被災者のみなさまに疎開先（緊急避難先）として、提供していただける方々の募集を行っています。</p>

<p>あわせて、農家の方々や田畑をお持ちの方など（耕作放棄地や有休農地も可とします）、有事の際の食料確保を目的とする農地の有償、無償提供を含めて、井戸水（飲料水としての）を使わせていただける方々に対し、【太陽と野菜の直売所】（東浪見岡本農園）が中心的な立場を担い、ホームページ上で公開させていただきます。</p>

<p>※「非公開」情報としても、農園のデータベースで管理させていただきます。</p>

<p>基本的に「有事の際の疎開先」となりますので、受入れ先のみなさまが「それは有事に該当しない」と判断すれば、きっぱりと受入れを断っていただいて構いません。</p>

<p>まずは会員登録していただき、各フォーム項目を埋めていただき、当農園の掲載可否判断にゆだねてください。</p>

<p>内容に過不足があれば、農園管理人から連絡を差し上げます。</p>

<p>よろしくお願い申し上げます。</p>
</div>

<?php
if (empty($_SESSION["setid"])){
?>
<div class="block">
<p class="centering"><a href="<?=$esurl?>member_regist01" class="btn">会員登録</a></p>
</div>

<form action="<?=$esurl?>login_chk" method="post">
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



</form>

<?php
}else{
$sql="SELECT * From t_user Where id=:setid AND dele=0 AND taikai=0";
$user = $dbh->prepare($sql);
$user -> bindValue(":setid",$_SESSION["setid"],PDO::PARAM_INT);
$user -> execute();
$rs = $user->fetch(PDO::FETCH_ASSOC);

$sql ="SELECT * From t_network Where uid=:setid";
$n = $dbh->prepare($sql);
$n -> bindValue(":setid",$_SESSION["setid"],PDO::PARAM_INT);
$n -> execute();
$rsu = $n->fetch(PDO::FETCH_ASSOC);

if (!empty($rsn)){
?>
<p class="red bold centering">既に登録されています。</p>
<?php
}else{
?>
<form action="<?=$esurl?>network_recruitment02" method="post" onSubmit="return signup(this)">

<input type="hidden" name="userid" value="<?=$_SESSION["setid"]?>">
<div class="block">
<h3>応募要項</h3>
<dl>
<dt>お名前</dt>
<dd>基本的に非公開、公開も可<br>
<?php
if (!empty($_SESSION["username"])){
echo $_SESSION["username"];
}
?><br>
<input type="checkbox" name="name_open" id="name_open" value="1" class="radiochk"><label for="name_open">お名前の公開が「可」であればチェックを入れてください。</label>

</dd>
</dl>
<dl>
<dt>公開名</dt>
<dd>ペンネームも可としますので、こちらが優先して公開されます。<br>
<input type="text" name="penname" id="penname" value="" size="10"></dd>
</dl>
<dl>
<dt>法人名</dt>
<dd>基本的に非公開、公開も可<br><?php
if (!empty($_SESSION["company"])){
echo $_SESSION["company"];
}
?><br>
<input type="checkbox" name="company_open" id="company_open" value="1" class="radiochk"><label for="company_open">法人名の公開が「可」であればチェックを入れてください。</label></dd>
</dl>
<dl>
<dt>郵便番号<em>（必須）</em></dt>
<dd><?php
if (!empty($rs["zip"])){
$zip=explode("-",$rs["zip"]);
$zip1=$zip[0];
$zip2=$zip[1];
}
?>
〒<input type="text" name="zip1" id="zip1" value="<?=$zip1?>" class="zip"> - <input type="text" name="zip2" id="zip2" value="<?=$zip2?>" class="zip" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','state','address','');">

</dl>
<dl>
<dt>都道府県<em>（必須）</em></dt>
<dd><?php
				$sql="SELECT * From t_state";
                $state = $dbh->prepare($sql);
                $state->execute();
				$result = $state->fetchAll(PDO::FETCH_ASSOC);
				?>	
				<select name="state" id="state">
				<option value="">選　択</option>
<?php
foreach($result as $rss){
?>
<option value="<?=$rss["id"]?>"<?=selected($rss["id"],$rs["state"])?>><?=$rss["state"]?></option>
<?php
}
?>
</select>
</dd>
</dl>
<dl>
<dt>市区町村名<em>（必須）</em></dt>
<dd>
<input type="text" name="address" id="address" value="<?=$rs["address"]?>">

</dl>
<dl>
<dt>以下住所<em>（必須）</em></dt>
<dd><input type="text" name="address2" id="address2" value="<?=$rs["address2"]?>"></dd>
</dl>

<dl>
<dt>対象住所<em>（必須）</em></dt>
<dd>〇〇県〇〇郡市まで記載。全公開も可<br>
<input type="text" name="address3" id="address3" value=""></dd>
</dl>

<dl>
<dt>連絡先電話番号<em>（必須）</em></dt>
<dd>基本的に非公開。<br>※ハイフン（-）付きで入力してください。<br><input type="text" name="tel" id="tel" value="<?=$rs["tel"]?>"></dd>
</dl>

<dl>
<dt>メールアドレス<em>（必須）</em></dt>
<dd>基本的に非公開<br><input type="text" name="email" id="email" value="<?=$rs["email"]?>"></dd>
</dl>

<dl>
<dt>提供可能種別<em>（必須）</em></dt>
<dd>複数選択可<br><input type="checkbox" name="syubetsu[]" id="syubetsu1" value="居宅" class="radiochk"><label for="syubetsu1">居宅</label><br>
<input type="checkbox" name="syubetsu[]" id="syubetsu2" value="畑" class="radiochk"><label for="syubetsu2">畑</label><br>
<input type="checkbox" name="syubetsu[]" id="syubetsu3" value="田んぼ" class="radiochk"><label for="syubetsu3">田んぼ</label><br>
<input type="checkbox" name="syubetsu[]" id="syubetsu4" value="山林" class="radiochk"><label for="syubetsu4">山林</label><br>
<input type="checkbox" name="syubetsu[]" id="syubetsu5" value="雑種地" class="radiochk"><label for="syubetsu5">雑種地</label></dd>
</dl>

<dl>
<dt>広さ<em>（必須）</em></dt>
<dd><input type="text" name="breadth" id="breadth" value="" style="width:4em;">㎡<br>
部屋数 <input type="text" name="heya" id="heya" value="" style="width:4em;">部屋<br>
<input type="checkbox" name="ikken" id="ikken" value="1" class="radiochk"><label for="ikken">一軒家</label></dd>
</dl>

<dl>
<dt>受入れ人数<em>（必須）</em></dt>
<dd><input type="text" name="ninzu" id="ninzu" value="" style="width:4em;">人まで
</dd>
</dl>

<dl>
<dt>受入れ性別<em>（必須）</em></dt>
<dd><input type="radio" name="sex" id="sex1" value="男性のみ" class="radiochk"><label for="sex1">男性のみ</label><br>
<input type="radio" name="sex" id="sex2" value="女性のみ" class="radiochk"><label for="sex2">女性のみ</label><br>
<input type="radio" name="sex" id="sex3" value="いずれも可" class="radiochk"><label for="sex3">いずれも可</label>
</dd>
</dl>

<dl>
<dt>食料の有無<em>（必須）</em></dt>
<dd><input type="checkbox" name="food[]" id="food1" value="米" class="radiochk"><label for="food1">米</label><br>
<input type="checkbox" name="food[]" id="food2" value="食料・野菜" class="radiochk"><label for="food2">食料・野菜</label><br>
<input type="checkbox" name="food[]" id="food3" value="魚介類" class="radiochk"><label for="food3">魚介類</label><br>
<input type="checkbox" name="food[]" id="food4" value="肉類" class="radiochk"><label for="food4">肉類</label>
</dd>
</dl>

<dl>
<dt>自家発電システム設置の有無<em>（必須）</em></dt>
<dd><input type="radio" name="power" id="power1" value="あり" class="radiochk"><label for="power1">あり</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="power" id="power2" value="なし" class="radiochk"><label for="power2">なし</label><br>
<p class="solar" style="display: none;"><input type="radio" name="solar" id="solar1" value="太陽光発電（昼のみ）" class="radiochk"><label for="solar1">太陽光発電（昼のみ）</label><br>
<input type="radio" name="solar" id="solar2" value="太陽光蓄電（昼夜）" class="radiochk"><label for="solar2">太陽光蓄電（昼夜）</label></p>
</dd>
</dl>

<dl>
<dt>飲料水の有無<em>（必須）</em></dt>
<dd><input type="radio" name="well" id="well1" value="あり" class="radiochk"><label for="well1">あり</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="well" id="well2" value="なし" class="radiochk"><label for=well2">なし</label><br>
<p class="well" style="display: none;"><input type="radio" name="water" id="water1" value="井戸水あり（飲料可）" class="radiochk"><label for="water1">井戸水あり（飲料可）</label><br>
<input type="radio" name="water" id="water2" value="井戸水あり（飲料不可）" class="radiochk"><label for="water2">井戸水あり（飲料不可）</label></p>
</dd>
</dl>

<dl>
<dt>ペット同居の有無<em>（必須）</em></dt>
<dd><input type="radio" name="pet" id="pet1" value="あり" class="radiochk"><label for="pet1">あり</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="pet" id="pet2" value="なし" class="radiochk"><label for="pet2">なし</label>
</dd>
</dl>

<dl>
<dt>ペットの受入れ<em>（必須）</em></dt>
<dd><p><input type="radio" name="petok" id="petok1" value="可" class="radiochk"><label for="petok1">可</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="petok" id="petok2" value="不可" class="radiochk"><label for="petok2">不可</label></p>

<p class="petok" style="display:none;">・受入れ可の場合<br><input type="radio" name="petplace" id="petplace1" value="屋内" class="radiochk"><label for="petplace1">屋内</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="petplace" id="petplace2" value="屋外" class="radiochk"><label for="petplace2">屋外</label></p>
<p class="petok" style="display:none;">・ペットのサイズ<br><input type="radio" name="petsize" id="petsize1" value="小型のみ" class="radiochk"><label for="petsize1">小型のみ</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="petsize" id="petsize2" value="大型可" class="radiochk"><label for="petsize2">大型可</label></p>
</dd>
</dl>

<dl>
<dt>宿泊費の有償・無償<em>（必須）</em></dt>
<dd><p><input type="radio" name="price" id="price1" value="無償" class="radiochk"><label for="price1">無償</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="price" id="price2" value="有償" class="radiochk"><label for="price2">有償</label></p>

<p class="price" style="display:none;">・有償の場合<br>1泊 <input type="text" name="fee" id="fee" value="" style="width:4em;">円　～　ご相談</p>

</dd>
</dl>

<dl>
<dt>食事の提供<em>（必須）</em></dt>
<dd><p><input type="radio" name="meal" id="meal1" value="無償" class="radiochk"><label for="meal1">無償</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="meal" id="meal2" value="有償" class="radiochk"><label for="meal2">有償</label></p>

<p class="meal" style="display:none;">・有償の場合<br>1食 <input type="text" name="mealfee" id="mealfee" value="" style="width:4em;">円　～　ご相談</p>

</dd>
</dl>


</div>
<p>上記の内容でよろしければ、「内容確認」ボタンをクリックしてください。</p>
<p class="centering"><input type="submit" value="内 容 確 認"></p>

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

<?php
}

}
?>




<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
