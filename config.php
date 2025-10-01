<?php

$esurl = "";  //ホームページアドレスを指定

$imgurl = "";  //ホームページアドレスを指定

$photoimg = "";  //ホームページアドレスを指定
$tomail = "";
$bbsmail = "";
$mobile = "";

$kanriName = "";

//DB接続

try {
    $dbh = new PDO('mysql:host=hostname;dbname=dbname', 'userid', 'password');
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}


function getDbConnection()
{
    $dsn = 'mysql:host=hostname;dbname=dename;charset=utf8mb4';
    $user = 'userid';
    $pass = 'password';

    try {
        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        exit("接続失敗: " . $e->getMessage());
    }
}

function checked($w1, $w2)
{
    return ($w1 == $w2) ? ' checked' : '';
}

function selected($w1, $w2)
{
    return ($w1 == $w2) ? ' selected' : '';
}

//文字列の場合、強制的に0にする
function cnum($word)
{
    if (is_numeric($word)) {
        return $word + 0;
    } else {
        return 0;
    }
}


function renull($value)
{
    return trim($value) === '' ? null : $value;
}


function userloginch($id, $pass)
{
    $dbh2 = getDbConnection();
    if (!empty($id) && !empty($pass)) {

        $sql = "select * from t_user where email =:id and dele=0 and taikai=0";
        $user = $dbh2->prepare($sql);
        $user->bindValue(":id", $id, PDO::PARAM_STR);
        $user->execute();
        $prs = $user->fetch(PDO::FETCH_ASSOC);

        if (!empty($prs)) {

            if ($pass === $prs["password"]) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function control_login($id, $pass)
{
    $dbh2 = getDbConnection();
    if (!empty($id) && !empty($pass)) {

        $sql = "select * from t_passwd where userid =:userid";
        $user = $dbh2->prepare($sql);
        $user->bindValue(":userid", $id, PDO::PARAM_STR);
        $user->execute();
        $prs = $user->fetch(PDO::FETCH_ASSOC);

        if (!empty($prs)) {

            if ($pass === $prs["password"]) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function rers($rsobj, $name, $default)
{
    if (is_array($rsobj) && !empty($rsobj)) {
        return $rsobj[$name] ?? $default;
    } else {
        return $default;
    }
}


//ページネスト


function writeNavi($url, $webmax, $nowpoint, $count, $joken)
{
    $str = "";
    $joken2 = "";
    $joken3 = "";
    $e = 0;

    if ($nowpoint > 0) {
        $e = floor($nowpoint / $webmax); // 小数切り捨て
    }

    if (!empty($joken)) {
        $joken2 = '&' . $joken;
        $joken3 = '?' . $joken;
    }

    if ($nowpoint - $webmax >= 0 || $nowpoint + $webmax < $count) {
        $str .= '<ul class="navi container">';

        // 最初へ
        if ($nowpoint - $webmax >= 0) {
            $str .= '<li class="prest"><a href="' . $url . $joken3 . '">|最初</a>&nbsp;</li>';
            // 前ページ
            if (($nowpoint - $webmax) > 0) {
                $str .= '<li class="pre"><a href="' . $url . '?point=' . ($nowpoint - $webmax) . $joken2 . '">＜＜前へ</a>&nbsp;</li>';
            } else {
                $str .= '<li class="pre"><a href="' . $url . $joken3 . '">＜＜前へ</a>&nbsp;</li>';
            }
        }

        // ページ番号範囲
        $total_pages = ceil($count / $webmax);
        $e1 = max($e - 1, 1);
        $e2 = min($e + 3, $total_pages);
        if ($e2 < 5) $e2 = min(5, $total_pages);

        if ($e1 > 1) $str .= "<li>..</li>";
        for ($a = $e1; $a <= $e2; $a++) {
            if (($e + 1) != $a) {
                $str .= '<li class="centertext">';
                if ($a != 1) {
                    $str .= '<a href="' . $url . '?point=' . (($a - 1) * $webmax) . $joken2 . '">';
                } else {
                    $str .= '<a href="' . $url . $joken3 . '">';
                }
            } else {
                $str .= '<li class="centertext ontab">';
            }

            $str .= $a;

            if (($e + 1) != $a) {
                $str .= '</a>';
            }
            $str .= '</li>';
        }
        if ($e2 < $total_pages) $str .= "<li>..</li>";

        // 次ページと最後へ
        if ($e < $total_pages - 1) {
            $str .= '<li class="next"><a href="' . $url . '?point=' . ($nowpoint + $webmax) . $joken2 . '">次へ＞＞</a>&nbsp;</li>';
            $str .= '<li class="nextst"><a href="' . $url . '?point=' . (($total_pages - 1) * $webmax) . $joken2 . '">&nbsp;最後|</a></li>';
        }

        $str .= "</ul>";
    }

    echo $str;
}



//メールマガジン送信
$url = "";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "エラー: " . curl_error($ch);
} else {
    //echo $response;
}
curl_close($ch);
//メールマガジン送信ここまで