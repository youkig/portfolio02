<?php
//予約済みデータの集計
$yd = array_fill(0, 32, 0); // 0で初期化
$yn = array_fill(0, 32, 0);
//$sql="SELECT count(ydate) as co,ydate From t_yasaigari02 Where ydate>='" & tmonth &"/01"& "' and ydate<'" & dateserial(year(nextmonth),month(nextmonth),1)& "' and cancel=0 group by ydate order by ydate"
$sql="SELECT count(ydate) as co,ydate From t_yasaigari02 Where ydate>=:tmonth and ydate<:edate and cancel=0 group by ydate order by ydate";
$y = $dbh->prepare($sql);
$y -> bindValue(":tmonth",date('Y-m-d',strtotime($tmonth.'-01')),PDO::PARAM_STR);
$y -> bindValue(":edate",date('Y-m-d', strtotime($nextmonth . '-01')),PDO::PARAM_STR);
$y -> execute();
$result = $y->fetchAll(PDO::FETCH_ASSOC);
if (!empty($result)){
    foreach($resulr as $rsy){

        $d=date('d',strtotime($rsy["ydate"]));
        $yd[$d]=$rsy["ydate"];
        $yd[$d]=$rsy["co"];
    }
}

//臨時休業日を取得

//$sql="SELECT * From t_temporary_close Where rdate>='" & tmonth &"/01"& "' and rdate<'" & dateserial(year(nextmonth),month(nextmonth),1)& "' and cancel=0"
$sql="SELECT * From t_temporary_close Where rdate>=:tmonth and rdate<:edate and cancel=0";
$c = $dbh->prepare($sql);
$c -> bindValue(":tmonth",date('Y-m-d',strtotime($tmonth.'-01')),PDO::PARAM_STR);
$c -> bindValue(":edate",date('Y-m-d', strtotime($nextmonth . '-01')),PDO::PARAM_STR);
$c -> execute();

$result = $c->fetchAll(PDO::FETCH_ASSOC);

$r = "";
if (!empty($result)){
    foreach($result as $key=>$rinji){
        $r .= date('d',strtotime($rinji["rdate"]));
        if($key !== array_key_last($result)){
            $r .= ",";
        }
    }

}

//'祝日の取得
$TargetYear = date('Y',strtotime($today));
$Targetmonth = date('m',strtotime($tmonth));

$Targetdate = $TargetYear . "-" . $Targetmonth . "-1T00:00:00+09:00";
$Targetlastdate = $TargetYear . "-" . $Targetmonth . "-" . $lastday . "T00:00:00+09:00";

$api = "APIkey";
$holiday_id = "ja.japanese#holiday@group.v.calendar.google.com";
$url = "https://www.googleapis.com/calendar/v3/calendars/" . urlencode($holiday_id) . "/events?orderBy=startTime&singleEvents=true";
$url .= "&timeMin=" . urlencode($Targetdate);
$url .= "&timeMax=" . urlencode($Targetlastdate);
$url .= "&key=" . $api;

// 初期化
$ch = curl_init();

// オプション設定
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 実行
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
    exit;
}

curl_close($ch);

$result = json_decode($response);

foreach($result->items as $row){
    // [予定の日付 => 予定のタイトル]
    $results[$row->start->date] = $row->summary;
}

$darray = array();
$sarray = array();
foreach($results as $key=>$val){
    array_push($darray,$key);
    array_push($sarray,$val);
}


?>