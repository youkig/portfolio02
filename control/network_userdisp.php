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

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCss1VhMGIWmeGRIF1_Vw37911EjQIo4Uc&sensor=false"></script>
<script>
var geocoder;
var map;
function initialize() {
geocoder = new google.maps.Geocoder();
var latlng = new google.maps.LatLng(35.697456,139.702148);
 var opts = {
 zoom: 15,
 center: latlng,
 mapTypeId: google.maps.MapTypeId.ROADMAP
 }
 map = new google.maps.Map
  (document.getElementById("map_canvas"), opts);
}

function codeAddress() {
 var address = document.getElementById("address3").value;
 if (geocoder) {
 geocoder.geocode( { 'address': address,'region': 'jp'},
    function(results, status) {
  if (status == google.maps.GeocoderStatus.OK) {
    map.setCenter(results[0].geometry.location);

   var bounds = new google.maps.LatLngBounds();
   for (var r in results) {
    if (results[r].geometry) {
     var latlng = results[r].geometry.location;
     bounds.extend(latlng);
    new google.maps.Marker({
    position: latlng,map: map
    });
        
     var lats = document.getElementById('lats');
     var lngs = document.getElementById('lngs');
   lats.value = latlng.lat();
    lngs.value = latlng.lng();

    }
   }
   //map.fitBounds(bounds);
   }else{
    alert("Geocode 取得に失敗しました reason: "
         + status);
   }
  });
 }
}
</script>

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
	
        $sql ="select * From t_network Where id=:id";
        $n = $dbh->prepare($sql);
        $n -> bindValue(":id",$id,PDO::PARAM_INT);
        $n -> execute();
        $rs = $n -> fetch(PDO::FETCH_ASSOC);
        if (!$rs){
        header("location:network_userlist.php");
        }else{
        $uid=$rs["uid"];
        }
}



if (!empty($_POST["change"])){
$id = cnum($_REQUEST["id"]);

	if ($id !== 0){
		$sql = "UPDATE t_network set namedisp=:namedisp,penname=:penname,companydisp=:companydisp,zip=:zip,state=:state,address1=:address,address2=:address2,address3=:address3,";
        $sql .= "tel=:tel,email=:email,syubetsu=:syubetsu,space=:breadth,roomnum=:heya,house=:ikken,acceptednum=:ninzu,acceptesex=:sex,food=:food,powersystem=:power,";
        $sql .= "solarsystem=:solar,drink=:well,well=:water,petliving=:pet,petok=:petok,indoor=:petplace,petsize=:petsize,stayfee=:price,staycharge=:fee,meal=:meal,";
        $sql .= "mealcharge=:mealfee,shinsa=:shinsa,lat=:lat,lng=:lng Where id=:id";
        $n = $dbh->prepare($sql);
        $n -> bindValue(":namedisp",cnum($_POST["name_open"]),PDO::PARAM_INT);
        $n -> bindValue(":penname",renull($_POST["penname"]),PDO::PARAM_STR);
        $n -> bindValue(":companydisp",cnum($_POST["company_open"]),PDO::PARAM_INT);
        $n -> bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);
        $n -> bindValue(":state",cnum($_POST["state"]),PDO::PARAM_INT);
        $n -> bindValue(":address",renull($_POST["address"]),PDO::PARAM_STR);
        $n -> bindValue(":address2",renull($_POST["address2"]),PDO::PARAM_STR);
        $n -> bindValue(":address3",renull($_POST["address3"]),PDO::PARAM_STR);
        $n -> bindValue(":tel",renull($_POST["tel"]),PDO::PARAM_STR);
        $n -> bindValue(":email",renull($_POST["email"]),PDO::PARAM_STR);
        $n -> bindValue(":syubetsu",renull($_POST["syubetsu"]),PDO::PARAM_STR);
        $n -> bindValue(":breadth",renull($_POST["breadth"]),PDO::PARAM_STR);
        $n -> bindValue(":heya",cnum($_POST["heya"]),PDO::PARAM_INT);
        $n -> bindValue(":ikken",cnum($_POST["ikken"]),PDO::PARAM_INT);
        $n -> bindValue(":ninzu",cnum($_POST["ninzu"]),PDO::PARAM_INT);
        $n -> bindValue(":sex",renull($_POST["sex"]),PDO::PARAM_STR);
        $n -> bindValue(":food",renull($_POST["food"]),PDO::PARAM_STR);
        $n -> bindValue(":power",renull($_POST["power"]),PDO::PARAM_STR);
        $n -> bindValue(":solar",renull($_POST["solar"]),PDO::PARAM_STR);
        $n -> bindValue(":well",renull($_POST["well"]),PDO::PARAM_STR);
        $n -> bindValue(":water",renull($_POST["water"]),PDO::PARAM_STR);
        $n -> bindValue(":pet",renull($_POST["pet"]),PDO::PARAM_STR);
        $n -> bindValue(":petok",renull($_POST["petok"]),PDO::PARAM_STR);
        $n -> bindValue(":petplace",renull($_POST["petplace"]),PDO::PARAM_STR);
        $n -> bindValue(":petsize",renull($_POST["petsize"]),PDO::PARAM_STR);
        $n -> bindValue(":price",renull($_POST["price"]),PDO::PARAM_STR);
        $n -> bindValue(":fee",renull($_POST["fee"]),PDO::PARAM_STR);
        $n -> bindValue(":meal",renull($_POST["meal"]),PDO::PARAM_STR);
        $n -> bindValue(":mealfee",renull($_POST["mealfee"]),PDO::PARAM_STR);
        $n -> bindValue(":shinsa",cnum($_POST["shinsa"]),PDO::PARAM_INT);
        $n -> bindValue(":lat",renull($_POST["lat"]),PDO::PARAM_STR);
        $n -> bindValue(":lng",renull($_POST["lng"]),PDO::PARAM_STR);
        $n -> bindValue(":id",$id,PDO::PARAM_INT);
        $n -> execute();
	}else{
        $sql = "INSERT into t_network (uid,namedisp,penname,companydisp,zip,state,address1,address2,address3,tel,email,syubetsu,space,roomnum,house,acceptednum,acceptesex";
        $sql .= ",food,powersystem,solarsystem,drink,well,petliving,petok,indoor,petsize,stayfee,staycharge,meal,mealcharge,shinsa,lat,lng,indate) values ";
        $sql .= "(:uid,:namedisp,:penname,:companydisp,:zip,:state,:address,:address2,:address3,:tel,:email,:syubetsu,:breadth,:heya,:ikken,:ninzu,:sex,:food,:power,";
        $sql .= ":solar,:well,:water,:pet,:petok,:petplace,:petsize,:price,:fee,:meal,:mealfee,:shinsa,:lat,:lng,:indate)";
        $n = $dbh->prepare($sql);
        $n -> bindValue(":uid",$uid,PDO::PARAM_INT);
        $n -> bindValue(":namedisp",cnum($_POST["name_open"]),PDO::PARAM_INT);
        $n -> bindValue(":penname",renull($_POST["penname"]),PDO::PARAM_STR);
        $n -> bindValue(":companydisp",cnum($_POST["company_open"]),PDO::PARAM_INT);
        $n -> bindValue(":zip",$_POST["zip1"]."-".$_POST["zip2"],PDO::PARAM_STR);
        $n -> bindValue(":state",cnum($_POST["state"]),PDO::PARAM_INT);
        $n -> bindValue(":address",renull($_POST["address"]),PDO::PARAM_STR);
        $n -> bindValue(":address2",renull($_POST["address2"]),PDO::PARAM_STR);
        $n -> bindValue(":address3",renull($_POST["address3"]),PDO::PARAM_STR);
        $n -> bindValue(":tel",renull($_POST["tel"]),PDO::PARAM_STR);
        $n -> bindValue(":email",renull($_POST["email"]),PDO::PARAM_STR);
        $n -> bindValue(":syubetsu",renull($_POST["syubetsu"]),PDO::PARAM_STR);
        $n -> bindValue(":breadth",renull($_POST["breadth"]),PDO::PARAM_STR);
        $n -> bindValue(":heya",cnum($_POST["heya"]),PDO::PARAM_INT);
        $n -> bindValue(":ikken",cnum($_POST["ikken"]),PDO::PARAM_INT);
        $n -> bindValue(":ninzu",cnum($_POST["ninzu"]),PDO::PARAM_INT);
        $n -> bindValue(":sex",renull($_POST["sex"]),PDO::PARAM_STR);
        $n -> bindValue(":food",renull($_POST["food"]),PDO::PARAM_STR);
        $n -> bindValue(":power",renull($_POST["power"]),PDO::PARAM_STR);
        $n -> bindValue(":solar",renull($_POST["solar"]),PDO::PARAM_STR);
        $n -> bindValue(":well",renull($_POST["well"]),PDO::PARAM_STR);
        $n -> bindValue(":water",renull($_POST["water"]),PDO::PARAM_STR);
        $n -> bindValue(":pet",renull($_POST["pet"]),PDO::PARAM_STR);
        $n -> bindValue(":petok",renull($_POST["petok"]),PDO::PARAM_STR);
        $n -> bindValue(":petplace",renull($_POST["petplace"]),PDO::PARAM_STR);
        $n -> bindValue(":petsize",renull($_POST["petsize"]),PDO::PARAM_STR);
        $n -> bindValue(":price",renull($_POST["price"]),PDO::PARAM_STR);
        $n -> bindValue(":fee",renull($_POST["fee"]),PDO::PARAM_STR);
        $n -> bindValue(":meal",renull($_POST["meal"]),PDO::PARAM_STR);
        $n -> bindValue(":mealfee",renull($_POST["mealfee"]),PDO::PARAM_STR);
        $n -> bindValue(":shinsa",cnum($_POST["shinsa"]),PDO::PARAM_INT);
        $n -> bindValue(":lat",renull($_POST["lat"]),PDO::PARAM_STR);
        $n -> bindValue(":lng",renull($_POST["lng"]),PDO::PARAM_STR);
        $n -> bindValue(":indate",date('Y-m-d H:i:s'),PDO::PARAM_STR);
        $n -> execute();
	}
	
    
    $sql ="SELECT t_network.*,t_user.name,t_user.company from t_network inner join t_user on t_network.uid=t_user.id Where t_network.cancel=0 and t_network.shinsa=1";
    $n = $dbh->prepare($sql);
	$n -> execute();
	$result = $n ->fetchAll(PDO::FETCH_ASSOC);			
					

				$str = "";
				$str = "<markers>\n";
				if ($result){
                    foreach($result as $rsm){	
					    if (!empty($rsm["penname"])){
                            $oname = $rsm["penname"];
                        }elseif ($rsm["companydisp"]==1){
                            $oname = $rsm["company"];
                        }elseif ($rsm["namedisp"]==1){
                            $oname = $rsm["name"];
                        }else{
                            $oname = "";
                        }
						$str .= '<marker id="'.$rsm["id"].'" name="'.$oname.'" address="'.$rsm["address3"].'" lat="'.$rsm["lat"].'" lng="'.$rsm["lng"].'" />'. PHP_EOL;
					}
					
                }		
					$str .= "</markers>";
                    $path = "../photo/network/network_data_feed.xml";
                    file_put_contents($path,$str);
					
	
   

	if ($id !== 0){
		header("location:network_userdisp.php?id=".$id);
	}else{
		$sql = "select max(id) as co from t_network";
        $n = $dbh->prepare($sql);
        $n -> execute();

		$rsmax = $n -> fetch(PDO::FETCH_ASSOC);
		$id = $rsmax["co"];
        header("location:network_userdisp.php?id=".$id);
	}
}

?>

<title>疎開先ネットワーク会員詳細【<?=$kanriName?>】</title>
</head>
<body onLoad="initialize();codeAddress();">
<div id="box" class="kanri">
<?php include("include/header.php")?>
	<div id="main">
		<?php include("include/leftpane.php")?>
		<div id="cnt">
			<h2>疎開先ネットワーク会員詳細</h2>



<div class="block">

	<?php
		if ($id==0){
		?>
        <p>新規「疎開先ネットワーク」会員登録ページです。必要項目を入力してください。</p>
     <?php
        }
	 ?>   
	
	<form action="network_userdisp.php" method="post">
    
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
      <h3>会員情報</h3>
      <?php
      $sql ="select * From t_user Where id=:uid";
      $u = $dbh->prepare($sql);
      $u -> bindValue(":uid",$uid,PDO::PARAM_INT);
      $u -> execute();
      $rsu = $u -> fetch(PDO::FETCH_ASSOC);

      if ($rsu){
      ?>
        <table>   
      <tr>
          <th>お名前</th>
          <td><?=$rsu["name"]?></td>
      </tr> 
      <tr>
          <th>会社名</th>
          <td><?=$rsu["company"]?></td>
      </tr> 
		</table>
    <?php
      }
    ?>    
        
        
        <h3>公開情報</h3>
     <table>   
    <tr>
        <th>お名前</th>
        <td>
        <input type="checkbox" name="name_open" id="name_open" value="1" class="radiochk"<?=checked(rers($rs,"namedisp",""),True)?> /><label for="name_open">お名前の公開が「可」であればチェックを入れてください。</label>
        
        </td>
    </tr>
    <tr>
        <th>公開名</th>
        <td>ペンネームも可としますので、こちらが優先して公開されます。<br />
        <input type="text" name="penname" id="penname" value="<?=rers($rs,"penname","")?>" size="10" /></td>
    </tr>
    <tr>
        <th>法人名</th>
        <td>
        <input type="checkbox" name="company_open" id="company_open" value="1" class="radiochk"<?=checked(rers($rs,"companydisp",""),True)?> /><label for="company_open">法人名の公開が「可」であればチェックを入れてください。</label></td>
    </tr>
    <tr>
        <th>郵便番号<em>（必須）</em></th>
        <td><?php
			
			if (!empty(rers($rs,"zip",""))){
			$zip = explode("-",rers($rs,"zip",""));
			$zip1=$zip[0];
			$zip2=$zip[1];
			}
			?>
        〒<input type="text" name="zip1" id="zip1" value="<?=$zip1?>" class="zip" /> - <input type="text" name="zip2" id="zip2" value="<?=$zip2?>" class="zip" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','state','address','');" />
        
    </tr>
    <tr>
        <th>都道府県<em>（必須）</em></th>
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
        <th>市区町村名<em>（必須）</em></th>
        <td>
        <input type="text" name="address" id="address" value="<?=rers($rs,"address1","")?>" />
        
    </tr>
    <tr>
        <th>以下住所<em>（必須）</em></th>
        <td><input type="text" name="address2" id="address2" value="<?=rers($rs,"address2","")?>" /></td>
    </tr>
    
    <tr>
        <th>対象住所<em>（必須）</em></th>
        <td>〇〇県〇〇郡市まで記載。全公開も可<br />
        <input type="text" name="address3" id="address3" value="<?=rers($rs,"address3","")?>" /></td>
    </tr>
  
    <tr>
        <th>連絡先電話番号<em>（必須）</em></th>
        <td>基本的に非公開<br /><input type="text" name="tel" id="tel" value="<?=rers($rs,"tel","")?>" /></td>
    </tr>
    
    <tr>
        <th>メールアドレス<em>（必須）</em></th>
        <td>基本的に非公開<br /><input type="text" name="email" id="email" value="<?=rers($rs,"email","")?>" /></td>
    </tr>
    
    <tr>
        <th>提供可能種別<em>（必須）</em></th>
        <td>複数選択可<br /><input type="checkbox" name="syubetsu" id="syubetsu1" value="居宅" class="radiochk"<?=checked(rers($rs,"syubetsu",""),"居宅")?> /><label for="syubetsu1">居宅</label><br />
        <input type="checkbox" name="syubetsu" id="syubetsu2" value="畑" class="radiochk"<?=checked(rers($rs,"syubetsu",""),"畑")?> /><label for="syubetsu2">畑</label><br />
        <input type="checkbox" name="syubetsu" id="syubetsu3" value="田んぼ" class="radiochk"<?=checked(rers($rs,"syubetsu",""),"田んぼ")?> /><label for="syubetsu3">田んぼ</label><br />
        <input type="checkbox" name="syubetsu" id="syubetsu4" value="山林" class="radiochk"<?=checked(rers($rs,"syubetsu",""),"山林")?> /><label for="syubetsu4">山林</label><br />
        <input type="checkbox" name="syubetsu" id="syubetsu5" value="雑種地" class="radiochk"<?=checked(rers($rs,"syubetsu",""),"雑種地")?> /><label for="syubetsu5">雑種地</label></td>
    </tr> 

    <tr>
        <th>広さ<em>（必須）</em></th>
        <td><input type="text" name="breadth" id="breadth" value="<?=rers($rs,"space","")?>" style="width:4em;" />㎡<br />
        部屋数 <input type="text" name="heya" id="heya" value="<?=rers($rs,"roomnum","")?>" style="width:4em;" />部屋<br />
        <input type="checkbox" name="ikken" id="ikken" value="1" class="radiochk"<?=checked(rers($rs,"house",""),True)?> /><label for="ikken">一軒家</label></td>
    </tr>
    
    <tr>
        <th>受入れ人数<em>（必須）</em></th>
        <td><input type="text" name="ninzu" id="ninzu" value="<?=rers($rs,"acceptednum","")?>" style="width:4em;" />人まで
        </td>
    </tr>
    
    <tr>
        <th>受入れ性別<em>（必須）</em></th>
        <td><input type="radio" name="sex" id="sex1" value="男性のみ" class="radiochk"<?=checked(rers($rs,"acceptesex",""),"男性のみ")?> /><label for="sex1">男性のみ</label><br />
        <input type="radio" name="sex" id="sex2" value="女性のみ" class="radiochk"<?=checked(rers($rs,"acceptesex",""),"女性のみ")?> /><label for="sex2">女性のみ</label><br />
        <input type="radio" name="sex" id="sex3" value="いずれも可" class="radiochk"<?=checked(rers($rs,"acceptesex",""),"いずれも可")?> /><label for="sex3">いずれも可</label>
        </td>
    </tr>
    
    <tr>
        <th>食料の有無<em>（必須）</em></th>
        <td><input type="checkbox" name="food" id="food1" value="米" class="radiochk"<?=checked(rers($rs,"food",""),"米")?> /><label for="food1">米</label><br />
        <input type="checkbox" name="food" id="food2" value="食料・野菜" class="radiochk"<?=checked(rers($rs,"food",""),"食料・野菜")?> /><label for="food2">食料・野菜</label><br />
        <input type="checkbox" name="food" id="food3" value="魚介類" class="radiochk"<?=checked(rers($rs,"food",""),"魚介類")?> /><label for="food3">魚介類</label><br />
        <input type="checkbox" name="food" id="food4" value="肉類" class="radiochk"<?=checked(rers($rs,"food",""),"肉類")?> /><label for="food4">肉類</label>
        </td>
    </tr>
    
    <tr>
        <th>自家発電システム設置の有無<em>（必須）</em></th>
        <td><input type="radio" name="power" id="power1" value="あり" class="radiochk"<?=checked(rers($rs,"powersystem",""),"あり")?> /><label for="power1">あり</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="power" id="power2" value="なし" class="radiochk"<?=checked(rers($rs,"powersystem",""),"なし")?> /><label for="power2">なし</label><br />
        <input type="radio" name="solar" id="solar1" value="太陽光発電（昼のみ）" class="radiochk"<?=checked(rers($rs,"solarsystem",""),"太陽光発電（昼のみ）")?> /><label for="solar1">太陽光発電（昼のみ）</label><br />
        <input type="radio" name="solar" id="solar2" value="太陽光蓄電（昼夜）" class="radiochk"<?=checked(rers($rs,"solarsystem",""),"太陽光蓄電（昼夜）")?> /><label for="solar2">太陽光蓄電（昼夜）</label>
        </td>
    </tr>
    
    <tr>
        <th>飲料水の有無<em>（必須）</em></th>
        <td><input type="radio" name="well" id="well1" value="あり" class="radiochk"<?=checked(rers($rs,"drink",""),"あり")?> /><label for="well1">あり</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="well" id="well2" value="なし" class="radiochk"<?=checked(rers($rs,"drink",""),"なし")?> /><label for=well2">なし</label><br />
        <input type="radio" name="water" id="water1" value="井戸水あり（飲料可）" class="radiochk"<?=checked(rers($rs,"well",""),"井戸水あり（飲料可）")?> /><label for="water1">井戸水あり（飲料可）</label><br />
        <input type="radio" name="water" id="water2" value="井戸水あり（飲料不可）" class="radiochk"<?=checked(rers($rs,"well",""),"井戸水あり（飲料不可）")?> /><label for="water2">井戸水あり（飲料不可）</label><br />
        </td>
    </tr>
    
    <tr>
        <th>ペット同居の有無<em>（必須）</em></th>
        <td><input type="radio" name="pet" id="pet1" value="あり" class="radiochk"<?=checked(rers($rs,"petliving",""),"あり")?> /><label for="pet1">あり</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="pet" id="pet2" value="なし" class="radiochk"<?=checked(rers($rs,"petliving",""),"なし")?> /><label for="pet2">なし</label>
        </td>
    </tr>
    
    <tr>
        <th>ペットの受入れ<em>（必須）</em></th>
        <td><p><input type="radio" name="petok" id="petok1" value="可" class="radiochk"<?=checked(rers($rs,"petok",""),"可")?> /><label for="petok1">可</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="petok" id="petok2" value="不可" class="radiochk"<?=checked(rers($rs,"petok",""),"不可")?> /><label for="petok2">不可</label></p>
        
        <p>・受入れ可の場合<br /><input type="radio" name="petplace" id="petplace1" value="屋内" class="radiochk"<?=checked(rers($rs,"indoor",""),"屋内")?> /><label for="petplace1">屋内</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="petplace" id="petplace2" value="屋外" class="radiochk"<?=checked(rers($rs,"indoor",""),"屋外")?> /><label for="petplace2">屋外</label></p>
        <p>・ペットのサイズ<br /><input type="radio" name="petsize" id="petsize1" value="小型のみ" class="radiochk"<?=checked(rers($rs,"petsize",""),"小型のみ")?> /><label for="petsize1">小型のみ</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="petsize" id="petsize2" value="大型可" class="radiochk"<?=checked(rers($rs,"petsize",""),"大型可")?> /><label for="petsize2">大型可</label></p>
        </td>
    </tr>
    
    <tr>
        <th>宿泊費の有償・無償<em>（必須）</em></th>
        <td><p><input type="radio" name="price" id="price1" value="無償" class="radiochk"<?=checked(rers($rs,"stayfee",""),"無償")?> /><label for="price1">無償</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="price" id="price2" value="有償" class="radiochk"<?=checked(rers($rs,"stayfee",""),"有償")?> /><label for="price2">有償</label></p>
        
        <p>・有償の場合<br />1泊 <input type="text" name="fee" id="fee" value="<?=rers($rs,"staycharge","")?>" style="width:4em;" />円　～　ご相談</p>
        
        </td>
    </tr>
    
     <tr>
        <th>食事の提供<em>（必須）</em></th>
        <td><p><input type="radio" name="meal" id="meal1" value="無償" class="radiochk"<?=checked(rers($rs,"meal",""),"無償")?> /><label for="meal1">無償</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="meal" id="meal2" value="有償" class="radiochk"<?=checked(rers($rs,"meal",""),"有償")?> /><label for="meal2">有償</label></p>
        
        <p>・有償の場合<br />1食 <input type="text" name="mealfee" id="mealfee" value="<?=rers($rs,"mealcharge","")?>" style="width:4em;" />円　～　ご相談</p>
        
        </td>
    </tr>
        
        
        <tr>
        	<th>使用</th>
            <td>
            <?php
			if (rers($rsu,"taikai","")==1){
			?>
            <p class="red">こちらの会員は退会済みです。</p>
            <?php
            }
			?>
            <ul class="inline">
	            <li><label for="disp0"><input type="radio" name="disp" id="disp0" value="0"<?=checked(0,rers($rs,"cancel",""))?> /> 使用可</label></li>
	            <li><label for="disp1"><input type="radio" name="disp" id="disp1" value="1"<?=checked(1,rers($rs,"cancel",""))?> /> 使用不可</label></li>
            </ul>
            </td>
        </tr>
        
       
        <tr>
        	<th>登録日</th>
            <td>
            <?=rers($rs,"indate",date('Y-m-d H:i:s'))?>
            </td>
        </tr>

       
    
<?php
			if (rers($rsu,"taikai","")==0){
			?>
        <tr>
        	<th>退会</th>
            <td>
            <input type="button" value="強制退会" name="taikaiset" id="taikaiset" /><br />※強制退会させると、再登録できません
            </td>
		</tr>
<?php
            }
			?>		
        
        
        </table>
        <input type="hidden" name="lat" id="lats" value="" />
        <input type="hidden" name="lng" id="lngs" value="" />
		<p><input type="submit" value="登録" name="change" /></p>
        
        
	</form>
    
    <div id="map_canvas" style="width:650px;height:500px;"></div>

</div>

		</div>

	</div>
</div>


</body>
</html>
