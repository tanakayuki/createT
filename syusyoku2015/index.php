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
//    var_dump($temp);
    if (!$temp = $SELECT_query->SQL($temp)) {
        var_dump($response);
//        存在していない
//        新規作成
        $sql_new = array(
            'INSERT INTO' => "Login(`ac_types`, `user_id`, `names`, `picture`)",
            'VALUES' => "('$ac_type', '{$response['id']}', '{$response['name']}', '{$response['id']}.jpg')"
        );
        $temp = $SELECT->SQL($sql_new, '');
        $INSERT_query->SQL($temp);
//        登録名を出す
        $sql_login = array_merge($sql_login, array(
            'WHERE' => "ac_types='$ac_type'",
            'AND' => "user_id='{$response['id']}'"
        ));
        $temp = $SELECT->SQL($sql_login, '');
        $_SESSION['login_id'] = array(
            'type'=>$ac_type,
            'id'=>$response['id'],
            'name'=>$SELECT_query->SQL($temp)[0]['names']
        );
    } else {
//      存在する
//        var_dump($temp);
        $_SESSION['login_id'] = array(
            'type'=>$ac_type,
            'id'=>$response['id'],
            'name'=>$temp[0]['names']
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
<!DOCTYPE html>
<!-- saved from url=(0045)http://ianlunn.co.uk/plugins/jquery-parallax/ -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>home</title>

    <?php //js css 外部読み込み分のまとめ ?>
    <?php require_once("imput.php") ?>


    <link rel="stylesheet" type="text/css" href="jQuery Parallax Plugin Demo_files/reset.css">
<link href="./jQuery Parallax Plugin Demo_files/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./jQuery Parallax Plugin Demo_files/jquery.parallax-1.1.3.js"></script>
<script type="text/javascript" src="./jQuery Parallax Plugin Demo_files/jquery.localscroll-1.2.7-min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

    body_fade();

    //$('#nav').localScroll(800);
	$('#intro').parallax("10%", 0.1);
    $('#intro2').parallax("20%", 0.3);
    $('#second').parallax("30%", 0.1);
    $('#second2').parallax("50%", 0.3);
	$('.bg1').parallax("10%", 0.5);
	$('.bg2').parallax("10%", 0.2);
	$('#third').parallax("50%", 0.3);


    $('#intro').localScroll();
})
</script>


</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&appId=799166940143798&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>


<div id="warp">
<!--グローバルナビ-->
　　<?php //ヘッダー ?>
   <?php require_once("header.php");?>

<div id="intro" style="background-position: 50% 0px;">
    <div class="story">
      <div class="float-left">
        <h2>カスタマイズTシャツ？</h2>
          <div id="login">
          <p>まずはログイン</p>
              <p><a href="./login/google_login.php">
                      <img src="./images/google-login-button.png">
                  </a>
              </p>
          </div>
<!--          facebook-->
          <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
<!--      line  -->
          <span>
<script type=”text/javascript” src=”//media.line.me/js/line-button.js?v=20140127″ ></script>
<script type=”text/javascript”>
new media_line_me.LineButton({“pc”:true,”lang”:”ja”,”type”:”a”,”text”:”ここにURL“,”withUrl”:true});
</script>
</span>

          <!-- head 内か、body 終了タグの直前に次のタグを貼り付けてください。 -->
          <script src="https://apis.google.com/js/platform.js" async defer>
              {lang: 'ja'}
          </script>

          <!-- +1 ボタン を表示したい位置に次のタグを貼り付けてください。 -->
          <div class="g-plusone" data-annotation="inline" data-width="300"></div>


          <span>
<script type="text/javascript" src="//media.line.me/js/line-button.js?v=20140411" ></script>
<script type="text/javascript">
    new media_line_me.LineButton({"pc":false,"lang":"ja","type":"a"});
</script>
</span>
          <a href="http://line.me/R/msg/text/?LINE%E3%81%A7%E9%80%81%E3%82%8B%0D%0Ahttp%3A%2F%2Fline.me%2F">
              <img src="./images/sns/line.png" width="70" alt="LINEで送る" />
          </a>

      </div>
      </div> <!--.story-->
    </div>
  <!--#intro-->
  <div id="intro2" style="background-position: 50% 60px;">
  <img src="jQuery Parallax Plugin Demo_files/images/bg_g3_02.png" width="112" height="45">
  <p>START</p>

</div>



<div id="second" style="background-position: 50% 60px;">
    <div class="story">
    <div class="bg1" style="background-position: 50% 240px;"></div>
    <div class="bg2" style="background-position: 50% 240px;"></div>
      <div class="float-right">
        <h2>ここのサイトについて</h2>
        <p>みんなで作る新しい形のショッピングをご提供いたします</p>
      </div>
    </div> <!--.story-->
</div>

    <!--#second-->

<div id="second2" style="background-position: 50% 60px;">
  	<img src="jQuery Parallax Plugin Demo_files/images/bg_g3_02.png" width="112" height="45">
  	<p>NEXT</p>
</div>


  <div id="third" style="background-position: 50% 148px;">
    <div class="story">
    </div><!--.story-->
  </div><!--#third-->
    <?php //フッター領域?>
    <?php require_once("footer.php"); ?>
</div>

  
</body></html>