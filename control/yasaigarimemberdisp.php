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

<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<script type="text/javascript">
$(function () {
	registEnd("yasaigarimemberdisp.php");
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
    
    
    $("#day").change(function(){
        var year = $("#year").val();
        var month = $("#month").val();
        month = month-1;
        var day = $("#day").val();
        
        var dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ] ;
        var date = new Date(year,month,day);
        var week = dayOfWeekStrJP[date.getDay()];
        if(week=="火" || week=="金"){
        alert("その日は" + week + "曜日（定休日）です。");
        $("#week").html("(" + week + ")");
        }else{
        $("#week").html("(" + week + ")");
        }
    })
	
	$("#cancel").click(function(){
		if(window.confirm('キャンセルしてよろしいですか？')){
        var a = $("#id").val();
        var b = $("#uid").val();
    
			$.ajax({
				type: "get",
				url: "./js/news_del.php",
				data: "cancelid=" + a + "&uid=" + b,
				success: function(str){
					if(str == "success"){
						setTimeout(ReloadAddr,100);
						alert("キャンセルされました。");
					}else{
						alert(str + "エラーが起こりました。\n処理は完了していない可能性があります。");
					}
				}
			});
        }else{
        
        return false;
        }
	})
    
    
    $("#cancel2").click(function(){
		if(window.confirm('キャンセルを取り消ししてよろしいですか？')){
        var a = $("#id").val();
        var b = $("#uid").val();
			$.ajax({
				type: "get",
				url: "./js/news_del.php",
				data: "cancelid2=" + a + "&uid=" + b,
				success: function(str){
					if(str == "success"){
						setTimeout(ReloadAddr,100);
						alert("取り消しされました。");
					}else{
						alert(str + "エラーが起こりました。\n処理は完了していない可能性があります。");
					}
				}
			});
        }else{
        
        return false;
        }
	})
});
</script>

<?php

$id = cnum($_GET["id"]);
if ($id !== 0){
	$sql = "select t_yasaigari01.*,t_yasaigari01.uid as uid2,t_yasaigari02.*,t_yasaigari01.id as id,t_yasaigari01.cancel as cancel,t_yasaigari02.id as id2 from t_yasaigari01 inner join t_yasaigari02 on t_yasaigari01.id=t_yasaigari02.uid where t_yasaigari01.id = :id";
    $y = $dbh->prepare($sql);
    $y -> bindValue(":id",$id,PDO::PARAM_INT);
    $y -> execute();
    $rs = $y -> fetch(PDO::FETCH_ASSOC);
	
	if (!$rs){
        header("location:yasaigarimemberlist.php");
    }
	
}


if (!empty($_POST["change"])){
	$id = cnum($_POST["id"]);
    $uid = cnum($_POST["uid"]);


	if ($id !== 0){
		$sql = "UPDATE t_yasaigari01 set person=:person,company=:company,busyo=:busyo,name=:name,furigana=:furigana,email=:email,tel=:tel,zip=:zip,state=:state";
        $sql .= ",address=:address,address2=:address2,comment=:comment Where id=:id";
        $y = $dbh->prepare($sql);
        $y ->bindValue(":person",renull($_POST["person"]),PDO::PARAM_STR);
        $y ->bindValue(":company",renull($_POST["company"]),PDO::PARAM_STR);
        $y ->bindValue(":busyo",renull($_POST["busyo"]),PDO::PARAM_STR);
        $y ->bindValue(":name",renull($_POST["name"]),PDO::PARAM_STR);
        $y ->bindValue(":furigana",renull($_POST["furigana"]),PDO::PARAM_STR);
        $y ->bindValue(":email",renull($_POST["email"]),PDO::PARAM_STR);
        $y ->bindValue(":tel",renull($_POST["tel"]),PDO::PARAM_STR);
        $y ->bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);
        $y ->bindValue(":state",renull($_POST["state"]),PDO::PARAM_INT);
        $y ->bindValue(":address",renull($_POST["address"]),PDO::PARAM_STR);
        $y ->bindValue(":address2",renull($_POST["address2"]),PDO::PARAM_STR);
        $y ->bindValue(":comment",renull($_POST["comment"]),PDO::PARAM_STR);
        $y ->bindValue(":id",$id,PDO::PARAM_INT);
        $y -> execute();
	}else{
		$sql = "INSERT into t_yasaigari01 (person,company,busyo,name,furigana,email,tel,zip,state,address,address2,comment,indate) values (:person,:company,:busyo,:name,:furigana,:email,:tel,:zip,:state,:address,:address2,:comment,:indate)";
		$y = $dbh->prepare($sql);
        $y ->bindValue(":person",renull($_POST["person"]),PDO::PARAM_STR);
        $y ->bindValue(":company",renull($_POST["company"]),PDO::PARAM_STR);
        $y ->bindValue(":busyo",renull($_POST["busyo"]),PDO::PARAM_STR);
        $y ->bindValue(":name",renull($_POST["name"]),PDO::PARAM_STR);
        $y ->bindValue(":furigana",renull($_POST["furigana"]),PDO::PARAM_STR);
        $y ->bindValue(":email",renull($_POST["email"]),PDO::PARAM_STR);
        $y ->bindValue(":tel",renull($_POST["tel"]),PDO::PARAM_STR);
        $y ->bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);
        $y ->bindValue(":state",renull($_POST["state"]),PDO::PARAM_INT);
        $y ->bindValue(":address",renull($_POST["address"]),PDO::PARAM_STR);
        $y ->bindValue(":address2",renull($_POST["address2"]),PDO::PARAM_STR);
         $y ->bindValue(":comment",renull($_POST["comment"]),PDO::PARAM_STR);
        $y ->bindValue(":indate",date('Y-m-d H:i:s'),PDO::PARAM_STR);
        $y -> execute();
		
	}
	
	

	if ($id !== 0){
		header ("location:yasaigarimemberdisp.php?id=". $id);
	}else{
		$sql = "select max(id) as co from t_yasaigari01";
        $m = $dbh->prepare($sql);
		$m ->execute();
        $rsmax = $m->fetch(PDO::FETCH_ASSOC);

		$id = $rsmax["co"];
        

            if ($uid !== 0){
                $sql = "UPDATE t_yasaigari02 set ydate=:ydate,yhour=:yhour,ytime=:ytime,num=:num,kago=:kago,bento=:bento,bentonum=:bentonum Where uid=:uid";
                $y = $dbh->prepare($sql);
                $y -> bindValue(":ydate",date('Y-m-d',strtotime("{$_POST["year"]}-{$_POST["month"]}-{$_POST["day"]}")),PDO::PARAM_STR);
                $y -> bindValue(":yhour",cnum($_POST["hour"]),PDO::PARAM_INT);
                $y -> bindValue(":ytime",cnum($_POST["time"]),PDO::PARAM_INT);
                $y -> bindValue(":num",cnum($_POST["ninzu"]),PDO::PARAM_INT);
                $y -> bindValue(":kago",cnum($_POST["kago"]),PDO::PARAM_INT);
                $y -> bindValue(":bento",cnum($_POST["obento"]),PDO::PARAM_INT);
                $y -> bindValue(":bentonum",cnum($_POST["bentonum"]),PDO::PARAM_INT);
                $y -> bindValue(":uid",$id,PDO::PARAM_INT);
                $y -> execute();
            }else{
                $sql = "INSERT into t_yasaigari02 (uid,ydate,yhour,ytime,num,kago,bento,bentonum) values (:uid,:ydate,:yhour,:ytime,:num,:kago,:bento,:bentonum)";
                $y = $dbh->prepare($sql);
                $y -> bindValue(":uid",$id,PDO::PARAM_INT);
                $y -> bindValue(":ydate",date('Y-m-d',strtotime("{$_POST["year"]}-{$_POST["month"]}-{$_POST["day"]}")),PDO::PARAM_STR);
                $y -> bindValue(":yhour",cnum($_POST["hour"]),PDO::PARAM_INT);
                $y -> bindValue(":ytime",cnum($_POST["time"]),PDO::PARAM_INT);
                $y -> bindValue(":num",cnum($_POST["ninzu"]),PDO::PARAM_INT);
                $y -> bindValue(":kago",cnum($_POST["kago"]),PDO::PARAM_INT);
                $y -> bindValue(":bento",cnum($_POST["obento"]),PDO::PARAM_INT);
                $y -> bindValue(":bentonum",cnum($_POST["bentonum"]),PDO::PARAM_INT);
                $y -> execute();
            }
       
		header ("location:yasaigarimemberdisp.php?id=". $id);
	}
    
    
}
?>

<title>お客様情報【<?=$kanriName?>】</title>
</head>
<body>
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
	<?php include("include/leftpane.php")?>
		<div id="cnt">
			<h2>お客様情報</h2>



<div class="block">

	<?php
		if ($id==0){
		?>
        <p>新規予約登録ページです。必要項目を入力してください。</p>
     <?php
	}
	 ?>   
	
    <?php
    if ($id!==0){
    if (rers($rs,"cancel","")==1){
    ?>
    <p class="red bold">こちらの予約はキャンセルされました</p>
    <?php
    }
}
    ?>
	<form action="yasaigarimemberdisp.php" method="post">
		<input type="hidden" name="id" id="id" value="<?=$id?>" />
        
        <table>
        <?php
		if ($id!==0){
		?>
        <tr>
        	<th>登録日</th>
            <td>
            <?=rers($rs,"indate",date('Y-m-d'))?>
            </td>
        </tr>
        <?php
        }
        if (!empty(rers($rs,"uid2",""))){
        ?>
        
        <tr>
            <th>会員</th>
            <td><a href="userdisp.php?id=<?=rers($rs,"uid2","")?>">会員ページ</a></td>
        </tr>
		  <?php
          }
          ?>   
        <tr>
        	<th>法人/個人</th>
            <td>
            <?php
            $checkedh ="";
            $checkedk ="";
            if (!empty(rers($rs,"person",""))){
            if (rers($rs,"person","")=="法人"){
                $checkedh = " checked='checked'";
            }else{
                $checkedk = " checked='checked'";
            }
            
        }
            ?>
            <input type="radio" name="person" id="person1" value="法人"<?=$checkedh?>><label for="person1">法人</label>
            <input type="radio" name="person" id="person2" value="個人"<?=$checkedk?>><label for="person2">個人</label>
            
            </td>
		</tr>
        
       
        
        
        <tr>
        	<th>会社名</th>
            <td>
            <input type="text" size="40" name="company" value="<?=rers($rs,"company","")?>" style="width:98%" />
            </td>
        </tr>
        
        <tr>
        	<th>部署名</th>
            <td>
            <input type="text" size="40" name="busyo" value="<?=rers($rs,"busyo","")?>" style="width:98%" />
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
			$zip1="";
			$zip2="";
			if (!empty(rers($rs,"zip",""))){
			$zip = explode("-",rers($rs,"zip",""));
			$zip1=$zip[0];
			$zip2=$zip[1];
			}
			?>
            <input type="text" name="zip1" id="zip1" value="<?=$zip1?>" size="5" class="zip" /> - <input type="text" name="zip2" id="zip2" value="<?=$zip2?>" size="7" class="zip" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','state','address','');" />
            
            </td>
        </tr>

        <tr>
        	<th>都道府県</th>
            <td>
            
            <select name="state">
            	<option value=""></option>
            	<?php
						$sql = "SELECT * from t_state";
                        $s = $dbh->prepare($sql);
						$s -> execute();
                        $result = $s->fetchAll(PDO::FETCH_ASSOC);
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
        	<th>住所</th>
            <td>
            <input type="text" size="40" name="address" value="<?=rers($rs,"address","")?>" style="width:98%" />
            </td>
        </tr>

        <tr>
        	<th>以下番地、建物名、部屋番号など</th>
            <td>
            <input type="text" size="40" name="address2" value="<?=rers($rs,"address2","")?>" style="width:98%" />
            </td>
        </tr>
    
		
        <tr>
        	<th>備考</th>
            <td>
            <textarea name="comment" id="comment" cols="30" rows="10" style="width:100%"><?=rers($rs,"comment","")?></textarea>
            </td>
		</tr>


        </table>
       
        
        <h3>予約内容</h3>
        <table>
            <tr>
        	<th>予約日</th>
            <td>
            <select name="year" id="year">
                <?php
                $y=date('Y');
                $y2=$y+1;
                for ($a=$y;$a<=$y2;$a++){
                ?>
                <option value="<?=$a?>"<?if (!empty(rers($rs,"ydate",""))){echo (selected($a,date('Y',strtotime(rers($rs,"ydate","")))));}?>><?=$a?></option>
                <?php
                }
                ?>
            </select>年
            <select name="month" id="month">
                <?php
                for ($a=1;$a<=12;$a++){
                ?>
                <option value="<?=$a?>"<?if (!empty(rers($rs,"ydate",""))){echo (selected($a,date('m',strtotime(rers($rs,"ydate","")))));}?>><?=$a?></option>
               <?php
                }
                ?>
            </select>月
            
            <select name="day" id="day">
                <?php
                for ($a=1;$a<=31;$a++){
                ?>
                <option value="<?=$a?>"<?if (!empty(rers($rs,"ydate",""))){echo (selected($a,date('d',strtotime(rers($rs,"ydate","")))));}?>><?=$a?></option>
                <?php
                }
                ?>
            </select>日
            <?php
            $weekname = [
            '日', //0
            '月', //1
            '火', //2
            '水', //3
            '木', //4
            '金', //5
            '土', //6
            ];
            if (!empty(rers($rs,"ydate",""))){
            $week = date('w',strtotime(rers($rs,"ydate","")));
            echo ("<span id='week'>(".$weekname[$week].")</span>");
            }
            ?>
            </td>
            <tr>
            <th>予約時間</th>
            <td>
                <select name="hour" id="hour">
                    <?php
                    for ($a=8;$a<=16;$a++){
                    ?>
                    <option value="<?=$a?>"<?=selected($a,rers($rs,"yhour",""))?>><?=$a?></option>
                    <?php
                    }
                    ?>
                </select>時
                <select name="time" id="time">
                    <option value="0"<?=selected(0,rers($rs,"ytime",""))?>>00</option>
                    <option value="10"<?=selected(0,rers($rs,"ytime",""))?>>10</option>
                    <option value="20"<?=selected(0,rers($rs,"ytime",""))?>>20</option>
                    <option value="30"<?=selected(30,rers($rs,"ytime",""))?>>30</option>
                    <option value="40"<?=selected(0,rers($rs,"ytime",""))?>>40</option>
                    <option value="50"<?=selected(0,rers($rs,"ytime",""))?>>50</option>
                    
                </select>分
            </td>
            </tr>
            
            <tr>
            <th>人数</th>
            <td>
                <select name="ninzu" id="ninzu">
                    <?php
                    for ($a=1;$a<=50;$a++){
                    ?>
                    <option value="<?=$a?>"<?=selected($a,rers($rs,"num",""))?>><?=$a?></option>
                    <?php
                    }
                    ?>
                </select>人
                
            </td>
            </tr>
            
            <tr>
            <th>カゴ数</th>
            <td>
                <select name="kago" id="kago">
                    <?php
                    for ($a=1;$a<=50;$a++){
                    ?>
                    <option value="<?=$a?>"<?=selected($a,rers($rs,"kago",""))?>><?=$a?></option>
                    <?php
                    }
                    ?>
                </select>個
                
            </td>
            </tr>
            
            <tr>
            <th>昼食弁当予約</th>
            <td>
            <input type="checkbox" name="obento" id="obento" value="1"<?=checked(true,rers($rs,"bento",""))?>><label for="obento">お弁当を予約する</label><br />
                <select name="obentokazu" id="obentokazu">
                <option value=""></option>
                    <?php
                    for ($a=1;$a<=50;$a++){
                    ?>
                    <option value="<?=$a?>"<?=selected($a,rers($rs,"bentonum",""))?>><?=$a?></option>
                    <?php
                    }
                    ?>
                </select>個
                
            </td>
            </tr>
        </tr>
        </table>

        <input type="hidden" name="uid" id="uid" value="<?=rers($rs,"id2","")?>" />
		<p><input type="submit" value="登録" name="change" /><?php if ($id!==0) {?>&nbsp;
            <?php
                if (rers($rs,"cancel","0") == 0){
                ?>
                <input type="button" value="キャンセル" name="cancel" id="cancel" />
        <?php
        }else{
        ?>
        <input type="button" value="キャンセル取り消し" name="cancel2" id="cancel2" />
        <?php
        }
    }
    ?>
        </p>
        
        
	</form>
    
    

</div>

		</div>

	</div>
</div>

</body>
</html>
