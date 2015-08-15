<?php
session_start();
//google login用
require_once './login/login_dif.php';
require_once 'class.php';
$SELECT = new SELECT();
$SELECT_query = new SELECT_query();
$INSERT_query = new INSERT_query();
$sql_login = json_decode(SQL_LOGIN, true);

if(isset($_SESSION['google'])) {
    unset($_SESSION['google']);
    $app_id = GG_app_id;
    $app_secret = GG_app_secret;
    $my_url = GG_my_url;

    $code = $_REQUEST["code"];
    $token_url = "https://accounts.google.com/o/oauth2/token";
    $params = "code=" . $code;
    $params .= "&client_id=" . $app_id;
    $params .= "&client_secret=" . $app_secret;
    $params .= "&redirect_uri=" . urlencode($my_url);
    $params .= "&grant_type=authorization_code";
    $response = dorequest($token_url, $params, 'POST');
    $response = json_decode($response);
}
    if (isset ($response->access_token)) {
        $info_url = 'https://www.googleapis.com/oauth2/v1/userinfo';
        $params = 'access_token=' . urlencode($response->access_token);
        unset ($response);
        $response = dorequest($info_url, $params, 'GET');

        $ac_type = "google";
        $response = json_decode($response, true);
        $sql_login = array_merge($sql_login, array(
            'WHERE' => "ac_types='$ac_type'",
            'AND' => "user_id='{$response['id']}'"
        ));
        $temp = $SELECT->SQL($sql_login, '');
        var_dump($temp);
        if (!$SELECT_query->SQL($temp)) {
            var_dump($response);
//        存在していない
//        新規作成
            $sql_new = array(
                'INSERT INTO' => "Login(`ac_types`, `user_id`, `names`, `picture`)",
                'VALUES' => "('$ac_type', '{$response['id']}', '{$response['name']}', '{$response['id']}.jpg')"
            );
            $temp = $SELECT->SQL($sql_new, '');
            $INSERT_query->SQL($temp);
            $_SESSION['login_id'] = array(
                'type'=>$ac_type,
                'id'=>$response['id']
            );
        } else {
//      存在する
            echo "存在する";
            $_SESSION['login_id'] = array(
                'type'=>$ac_type,
                'id'=>$response['id']
            );
        }
    }
    function dorequest($url, $params, $type)
    {
        $ch = curl_init();
        if ($type == 'POST') {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_POST, 1);
        } else
            curl_setopt($ch, CURLOPT_URL, $url . "?" . $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        unset ($response);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
?>
<!doctype html>
<html lang="ja">
<head>
<meta charset="UTF-8">

<title>top</title>
<style>
#top{
	width:100%;
	height:500px;
	background:#666;
}
#G_navi{
	position:absolute;
	z-index:9999;
	top:0;
	width:20%;
	height:2000px;
	background-color:#333;
	overflow:hidden;
	float:left;
	margin-left:5%;
}
#content{
	position:absolute;
	margin-left:25%;
}
.item{
	float:left;
	width:250px;
	height:300px;
	background-color:#999;
	border:solid 1px #0000CC;
	margin:1%;
}
</style>
</head>
<body>

<!---->
<!--<section id="top">-->
<!---->
<!--</section>-->
<!---->
<!--<section id="G_navi">-->
<!--    <ul>-->
<!--        <li>カート</li>-->
<!--        <li>マイページ</li>-->
<!--    </ul>	-->
<!--</section>-->
<!--<section id="content">-->
<!--  <ul>-->
<!--        <li class="item"></li>-->
<!--        <li class="item"></li>-->
<!--        <li class="item"></li>-->
<!--        <li class="item"></li>-->
<!--        <li class="item"></li>-->
<!--        <li class="item"></li>-->
<!--        <li class="item"></li>-->
<!--        <li class="item"></li>-->
<!--    </ul>	-->
<!--</section>-->
</body>
</html>