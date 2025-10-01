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

    <?php
    $sql = "SELECT * FROM t_prose Where disp=1 and id = :id";
    $p = $dbh->prepare($sql);
    $p->bindValue(':id', cnum($_GET['id']), PDO::PARAM_INT);
    $p->execute();
    $result = $p->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $id = $result['id'];
        $title = $result['title'];
        $content = nl2br($result['comment']);
        $image = $result['image'];
        $pdate = $result['pdate'];
    } else {
        $error = '<p>まだ散文詩が登録されていません。</p>';
    }
    ?>
    <title><?= $title ?>／日々の野菜たちとの戯れとお天道様との散文詩／野菜狩り 千葉県【太陽と野菜の直売所】レンタル農園 一宮町／野菜収穫体験 九十九里</title>

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


                        <p class="righting">掲載日（<?= date('Y/m/d', strtotime($pdate)) ?>）</p>
                        <p><?= $content ?></p>

                        <?php
                        if (!empty($image)) {
                            echo '<img src="../photo/proseimg/' . $image . '" alt="画像" style="max-width:100%;height:auto;" />';
                        }
                        ?>

                    </div>

                    <p class="righting"><a href="<?= $esurl ?>prose" class="underline">一覧へ戻る</a></p>

                    <div class="block">
                        <?php
                        $sql = "SELECT * FROM t_prose_comment WHERE pid = :id and userid<>0 and disp=1 and shinsa=1 ORDER BY indate desc";
                        $n = $dbh->prepare($sql);
                        $n->bindValue(":id", $id, PDO::PARAM_INT);
                        $n->execute();
                        $comments = $n->fetchAll(PDO::FETCH_ASSOC);
                        if ($comments) :
                        ?>
                            <h3>会員からのコメント投稿</h3>

                            <div class="comment">
                                <?php foreach ($comments as $comment) : ?>
                                    <div class="comment-item">
                                        <p class="comment-date">投稿日：<?= date('Y/m/d H:i:s', strtotime($comment["indate"])) ?></p>
                                        <p class="comment-penname">ペンネーム：<?= htmlspecialchars($comment["penname"]) ?></p>
                                        <p class="comment-text"><?= nl2br(htmlspecialchars($comment["comment"])) ?></p>
                                        <?php
                                        $sql = "SELECT * FROM t_prose_comment WHERE pid = :id and userid=0 and motoid=:motoid ORDER BY indate desc";
                                        $n = $dbh->prepare($sql);
                                        $n->bindValue(":id", $id, PDO::PARAM_INT);
                                        $n->bindValue(":motoid", $comment["id"], PDO::PARAM_INT);
                                        $n->execute();
                                        $comments = $n->fetchAll(PDO::FETCH_ASSOC);

                                        ?>
                                        <div class="comment-children">
                                            <?php foreach ($comments as $comment) : ?>
                                                <?php if (!empty($comment["comment"])) : ?>
                                                    <div class="comment-item2">

                                                        <p class="comment-penname"><?= htmlspecialchars($comment["penname"]) ?>からのコメント</p>
                                                        <p class="comment-text"><?= nl2br(htmlspecialchars($comment["comment"])) ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php
                        endif;
                        $logid = $_COOKIE["logid"];
                        $pass = $_COOKIE["pass"];
                        $setid = $_COOKIE["setid"];
                        ?>
                        <div class="block prose-comment">

                            <h4 class="centering">コメントを投稿できます。</h4>
                            <?php
                            if (!empty($logid) && !empty($pass)) {
                                $sql = "SELECT * FROM t_user WHERE id = :id";
                                $u = $dbh->prepare($sql);
                                $u->bindValue(':id', cnum($setid), PDO::PARAM_INT);
                                $u->execute();
                                $user = $u->fetch(PDO::FETCH_ASSOC);
                            ?>
                                <form method="post" action="prose_detail2.php?id=<?= $id ?>" class="comment-form">
                                    <p>ペンネーム：<input type="text" name="penname" id="penname" value="<?= htmlspecialchars($user["penname"], ENT_QUOTES, 'UTF-8') ?>" style="width: 80%"></p>
                                    <textarea name="comment" id="comment" rows="4" style="width: 100%;" placeholder="コメントを入力"></textarea>
                                    <p class="centering"><button type="submit" id="comment-submit">投稿</button></p>
                                    <?php
                                    function setToken()
                                    {
                                        $TOKEN_LENGTH = 32;
                                        $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);

                                        $token = bin2hex($bytes);
                                        $_SESSION['crsf_token'] = $token;
                                        return $token;
                                    }
                                    ?>
                                    <input type="hidden" name="token" value="<?= setToken() ?>">
                                </form>
                            <?php
                            } else {

                            ?>
                                <p class="centering">コメントを投稿するには会員ログインが必要です。</p>
                                <form action="<?= $esurl ?>login_chk" method="post">
                                    <div class="block">

                                        <h3>会員ログインフォーム</h3>
                                        <p>既に会員登録済みの場合は、ログインしてください。</p>

                                        <p><?= $errmes ?></p>


                                        <dl>
                                            <dt>ユーザーID</dt>
                                            <dd><input type="text" name="loginid" id="loginid" value="" style="width: 80%"></dd>
                                        </dl>

                                        <dl>
                                            <dt>パスワード</dt>
                                            <dd><input type="password" name="password" id="password" value="" style="width: 80%"></dd>
                                        </dl>



                                    </div>

                                    <div class="block">

                                        <p class="centering"><input type="submit" name="submit" value="ログイン"></p>
                                    </div>
                                <?php
                            }
                                ?>
                        </div>
                    </div>
                    <script defer>
                        document.querySelector(".comment-form").addEventListener("submit", function(event) {
                            var comment = document.getElementById("comment").value.trim();
                            if (comment.length === 0) {
                                alert("コメントを入力してください。");
                                event.preventDefault();
                            }
                        });
                    </script>

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