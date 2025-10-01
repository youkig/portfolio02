<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<?php include("config.php"); ?>


<head>
    <meta name="robots" content="all">
    <meta property="og:title" content="">
    <meta property="og:type" content="website">
    <meta property="og:url" content="index.php">
    <meta property="og:locale" content="jp_JP">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="canonical" href="<?= $esurl ?>tanbo_buy.php">
    <meta name="keywords" content="野菜狩り,野菜収穫体験,レンタル農園,貸し農園,レンタル農機具,レンタルキッチン,レンタル厨房,完全有機栽培,野菜直売所,井戸掘り,耕運代行,ソーラー,太陽光,非常用電源,千葉県,長生郡,一宮町,東浪見,外房,九十九里,とらみスイート">

    <meta name="description" content="千葉県長生郡一宮町、サーフィンのメッカでも釣ヶ崎海岸にほど近いエリアで、完全有機栽培で野菜を作っている【太陽と野菜の直売所】（東浪見岡本農園）ホームページでは、観光農園として野菜狩り・農業体験サービスのほか、期間貸しのレンタル農園のご紹介や、農機・農機具レンタル、レンタル厨房のご案内をしております。停電時にいつも電気のある災害避難所としてもご利用になれます。">


    <title>コメント投稿／日々の野菜たちとの戯れとお天道様との散文詩／野菜狩り 千葉県【太陽と野菜の直売所】レンタル農園 一宮町／野菜収穫体験 九十九里</title>

    <link rel="stylesheet" href="css/base.css?<?= str_replace(":", "", date("H:i:s")); ?>" type="text/css">
    <?php include("include/js.php") ?>

</head>

<body>

    <div id="box">

        <div id="header">
            <h1>野菜狩り 千葉県／レンタル農園 一宮町／農機具レンタル 長生郡</h1>


            <?php include("include/header.php") ?>


            <div id="main" class="container">
                <?php include("include/leftpane.php") ?>
                <div id="cnt" class="prose">

                    <p class="pankuzu"><a href="<?= $esurl ?>">トップページ</a> | 日々の野菜たちとの戯れとお天道様との散文詩 | <?= $title ?></p>
                    <div class="block">
                        <h2><img src="img/prose/h2.jpg" alt="日々の野菜たちとの戯れとお天道様との散文詩" width="780" height="205"></h2>

                    </div>

                    <h3><?= $title ?></h3>
                    <div class="naiyo">

                        <?php
                        if (empty($_SESSION['crsf_token'])) {
                            echo "<p>アクセスが不正です。</p>";
                        } elseif ($_SESSION['crsf_token'] == filter_input(INPUT_POST, "token")) {
                            $setid = $_COOKIE["setid"];
                            if (!empty($_POST["comment"]) && !empty($_GET["id"])) {
                                if (!empty($_POST["penname"])) {
                                    $penname = $_POST["penname"];
                                } else {
                                    $penname = "匿名希望";
                                }
                                $sql = "UPDATE t_user set penname=:penname where id=:id";
                                $n = $dbh->prepare($sql);
                                $n->bindValue(':penname', $penname, PDO::PARAM_STR);
                                $n->bindValue(':id', $setid, PDO::PARAM_INT);
                                $n->execute();
                                try {
                                    $sql = "INSERT INTO t_prose_comment (pid,userid,penname,comment,indate,disp,shinsa) values (:pid,:userid,:penname,:comment,:indate,:disp,:shinsa)";
                                    $p = $dbh->prepare($sql);
                                    $p->bindValue(':pid', cnum($_GET["id"]), PDO::PARAM_INT);
                                    $p->bindValue(':userid', $setid, PDO::PARAM_INT);
                                    $p->bindValue(':penname', $penname, PDO::PARAM_STR);
                                    $p->bindValue(':comment', $_POST["comment"], PDO::PARAM_STR);
                                    $p->bindValue(':indate', date("Y-m-d H:i:s"), PDO::PARAM_STR);
                                    $p->bindValue(':disp', 0, PDO::PARAM_INT);
                                    $p->bindValue(':shinsa', 0, PDO::PARAM_INT);
                                    $p->execute();
                                    // '****************************************************************
                                    // ' メール送信
                                    // '****************************************************************
                                    mb_language("japanese");
                                    mb_internal_encoding("UTF-8");
                                    // '****************************************************************
                                    // ' 管理者へ
                                    // '****************************************************************
                                    $header = "From: " . mb_encode_mimeheader("東浪見岡本農園") . "<torami@okamoto-farm.co.jp>\r\n";
                                    $subj = "【太陽と野菜の直売所】散文詩コメント投稿のお知らせ";
                                    $to = "<torami@okamoto-farm.co.jp>";
                                    $header .= "Bcc: <okamotofarm@docomo.ne.jp>\r\n";

                                    //$header .= "Content-Type: text/plain; charset=UTF-8\r\n";


                                    $send_msg = "会員から散文詩へのコメントが投稿されました。\n\n";
                                    $send_msg .= "内容を確認の上、審査をしてホームページへ反映させてください。\n";
                                    $send_msg .= "----------------------------------------\n";
                                    $send_msg .= "https://www.okamoto-farm.co.jp/control/prose_02?id=" . cnum($_GET["id"]) . "\n";

                                    // '****************************************************************
                                    // ' 送信(管理者)
                                    // '****************************************************************
                                    if (mb_send_mail($to, $subj, $send_msg, $header)) {
                                        $rs_manager = "";
                                    } else {
                                        $rs_manager = 1;
                                    }
                                    echo '<p class="centering">コメントが投稿されました。内容を確認の上、反映させていただきます。</p>';
                                } catch (PDOException $e) {
                                    echo 'Error: ' . $e->getMessage();
                                }
                            }
                        }
                        ?>

                    </div>

                    <p class="righting"><a href="<?= $esurl ?>prose_detail?id=<?= cnum($_GET["id"]) ?>" class="underline">戻る</a></p>



                    <p id="page-top"><a href="#box"><img src="img/common/pagetop.gif" alt="PAGETOP" width="87" height="88"></a></p>
                    <!-- id cnt end -->
                </div>

                <?php include("include/rightpane.php") ?>

                <!-- id main end -->
            </div>

            <?php include("include/footer.php") ?>


            <!-- id box end -->
        </div>
</body>

</html>