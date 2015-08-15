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

    <link rel="stylesheet" type="text/css" href="css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="jQuery Parallax Plugin Demo_files/reset.css">
    <link href="./jQuery Parallax Plugin Demo_files/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="./jQuery Parallax Plugin Demo_files/jquery.parallax-1.1.3.js"></script>
    <script type="text/javascript" src="./jQuery Parallax Plugin Demo_files/jquery.localscroll-1.2.7-min.js"></script>
<!--    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">-->
<!--    <script src="js/jquery.min.js"></script>-->
    <script src="js/jquery.ghosttype-1.2.js"></script>
    <script src="js/jquery.inview.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.top_nav ul li').removeClass('active');
            $('.top_nav ul li:eq(0)').addClass('active');
//            body_fade();
            //$('#nav').localScroll(800);
            $('#intro').parallax("10%", 0.1);
            $('#second').parallax("30%", 0.1);
            $('.bg1').parallax("10%", 0.5);
            $('.bg2').parallax("30%", 0.2);
            $('#third').parallax("50%", 0.3);
            $('#intro').localScroll();
        });
        $(function () {
        /**
         *live使っている　スクロールに応じたアニメーション処理
         */
        $('#logo').on('inview', function(event, isInView, visiblePartX, visiblePartY) {
            if (isInView) {
                //要素が見えたときに実行する処理
                $(".float-right img").hide().toggleClass('animated fadeInRight');
            } else {
                //要素が見えなくなったときに実行する処理
                $(".float-right img").show().toggleClass('animated fadeInRight');
            }
        });
            $('footer').on('inview', function(event, isInView, visiblePartX, visiblePartY) {
                if (isInView) {
                    //要素が見えたときに実行する処理
                    $("#footer_title h1").show().toggleClass('fadeInDown animated');
                    $("#footer_title p").show().toggleClass('fadeInDown animated');
                    $("#footer_login").show().toggleClass('fadeInDown animated');

                    $(".con div").show().toggleClass('fadeInLeft animated');
                } else {
                    //要素が見えなくなったときに実行する処理
                    $("#footer_title h1").hide().removeClass('fadeInDown animated');
                    $("#footer_title p").hide().removeClass('fadeInDown animated');
                    $("#footer_login").hide().toggleClass('fadeInDown animated');

                    $(".con div").hide().toggleClass('fadeInLeft animated');
                }
            });
            $(".type").each(function() {
                var $this = $(this);
                var str = $this.text();
                $this.empty().show();
                str = str.split("");
//              str.push("|");
//                待機時間
                var delay = 100;
                $.each(str, function(i, val) {
                    if (val == "^") {
//              ^を書くと待機する
                } else {
                        $this.append('<span>' + val + '</span>');
                        $this.children("span").hide().fadeIn(100).delay(delay * i);
                    }
                });
                $this.children("span:last").css("textDecoration", "blink");
            });
        });
        $(function () {
            slidr.create('slidr-inline-static', {
                breadcrumbs: true,
//                controls: 'corner',
                fade: false,
                overflow: false,
                theme: '#222',
                timing: { 'linear': '0.5s ease-in' },
                transition: 'linear'
            }).start();
        });
    </script>
</head>
<body>
<style>
    .fadeInRight{
        /* ５秒かけてアニメーションする */
        /*-webkit-animation-duration: 3s;*/
        /*animation-duration: 2s;*/
        /* 4秒待ってからアニメーションする */
        /*-webkit-animation-duration: 4s;*/
        /*animation-delay: 4s;*/
        /* 5回繰り返す */
        /*-webkit-animation-iteration-count: 5;*/
        /*animation-iteration-count: 5;*/
    }
</style>
<div id="warp">
    <div id="intro" style="background-position: 50% 0px;">
        <div id="intro2">
        <div class="story">
            <?php //共通ヘッダー ?>
            <?php require_once("header.php");?>
<!--        --><?php //require_once "top_img.php"; ?>
        <style>
            .footer_container{
                width: 90%;
                margin: 0 auto;
            }
            .con{
                float: left;
                width: 50%;
            }
        </style>
            <div class="float-left">
<!--          <h1><img src="images/top_text.png"></h1>-->
                <div id="top_Lcon">
                <div id="top_text">
                    <p class="type">ORIGINAL</p>
                    <p class="type">^^^^^^T-SHIRT</p>
                    <p class="type">^^^^^^^^^CREATE</p>
                    <p style="font-size: 15px">みんなで作る新しい形のショッピングをご提供いたします。</p>
                </div>
                <div id="login">
                    <a class="btn_custom" href="./login/google_login.php">
                        まずはログイン
                    </a>
                </div>
                    <div id="sns">
                        <span><img src="images/sns/facebook.png"></span>
                        <span><img src="images/sns/googleplus.png"></span>
                        <span><img src="images/sns/twitter.png"></span>
                    </div>
                </div>
                    <?php require_once("top_slider.php");?>
            </div>
        </div>
        </div>
    </div>



    <div id="second" style="background-position: 50% 60px;">
        <div class="story">
            <div class="bg1" style="background-position: 50% 240px;"></div>
    <div class="bg2"></div>
        <div class="float-right">
<h2>マウスだけでカンタン作成</h2>
        <img src="jQuery Parallax Plugin Demo_files/images/about.png">
      </div>
    </div> <!--.story-->
</div>

    <div id="third" style="background-position: 50% 148px;">
        <div class="story">
            <div class="footer_container">
                <div class="con_text">
                    <div id="footer_title"  style="text-align:center;">
                        <h1 style="display:none;visibility: visible;">All In ONE For You</h1>
                        <p style="display:none;visibility: visible;">すべてのサービスを貴方に</p>
                    </div>
                </div>
                <div id="footer_login" style="display: none;">
                    <a class="btn_custom" href="./login/google_login.php" style="margin: 0 auto;">
                        簡単ログイン
                    </a>
                </div>
                <div class="con_area">
                    <div class="con">
                        <div class="item" style="display:none;">
                            <img src="./images/numbers.png">
                            <h2>ぴったりなものを探しに行こう！</h2>
                            <button type="button" class="btn_custom" style="margin: 0 auto;">検索する</button>
                        </div>
                    </div>
                    <div class="con">
                        <div class="item" style="display:none;visibility: visible;-webkit-animation-delay: 0.5s; -moz-animation-delay: 0.5s; animation-delay: 0.5s;">
                            <img src="./images/analytics_two.png" width="128" height="128">
                            <h2>自分で新たな作品を生み出そう！</h2>
                            <button type="button" class="btn_custom" style="margin: 0 auto;">作成する</button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--.story-->
    </div><!--#third-->
    <?php //フッター領域?>
    <?php require_once("footer.php"); ?>
</div>
</body></html>