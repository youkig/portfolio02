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

    <script>
        $(function() {
            $(".deletebtn").click(function() {
                if (confirm("本当に削除しますか？")) {
                    var id = $(this).data("id");

                    $.ajax({
                        url: 'mailmaga_history_delete.php',
                        type: 'GET',
                        data: 'id=' + id,
                        success: function(response) {
                            alert('削除しました。');
                            location.reload();
                        },
                        error: function() {
                            alert('削除に失敗しました。');
                        }
                    });
                }
            });
        });
    </script>
    <title>過去のメールマガジン配信履歴【<?= $kanriName ?>】</title>
</head>

<body>
    <div id="box" class="kanri">
        <?php include("include/header.php") ?>

        <div id="main">
            <?php include("include/leftpane.php") ?>
            <div id="cnt">

                <h2>過去のメールマガジン配信履歴</h2>


                <div class="block">
                    <p>過去に配信したメールマガジンを選択して、再送信することができます。</p>
                </div>


                <h3>過去のメールマガジン一覧</h3>
                <?php
                $sql = "SELECT * From t_mailmaga_history order by in_date desc";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div class="block">
                    <table class="mailmaga">
                        <tr>
                            <th class="centering" style="width: 10%;">配信日</th>
                            <th class="centering" style="width: 50%;">タイトル</th>
                            <th class="centering">操作</th>
                            <th class="centering">削除</th>
                        </tr>
                        <?php

                        foreach ($results as $rs) {
                        ?>
                            <tr>
                                <td><?= date("Y/m/d", strtotime($rs["in_date"])) ?></td>
                                <td><?= htmlspecialchars($rs["title"], ENT_QUOTES, "UTF-8") ?></td>
                                <td class="centering"><a href="mailmagasend.php?sendid=<?= $rs["id"] ?>" class="underline">再送信</a></td>
                                <td class="centering"><span class="underline deletebtn" data-id="<?= $rs["id"] ?>" style="cursor:pointer;">削除</span></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>

                </div>

            </div>
        </div>


</body>

</html>