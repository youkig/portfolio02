<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<?php include("../config.php"); ?>

<?php
$userid2 = $_COOKIE["adminlogin"];
$password2 = $_COOKIE["adminpasswd"];
if (control_login($userid2, $password2) === false) {
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
    <?php include("include/js.php"); ?>
    <script src="https://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3-https.js" charset="UTF-8"></script>

    <script type="text/javascript">
        $(function() {
            $("#printsheet_bth").click(function() {
                window.print();
                document.printform.submit();
            });
        });
    </script>

    <?php

    $id = cnum($_REQUEST["id"]);
    if ($id !== 0) {
        $sql = "select * from t_cuser where id = :id";
        $c = $dbh->prepare($sql);
        $c->bindValue(":id", $id, PDO::PARAM_INT);
        $c->execute();
        $rs = $c->fetch(PDO::FETCH_ASSOC);
    }

    ?>
    <style type="text/css">
        <!--
        @media print {


            #box3 #cnt3.print_sheet input.noprint {
                display: none;
            }
        }
        -->
    </style>
    <?php
    if (cnum($_REQUEST["t"]) == 2) {
        $chohyou = "納品書";
        $text = "下記の通り、納品いたします。";
    } elseif (cnum($_REQUEST["t"]) == 1) {
        $chohyou = "請求書";
        $text = "下記の通り、ご請求申し上げます。";
} elseif (cnum($_REQUEST["t"]) == 3) {
        $chohyou = "見積書";
        $text = "下記の通り、お見積書いたします。";
    } else {
        $chohyou = "領収書";
        $text = "下記、正に領収いたしました。";
    }
    ?>

    <title><?= $_POST["name"] ?>様　<?= $chohyou ?>【東浪見岡本農園】</title>
</head>

<body>
    <div id="box3" class="kanri">



        <div id="cnt3" class="print_sheet">






            <h3><?= $chohyou ?></h3>

            <form action="print_sheet03.php" method="post" name="printform" id="printform">
                <input type="hidden" name="id" value="<?= $id ?>" />
                <input type="hidden" name="mid" value="<?= $_POST["mid"] ?>" />

                <input type="hidden" name="counttr" value="<?= cnum($_POST["counttr"]) ?>" />
                <input type="hidden" name="t" value="<?= $_POST["t"] ?>" />

                <div class="block container">
                    <div class="leftbox">

                        <p class="cname"><?= $_POST["name"] ?> 様</p>
                        <input type="hidden" name="name" value="<?= $_POST["name"] ?>" />
                        <p style="margin-bottom:20px;"><?= $text ?></p>

                        <table class="titles">
                            <tr>
                                <th>件名</th>
                                <td><?= $_POST["subtitle"] ?><input type="hidden" name="subtitle" value="<?= $_POST["subtitle"] ?>" /></td>
                            </tr>
                        </table>
                        <?php

                        $syoukei = 0;
                        for ($i = 1; $i <= $_POST["counttr"]; $i++) {
                            $syoukei += (cnum($_POST["kazu" . $i]) * cnum($_POST["tanka" . $i]));
                        }

                        $total_price = $syoukei;
                        ?>
                        <table class="totalprice">
                            <tr>
                                <th>合計金額</th>
                                <td class="price">￥<?php
                                                    echo number_format(cnum($_POST["total_price"]));
                                                    ?>

                                </td>
                                <td class="zei">（税込）</td>
                            </tr>
                        </table>

                    </div>

                    <div class="rightbox">
                        <input type="hidden" name="newregi" value="<?= $_POST["newregi"] ?>" />
                        <p><?= $chohyou ?>No.
                            <?php
                            if (!empty($_POST["newregi"])) {
                            } elseif (!empty($_POST["rno"])) {
                                echo $_POST["rno"]; ?><input type="hidden" name="rno" value="<?= $_POST["rno"] ?>" />
                            <?php
                            } elseif (cnum($_POST["id"]) == 0) {
                                $sql = "SELECT max(id) as maxid From t_receipt_master";
                                $m = $dbh->prepare($sql);
                                $m->execute();
                                $rsm = $m->fetch(PDO::FETCH_ASSOC);
                                $maxid = cnum($rsm["maxid"]) + 1;
                                echo sprintf('%06d', $maxid);
                            }
                            ?>
                            <br />
                            発行日 <?php
                                if (!empty($_POST["newregi"])) {
                                    echo date('Y/m/d');
                                ?>
                                <input type="hidden" name="indate" value="<?= date('Y-m-d') ?>" />

                            <?php
                                } elseif (!empty($_POST["indate"])) {
                                    echo $_POST["indate"];
                            ?>
                                <input type="hidden" name="indate" value="<?= $_POST["indate"] ?>" />


                            <?php
                                }
                            ?>
                        </p>


                        <p class="address">〒299-4303<br />
                            千葉県長生郡一宮町東浪見4721番<br />
                            （東浪見岡本農園）【太陽と野菜の直売所】<br />
                            農園責任者：岡本　洋<br />
                            TEL：0475-40-0831

                        </p>

                        <?php
                        if (cnum($_REQUEST["t"]) == 1) {
                        ?><p>[振込先口座]<br />・<span style="font-size:80%;">房総信用組合 一宮支店 普通 2140004<br />株式会社 東浪見岡本農園</p>
                        <?php
                        }
                        ?>

                    </div>
                    <!--block-->
                </div>


                <div class="block">
                    <table class="meisai">
                        <thead>
                            <tr>
                                <th>　</th>
                                <th>品名</th>
                                <th>数量</th>
                                <th>単位</th>
                                <th>単価</th>
                                <th>合計</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            for ($i = 1; $i <= cnum($_POST["counttr"]); $i++) {
                                $goukei = "";
                            ?>
                                <tr>
                                    <th><?= $i ?><input type="hidden" name="subid<?= $i ?>" value="<?= $_POST["subid" . $i] ?>" /></th>
                                    <td class="hinmei"><?= htmlentities($_POST["hinmei" . $i], ENT_QUOTES, 'UTF-8') ?><input type="hidden" name="hinmei<?= $i ?>" value="<?= htmlentities($_POST["hinmei" . $i], ENT_QUOTES, 'UTF-8') ?>" /></td>
                                    <td class="kazu"><?php if (!empty($_POST["kazu" . $i])) {
                                                            echo $_POST["kazu" . $i];
                                                        } ?><input type="hidden" name="kazu<?= $i ?>" value="<?= $_POST["kazu" . $i] ?>" /></td>
                                    <td class="tani"><?= htmlentities($_POST["tani" . $i], ENT_QUOTES, 'UTF-8') ?><input type="hidden" name="tani<?= $i ?>" value="<?= htmlentities($_POST["tani" . $i], ENT_QUOTES, 'UTF-8') ?>" /></td>
                                    <td class="right"><?php if (!empty($_POST["tanka" . $i])) {
                                                            echo number_format(cnum($_POST["tanka" . $i]));
                                                        } ?><input type="hidden" name="tanka<?= $i ?>" value="<?= $_POST["tanka" . $i] ?>" /></td>
                                    <td class="right"><?php if (!empty($_POST["goukei" . $i])) {
                                                            echo number_format(cnum($_POST["goukei" . $i]));
                                                        ?>
                                            <input type="hidden" name="goukei<?= $i ?>" value="<?= $_POST["goukei" . $i] ?>" />
                                        <?php
                                                        } elseif (!empty($_POST["tanka" . $i])) {

                                                            $goukei = cnum($_POST["kazu" . $i]) * cnum($_POST["tanka" . $i]);
                                                            echo number_format($goukei);
                                        ?>
                                            <input type="hidden" name="goukei<?= $i ?>" value="<?= $goukei ?>" />
                                        <?php
                                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="6" style="border:none; padding:4px 0;"></td>
                            </tr>
                        </tbody>

                        <tfoot>

                            <tr>
                                <th colspan="4"></th>
                                <th class="second">小計</th>
                                <td class="right">￥<?php
                                                    echo number_format(cnum($_POST["syokei"]));
                                                    ?>
                                    <input type="hidden" name="syokei" value="<?= $_POST["syokei"] ?>" />

                                </td>
                            </tr>

                            <tr>
                                <th colspan="4"></th>
                                <th class="second">消費税</th>
                                <td class="right"><? if (!empty($_POST["zei"])) {
                                                        echo "￥" . number_format($_POST["zei"]);
                                                    ?>
                                        <input type="hidden" name="zei" value="<?= $_POST["zei"] ?>" />

                                    <?php
                                                    }

                                    ?>


                                </td>
                            </tr>

                            <tr>
                                <th colspan="4"></th>
                                <th class="second">合計金額</th>
                                <td class="right">\
                                    <?php

                                    echo number_format(cnum($_POST["total_price"]));
                                    ?>
                                    <input type="hidden" name="total_price" value="<?= $_POST["total_price"] ?>" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </div>

                <?php
                if (!empty($_POST["comment"])) {
                ?>
                    <div class="block">
                        備考
                        <p style="border:1px solid #333; padding:3px;"><?= nl2br($_POST["comment"]) ?></p>
                        <input type="hidden" name="comment" value="<?= $_POST["comment"] ?>" />
                    </div>
                <?php
                }

                ?>


                <p class="centering"><input type="button" name="printsheet" id="printsheet_bth" value="　印刷して登録　" onclick="print_sheet()" class="noprint" /></p>
            </form>

        </div>

    </div>




</body>

</html>