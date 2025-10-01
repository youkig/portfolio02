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

    <?php
    $sql = "SELECT * From t_mailmaga Where id=1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $m = $stmt->fetch(PDO::FETCH_ASSOC);

    $n = $m["number"];
    if (isset($_POST["stop"]) && $_POST["stop"] == 1) {
        // メールマガジン配信中止
        $sql = "UPDATE t_mailmaga SET sentnumber=:sentnumber WHERE id=1";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':sentnumber', $n, PDO::PARAM_INT);
        $stmt->execute();

        echo '<script>alert("メールマガジンの配信を中止しました。");</script>';
        echo '<script>location.href="mailmagasend.php";</script>';
        exit;
    }



    ?>
    <title>メールマガジン配信中止【<?= $kanriName ?>】</title>
</head>

<body>
    <div id="box" class="kanri">
        <?php include("include/header.php") ?>

        <div id="main">
            <?php include("include/leftpane.php") ?>
            <div id="cnt">

                <h2>メールマガジン中止</h2>


                <div class="block">
                    <p>メールマガジン配信を中止します。</p>
                </div>


                <form method="post" action="mailmagastop.php">
                    <div class="block">
                        <p>本当に配信を中止しますか？</p>

                        <input type="submit" value="中止する" />
                        <input type="hidden" name="stop" value="1" />
                    </div>
                </form>



            </div>

        </div>
    </div>


</body>

</html>