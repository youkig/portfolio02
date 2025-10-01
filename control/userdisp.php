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

<script type="text/javascript">
$(function () {
	registEnd("memberdisp.php");
	$("#taikaiset").click(function(){
		if(window.confirm("強制退会させますか？")){
			var a = $("#member").val();
			$.ajax({
				type: "get",
				url: "./js/taikai.php",
				data: "id=" + a,
				success: function(str){
					if(str == "success"){
						setTimeout(ReloadAddr,100);
						alert("退会されました。");
					}else{
						alert(str + "エラーが起こりました。\n処理は完了していない可能性があります。");
					}
				}
			});
		};
	});
	
	$("#blackbtn").click(function(){
		$(".bcomment").css("display","block");
		$("#blackbtn2").css("display","block");
		$("#blackbtn").css("display","none");
	})
	
	
	$(".syubetsucheck").click(function(){
		$(".nouenmember").fadeOut();	
	})
	
	$(".syubetsucheck2").click(function(){
		$(".nouenmember").fadeIn();	
	})
});
</script>

<?php

$id = cnum($_REQUEST["id"]);
if ($id !== 0){
	$sql = "select * from t_user where id = :id";
	$u = $dbh->prepare($sql);
	$u -> bindValue(":id",$id,PDO::PARAM_INT);
	$u -> execute();
	$rs = $u -> fetch(PDO::FETCH_ASSOC);
	if (!$rs){
		header("location:userlist.php");
	}
}


if (!empty($_POST["change"])){
	$id = cnum($_REQUEST["id"]);

	if ($id !== 0){
		$sql = "UPDATE t_user set person=:person,company=:company,busyo=:busyo,name=:name,furigana=:furigana,email=:email,tel=:tel,zip=:zip,state=:state,address=:address,address2=:address2,mailmaga=:mailmaga,dele=:dele,comment=:comment";
		if (!empty($_POST["password"])){
			$sql .= ",password=:password,password2=:password2";
		}
		$sql .= " Where id=:id";
		$u = $dbh->prepare($sql);
		$u -> bindValue(":person",cnum($_POST["person"]),PDO::PARAM_INT);
		$u -> bindValue(":company",renull($_POST["company"]),PDO::PARAM_STR);
		$u -> bindValue(":busyo",renull($_POST["fcompany"]),PDO::PARAM_STR);
		$u -> bindValue(":name",renull($_POST["name"]),PDO::PARAM_STR);
		$u -> bindValue(":furigana",renull($_POST["furigana"]),PDO::PARAM_STR);
		$u -> bindValue(":email",renull($_POST["email"]),PDO::PARAM_STR);
		$u -> bindValue(":tel",renull($_POST["tel"]),PDO::PARAM_STR);
		$u -> bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);
		$u -> bindValue(":state",cnum($_POST["state"]),PDO::PARAM_INT);
		$u -> bindValue(":address",renull($_POST["address"]),PDO::PARAM_STR);
		$u -> bindValue(":address2",renull($_POST["address2"]),PDO::PARAM_STR);
		$u -> bindValue(":mailmaga",renull($_POST["mailmaga"]),PDO::PARAM_INT);
		$u -> bindValue(":dele",cnum($_POST["disp"]),PDO::PARAM_INT);
		if (!empty($_POST["password"])){
			$u -> bindValue(":password",password_hash($_POST["password"],PASSWORD_DEFAULT),PDO::PARAM_STR);
			$u -> bindValue(":password2",$_POST["password"],PDO::PARAM_STR);
		}
		$u -> bindValue(":comment",renull($_POST["biko"]),PDO::PARAM_STR);
		$u -> bindValue(":id",$id,PDO::PARAM_INT);
		$u -> execute();
	}else{
		$sql = "INSERT into t_user (person,company,busyo,name,furigana,email,tel,zip,state,address,address2,mailmaga,dele,password,password2,comment,indate) values ";
		$sql .= "(:person,:company,:busyo,:name,:furigana,:email,:tel,:zip,:state,:address,:address2,:mailmaga,:dele,:password,:password2,:comment,:indate)";
		$u = $dbh->prepare($sql);
		$u -> bindValue(":person",cnum($_POST["person"]),PDO::PARAM_INT);
		$u -> bindValue(":company",renull($_POST["company"]),PDO::PARAM_STR);
		$u -> bindValue(":busyo",renull($_POST["fcompany"]),PDO::PARAM_STR);
		$u -> bindValue(":name",renull($_POST["name"]),PDO::PARAM_STR);
		$u -> bindValue(":furigana",renull($_POST["furigana"]),PDO::PARAM_STR);
		$u -> bindValue(":email",renull($_POST["email"]),PDO::PARAM_STR);
		$u -> bindValue(":tel",renull($_POST["tel"]),PDO::PARAM_STR);
		$u -> bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);
		$u -> bindValue(":state",cnum($_POST["state"]),PDO::PARAM_INT);
		$u -> bindValue(":address",renull($_POST["address"]),PDO::PARAM_STR);
		$u -> bindValue(":address2",renull($_POST["address2"]),PDO::PARAM_STR);
		$u -> bindValue(":mailmaga",renull($_POST["mailmaga"]),PDO::PARAM_INT);
		$u -> bindValue(":dele",0,PDO::PARAM_INT);
		if (!empty($_POST["password"])){
			$u -> bindValue(":password",password_hash($_POST["password"],PASSWORD_DEFAULT),PDO::PARAM_STR);
			$u -> bindValue(":password2",$_POST["password"],PDO::PARAM_STR);
		}
		$u -> bindValue(":comment",renull($_POST["biko"]),PDO::PARAM_STR);
		$u -> bindValue(":indate",date('Y-m-d H:i:s'),PDO::PARAM_STR);
		$u -> execute();
	}
	

	if ($id !== 0){
		header("location:userdisp.php?id=".$id);
	}else{
		$sql = "select max(id) as co from t_user";
		$u =$dbh->prepare($sql);
		$u -> execute();
		$rsmax = $u -> fetch(PDO::FETCH_ASSOC);
		$id = $rsmax["co"];
		header("location:userdisp.php?id=".$id);
	}
}
?>

<title>会員詳細【<?=$kanriName?>】</title>
</head>
<body>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
		<?php include("include/leftpane.php")?>
		<div id="cnt">
			<h2>会員詳細</h2>



<div class="block">

	<?php
		if ($id==0){
	?>
        <p>新規会員登録ページです。必要項目を入力してください。</p>
    <?php
	}
	?>  
	
	<form action="userdisp.php" method="post">
		<input type="hidden" name="id" value="<?=$id?>" id="member" />
        
        <table>
        
       
       
		      
        <tr>
        	<th>法人/個人</th>
            <td>
            <?php
			if (!empty(rers($rs,"company",""))){
			echo "法人";
			}else{
			echo "個人";
			}
			?>
            </td>
		</tr>
        
        
        <tr>
        	<th>会社名</th>
            <td>
            <input type="text" size="40" name="company" value="<?=rers($rs,"company","")?>" style="width:98%" />
            </td>
        </tr>
        
        <tr>
        	<th>部署</th>
            <td>
            <input type="text" size="40" name="fcompany" value="<?=rers($rs,"busyo","")?>" style="width:98%" />
            </td>
        </tr>
        
        <tr>
        	<th>名前</th>
            <td>
            <input type="text" size="40" name="name" value="<?=rers($rs,"name","")?>" style="width:98%" />
            </td>
        </tr>
        
        <tr>
        	<th>ふりがな</th>
            <td>
            <input type="text" size="40" name="furigana" value="<?=rers($rs,"furigana","")?>" style="width:98%" />
            </td>
        </tr>
        
        
       

        <tr>
        	<th>E-mail</th>
            <td>
            <input type="text" size="40" name="email" value="<?=rers($rs,"email","")?>" style="width:98%" />
            </td>
        </tr>
        
        <tr>
        	<th>電話番号</th>
            <td>
            <input type="text" size="40" name="tel" value="<?=rers($rs,"tel","")?>" style="width:98%" />
            </td>
        </tr>
        

        <tr>
        	<th>郵便番号</th>
            <td>
            <?php
			
			if (!empty(rers($rs,"zip",""))){
			$zip = explode("-",rers($rs,"zip",""));
			$zip1=$zip[0];
			$zip2=$zip[1];
			}
			?>
            <input type="text" name="zip1" id="zip1" value="<?=$zip1?>" size="5" /> - <input type="text" name="zip2" id="zip2" value="<?=$zip2?>" size="7" />
            
            </td>
        </tr>

        <tr>
        	<th>都道府県</th>
            <td>
			
            <select name="state">
            	<option value=""></option>
            	 <?php
					$sql = "SELECT * From t_state";
					$s = $dbh->prepare($sql);
					$s -> execute();
					$result = $s -> fetchAll(PDO::FETCH_ASSOC);

					foreach($result as $rsstate){
					?>
                        <option value="<?=$rsstate["id"]?>"<?=selected($rsstate["id"],rers($rs,"state",""))?>><?=$rsstate["state"]?></option>
                    <?php
					}
					?>
            </select>
            </td>
        </tr>

        <tr>
        	<th>市区町村名</th>
            <td>
            <input type="text" size="40" name="address" value="<?=rers($rs,"address","")?>" style="width:98%" />
            </td>
        </tr>

        <tr>
        	<th>以下番地、建物名など</th>
            <td>
            <input type="text" size="40" name="address2" value="<?=rers($rs,"address2","")?>" style="width:98%" />
            </td>
        </tr>
     
        <tr>
        	<th>パスワード</th>
            <td>
            6文字～12文字<br />
            ※変更しない場合は空のまま<br />
            <input type="text" size="40" name="password" value="" style="width:98%" />
            </td>
        </tr>
        
      
        <tr>
            <th>メールマガジン</th>
            <td><input type="checkbox" name="mailmaga" id="mailmaga" value="1"<?=(rers($rs,"mailmaga","")==true) ? ' checked="checked"' : ''?> /><label for="mailmaga">配信希望の場合はチェックを入れてください</label></td>
        </tr>
        
       <?php
	   if ($id!==0){
	   ?>
        <tr>
        	<th>帳票印刷</th>
            <td>
            <ul>
            	<li><a href="print_sheet01.php?uid=<?=$id?>&t=0" target="_blank">新規領収書発行</a>
                	<?php
					$sql="SELECT * From t_receipt_master Where uid=:id and syubetsu=0 and (dele=0 or dele is null) order by indate desc";
					$r = $dbh->prepare($sql);
					$r -> bindValue(":id",$id,PDO::PARAM_INT);
					$r -> execute();
					$result = $r -> fetch(PDO::FETCH_ASSOC);
					
					if($result){
					?>
					<dl>
                    <dt>　領収書発行履歴</dt>
					<?php
					foreach($result as $rsr){
					?>
						<dd>・<a href="print_sheet01.php?pid=<?=$rsr["id"]?>&id=<?=$id?>&t=0" target="_blank" class="underline"><?=$rsr["subj"]?>&nbsp;<?=$rsr["indate"]?></a></dd>
					 <?php
					 }
					 ?>  
					</dl>
					<?php
					}
					?>
                </li>
                <li><a href="print_sheet01.php?uid=<?=$id?>&t=1" target="_blank">新規請求書発行</a>
                <?php
					$sql = "SELECT * From t_receipt_master Where uid=:id and syubetsu=1 and (dele=0 or dele is null) order by indate desc";
					$r = $dbh->prepare($sql);
					$r -> bindValue(":id",$id,PDO::PARAM_INT);
					$r -> execute();
					$result = $r -> fetch(PDO::FETCH_ASSOC);
					
					if($result){
					
					?>
					<dl>
                    <dt>　請求書発行履歴</dt>
					<?php
					foreach($result as $rsr){
					?>
						<dd>・<a href="print_sheet01.php?pid=<?=$rsr["id"]?>&id=<?=$id?>&t=1" target="_blank" class="underline"><?=$rsr["subj"]?>&nbsp;<?=$rsr["indate"]?></a></dd>
					<?php
					}
					?>
					</dl>
					<?php
					}
					?>
                </li>
            </ul>
            
            
            </td>
        </tr>
       <?php
					}
					?>
        
        
        <tr>
        	<th>使用</th>
            <td>
            <?php
			if (rers($rs,"taikai","")==true){
			?>
            <p class="red">こちらの会員は退会済みです。</p>
            <?php
			}
			?>
            <ul class="inline">
	            <li><label for="disp0"><input type="radio" name="disp" id="disp0" value="0"<?=checked(false,rers($rs,"dele",""))?> /> 使用可</label></li>
	            <li><label for="disp1"><input type="radio" name="disp" id="disp1" value="1"<?=checked(true,rers($rs,"dele",""))?> /> 使用不可</label></li>
            </ul>
            </td>
        </tr>
        
       
        <tr>
        	<th>登録日</th>
            <td>
            <?=rers($rs,"indate",date('Y-m-d H:i:s'))?>
            </td>
        </tr>

       
    

        <tr>
        	<th>退会</th>
            <td>
            <input type="button" value="強制退会" name="taikaiset" id="taikaiset" /><br />※強制退会させると、再登録できません
            </td>
		</tr>
		
        <tr>
        	<th>ご質問・ご要望</th>
            <td>
            <textarea name="biko" id="biko" cols="30" rows="10" style="width:100%"><?=rers($rs,"comment","")?></textarea>
            </td>
		</tr>


        </table>


		<p><input type="submit" value="登録" name="change" /></p>
        
        
	</form>
    
    

</div>

		</div>

	</div>
</div>


</body>
</html>
