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
    <script src="js/news.js" type="text/javascript"></script>


    <title>メールマガジン配信【<?= $kanriName ?>】</title>
</head>

<body>
    <div id="box" class="kanri">
        <?php include("include/header.php") ?>

        <div id="main">
            <?php include("include/leftpane.php") ?>
            <div id="cnt">

                <h2>メールマガジン配信</h2>


                <div class="block">

                    <?php
                    if (!empty($_POST['email']) && !empty($_POST['title']) && !empty($_POST['naiyou'])) {

                        $sql = "SELECT * From t_user Where taikai=0";
                        if ($_POST['haishin'] == 1) {
                            $sql .= " and mailmaga=1";
                        }
                        if ($_POST['haishin'] == 3) {
                            $sql .= " and mailmaga=0";
                        }
                        $stmt = $dbh->prepare($sql);

                        $stmt->execute();
                        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


                        $fp = fopen('mailcsv/mailmaga.txt', 'w');
                        foreach ($users as $user) {
                            //csv作成

                            fwrite($fp, $user['company'] . ',' . $user['name'] . ',' . $user['email'] . "\n");
                        }
                        fclose($fp);

                        $sqlco = "SELECT count(id) From t_user Where taikai=0";
                        if ($_POST['haishin'] == 1) {
                            $sqlco .= " and mailmaga=1";
                        }
                        if ($_POST['haishin'] == 3) {
                            $sqlco .= " and mailmaga=0";
                        }
                        $stmt = $dbh->prepare($sqlco);
                        $stmt->execute();
                        $count = $stmt->fetchColumn();


                        //メール配信内容登録
                        $sql = "UPDATE t_mailmaga set haishin=:haishin,email=:email,title=:title,naiyo=:naiyo,number=:number,sentnumber=:sentnumber,in_date=:in_date where id=1";
                        $n = $dbh->prepare($sql);
                        $n->bindValue(":haishin", $_POST['haishin'], PDO::PARAM_INT);
                        $n->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
                        $n->bindValue(":title", $_POST['title'], PDO::PARAM_STR);
                        $n->bindValue(":naiyo", $_POST['naiyou'], PDO::PARAM_STR);
                        $n->bindValue(":number", $count, PDO::PARAM_INT);
                        $n->bindValue(":sentnumber", 0, PDO::PARAM_INT);
                        $n->bindValue(":in_date", date('Y-m-d H:i:s'), PDO::PARAM_STR);
                        $n->execute();

                        //メール配信履歴登録
                        $sql = "INSERT into t_mailmaga_history (email,title,naiyo,haishin,number,in_date) values (:email,:title,:naiyo,:haishin,:number,:in_date)";
                        $n = $dbh->prepare($sql);
                        $n->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
                        $n->bindValue(":title", $_POST['title'], PDO::PARAM_STR);
                        $n->bindValue(":naiyo", $_POST['naiyou'], PDO::PARAM_STR);
                        $n->bindValue(":haishin", $_POST['haishin'], PDO::PARAM_INT);
                        $n->bindValue(":number", $count, PDO::PARAM_INT);
                        $n->bindValue(":in_date", date('Y-m-d H:i:s'), PDO::PARAM_STR);
                        $n->execute();
                    }

                    //署名登録
                    if (!empty($_POST['signature'])) {
                        $sql = "update t_signature set naiyo=:naiyo";
                        $stmt = $dbh->prepare($sql);
                        $stmt->bindValue(":naiyo", $_POST['signature'], PDO::PARAM_STR);
                        $stmt->execute();
                    }
                    ?>
                    <p>メールマガジン配信の登録が完了しました。</p>
                    <p><a href="mailmagasend.php">メールマガジン配信画面に戻る</a></p>
                </div>





            </div>

        </div>
    </div>


</body>

</html>