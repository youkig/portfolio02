<?php $siteid=61?>
<?php include("include/autometa.php");?>
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCss1VhMGIWmeGRIF1_Vw37911EjQIo4Uc"></script>

<script>

$(function(){
//JSONファイル読み込み開始
$.ajax({
url:"photo/network/network_data_feed.xml",
cache:false,
dataType:"xml",
success:function(xml){
var data=xmlRequest(xml);
initialize(data);
}
});
});

function OnLinkClick(id){
window.open('network_details.php?id='+ id,'win', 'width=770, height=600, menubar=no, toolbar=no, scrollbars=yes');
}

function OnChatClick(id){
window.open('chat/index.php?id='+ id,'win', 'width=770, height=600, menubar=no, toolbar=no, scrollbars=yes');
}

// XMLファイル読み込み完了
function xmlRequest(xml){
var data=[];
$(xml).find("markers > marker").each(function(){
var dat={};
dat.lat=this.getAttribute("lat");
dat.lng=this.getAttribute("lng");
dat.id=this.getAttribute("id");

var penname="";
if(this.getAttribute("name")==''){
penname="匿名";
}else{
penname=this.getAttribute("name");
}

var comment=""
if(this.getAttribute("comment")!=''){
	comment=comment+"<br><a href='javascript:void(0);' onclick='OnLinkClick(" + dat.id + ");' class='inqbtn'>"+penname+"様の情報を見る</a>";
comment=comment+"<br><a href='javascript:void(0);' onclick='OnChatClick(" + dat.id + ");' class='inqbtn'>チャットを要求</a>";
}


var textdata="<span class='bold'>"+penname+"様"+comment;


dat.content=textdata;

$(this).children().each(function(){
if(this.childNodes.length>0)dat[this.tagName]=this.childNodes[0].nodeValue;
});
data.push(dat);
});
return data;
}

// Attach Message
//function attach_message( map, marker, msg, iw ){
//google.maps.event.addListener(marker, 'click', function( event ){
//iw.setContent( msg );iw.open(map, marker);});
//}

function attach_message( map, marker, msg, iw ){
//google.maps.event.addListener(marker, 'click', function( event ){
//iw.setContent( msg );iw.open(map, marker);});
google.maps.event.addListener(marker, 'click', function( event ){
iw.setContent( msg );iw.open(map, marker);
});

//google.maps.event.addListener(marker, 'mouseout', function( event ){
//          iw.close();
//});
}

function initialize(data){
var latp = document.getElementById("lat").value;
var lngp = document.getElementById("lng").value;
var opts={
zoom:5,
streetViewControl: false,
center:new google.maps.LatLng(latp,lngp),
scrollwheel: true,
mapTypeId:google.maps.MapTypeId.ROADMAP
};
var map=new google.maps.Map(document.getElementById("mapCanvas"),opts);

var iwopts = {
//content: 'Hello',

maxWidth: 250
// positon: latlng
};

var iw  = new google.maps.InfoWindow(iwopts);

if (data != null) {
var i=data.length;
}

while(i-- >0){
var dat=data[i];
var obj={
position:new google.maps.LatLng(dat.lat,dat.lng),
map:map,
icon: "img/recruitment/logo.png"
	
};

var marker=new google.maps.Marker(obj);


attach_message(map, marker, dat.content,iw);

//マップクリックイベントを追加
//google.maps.event.addListener(map, 'click', function(e) {
//インフォウィンドウを消去
//iw.close();
//});

}
}

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
	<div id="cnt" class="company network">

	<p class="pankuzu"><a href="<?=$esurl?>">トップページ</a> | 有事の際の「疎開先ネットワーク」 提供者一覧</p>
	<div class="block">
	<h2><img src="img/recruitment/h2_02.jpg" alt="有事の際の「疎開先ネットワーク」 提供者一覧" width="780" height="205"></h2>

</div>

<div class="block">
<div id="mapCanvas" style="width:100%; height:650px;"></div>
</div>



<?php
	$lat=36.674983;
	$lng=137.456772;
?>
<input type="hidden" name="lat" id="lat" value="<?=$lat?>">
<input type="hidden" name="lng" id="lng" value="<?=$lng?>">

<h3>有事の際の「疎開先ネットワーク」 提供者一覧</h3>

<?php
$sql="SELECT t_user.name,t_user.company,t_network.* From t_user inner join t_network on t_user.id=t_network.uid Where t_network.shinsa=1 and t_network.cancel=0 order by t_network.state";
$n = $dbh->prepare($sql);
$n -> execute();
$result = $n->fetchAll(PDO::FETCH_ASSOC);
if (!empty($result)){
?>
<table>
<thead>
<tr>
<th>詳細</th>
<th style="width:40%">住所</th>
<th style="width:30%">会社名</th>
<th style="width:20%">名前</th>
</tr>
</thead>

<tbody>
<?php
foreach($result as $rs){
?>
<tr>
<td><input type="button" value="詳細" onclick="OnLinkClick(<?=$rs['id']?>)"></td>
<td><a href="javascript:void(0);" onclick="OnLinkClick(<?=$rs['id']?>)" class="inqbtn underline"><?=$rs["address3"]?></a></td>
<td><?php
if ($rs["companydisp"]==1){
echo $rs["company"];
}else{
echo "非公開";
}
?></td>
<td><?php
if (!empty($rs["penname"])){
echo $rs["penname"];
}elseif ($rs["namedisp"]==1){
echo $rs["name"];
}else{
echo "非公開";
}
?></td>
</tr>
<?php
}
?>
</tbody>
</table>

<?php
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
