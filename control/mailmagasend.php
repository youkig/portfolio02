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
    <script type="text/javascript">
        $(function() {
            $("#oldmail").change(function() {
                var id = $(this).val();
                if (id !== "") {
                    $.ajax({
                        url: 'ajax_oldmail.php',
                        type: 'GET',
                        data: "id=" + id,
                        dataType: 'json',
                        success: function(data) {
                            $("#email").val(data.email);
                            $("#title").val(data.title);
                            $("#naiyou").val(data.naiyo);
                        },
                        error: function() {
                            alert('通信に失敗しました。');
                        }
                    });
                } else {
                    $("#title").val('');
                    $("#naiyou").val('');
                }
            });
        });
    </script>

    <script type="text/javascript">
        function signup(f) {
            if (f.title.value === "") {
                alert("タイトルを入力してください。");
                f.title.focus();
                return false;
            }
            if (f.naiyou.value === "") {
                alert("内容を入力してください。");
                f.naiyou.focus();
                return false;
            }
            if (f.signature.value === "") {
                alert("署名を入力してください。");
                f.signature.focus();
                return false;
            }
            return true;
        }



        function txtch() {
            var txt = document.getElementById("naiyou").value;

            var search_txt = "[①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳ⅠⅡⅢⅣⅤⅥⅦⅧⅨⅩ㍉㌔㌢㍍㌘㌧㌃㌶㍑㍗㌍㌦㌣㌫㍊㌻㎜㎝㎞㎎㎏㏄㎡㍻〝〟№㏍℡㊤㊥㊦㊧㊨㈱㈲㈹㍾㍽㍼纊鍈蓜炻棈兊夋奛奣寬﨑嵂咊咩哿喆坙坥垬埈]";

            if (txt.match(search_txt)) {
                alert("機種依存文字は使わないでください。");
            }

        }

        window.onbeforeunload = function() {

            return "ページを移動しようとしています。";

        }
    </script>
    <?php

    $sql = "SELECT * From t_mailmaga Where id=1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $mailmaga = $stmt->fetch(PDO::FETCH_ASSOC);

    $sendchk = 0;
    if ($mailmaga["number"] > $mailmaga["sentnumber"]) {
        $sendchk = 1;
    }
    ?>
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
                    <p>メールマガジン配信を行うことができます。</p>
                </div>

                <?php
                if ($sendchk == 1) {
                    echo '<div class="block"><p class="red">現在、メールマガジンが配信中です。<br>配信終了まで新たなメールマガジンは作成できません。</p>';
                    echo '<p>配信予定件数：' . $mailmaga["number"] . '件<br>配信済件数：' . $mailmaga["sentnumber"] . '件</p></div>';
                    echo '<div class="block"><p><a href="mailmagastop.php">配信を中止する</a></p></div>';
                }
                ?>


                <h3>メールマガジン作成</h3>
                <p><select name="oldmail" id="oldmail" onchange="oldmailchange()">
                        <option value="">過去のメールマガジンから選択</option>
                        <?php
                        $sql = "SELECT * From t_mailmaga_history order by in_date desc";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $rs) {
                        ?>
                            <option value="<?= $rs['id'] ?>"><?= htmlspecialchars($rs['title'], ENT_QUOTES) ?> (<?= $rs['in_date'] ?>)</option>
                        <?php
                        }
                        ?>
                    </select>
                </p>

                <?php
                if (!empty($_GET['sendid'])) {
                    $sql = "SELECT * From t_mailmaga_history Where id=:id";
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(":id", $_GET['sendid'], PDO::PARAM_INT);
                    $stmt->execute();
                    $rs = $stmt->fetch(PDO::FETCH_ASSOC);
                    $tomail = $rs['email'];
                    $title = $rs['title'];
                    $naiyou = $rs['naiyo'];
                }
                ?>
                <form method="post" action="mailmagasend02.php" onsubmit="return signup(this)">
                    <div class="block">
                        <table>
                            <tbody>
                                <tr>
                                    <th>配信先</th>
                                    <td><input type="radio" name="haishin" id="haishi1" value="1" checked /><label for="haishin1">メルマガ希望のみ</label><br>
                                        <input type="radio" name="haishin" id="haishi2" value="2" /><label for="haishin2">全会員</label><br>
                                        <input type="radio" name="haishin" id="haishi3" value="3" /><label for="haishin3">一般会員のみ</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>配信メールアドレス</th>
                                    <td><input type="text" name="email" id="email" value="<?= $tomail ?>" size="60" /></td>
                                </tr>
                                <tr>
                                    <th>タイトル</th>
                                    <td><input name="title" id="title" type="text" size="60" value="<?= htmlspecialchars($title, ENT_QUOTES) ?>" /></td>
                                </tr>
                                <tr>
                                    <th>内容</th>
                                    <td>
                                        ※会社名、氏名は自動で挿入されます。<br>
                                        <textarea name="naiyou" id="naiyou" class="naiyou" rows="100" style="width:100%" onKeyUp="txtch();"><?= htmlspecialchars($naiyou, ENT_QUOTES) ?></textarea>
                                    </td>
                                </tr>
                                <?php
                                $sql = "SELECT * From t_signature";
                                $stmt = $dbh->prepare($sql);
                                $stmt->execute();
                                $signature = $stmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <tr>
                                    <th>署名</th>
                                    <td><textarea name="signature" id="signature" rows="10" style="width:50%"><?= htmlspecialchars($signature['naiyo'], ENT_QUOTES) ?></textarea></td>
                                </tr>

                            </tbody>
                        </table>
                        <?php
                        if ($sendchk == 1) {
                            echo '<p class="red">現在、メールマガジンが配信中です。<br>配信終了まで新たなメールマガジンは作成できません。</p>';
                        } else {
                        ?>
                            <p><input value="確認する" type="submit" /></p>
                        <?php
                        }
                        ?>

                    </div>
                </form>



            </div>

        </div>
    </div>


</body>

</html>