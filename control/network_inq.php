<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<?php include("../config.php");?>

<?php
$userid2 = $_COOKIE["adminlogin"];
$password2 = $_COOKIE["adminpasswd"];
if(control_login($userid2,$password2)===false){
	header("location:login.php");
	exit;
}
?>
<head>
<meta name="robots" content="all">
<meta property="og:title" content="太陽と野菜の直売所【東浪見岡本農園】">
<meta property="og:type" content="website">
<meta property="og:url" content="index.php">
<meta property="og:locale" content="jp_JP">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="robots" content="none" />

<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include("include/js.php");?>
<script src="https://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3-https.js" charset="UTF-8"></script>




<?php

$id = cnum($_REQUEST["id"]);
if ($id !== 0){
	
        $sql ="select * From t_network_inq Where id=:id";
        $n = $dbh->prepare($sql);
        $n -> bindValue(":id",$id,PDO::PARAM_INT);
        $n -> execute();
        $rs = $n -> fetch(PDO::FETCH_ASSOC);
        if (!$rs){
        header("location:network_inqlist.php");
        }else{
        $uid=$rs["uid"];
        }

}


if ($_SERVER["REQUEST_METHOD"]=="POST"){
	$id = cnum($_REQUEST["id"]);

	if ($id !== 0){
		$sql = "UPDATE t_network_inq set name=:name,furigana=:furigana,sex=:sex,zip=:zip,state=:state,address=:address,address2=:address2,tel=:tel,";
        $sql .= "email=:email,personnum=:personnum,adult=:adult,child=:child,pet=:pet,stayok=:stayok,foodok=:foodok,comment=:comment Where id=:id";
        $n = $dbh->prepare($sql);
        $n -> bindValue(":name",renull($_POST["name"]),PDO::PARAM_STR);
        $n -> bindValue(":furigana",renull($_POST["furigana"]),PDO::PARAM_STR);
        $n -> bindValue(":sex",renull($_POST["sex"]),PDO::PARAM_STR);
        $n -> bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);
        $n -> bindValue(":sex",cnum($_POST["state"]),PDO::PARAM_INT);
        $n -> bindValue(":address",renull($_POST["address"]),PDO::PARAM_STR);
        $n -> bindValue(":address2",renull($_POST["address2"]),PDO::PARAM_STR);
        $n -> bindValue(":tel",renull($_POST["tel"]),PDO::PARAM_STR);
        $n -> bindValue(":email",renull($_POST["email"]),PDO::PARAM_STR);
        $n -> bindValue(":personnum",cnum($_POST["ninzu"]),PDO::PARAM_INT);
        $n -> bindValue(":adult",cnum($_POST["adult"]),PDO::PARAM_INT);
        $n -> bindValue(":child",cnum($_POST["child"]),PDO::PARAM_INT);
        $n -> bindValue(":pet",renull($_POST["petnaiyo"]),PDO::PARAM_STR);
        $n -> bindValue(":stayok",cnum($_POST["syukuhaku"]),PDO::PARAM_STR);
        $n -> bindValue(":foodok",cnum($_POST["syokuji"]),PDO::PARAM_STR);
        $n -> bindValue(":comment",cnum($_POST["comment"]),PDO::PARAM_STR);
        $n -> bindValue(":id",$id,PDO::PARAM_INT);
        $n -> execute();
	}

	
}


?>

<title>疎開先ネットワークお問合せ詳細【<?=$kanriName?>】</title>
</head>
<body>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
		<?php include("include/leftpane.php")?>
		<div id="cnt">
			<h2>疎開先ネットワークお問合せ詳細</h2>



<div class="block">


	
	<form action="network_inq.php" method="post">
    
    <input type="hidden" name="id" value="<?=$id?>" />
	   
      <h3>問合せ情報</h3>
      
        <table> 
        
         <tr>
        	<th>問合せ日</th>
            <td>
            <?=rers($rs,"indate","")?>
            </td>
        </tr>
      <tr>
          <th>お名前</th>
          <td><input type="text" name="name" id="name" value="<?=rers($rs,"name","")?>" /></td>
      </tr> 
      <tr>
          <th>ふりがな</th>
          <td><input type="text" name="furigana" id="furigana" value="<?=rers($rs,"furigana","")?>" /></td>
      </tr> 
		 
   
    <tr>
        <th>性別</th>
        <td><?=$rs["sex"]?></td>
    </tr>
    <tr>
        <th>郵便番号</th>
        <td><?php
			
			if (!empty(rers($rs,"zip",""))){
			$zip = explode("-",rers($rs,"zip",""));
			$zip1=$zip[0];
			$zip2=$zip[1];
			}
			?>
        〒<input type="text" name="zip1" id="zip1" value="<?=$zip1?>" class="zip" size="4" /> - <input type="text" name="zip2" id="zip2" value="<?=$zip2?>" class="zip" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','state','address','');" size="4" />
        
    </tr>
    <tr>
        <th>都道府県</th>
        <td>
        <select name="state" id="state">
        <option value="">選　択</option>
         <?php
			$sql = "SELECT * From t_state";
			$s = $dbh->prepare($sql);
			$s -> execute();
			$result = $s -> fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $rss){
		?>
        <option value="<?=$rss["id"]?>"<?=selected($rss["id"],$rs["state"])?>><?=$rss["state"]?></option>
        <?php
            }
        ?>
        </select>
        </td>
    </tr>
    <tr>
        <th>市区町村名<</th>
        <td>
        <input type="text" name="address" id="address" value="<?=rers($rs,"address","")?>" />
        
    </tr>
    <tr>
        <th>以下住所</th>
        <td><input type="text" name="address2" id="address2" value="<?=rers($rs,"address2","")?>" /></td>
    </tr>
    
    
    <tr>
        <th>連絡先電話番号</th>
        <td><input type="text" name="tel" id="tel" value="<?=rers($rs,"tel","")?>" /></td>
    </tr>
    
    <tr>
        <th>メールアドレス</th>
        <td><input type="text" name="email" id="email" value="<?=rers($rs,"email","")?>" /></td>
    </tr>
    
    <tr>
        <th>利用人数</th>
        <td>合計<input type="text" name="ninzu" id="ninzu" value="<?=rers($rs,"personnum","")?>" size="4" /> 人<br />
        大人<input type="text" name="adult" id="adult" value="<?=rers($rs,"adult","")?>" size="4" /> 人　　子供<input type="text" name="child" id="child" value="<?=rers($rs,"child","")?>" size="4" /> 人</td>
    </tr> 

    <tr>
        <th>ペット受入れ</th>
        <td><?(rers($rs,"petok","")==1) ? $rs["petok"] : "不可"?><br />
        <textarea name="petnaiyo" cols="60" row="3"><?=rers($rs,"pet","")?></textarea>
        </td>
    </tr>
    
    <tr>
        <th>宿泊施設提供</th>
        <td><input type="radio" name="syukuhaku" id="syukuhaku1" value="希望する"<?=checked(rers($rs,"stayok",""),"希望する")?> /><label for="syukuhaku1">希望する</label><br />
        <input type="radio" name="syukuhaku" id="syukuhaku2" value="希望しない"<?=(!empty(rers($rs,"stayok",""))) ? " checked" : ""?> /><label for="syukuhaku2">希望しない</label>
        </td>
    </tr>
    
    <tr>
        <th>食事提供</th>
        <td>
        <input type="radio" name="syokuji" id="syokuji1" value="希望する"<?=checked(rers($rs,"foodok",""),"希望する")?> /><label for="syokuji1">希望する</label><br />
        <input type="radio" name="syokuji" id="syokuji2" value="希望しない"<?= (!empty(rers($rs,"foodok",""))) ? " checked" : ""?> /><label for="syokuji2">希望しない</label>
        </td>
    </tr>
    
    <tr>
        <th>ご質問・ご希望</th>
        <td>
        <textarea name="comment" id="comment" cols="60" row="3"><?=rers($rs,"comment","")?></textarea>
        </td>
    </tr>
    
    <tr>
        <th>IPアドレス・ホスト</th>
        <td>
        IPアドレス：<?=rers($rs,"ipaddress","")?><br/>
        ホスト：<?=rers($rs,"hostname","")?>
        </td>
    </tr>


        
        </table>
       
		<p><input type="submit" value="修正" name="change" /></p>
        
        
	</form>


</div>

		</div>

	</div>
</div>


</body>
</html>
