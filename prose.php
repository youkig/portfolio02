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

    <title>日々の野菜たちとの戯れとお天道様との散文詩／野菜狩り 千葉県【太陽と野菜の直売所】レンタル農園 一宮町／野菜収穫体験 九十九里</title>

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

                    <p class="pankuzu"><a href="<?= $esurl ?>">トップページ</a> | 日々の野菜たちとの戯れとお天道様との散文詩</p>
                    <div class="block">
                        <h2><img src="img/prose/h2.jpg" alt="日々の野菜たちとの戯れとお天道様との散文詩" width="780" height="205"></h2>

                    </div>

                    <div class="block">
                        <p>当ページでは、【太陽と野菜の直売所】（東浪見岡本農園）農園管理人の岡本が、日々の野菜やお米などの栽培作業を通じて、小さく聴こえてきた野菜たちの声、また昨今は強烈に降り注ぐお天道様からの意思表示を、その日そのときに感じたままの感性で、ど素人ではありながらも、恥ずかし気もなく感じたままに書いてみようと始めた散文詩です。</p>

                        <p>毎日書くこともありますし、おそらくは1か月以上何も書けないこともあるでしょうが、長くお天道様とかかわってきた自分（農園管理人：岡本）が、もしかしたら「こんな世の中で果たしていいのか？」を主題にして、小さな紙面を綴っていきたいと思っています。</p>

                        <p>各散文詩には、コメント欄を設けてみますが、会員登録のない方のコメントはできないようにしています。</p>

                        <p>ぜひ、巷間の匿名性の甚だしい「SNSサイト」のような、無責任なコメントにならないようにお願いいたします。</p>

                    </div>

                    <div class="block">
                        <h3>散文詩一覧</h3>

                        <?php
                        $sql = "SELECT * FROM t_prose Where disp=1 ORDER BY pdate DESC";
                        $p = $dbh->prepare($sql);
                        $p->execute();
                        $result = $p->fetchAll(PDO::FETCH_ASSOC);
                        if ($result) {
                            foreach ($result as $row) {
                                echo '<div class="prose-item">';
                                echo '<h4><a href="prose_detail.php?id=' . $row['id'] . '">(' . date('Y/m/d', strtotime($row['pdate'])) . ')  &nbsp;' . $row['title'] . '</a></h4>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>まだ散文詩が登録されていません。</p>';
                        }
                        ?>


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