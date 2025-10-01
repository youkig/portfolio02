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

<?php

$id = cnum($_GET["id"]);
if ($id !== 0){
	
        $sql ="select * From t_bbs Where id=:id";
        $b = $dbh->prepare($sql);
        $b -> bindValue(":id",$id,PDO::PARAM_INT);
        $b -> execute();
        $rs= $b->fetch(PDO::FETCH_ASSOC);
        if (!$rs){
        header("location:bbslist.php");
        }
    
}


if (!empty($_POST["change"])){
	$id =cnum($_REQUEST["id"]);

    
	if ($id !== 0){
		$sql = "UPDATE t_bbs set name=:name,penname=:penname,zip=:zip,state=:state,address=:address,address2=:address2,tel=:tel,email=:email,category=:category,comment=:comment";
        $sql .= ",memo=:memo,disp=:disp,shinsa=:shinsa Where id=:id";
        $b = $dbh->prepare($sql);
        $b -> bindValue(":name",renull($_POST["name"]),PDO::PARAM_STR);
        $b -> bindValue(":penname",renull($_POST["penname"]),PDO::PARAM_STR);
        $b -> bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);
        $b -> bindValue(":state",renull($_POST["state"]),PDO::PARAM_STR);
        $b -> bindValue(":address",renull($_POST["address"]),PDO::PARAM_STR);
        $b -> bindValue(":address2",renull($_POST["address2"]),PDO::PARAM_STR);
        $b -> bindValue(":tel",renull($_POST["tel"]),PDO::PARAM_STR);
        $b -> bindValue(":email",renull($_POST["email"]),PDO::PARAM_STR);
        $b -> bindValue(":category",renull($_POST["category"]),PDO::PARAM_STR);
        $b -> bindValue(":comment",renull($_POST["comment"]),PDO::PARAM_STR);
        $b -> bindValue(":memo",renull($_POST["memo"]),PDO::PARAM_STR);
        $b -> bindValue(":disp",cnum($_POST["disp"]),PDO::PARAM_INT);
        $b -> bindValue(":shinsa",cnum($_POST["shinsa"]),PDO::PARAM_INT);
        $b -> bindValue(":id",$id,PDO::PARAM_INT);
        $b -> execute();
	}else{
		$sql = "INSERT into t_bbs (name,penname,zip,state,address,address2,tel,email,category,comment,memo,disp,shinsa,indate) values (:name,:penname,:zip,:state,:address,:address2,:tel,:email,:category,:comment,:memo,:disp,:shinsa,:indate)";
		$b = $dbh->prepare($sql);
        $b -> bindValue(":name",renull($_POST["name"]),PDO::PARAM_STR);
        $b -> bindValue(":penname",renull($_POST["penname"]),PDO::PARAM_STR);
        $b -> bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);
        $b -> bindValue(":state",renull($_POST["state"]),PDO::PARAM_STR);
        $b -> bindValue(":address",renull($_POST["address"]),PDO::PARAM_STR);
        $b -> bindValue(":address2",renull($_POST["address2"]),PDO::PARAM_STR);
        $b -> bindValue(":tel",renull($_POST["tel"]),PDO::PARAM_STR);
        $b -> bindValue(":email",renull($_POST["email"]),PDO::PARAM_STR);
        $b -> bindValue(":category",renull($_POST["category"]),PDO::PARAM_STR);
        $b -> bindValue(":comment",renull($_POST["comment"]),PDO::PARAM_STR);
        $b -> bindValue(":memo",renull($_POST["memo"]),PDO::PARAM_STR);
        $b -> bindValue(":disp",cnum($_POST["disp"]),PDO::PARAM_INT);
        $b -> bindValue(":shinsa",cnum($_POST["shinsa"]),PDO::PARAM_INT);
        $b -> bindValue(":indate",date('Y-m-d H:i:s'),PDO::PARAM_STR);
        $b -> execute();
	}
    
   

	if ($id !== 0){
		header ("location:bbsdisp.php?id=" . $id);
	}else{
		$sql = "select max(id) as co from t_bbs";
        $m = $dbh->prepare($sql);
        $m -> execute();
	    $rsmax = $m -> fetch(PDO::FETCH_ASSOC);
		$id = $rsmax["co"];
		header ("location:bbsdisp.php?id=" . $id);
	}
}


?>

<title>一宮町町政への苦情、ご意見投稿詳細【<?=$kanriName?>】</title>
</head>
<body onLoad="initialize();codeAddress();">
<div id="box" class="kanri">
<?php include("include/header.php")?>

	<div id="main">
	<?php include("include/leftpane.php")?>
		<div id="cnt">
			<h2>一宮町町政への苦情、ご意見投稿詳細</h2>



<div class="block">

	<?php
		if ($id==0){
	?>
        <p>新規「一宮町町政への苦情、ご意見投稿」登録ページです。必要項目を入力してください。</p>
     <?php
	 }else{
	 ?>  
     
     <p><a href="../ichinomiya_bbs.php#result<?=rers($rs,"id","")?>" target="_blank" class="underline">投稿ページの確認へ</a></p>
     <table>
	<tr>
        	<th>登録日</th>
            <td>
            <?=rers($rs,"indate",date('Y-m-d'))?>
            </td>
        </tr>
    </table>   
     <?php
     }
	 ?>
	<form action="bbsdisp.php" method="post">
    
    <input type="hidden" name="id" value="<?=$id?>" />
	    <h3>審査</h3>
        
        <table>
            <tr>
                <th>審査</th>
                <td>
                <?php
                if (rers($rs,"shinsa","")==0){
                echo '<p class="red bold">※まだ審査がされておりません。</p>';
                }
                ?>
                <select name="shinsa" id="shinsa">
                    <option value="0"<?=selected(rers($rs,"shinsa",""),0)?>>未審査</option>
                    <option value="1"<?=selected(rers($rs,"shinsa",""),1)?>>審査済み（承認）</option>
                    <option value="2"<?=selected(rers($rs,"shinsa",""),2)?>>未承認</option>
                </select></td>
            </tr>
        </table>
    
        <h3>表示/非表示</h3>
    <table>    
        <tr>
        	<th>表示/非表示</th>
            <td>
            <input type="radio" name="disp" id="disp1" value="1"<?=checked(rers($rs,"disp",""),true)?> /><label for="disp1">表示</label><br />
            <input type="radio" name="disp" id="disp2" value="0"<?=checked(rers($rs,"disp",""),false)?> /><label for="disp2">非表示</label>
            </td>
        </tr>
    </table>        
        
        <h3>投稿者情報</h3>
     <table>   
    <tr>
        <th>お名前</th>
        <td>
        <input type="text" name="name" id="name" value="<?=rers($rs,"name","")?>" size="10" />
        
        </td>
    </tr>
    <tr>
        <th>ペンネーム</th>
        <td>ペンネームが登録されていない場合は、「匿名」と表示されます。<br />
        <input type="text" name="penname" id="penname" value="<?=rers($rs,"penname","")?>" size="10" /></td>
    </tr>
    
    <tr>
        <th>郵便番号<em>（必須）</em></th>
        <td><?php
        if (!empty($rs["zip"])){
        $zip=explode("-",$rs["zip"]);
        $zip1=$zip[0];
        $zip2=$zip[1];
        }
        ?>
        〒<input type="text" name="zip1" id="zip1" value="<?=$zip1?>" class="zip" size="4" /> - <input type="text" name="zip2" id="zip2" value="<?=$zip2?>" class="zip" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','state','address','');" size="5" />
        
    </tr>
    <tr>
        <th>都道府県<em>（必須）</em></th>
        <td><?php
        $sql = "SELECT * From t_state";
        $s = $dbh->prepare($sql);
        $result = $s -> fetchAll(PDO::FETCH_ASSOC);
        ?>
        <select name="state" id="state">
        <option value="">選　択</option>
        <?php
        foreach($result as $rss){
        ?>
        <option value="<?=$rss["state"]?>"<?=selected($rss["state"],$rs["state"])?>><?=$rss["state"]?></option>
        <?php
        }
        ?>
        </select>
        </td>
    </tr>
    <tr>
        <th>市区町村名<em>（必須）</em></th>
        <td>
        <input type="text" name="address" id="address" value="<?=rers($rs,"address","")?>" />
        
    </tr>
    <tr>
        <th>以下住所<em>（必須）</em></th>
        <td><input type="text" name="address2" id="address2" value="<?=rers($rs,"address2","")?>" /></td>
    </tr>
    
   
  
    <tr>
        <th>電話番号<em>（必須）</em></th>
        <td><input type="text" name="tel" id="tel" value="<?=rers($rs,"tel","")?>" /></td>
    </tr>
    
    <tr>
        <th>メールアドレス<em>（必須）</em></th>
        <td><input type="text" name="email" id="email" value="<?=rers($rs,"email","")?>" /></td>
    </tr>
    </table>
   

  
   <h3>投稿内容</h3>
  
    <table>
        <tr>
            <th>対象の組織・課</th>
            <td><select name="category" id="category">
            <option value=""></option>
            <option value="町長"<?=selected(rers($rs,"category",""),"町長")?>>町長</option>
            <option value="総務課"<?=selected(rers($rs,"category",""),"総務課")?>>総務課</option>
            <option value="企画広報課"<?=selected(rers($rs,"category",""),"企画広報課")?>>企画広報課</option>
            <option value="税務課"<?=selected(rers($rs,"category",""),"税務課")?>>税務課</option>
            <option value="住民課"<?=selected(rers($rs,"category",""),"住民課")?>>住民課</option>
            <option value="福祉健康課"<?=selected(rers($rs,"category",""),"福祉健康課")?>>福祉健康課</option>
            <option value="子育て支援課"<?=selected(rers($rs,"category",""),"子育て支援課")?>>子育て支援課</option>
            <option value="都市環境課"<?=selected(rers($rs,"category",""),"都市環境課")?>>都市環境課</option>
            <option value="産業観光課"<?=selected(rers($rs,"category",""),"産業観光課")?>>産業観光課</option>
            <option value="会計課"<?=selected(rers($rs,"category",""),"会計課")?>>会計課</option>
            <option value="教育課"<?=selected(rers($rs,"category",""),"教育課")?>>教育課</option>
            <option value="議会事務局"<?=selected(rers($rs,"category",""),"議会事務局")?>>議会事務局</option>
            <option value="その他"<?=selected(rers($rs,"category",""),"その他")?>>その他</option>
            </select></td>
        </tr>
        <tr>
        	<th>投稿内容</th>
            <td>
            <textarea name="comment" id="comment" cols="60" rows="10"><?=rers($rs,"comment","")?></textarea>
            </td>
		</tr>

        </table>
        
        
    <h3>農園からのコメント</h3>
    
    <table>

        <tr>
        	<th>コメント</th>
            <td>
            <textarea name="memo" id="memo" cols="60" rows="10"><?=rers($rs,"memo","")?></textarea>
            </td>
		</tr>

     </table>
    
		<p><input type="submit" value="登録" name="change" /></p>
        
        
	</form>
    
    <p><a href="../ichinomiya_bbs.php#result<?=rers($rs,"id","")?>" target="_blank" class="underline">投稿ページの確認へ</a></p>

</div>

		</div>

	</div>
</div>


</body>
</html>
