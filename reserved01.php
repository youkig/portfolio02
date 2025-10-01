<?php $siteid=77?>
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

<meta name="keywords" content="<?=$n_keyword?>">

<meta name="description" content="<?=$n_description?>">

<title><?=$n_title?></title>

<link rel="stylesheet" href="css/base.css?<?=str_replace(":", "", date("H:i:s")); ?>" type="text/css">
<?php include("include/js.php")?>
<script src="js/reserved_chk.js"></script>
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


<div id="box">

<div id="header">
<h1><?=$n_h1?></h1>


<?php include("include/header.php")?>

<div id="main" class="container">
	<?php include("include/leftpane.php")?>
	<div id="cnt" class="company cart">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 注文フォーム</p>
	<div class="block">
	<h2>注文フォーム</h2>

<p>こちらのフォームからご注文を承ります。必要事項を入力の上、送信してください。</p>

</div>

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


<form action="<?=$esurl?>reserved02" method="post" onSubmit="return signup(this)">
<div class="block">
<h3>注文フォーム</h3>


<!--スタート買い物明細-->
					
						<table summary="購入商品">
									<thead>
										<tr>
											<th>商品名</th>
											<th>商品単価</th>
											<th>数量</th>
											<th>金額</th>
											
										</tr>
									</thead>
					
					<tbody>
					<?php
					$cnt=0;
					$SUM = 0;
					$OPSEL_COUNT = 3;
					$tyumon=0;
					
					
					foreach($_COOKIE as $key=>$val){

						if(strpos($key,"okamotofarm")!==false){
							
						$tyumon=1;
						$cnt++;
					
							$sql="SELECT * From t_master Where id=:id";
							$p = $dbh->prepare($sql);
							$p->bindValue(":id",str_replace("okamotofarm_","",$key),PDO::PARAM_INT);
							$p->execute();
							$rss = $p->fetch(PDO::FETCH_ASSOC);
							if (!empty($rss)){
					?>
							<tr>
					
							<td class="one"><?=$rss["item"] ?></td>
							<td class="righting">￥<?= number_format($rss["price"]) ?></td>
							<td class="centering"><?=$val?><?=$rss["unit"]?></td>
							<td class="righting">￥<?= number_format($rss["price"]*$val)?></td>

							</tr>
					<?php
								$SUM += cnum($rss["price"])*$val;
							}
						}
					}
					
					$zei = 0;
					
					?>
					
					</tbody>

<tfoot>
					
						<tr>
							<td colspan="3" class="one">合計金額</td>
								   <td class="righting">￥<?= number_format($SUM)?></td>
								
						</tr>
					</tfoot>
					</table>
	



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
	<dt>電話番号</dt>
<dd><input type="text" name="tel" id="tel" value="<?=$tel?>"></dd>
</dl>

<dl>
	<dt>郵便番号&nbsp;<em>[必須]</em></dt>
<dd><input type="text" name="zip1" id="zip1" value="<?=$zip1?>" class="zip"> - <input type="text" name="zip2" id="zip2" value="<?=$zip2?>" class="zip"onKeyUp="AjaxZip3.zip2addr('zip1','zip2','state','address','');"></dd>
</dl>

<dl>
	<dt>都道府県</dt>
<dd><select name="state" id="state">
<option value=""></option>
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
	<dt>市区町村名</dt>
<dd><input type="text" name="address" id="address" value="<?=$address?>"></dd>
</dl>

<dl>
	<dt>以下番地、建物名など</dt>
<dd><input type="text" name="address2" id="address2" value="<?=$address2?>"></dd>
</dl>

<dl>
	<dt>ご来店予定日&nbsp;<em>[必須]</em></dt>
<dd>
				<select name="month" id="month">
<option value=""></option>
				<?php
				for($a=1;$a<=12;$a++){
				?>
<option value="<?=$a?>"><?=$a?></option>
<?php
				}
				?>
</select>月

<select name="day" id="day">
<option value=""></option>
				<?php
				for($b=1;$b<=31;$b++){
				?>
<option value="<?=$b?>"><?=$b?></option>
<?php
				}
				?>
</select>日
</dd>
</dl>


<dl>
	<dt>ご質問・ご要望など</dt>
<dd>
				<textarea name="comment" id="comment" cols="60" rows="5" style="width:100%;"></textarea>
</dd>
</dl>


</div>

<div class="block">
<p>上記内容でよろしければ、確認画面へお進みください。</p>
<p class="centering"><input type="submit" name="submit" value="確認"></p>
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
