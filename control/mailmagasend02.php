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

                <h2>メールマガジン配信（内容確認）</h2>


                <div class="block">
                    <p>以下の内容でよろしいでしょうか？</p>
                </div>


                <h3>メールマガジン作成</h3>
                <form method="post" action="mailmagasend03.php">
                    <div class="block">
                        <table>
                            <tbody>
                                <tr>
                                    <th>配信先</th>
                                    <td><?php
                                        if ($_POST["haishin"] == 1) {
                                            echo "メルマガ希望のみ";
                                        } elseif ($_POST["haishin"] == 3) {
                                            echo "一般会員のみ";
                                        } else {
                                            echo "全会員";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>配信メールアドレス</th>
                                    <td><?= $_POST["email"] ?></td>
                                </tr>
                                <tr>
                                    <th>タイトル</th>
                                    <td><?= $_POST["title"] ?></td>
                                </tr>
                                <tr>
                                    <th>内容</th>
                                    <td>
                                        <?= nl2br($_POST["naiyou"]) ?>

                                    </td>
                                </tr>
                                <tr>
                                    <th>署名</th>
                                    <td> <?= nl2br($_POST["signature"]) ?></td>
                                </tr>

                            </tbody>
                        </table>
                        <p><input value="この内容で登録する" type="submit" />　<input type="button" value="戻る" onclick="history.back()" /></p>
                    </div>

                    <?php
                    foreach ($_POST as $key => $value) {
                        echo '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
                    }
                    ?>
                </form>



            </div>

        </div>
    </div>


</body>

</html>