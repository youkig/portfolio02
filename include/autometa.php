<?php

//DB接続

try{
    $dbh = new PDO('mysql:host=mysql80.salmonyak7.sakura.ne.jp;dbname=salmonyak7_autometa','salmonyak7_autometa','Ja5pc9nTuMg');
} catch (PDOException $e) {
     echo "接続失敗: ". $e->getMessage(). "\n";
    exit();
}

$sql="select title From seo_title Where siteid=:siteid";
$title = $dbh->prepare($sql);
$title->bindValue(':siteid',$siteid,PDO::PARAM_INT);
$title->execute();
if($resule = $title->fetch(PDO::FETCH_ASSOC)){
	$n_title=$resule['title'];
}

$sql="select disc From seo_disc Where siteid=:siteid";
$disc = $dbh->prepare($sql);
$disc->bindValue(':siteid',$siteid,PDO::PARAM_INT);
$disc->execute();
if($resule = $disc->fetch(PDO::FETCH_ASSOC)){
	$n_description=$resule['disc'];
}

$sql="select keyword From seo_keyword Where siteid=:siteid";
$keyword = $dbh->prepare($sql);
$keyword->bindValue(':siteid',$siteid,PDO::PARAM_INT);
$keyword->execute();
if($resule = $keyword->fetch(PDO::FETCH_ASSOC)){
	$n_keyword=$resule['keyword'];
}

$sql="select h1 From seo_h1 Where siteid=:siteid";
$h1 = $dbh->prepare($sql);
$h1->bindValue(':siteid',$siteid,PDO::PARAM_INT);
$h1->execute();
if($resule = $h1->fetch(PDO::FETCH_ASSOC)){
	$n_h1=$resule['h1'];
}

$sql="select h5 From seo_h5 Where siteid=:siteid";
$h5 = $dbh->prepare($sql);
$h5->bindValue(':siteid',$siteid,PDO::PARAM_INT);
$h5->execute();
if($resule = $h5->fetch(PDO::FETCH_ASSOC)){
	$n_h5=$resule['h5'];
}

?>