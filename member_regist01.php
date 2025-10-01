<?php $siteid=57?>
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
<link rel="canonical" href="<?=$esurl?>member_regist01.php">
<meta name="keywords" content="<?=$n_keyword?>">

<meta name="description" content="<?=$n_description?>">

<title><?=$n_title?></title>

<link rel="stylesheet" href="css/base.css?<?=str_replace(":", "", date("H:i:s")); ?>" type="text/css">
<?php include("include/js.php")?>

<script src="js/member_chk.js"></script>
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
	<div id="cnt" class="company">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 【太陽と野菜の直売所】（東浪見岡本農園）の会員募集中です！（事前登録）</p>
	<div class="block">
	<h2>【太陽と野菜の直売所】（東浪見岡本農園）の会員募集中です！（事前登録）</h2>

<p>【太陽と野菜の直売所】（東浪見岡本農園）では、令和4年6月から事前登録制として会員を募集することになりました！</p>

<p>当農園で用意している各種サービスのうち、「<a href="<?=$esurl?>rental_farm" class="underline">レンタル農園契約</a>」「<a href="<?=$esurl?>agency_service" class="underline">農機：農機具レンタル契約</a>」「<a href="<?=$esurl?>rental" class="underline">レンタル厨房・レンタルキッチン契約</a>」「<a href="<?=$esurl?>ensure_servic" class="underline">野菜栽培のための農地利用権利の確保サービス契約</a>」、各サービス契約には会員登録が必須となります。</p>

<p>※事前の身元確認ということになります。</p>

<p>もちろん、上記サービスを契約いただかない方でも、今後オープンする予定のバーベキュー飲食の予約時、レンタル厨房サービスの申し込み時には、事前会員登録があれば、お名前ほか住所の記入が省略できますので、手間もかからず便利なはずです。</p>

<p>決して、当店からのメール以外に、お客様情報を転用したり、ほかに情報提供をしたりすることはありませんので、安心して登録くださいますようお願いいたします。</p>

<p>よろしくお願いいたします。</p>

<p class="righting">【太陽と野菜の直売所】（東浪見岡本農園管理人：岡本　洋）</p>

</div>



<form action="<?=$esurl?>member_regist02" method="post" onSubmit="return signup(this)">
<div class="block">
<h3>会員登録フォーム</h3>
	
<dl>
	<dt>ご利用予定のサービス&nbsp;<em>[必須]</em></dt>
<dd>
※複数選択可<br>
<input type="checkbox" name="koumoku[]" id="koumoku1" value="野菜狩り・野菜収穫体験サービス" class="radiochk"><label for="koumoku1">野菜狩り・野菜収穫体験サービス</label><br>
<input type="checkbox" name="koumoku[]" id="koumoku2" value="レンタル農園（貸し農園）" class="radiochk"><label for="koumoku2">レンタル農園（貸し農園）</label><br>
<input type="checkbox" name="koumoku[]" id="koumoku3" value="農地耕運代行・農地復活代行サービス" class="radiochk"><label for="koumoku3">農地耕運代行・農地復活代行サービス</label><br>
<input type="checkbox" name="koumoku[]" id="koumoku4" value="農地利用権利の確保サービス" class="radiochk"><label for="koumoku4">農地利用権利の確保サービス</label><br>
<input type="checkbox" name="koumoku[]" id="koumoku5" value="レンタル厨房・レンタルキッチン" class="radiochk"><label for="koumoku5">レンタル厨房・レンタルキッチン</label><br>
<input type="checkbox" name="koumoku[]" id="koumoku6" value="農機・農機具・耕運機のレンタルサービス" class="radiochk"><label for="koumoku6">農機・農機具・耕運機のレンタルサービス</label><br>
<input type="checkbox" name="koumoku[]" id="koumoku9" value="有事の際の「疎開先ネットワーク」募集" class="radiochk"><label for="koumoku9">有事の際の「疎開先ネットワーク」募集</label><br>
<input type="checkbox" name="koumoku[]" id="koumoku7" value="商品のご予約" class="radiochk"><label for="koumoku7">商品のご予約</label><br>

<input type="checkbox" name="koumoku[]" id="koumoku8" value="事前登録のみ" class="radiochk"><label for="koumoku8">事前登録のみ</label>

</dd>
</dl>
<input type="hidden" name="recruitment" value="<?=$_GET["r"]?>">

<dl>
	<dt>法人・個人&nbsp;<em>[必須]</em></dt>
<dd><input type="radio" name="person" id="person1" value="法人" class="radiochk"><label for="person1">法人</label>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="person" id="person2" value="個人" class="radiochk"><label for="person2">個人</label></dd>
</dl>

	<dl class="houjin">
	<dt>法人名</dt>
<dd>※上記項目で「法人」を選択した場合は、必須です<br><input type="text" name="company" id="company" value=""></dd>
</dl>

<dl class="houjin">
	<dt>部署</dt>
<dd><input type="text" name="busyo" id="busyo" value=""></dd>
</dl>
<dl>
	<dt>お名前&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="name" id="name" value=""></dd>
</dl>

<dl>
	<dt>ふりがな&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="furigana" id="furigana" value=""></dd>
</dl>

<dl>
	<dt>メールアドレス&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="email" id="email" value=""></dd>
</dl>

<dl>
	<dt>メールアドレス（確認）&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="kemail" id="kemail" value=""></dd>
</dl>

<dl>
	<dt>パスワード&nbsp;<em>[必須]</em></dt>
<dd>※8文字以上、16文字以下の半角英数字<br><input type="password" name="password" id="password" value=""></dd>
</dl>

<dl>
	<dt>電話番号&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="tel" id="tel" value=""></dd>
</dl>

<dl>
	<dt>郵便番号&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="zip1" id="zip1" value="" class="zip"> - <input type="text" name="zip2" id="zip2" value="" class="zip" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','state','address','');"></dd>
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
                <option value="<?=$row["id"]?>"><?=$row["state"]?></option>
                <?php
				}
				?>
</select></dd>
</dl>

<dl>
	<dt>市区町村名&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="address" id="address" value=""></dd>
</dl>

<dl>
	<dt>以下番地、建物名など&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="address2" id="address2" value=""></dd>
</dl>

<dl>
	<dt>ご質問・ご要望など&nbsp;[任意]</dt>
<dd><textarea name="comment2" id="comment2" cols="20" rows="5"></textarea></dd>
</dl>


</div>

<div class="block">
<p><input type="checkbox" name="mailmaga" id="mailmaga" value="1"><label for="mailmaga">今後配信予定のメールマガジンを受信希望する場合は、チェックを入れてください。</label></p>
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

<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
