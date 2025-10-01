<?php $siteid=60?>
<?php include("include/autometa.php");?>
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCss1VhMGIWmeGRIF1_Vw37911EjQIo4Uc"></script>

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
</head>

<body onLoad="initialize();codeAddress();">




	<div id="cnt2">

<h2>「疎開先ネットワーク」詳細</h2>
<?php
$sql="SELECT t_user.name,t_user.company,t_network.* From t_user inner join t_network on t_user.id=t_network.uid Where t_network.id=:id and t_network.shinsa=1 and t_network.cancel=0";
$n = $dbh->prepare($sql);
$n -> bindValue(":id",$_GET["id"],PDO::PARAM_INT);
$n -> execute();
$rs = $n -> fetch(PDO::FETCH_ASSOC);

if (!empty($rs)){
?>
<div class="block">
<dl>
<dt>会社名</dt>
<dd><?php
if ($rs["companydisp"]==true){
echo $rs["company"];
}else{
echo "非公開";
}
?></dd>
</dl>

<dl>
<dt>名前</dt>
<dd><?php
if (!empty($rs["penname"])){
echo $rs["penname"];
}elseif ($rs["namedisp"]==1){
echo $rs["name"];
}else{
echo "非公開";
}
?></dd>
</dl>

<dl>
<dt>公開住所</dt>
<dd><?=$rs["address3"]?><input type="hidden" name="address3" id="address3" value="<?=$rs["address3"]?>"></dd>
</dl>

<dl>
<dt>提供可能種別</dt>
<dd><?=$rs["syubetsu"]?></dd>
</dl>

<dl>
<dt>広さ</dt>
<dd>広さ：<?php
if (!empty($rs["space"])){echo number_format($rs["spance"]) . "㎡";}?><br>
<?php if ($rs["roomnum"]!==0){echo "部屋数：" . $rs["roomnum"]. "部屋<br>";}?>
<?php if ($rs["house"]==1){echo "一軒家";}?>
</dd>
</dl>

<dl>
<dt>受け入れ人数</dt>
<dd><?=$rs["acceptednum"]?>人</dd>
</dl>

<dl>
<dt>受入れ性別</dt>
<dd><?=$rs["acceptesex"]?></dd>
</dl>

<dl>
<dt>食料の有無</dt>
<dd><?=$rs["food"]?></dd>
</dl>

<dl>
<dt>自家発電システム設置の有無</dt>
<dd><?=$rs["powersystem"]?>
<?php if (!empty($rs["solarsystem"])){echo "<br>".$rs["solarsystem"];}?></dd>
</dl>

<dl>
<dt>飲料水の有無</dt>
<dd><?=$rs["drink"]?>
<?php if (!empty($rs["well"])){echo "<br>".$rs["well"];}?></dd>
</dl>

<dl>
<dt>ペット同居の有無</dt>
<dd><?=$rs["petliving"]?>
</dd>
</dl>

<dl>
<dt>ペットの受入れ</dt>
<dd>
<?=$rs["petok"]?>
<?php if (!empty($rs["indoor"])){echo "<br>".$rs["indoor"];}?>
<?php if (!empty($rs["petsize"])){echo "<br>".$rs["petsize"];}?>
</dd>
</dl>

<dl>
<dt>宿泊費の有償・無償</dt>
<dd>
<?=$rs["stayfee"]?>
<?php if (!empty($rs["staycharge"])){echo "<br>1泊：" .number_format($rs["staycharge"]). "円 ～ご相談";}?>
</dd>
</dl>

<dl>
<dt>食事の提供</dt>
<dd>
<?=$rs["meal"]?>
<?php if (!empty($rs["mealcharge"])){echo "<br>1泊：" .number_format($rs["mealcharge"]). "円 ～ご相談";}?>
</dd>
</dl>

	</div>

<div class="block">
<p class="centering"><a href="chat/index.php?id=<?=$rs["id"]?>" class="btn">チャットを始める</a></p>
</div>

<div class="block">
<div id="map_canvas" style="width:100%; height:450px;"></div>
</div>


<div class="block">
<p class="centering"><a href="inq_01.php?id=<?=$rs["id"]?>" class="btn">提供者へ問合せ</a></p>
</div>

<input type="hidden" name="lat" id="lat" value="<?=$rs["lat"]?>">
<input type="hidden" name="lng" id="lng" value="<?=$rs["lng"]?>">

<?php
}
?>

<!-- id cnt2 end --></div>



</body>
</html>
