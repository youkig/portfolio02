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
            var q = getQueryAll(document.URL);
            registEnd("prose_02.php?" + q);
        });
    </script>

    <?php
    $error = "";
    if (!empty($_POST)) {
        if (isset($_FILES["image"])) {

            $fileTmpPath = $_FILES["image"]["tmp_name"];
            $filename = $_FILES["image"]["name"];
            $filesize = $_FILES["image"]["size"];
            $fileType = $_FILES["image"]["type"];
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

            $uploadFolder = "../photo/proseimg/";
            $allowedTypes = ["image/jpeg", "image/png", "image/gif"];

            //ファイルタイプチェック
            if (!in_array($fileType, $allowedTypes)) {

                $error = "JPEG / PNG / GIF の画像のみアップロードできます。";
            } else {
                //ファイル名の重複を避けるための処理
                $nowdatetime = date('YmdHis');
                $newFilename = uniqid("img_") . "_" . $nowdatetime . "." . $extension;
                $destPath = $uploadFolder . $newFilename;

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $success = 1;
                } else {
                    $error = "ファイルの保存に失敗しました。";
                }
            }
        }

        if (!empty($_POST["remove_image"])) {
            $sql = "UPDATE t_prose SET image=NULL WHERE id=:id";
            $n = $dbh->prepare($sql);
            $n->bindValue(":id", $id, PDO::PARAM_INT);
            $n->execute();
        }

        if (!empty($_POST["title"]) && !empty($_POST["naiyou"])) {

            $id = cnum($_POST["id"]);
            $sql = "UPDATE t_prose set title=:title,comment=:comment,image=:image,pdate=:pdate,disp=:disp Where id=:id";
            $n = $dbh->prepare($sql);
            $n->bindValue(":title", $_POST["title"], PDO::PARAM_STR);
            $n->bindValue(":comment", $_POST["naiyou"], PDO::PARAM_STR);
            if ($success == 1) {
                $n->bindValue(":image", $newFilename, PDO::PARAM_STR);
            } elseif (!empty($_POST["uploadimage"])) {
                $n->bindValue(":image", $_POST["uploadimage"], PDO::PARAM_STR);
            } else {
                $n->bindValue(":image", null, PDO::PARAM_NULL);
            }

            $n->bindValue(":pdate", date('Y-m-d', strtotime($_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"])), PDO::PARAM_STR);
            $n->bindValue(":disp", $_POST["disp"], PDO::PARAM_INT);
            $n->bindValue(":id", $id, PDO::PARAM_INT);
            $n->execute();

            header("location:prose_02.php?id=" . $id);
        }
    }
    ?>


    <?php
    $id = cnum($_REQUEST["id"]);
    $sql = "select * from t_prose where id = :id";
    $n = $dbh->prepare($sql);
    $n->bindValue(":id", $id, PDO::PARAM_INT);
    $n->execute();
    $rs = $n->fetch(PDO::FETCH_ASSOC);

    if (empty($rs)) {
        header("location:prose.php");
    }

    $y = date('Y', strtotime($rs["pdate"]));
    $m = date('m', strtotime($rs["pdate"]));
    $d = date('d', strtotime($rs["pdate"]));

    ?>
    <title>散文詩編集【<?= $kanriName ?>】</title>
</head>

<body>

    <div id="box" class="kanri">
        <?php include("include/header2.php") ?>

        <div id="main">
            <?php include("include/leftpane.php") ?>
            <div id="cnt">

                <h2>散文詩編集</h2>

                <div class="block">
                    <p>既存の散文詩の編集を行います。</p>
                    <p><a href="prose.php">散文詩一覧に戻る</a></p>
                </div>

                <h3>散文詩の編集</h3>


                <?php
                if (!empty($error)) {
                    echo "<div style='font-weight:bold;color:red;'>$error</div>";
                }
                ?>

                <p><a href="https://www.okamoto-farm.co.jp/prose_detail.php?id=<?= $rs["id"] ?>" target="_blank" class="underline">詳細ページを確認</a></p>
                <form method="post" action="prose_02.php" enctype="multipart/form-data">
                    <div class="block">
                        <table>
                            <tbody>
                                <tr>
                                    <th>日付</th>
                                    <td>
                                        <p>西暦<input name="year" id="year" type="text" size="10" value="<?= $y ?>" />年
                                            　<input name="month" id="month" type="text" size="10" value="<?= $m ?>" />月
                                            　<input name="day" id="day" type="text" size="10" value="<?= $d ?>" />日</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>タイトル</th>
                                    <td><input name="title" id="title" type="text" size="60" value="<?= $rs["title"] ?>" /></td>
                                </tr>
                                <tr>
                                    <th>内容</th>
                                    <td>
                                        <textarea name="naiyou" id="naiyou" class="naiyou" cols="50" rows="6" style="width:100%"><?= $rs["comment"] ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>画像</th>
                                    <td>
                                        <?php
                                        if (!empty($rs["image"])) {
                                            echo "<img src='../photo/proseimg/{$rs["image"]}' alt='画像' style='max-width:50%;height:auto;' />";
                                            echo "<br><label><input type='checkbox' name='remove_image' value='1'> 画像を削除</label>";
                                            echo "<input type='hidden' name='uploadimage' value='{$rs["image"]}'>";
                                        } else {
                                        ?>
                                            <input type="file" accept="image/*" name="image" id="imageInput" />
                                            <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>公開設定</th>
                                    <td>
                                        <ul class="inline">
                                            <li><label for="disp1"><input type="radio" value="1" name="disp" id="disp1" <?= checked($rs["disp"], true) ?> /> 公開</label></li>
                                            <li><label for="disp0"><input type="radio" value="0" name="disp" id="disp0" <?= checked($rs["disp"], false) ?> /> 下書き</label></li>

                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <p><a href="https://www.okamoto-farm.co.jp/prose_detail.php?id=<?= $rs["id"] ?>" target="_blank" class="underline">詳細ページを確認</a></p>
                        <img id="preview" src="" alt="画像プレビューがここに表示されます" width="640" style="display: none;">
                        <script>
                            const imageInput = document.getElementById('imageInput');
                            const preview = document.getElementById('preview');

                            imageInput.addEventListener('change', function() {
                                const file = this.files[0];

                                if (file && file.type.startsWith("image/")) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        preview.src = e.target.result;
                                        preview.style.display = "block";
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    preview.src = "";
                                    alert("画像ファイルを選択してください。");
                                }
                            });
                        </script>
                        <p><input value="この内容で登録する" type="submit" /></p>
                        <input type="hidden" name="id" value="<?= $id ?>" />
                    </div>
                </form>


                <div class="block">
                    <h3>会員からのコメント</h3>

                    <?php
                    $sql = "SELECT * From t_prose_comment Where pid = :id and motoid is null order by indate desc";
                    $c = $dbh->prepare($sql);
                    $c->bindValue(":id", $id, PDO::PARAM_INT);
                    $c->execute();
                    $comments = $c->fetchAll(PDO::FETCH_ASSOC);
                    if ($comments) {
                        foreach ($comments as $comment) {
                    ?>
                            <div class='comment' style='border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;'>
                                <p>投稿日（<?= date('Y/m/d H:i:s', strtotime($comment["indate"])) ?>） <input type="checkbox" name="disp" id="disp_<?= $comment["id"] ?>" class="disp-checkbox" data-id="<?= $comment["id"] ?>" <?= checked($comment["disp"], 1) ?>><label for="disp_<?= $comment["id"] ?>">表示/非表示</label>　<input type="checkbox" name="shinsa" id="shinsa_<?= $comment["id"] ?>" class="shinsa-checkbox" data-id="<?= $comment["id"] ?>" <?= checked($comment["shinsa"], 1) ?>><label for="shinsa_<?= $comment["id"] ?>">審査/未審査</label></p>
                                <p>ペンネーム：<?= htmlspecialchars($comment["penname"], ENT_QUOTES, 'UTF-8') ?>　（<a href="userdisp.php?id=<?= $comment["userid"] ?>" target="_blank" class="underline">会員詳細</a>）</p>
                                <p><?= nl2br($comment["comment"]) ?></p>
                                <p><button class="edit" data-id="<?= $comment["id"] ?>">会員コメントを編集する</button></p>
                                <div class="edit_form" id="edit_form_<?= $comment["id"] ?>" style="display: none;">
                                    <textarea name="edit_comment" rows="4" cols="50"><?= htmlspecialchars($comment["comment"], ENT_QUOTES, 'UTF-8') ?></textarea>
                                    <button class="submit_edit" data-id="<?= $comment["id"] ?>">編集内容を保存する</button>

                                </div>
                                <?php
                                $sql = "SELECT * From t_prose_comment Where pid = :id and motoid = :motoid";
                                $n = $dbh->prepare($sql);
                                $n->bindValue(":id", $comment["pid"], PDO::PARAM_INT);
                                $n->bindValue(":motoid", $comment["id"], PDO::PARAM_INT);
                                $n->execute();
                                $replies = $n->fetch(PDO::FETCH_ASSOC);

                                if (!$replies) {
                                ?>
                                    <p><button class="reply" data-id="<?= $comment["pid"] ?>">コメントへ返信する</button></p>
                                    <div class="reply_form" id="reply_form_<?= $comment["pid"] ?>" style="display: none;">
                                        <textarea name="reply_comment" rows="4" cols="50"></textarea>
                                        <input type="hidden" name="reply_id" value="<?= $comment["id"] ?>">
                                        <button class="submit_reply" data-id="<?= $comment["pid"] ?>">返信内容を投稿する</button>
                                    </div>
                                <?php
                                } else {
                                ?>

                                    <div class="edit_form" id="edit_form_<?= $replies["id"] ?>">
                                        <p>※農園管理人からのコメント</p>
                                        <textarea name="edit_comment" rows="4" cols="50"><?= htmlspecialchars($replies["comment"], ENT_QUOTES, 'UTF-8') ?></textarea>
                                        <button class="submit_edit" data-id="<?= $replies["id"] ?>">編集内容を保存する</button>

                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>

                    <?php
                    }

                    ?>

                    <script>
                        $(function() {
                            $(".reply").click(function() {
                                var id = $(this).data("id");

                                $("#reply_form_" + id).toggle();
                            });

                            $(".submit_reply").click(function() {
                                var id = $(this).data("id");
                                var comment = $(this).siblings("textarea[name='reply_comment']").val().trim();
                                var mid = $(this).siblings("input[name='reply_id']").val();
                                if (comment.length === 0) {
                                    alert("返信内容を入力してください。");
                                    return;
                                }

                                $.ajax({
                                    url: 'submit_reply.php',
                                    type: 'GET',

                                    data: "id=" + id + "&mid=" + mid + "&comment=" + encodeURIComponent(comment),
                                    success: function(response) {
                                        alert("返信が送信されました。");
                                        location.reload();
                                    },
                                    error: function() {
                                        alert("エラーが発生しました。もう一度お試しください。");
                                    }
                                });
                            });

                            $(".edit").click(function() {
                                var id = $(this).data("id");

                                $("#edit_form_" + id).toggle();
                            });

                            $(".submit_edit").click(function() {
                                var id = $(this).data("id");
                                var comment = $(this).siblings("textarea[name='edit_comment']").val().trim();
                                if (comment.length === 0) {
                                    alert("コメントを入力してください。");
                                    return;
                                }

                                $.ajax({
                                    url: 'submit_edit.php',
                                    type: 'GET',
                                    data: "id=" + id + "&comment=" + encodeURIComponent(comment),
                                    success: function(response) {
                                        alert("編集内容が保存されました。");
                                        location.reload();
                                    },
                                    error: function() {
                                        alert("エラーが発生しました。もう一度お試しください。");
                                    }
                                });
                            });

                            $(".disp-checkbox").change(function() {
                                var id = $(this).data("id");
                                var disp = $(this).is(":checked") ? 1 : 0;

                                $.ajax({
                                    url: 'toggle_disp.php',
                                    type: 'GET',
                                    data: "id=" + id + "&disp=" + disp,
                                    success: function(response) {
                                        alert("表示設定が更新されました。");

                                    },
                                    error: function() {
                                        alert("エラーが発生しました。もう一度お試しください。");
                                    }
                                });
                            });

                            $(".shinsa-checkbox").change(function() {
                                var id = $(this).data("id");
                                var shinsa = $(this).is(":checked") ? 1 : 0;

                                $.ajax({
                                    url: 'toggle_shinsa.php',
                                    type: 'GET',
                                    data: "id=" + id + "&shinsa=" + shinsa,
                                    success: function(response) {
                                        alert("審査設定が更新されました。");

                                    },
                                    error: function() {
                                        alert("エラーが発生しました。もう一度お試しください。");
                                    }
                                });
                            });
                        });
                    </script>
                </div>


            </div>
        </div>

</body>

</html>