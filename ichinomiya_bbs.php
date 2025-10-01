<?php $siteid=43?>
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
<link rel="canonical" href="<?=$esurl?>ichinomiya_bbs.php">
<meta name="keywords" content="<?=$n_keyword?>">

<meta name="description" content="<?=$n_description?>">

<title><?=$n_title?></title>

<link rel="stylesheet" href="css/base.css?<?=str_replace(":", "", date("H:i:s")); ?>" type="text/css">
<?php include("include/js.php")?>
<script src="js/bbs_chk.js"></script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>
</head>

<body>
<?php
if(!empty($n_h5)){
?>
<h5 id="autochangepg"><?=$n_h5?></h5>
<?php
}
?>
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
<div id="box">

<div id="header">
<h1><?=$n_h1?></h1>


<?php include("include/header.php")?>


<div id="main" class="container">
	<?php include("include/leftpane.php")?>
	<div id="cnt" class="fashion ichinomiya">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 千葉県一宮町へ移住をお考えの方々へ | 一宮町町政への苦情、ご意見投稿ページ</p>
	<div class="block">
	<h2>千葉県一宮町へ移住をお考えの方々へ</h2>

<h3><img src="img/ichinomiya/h3_02.png" alt="一宮町町政への苦情、ご意見投稿ページ" width="780" height="205"></h3>

<p>当ページでは、千葉県長生郡一宮町へ移住、また別荘地として検討されていらっしゃる方々への情報発信を行っています。</p>


</div>

<div class="block">

    <p>仮に、一宮町役場へ直接意見や苦情を具申したとしても、その内容は公開されることもなく、同じ義憤や不正行為があったとしても、同じ町民に伝わることもなく、「自分も同じ目に遭って苦労した」というような情報の共有はあり得ません。</p>

    <p>基本的に、投稿いただいた内容をそのまま掲載する（誤字脱字はリライトしますが）つもりではおりますが、一宮町役場の職員の実名や、投稿者ご本人の名前は、ホームページ上ではイニシャル英語表記といたします。</p>
    
    <p>また、中小誹謗が目的であったり、自分自身の体験ではない「伝聞投稿」であったりする場合は、掲載をお断りすることがあります。</p>
    
    <p>また、投稿内容について、農園管理人（岡本）から電話をかけることもありますので、この点はご承知おきください。</p>
    
    <p>※電話だけの苦情、ご意見は、お受けできません。</p>
    
    <p>町政を良くすること、正確な情報を提供して「一宮町への移住者を増やすこと」が目的になりますので、苦情やご意見のほか、「こんな対応素敵だった」というようなポジティブな投稿でも、もちろん大歓迎です。</p>
    
    <p>さて、投稿を開始してください！</p>
    
    <p class="centering"><a href="#result" class="underline">投稿された一宮町町政への苦情、ご意見一覧へ</a></p>
</div>


<form action="<?=$esurl?>ichinomiya_bbs02" method="post" onSubmit="return signup(this)">
<div class="block">
    
        <dl>
            <dt>お名前&nbsp;<em>[必須]</em></dt>
            <dd><input type="text" name="name" id="name" value="<?=$username?>" placeholder="例）山田　太郎"></dd>
        </dl>
        <dl>
            <dt>ペンネーム&nbsp;[任意]</dt>
            <dd><input type="text" name="penname" id="penname" value="" placeholder="例）ペンネーム"></dd>
        </dl>
        <dl>
            <dt>郵便番号&nbsp;<em>[必須]</em></dt>
            <dd><input type="text" name="zip1" id="zip1" value="<?=$zip1?>" class="zip"> - <input type="text" name="zip2" id="zip2" value="<?=$zip2?>" size="5" class="zip" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','state','address','');"></dd>
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
                </select>
            </dd>
        </dl>
        <dl>
	        <dt>市区町村名&nbsp;<em>[必須]</em></dt>
            <dd><input type="text" name="address" id="address" value="<?=$address?>" placeholder="例）長生郡一宮町東浪見"></dd>
        </dl>

        <dl>
            <dt>以下番地、建物名など&nbsp;<em>[必須]</em></dt>
            <dd><input type="text" name="address2" id="address2" value="<?=$address2?>" placeholder="例）4721番"></dd>
        </dl>
        
        <dl>
        <dt>電話番号&nbsp;<em>[必須]</em></dt>
            <dd><input type="text" name="tel" id="tel" value="<?=$tel?>" placeholder="例）0475-40-0831"></dd>
        </dl>
    
        <dl>
            <dt>メールアドレス&nbsp;<em>[必須]</em></dt>
            <dd><input type="text" name="email" id="email" value="<?=$email?>" placeholder="例）torami@okamoto-farm.co.jp"></dd>
        </dl>

        <dl>
            <dt>メールアドレス（確認）&nbsp;<em>[必須]</em></dt>
            <dd><input type="text" name="kemail" id="kemail" value="<?=$email?>" placeholder="例）torami@okamoto-farm.co.jp"></dd>
        </dl>
        
        <dl>
            <dt>対象の組織・課&nbsp;<em>[必須]</em></dt>
            <dd><select name="category" id="category">
            <option value=""></option>
            <option value="町長">町長</option>
            <option value="総務課">総務課</option>
            <option value="企画広報課">企画広報課</option>
            <option value="税務課">税務課</option>
            <option value="住民課">住民課</option>
            <option value="福祉健康課">福祉健康課</option>
            <option value="子育て支援課">子育て支援課</option>
            <option value="都市環境課">都市環境課</option>
            <option value="産業観光課">産業観光課</option>
            <option value="会計課">会計課</option>
            <option value="教育課">教育課</option>
            <option value="議会事務局">議会事務局</option>
            <option value="その他">その他</option>
            </select> &nbsp;&nbsp;<a href="https://www.town.ichinomiya.chiba.jp/info/kakuka/2.html" target="_blank" title="別サイトが開きます" class="underline">一宮町役場組織一覧</a></dd>
        </dl>
        <dl>
            <dt>投稿内容&nbsp;<em>[必須]</em></dt>
            <dd><textarea name="comment" id="comment" cols="40" rows="10"></textarea></dd>
        </dl>

        
</div>
    
    <div class="block">
        <p class="centering">上記の内容でよろしければ、「確認」ボタンをクリックしてください。</p>
        <p class="centering"><input type="submit" value="　確　認　"></p>
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
 

 <div class="block" style="margin-top:40px;" id="result">
 <h4 class="heading04">投稿された一宮町町政への苦情、ご意見</h4>
 
<?php
 $sql="SELECT * From t_bbs Where disp=1 and shinsa=1 order by indate desc";
 $b = $dbh->prepare($sql);
 $b -> execute();
$result = $b->fetchAll(PDO::FETCH_ASSOC);
if(!empty($result)){
foreach($result as $rst){
 if ($rst["penname"]!==""){
 $penname = $rst["penname"];
 }else{
 $penname = "匿名";
 }
 $category = "";
 if ($rst["category"]!==""){
 $category = "対象の組織・課：" . $rst["category"];
 }
 ?>
     <dl class="posts" id="result<?=$rst["id"]?>">
         <dt>&nbsp;ペンネーム：<?=$penname?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$category?>&nbsp;&nbsp;&nbsp;&nbsp;投稿日：<?=$rst["indate"]?></dt>
         <dd><p><?=nl2br($rst["comment"])?></p>
         <?php
         if ($rst["memo"]!==""){
         ?>
         <p class="comment"><img src="img/ichinomiya/1115_sy_m.png"><span class="bold" class="commenticon">一言コメント:</span><br>
         <?=nl2br($rst["memo"])?>
         </p>
         
         <?php
         }
         ?>
         </dd>
     </dl>
<?php
        }
    }else{
?>
    <p class="centering">今現在、投稿はございません。</p>
<?php
}
?>     
 </div>


<p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
<!-- id cnt end --></div>

<?php include("include/rightpane.php")?>

<!-- id main end --></div>

<?php include("include/footer.php")?>


<!-- id box end --></div>
</body>
</html>
