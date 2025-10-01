<?php
include("../../config.php");

$newid = cnum($_GET["newid"]);
$faqid = cnum($_GET["faqid"]);
$b1id = cnum($_GET["b1id"]);
$b2id = cnum($_GET["b2id"]);
$makerid = cnum($_GET["makerid"]);
$oid1 = cnum($_GET["oid1"]);
$oid2 = cnum($_GET["oid2"]);
$goodsid = cnum($_GET["goodsid"]);
$memid = cnum($_GET["memid"]);
$sid = cnum($_GET["sid"]);
$cancelid = cnum($_GET["cancelid"]);
$cancelid2 = cnum($_GET["cancelid2"]);
$uid = cnum($_GET["uid"]);
$specid = cnum($_GET["specid"]);
$rentalid = cnum($_GET["rentalid"]);
$pcancelid = cnum($_GET["pcancelid"]);
$pcancelid2 = cnum($_GET["pcancelid2"]);
$reserveday = renull($_GET["reserveday"]);
$ruid = cnum($_GET["ruid"]);
$rsid = cnum($_GET["rsid"]);
$rid = cnum($_GET["rid"]);
$proseid = cnum($_GET["proseid"]);
$faqcateid = cnum($_GET["faqcateid"]);
$faqid = cnum($_GET["faqid"]);

$nreserveday = renull($_GET["nreserveday"]);
$nruid = cnum($_GET["nruid"]);
$nrsid = cnum($_GET["nrsid"]);
$nrid = cnum($_GET["nrid"]);

$cleanid = cnum($_GET["clean"]);

if ($newid !== 0) {
	$sql = "select * from t_news where id = :newid";
	$n = $dbh->prepare($sql);
	$n->bindValue(":newid", $newid, PDO::PARAM_INT);
	$n->execute();
	$rs = $n->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "DELETE FROM t_news WHERE id = :newid";
		$n = $dbh->prepare($sql);
		$n->bindValue(":newid", $newid, PDO::PARAM_INT);
		$n->execute();
		echo "success";
	}
}




if ($b2id !== 0) {
	$sql = "select * from t_bunrui2 where id = :b2id";
	$b2 = $dbh->prepare($sql);
	$b2->bindValue(":b2id", $b2id, PDO::PARAM_INT);
	$b2->execute();
	$rs = $b2->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "DELETE FROM t_bunrui2 WHERE ID = :b2id";
		$b2 = $dbh->prepare($sql);
		$b2->bindValue(":b2id", $b2id, PDO::PARAM_INT);
		$b2->execute();
		echo "success";
	}
}


if ($sid !== 0) {
	$sql = "select * from t_master where id = :sid";
	$m = $dbh->prepare($sql);
	$m->bindValue(":sid", $sid, PDO::PARAM_INT);
	$m->execute();

	$rs = $m->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "DELETE FROM t_master WHERE id = :sid";
		$m = $dbh->prepare($sql);
		$m->bindValue(":sid", $sid, PDO::PARAM_INT);
		$m->execute();
		$uploadFolder = "../../photo/goods/";
		for ($a = 1; $a <= 4; $a++) {
			if (!empty($rs["image" . $a])) {
				unlink($uploadFolder . $rs["image" . $a]);
			}
		}
		echo "success";
	}
}



if ($goodsid !== 0) {
	$sql = "select * from t_master where id = :goodsid";
	$g = $dbh->prepare($sql);
	$g->bindValue(":goodsid", $goodsid, PDO::PARAM_INT);
	$g->execute();
	$rs = $g->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "UPDATE t_master set disp3=0 WHERE id = :goodsid";
		$g = $dbh->prepare($sql);
		$g->bindValue(":goodsid", $goodsid, PDO::PARAM_INT);
		$g->execute();
		echo "success";
	}
}

if ($memid !== 0) {
	$sql = "select * from t_user where id = :memid";
	$g = $dbh->prepare($sql);
	$g->bindValue(":memid", $memid, PDO::PARAM_INT);
	$g->execute();
	$rs = $g->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "DELETE FROM t_user WHERE id = :memid";
		$g = $dbh->prepare($sql);
		$g->bindValue(":memid", $memid, PDO::PARAM_INT);
		$g->execute();
		echo "success";
	}
}


if ($cancelid !== 0) {
	$sql = "select * from t_yasaigari01 where id = :cancelid";
	$g = $dbh->prepare($sql);
	$g->bindValue(":cancelid", $cancelid, PDO::PARAM_INT);
	$g->execute();
	$rs = $g->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "UPDATE t_yasaigari01 set cancel=1 WHERE id = :cancelid";
		$g = $dbh->prepare($sql);
		$g->bindValue(":cancelid", $cancelid, PDO::PARAM_INT);
		$g->execute();

		$sql = "UPDATE t_yasaigari02 set cancel=1 WHERE id = :uid";
		$g = $dbh->prepare($sql);
		$g->bindValue(":uid", $uid, PDO::PARAM_INT);
		$g->execute();
		echo "success";
	}
}


if ($cancelid2 !== 0) {
	$sql = "select * from t_yasaigari01 where id = :cancelid2";
	$g = $dbh->prepare($sql);
	$g->bindValue(":cancelid", $cancelid, PDO::PARAM_INT);
	$g->execute();
	$rs = $g->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "UPDATE t_yasaigari01 set cancel=0 WHERE id = :cancelid2";
		$g = $dbh->prepare($sql);
		$g->bindValue(":cancelid2", $cancelid2, PDO::PARAM_INT);
		$g->execute();

		$sql = "UPDATE t_yasaigari02 set cancel=0 WHERE id = :uid";
		$g = $dbh->prepare($sql);
		$g->bindValue(":uid", $uid, PDO::PARAM_INT);
		$g->execute();
		echo "success";
	}
}


if ($specid !== 0) {
	$sql = "select * from t_spec where id = :specid";
	$g = $dbh->prepare($sql);
	$g->bindValue(":specid", $specid, PDO::PARAM_INT);
	$g->execute();
	$rs = $g->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "DELETE FROM t_spec WHERE id = :specid";
		$g = $dbh->prepare($sql);
		$g->bindValue(":specid", $specid, PDO::PARAM_INT);
		$g->execute();
		echo "success";
	}
}

if ($rentalid !== 0) {
	$sql = "select * from t_product where id = :rentalid";
	$g = $dbh->prepare($sql);
	$g->bindValue(":rentalid", $rentalid, PDO::PARAM_INT);
	$g->execute();
	$rs = $g->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "DELETE FROM t_product WHERE id = :rentalid";
		$g = $dbh->prepare($sql);
		$g->bindValue(":rentalid", $rentalid, PDO::PARAM_INT);
		$g->execute();

		if (!empty($rs["image1"])) {
			$image_path = "../photo/product/" . $rs["image1"];
			unlink($image_path);
		}
		echo "success";
	}
}


if ($pcancelid !== 0) {
	$sql = "select * from t_productorder where id = :pcancelid";
	$g = $dbh->prepare($sql);
	$g->bindValue(":rentalid", $rentalid, PDO::PARAM_INT);
	$g->execute();
	$rs = $g->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "UPDATE t_productorder set cancel = 1 WHERE id = :pcancelid";
		$g = $dbh->prepare($sql);
		$g->bindValue(":pcancelid", $pcancelid, PDO::PARAM_INT);
		$g->execute();
		$sql = "UPDATE t_preserveday set cancel = 1 WHERE uid = :pcancelid";
		$g = $dbh->prepare($sql);
		$g->bindValue(":pcancelid", $pcancelid, PDO::PARAM_INT);
		$g->execute();
		echo "success";
	}
}

if ($pcancelid2 !== 0) {
	$sql = "select * from t_productorder where id = :pcancelid2";
	$g = $dbh->prepare($sql);
	$g->bindValue(":pcancelid2", $pcancelid2, PDO::PARAM_INT);
	$g->execute();
	$rs = $g->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "UPDATE t_productorder set cancel = 0 WHERE id = :pcancelid2";
		$g = $dbh->prepare($sql);
		$g->bindValue(":pcancelid2", $pcancelid2, PDO::PARAM_INT);
		$g->execute();
		$sql = "UPDATE t_preserveday set cancel = 0 WHERE uid = :pcancelid2";
		$g = $dbh->prepare($sql);
		$g->bindValue(":pcancelid2", $pcancelid2, PDO::PARAM_INT);
		$g->execute();
		echo "success";
	}
}

if (!empty($reserveday) && $ruid !== 0 && $rsid !== 0) {
	$sql = "select * from t_preserveday where reserveday = :reserveday AND uid=:ruid AND sid = :rsid";
	$g = $dbh->prepare($sql);
	$g->bindValue(":reserveday", $reserveday, PDO::PARAM_STR);
	$g->bindValue(":ruid", $ruid, PDO::PARAM_INT);
	$g->bindValue(":sid", $rsid, PDO::PARAM_INT);
	$g->execute();
	$rs = $g->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "UPDATE t_preserveday set cancel = 1 where reserveday = :reserveday AND uid=:ruid AND sid = :rsid";
		$g = $dbh->prepare($sql);
		$g->bindValue(":reserveday", $reserveday, PDO::PARAM_STR);
		$g->bindValue(":ruid", $ruid, PDO::PARAM_INT);
		$g->bindValue(":sid", $rsid, PDO::PARAM_INT);
		$g->execute();


		$sql = "SELECT count(reserveday) as co From t_preserveday inner join t_proreserved on t_preserveday.uid = t_proreserved.uid Where t_proreserved.id=:rid and t_proreserved.sid= :rsid and t_preserveday.cancel=0";
		$g = $dbh->prepare($sql);
		$g->bindValue(":rid", $rid, PDO::PARAM_INT);
		$g->bindValue(":rsid", $rsid, PDO::PARAM_INT);
		$g->execute();
		$rsc = $g->fetch(PDO::FETCH_ASSOC);


		$sql = "SELECT price1,price2 From t_product Where id=:rsid";
		$g = $dbh->prepare($sql);
		$g->bindValue(":rsid", $rsid, PDO::PARAM_INT);
		$g->execute();
		$rsp = $g->fetch(PDO::FETCH_ASSOC);
		if (!empty($rsp)) {
			$clean = "";
			if ($rsc["co"] == 0) {
				$price = 0;
			} elseif ($rsc["co"] == 1) {
				$price = $rsp["price1"];
			} elseif ($rsc["co"] > 1) {
				$price = $rsp["price2"] * $rsc["co"];
			}
			if ($rsc["co"] === 0) {
				$clean = ",cleaning = 0";
			}
			$sql = "UPDATE t_proreserved set price=:price";
			if ($rsc["co"] === 0) {
				$sql .= ",cleaning = 0";
			}
			$sql .= " Where id=:rid";
			$g = $dbh->prepare($sql);
			$g->bindValue(":price", $price, PDO::PARAM_INT);
			$g->bindValue(":rid", $rid, PDO::PARAM_INT);
			$g->execute();
		}

		echo "success";
	}
}

if (!empty($nreserveday) && $nruid !== 0 && $nrsid !== 0) {
	$sql = "select * from t_preserveday where reserveday = :nreserveday AND uid=:nruid AND sid =:nrsid";
	$g = $dbh->prepare($sql);
	$g->bindValue(":nreserveday", $nreserveday, PDO::PARAM_INT);
	$g->bindValue(":nruid", $nruid, PDO::PARAM_INT);
	$g->bindValue(":nrsid", $nrsid, PDO::PARAM_INT);
	$g->execute();
	$rs = $g->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "UPDATE t_preserveday set cancel = 0 where reserveday = :nreserveday AND uid=:nruid AND sid =:nrsid";
		$g = $dbh->prepare($sql);
		$g->bindValue(":nreserveday", $nreserveday, PDO::PARAM_INT);
		$g->bindValue(":nruid", $nruid, PDO::PARAM_INT);
		$g->bindValue(":nrsid", $nrsid, PDO::PARAM_INT);
		$g->execute();

		$sql = "SELECT count(reserveday) as co From t_preserveday inner join t_proreserved on t_preserveday.uid = t_proreserved.uid Where t_proreserved.id=:nrid and t_proreserved.sid=:nrsid and t_proreserved.uid=:nruid and t_preserveday.cancel=0";
		$g = $dbh->prepare($sql);
		$g->bindValue(":nruid", $nruid, PDO::PARAM_INT);
		$g->bindValue(":nrsid", $nrsid, PDO::PARAM_INT);
		$g->execute();
		$rsc = $g->fetch(PDO::FETCH_ASSOC);


		$sql = "SELECT price1,price2 From t_product Where id=:nrsid";
		$g = $dbh->prepare($sql);
		$g->bindValue(":nrsid", $nruid, PDO::PARAM_INT);
		$g->execute();
		$rsp = $g->fetch(PDO::FETCH_ASSOC);

		if (!empty($rsp)) {
			$clean = "";
			if ($rsc["co"] == 0) {
				$price = 0;
			} elseif ($rsc["co"] == 1) {
				$price = $rsp["price1"];
			} elseif ($rsc["co"] > 1) {
				$price = $rsp["price2"] * $rsc["co"];
			}

			$sql = "UPDATE t_proreserved set price=:price";
			if ($rsc["co"] == 0) {
				$sql .= ",cleaning = 0";
			}
			$sql .= " Where id=:nrid";
			$g = $dbh->prepare($sql);
			$g->bindValue(":nrid", $nrid, PDO::PARAM_INT);
			$g->execute();
		}
	}
}


if ($cleanid !== 0) {
	$sql = "select * from t_proreserved where id = :cleanid";
	$g = $dbh->prepare($sql);
	$g->bindValue(":cleanid", $cleanid, PDO::PARAM_INT);
	$g->execute();
	$rs = $g->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		if ($rs["cleaning"] == 1) {
			$sql = "UPDATE t_proreserved set cleaning = 0 WHERE id = :cleanid";
			$g = $dbh->prepare($sql);
			$g->bindValue(":cleanid", $cleanid, PDO::PARAM_INT);
			$g->execute();
		} else {
			$sql = "UPDATE t_proreserved set cleaning = 1 WHERE id = :cleanid";
			$g = $dbh->prepare($sql);
			$g->bindValue(":cleanid", $cleanid, PDO::PARAM_INT);
			$g->execute();
		}
		echo "success";
	}
}


if ($proseid !== 0) {
	$sql = "select * from t_prose where id = :proseid";
	$n = $dbh->prepare($sql);
	$n->bindValue(":proseid", $proseid, PDO::PARAM_INT);
	$n->execute();
	$rs = $n->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "DELETE FROM t_prose WHERE id = :proseid";
		$n = $dbh->prepare($sql);
		$n->bindValue(":proseid", $proseid, PDO::PARAM_INT);
		$n->execute();
		echo "success";
	}
}

if ($faqcateid !== 0) {
	$sql = "select * from t_faq_category where id = :faqcateid";
	$n = $dbh->prepare($sql);
	$n->bindValue(":faqcateid", $faqcateid, PDO::PARAM_INT);
	$n->execute();
	$rs = $n->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "DELETE FROM t_faq_category WHERE id = :faqcateid";
		$n = $dbh->prepare($sql);
		$n->bindValue(":faqcateid", $faqcateid, PDO::PARAM_INT);
		$n->execute();
		echo "success";
	}
}

if ($faqid !== 0) {
	$sql = "select * from t_faq where id = :faqid";
	$n = $dbh->prepare($sql);
	$n->bindValue(":faqid", $faqid, PDO::PARAM_INT);
	$n->execute();
	$rs = $n->fetch(PDO::FETCH_ASSOC);
	if (!empty($rs)) {
		$sql = "DELETE FROM t_faq WHERE id = :faqid";
		$n = $dbh->prepare($sql);
		$n->bindValue(":faqid", $faqid, PDO::PARAM_INT);
		$n->execute();
		echo "success";
	}
}
