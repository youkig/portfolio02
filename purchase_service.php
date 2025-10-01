<?php $siteid = 69 ?>
<?php include("include/autometa.php"); ?>
<!DOCTYPE html>
<html lang="ja">
<?php include("config.php"); ?>


<head>

    <meta name="robots" content="all">
    <meta property="og:title" content="太陽と野菜の直売所【東浪見岡本農園】">
    <meta property="og:type" content="website">
    <meta property="og:url" content="index.asp">
    <meta property="og:locale" content="jp_JP">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="canonical" href="<?= $esurl ?>purchase_service.asp">
    <meta name="keywords" content="<?= $n_keyword ?>">

    <meta name="description" content="<?= $n_description ?>">

    <title><?= $n_title ?></title>

    <link rel="stylesheet" href="css/base.css?<?= str_replace(":", "", date("H:i:s")); ?>" type="text/css">
    <?php include("include/js.php") ?>


<body>
    <?php
    if (!empty($n_h5)) {
    ?>
        <h5 id="autochangepg"><?= $n_h5 ?></h5>
    <?php
    }
    ?>


    <div id="box">

        <div id="header">
            <h1><?= $n_h1 ?></h1>



            <?php include("include/header.php") ?>


            <div id="main" class="container">
                <?php include("include/leftpane.php") ?>
                <div id="cnt" class="consul mypage farm rentallow">

                    <p class="pankuzu"><a href="<?= $esurl ?>index.asp">トップページ</a> | 中古農機具、使わなくなったトラクター買取りいたします！</p>
                    <div class="block">
                        <h2>中古農機具、使わなくなったトラクター買取りいたします！</h2>



                    </div>

                    <div class="block">


                        <div class="container">
                            <div class="leftbox">
                                <p>【太陽と野菜の直売所】（東浪見岡本農園）では、令和7年から中古のトラクターや使わなくなった耕運機、田植え機など、農機具類を積極的に買取りや、ホームページに掲載して販売代行のカタチによる支援も行っています。</p>


                            </div>
                            <div class="rightbox">
                                <p><img src="img/purchase/img01.jpg" width="278" alt="倉庫にあるトラクターや耕運機の写真です"></p>
                            </div>
                        </div>

                        <p>当農園では、基本的に「農機具のリサイクル」を目的としており、農園の提携会社が直接修理を行い、農園のホームページから動作品として販売いたします。</p>

                        <p>※鉄くずと判断される場合は、お引き取り不可能となる場合もあります。</p>

                        <p>また、納屋に長期間保管していたものの、すでに動かなくなってしまったトラクターは、基本的に「鉄くず料金」となってしまうものの、最近では「年代モノ」のトラクターに思わぬ高値がつくこともあります。</p>



                    </div>

                    <div class="block">
                        <h3>買取りまでの流れ</h3>

                        <ol class="first">
                            <li>ホームページの買取り希望フォーム、または農園管理人に直接電話をかける。<br />（電話番号　<?= $mobile ?>）</li>

                            <li>農園担当者が保管場所まで赴いて、その場で買取り価格を査定いたします。</li>

                            <li>販売代行をご要望の場合は、担当者と相談の上値決めを行います。</li>

                            <li>お支払いの場合は、基本的に現金ではなく銀行振込となります。（売り渡し人の特定のため必要となります。</li>

                        </ol>
                    </div>

                    <div class="block">
                        <h3>買取り・販売代行のできる農機具、重機一覧</h3>

                        <ul>
                            <li>トラクター、耕運機、付属する管理機</li>

                            <li>田植え機、バインダー、コンバイン、コメ乾燥機、選別機、計量器</li>

                            <li>ユンボ、シャベルカー、ブルドーザーなどの重機</li>

                            <li>機械工具類全般</li>

                            <li>電動工具、専用バッテリー、エンジン式工具など</li>

                            <li>自動車、バイク</li>

                        </ul>

                        <p>ほか、買取りできる物もありますので、ぜひご相談ください！</p>
                    </div>


                    <div class="block">
                        <p>なお、出張査定費用は<span class="red bold">「無料」</span>となります。（遠方の場合はお断りすることもあります）</p>
                    </div>

                    <div class="block">
                        <h3>ご連絡・お問合せ先</h3>

                        <p>メール：<a href="mailto:torami@okamoto-farm.co.jp" class="underline">torami@okamoto-farm.co.jp</a></p>
                        <p>電話：<?= $mobile ?>（農園管理人：岡本直通）</p>

                    </div>

                    <div class="wrapper container">
                        <div class="button">
                            <a href="https://www.okamoto-farm.co.jp/inquire01?purchase=1">
                                <div class="icon"><i class="fa-sharp fa-solid fa-envelope"></i></div>
                                <span>買取り希望フォーム</span>
                            </a>
                        </div>
                    </div>


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