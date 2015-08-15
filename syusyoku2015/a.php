<!DOCTYPE html>
<!-- saved from url=(0026)http://9-bb.com/demo/0035/ -->
<html lang="ja"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="UTF-8">
  <meta name="robots" content="noindex">
  <title>9ineBB DEMO 0035</title>

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

    <style>
        html,body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        body > div {
            width: 100%;
            height: 100%;
        }

        h2 {
            text-align: center;
            font-size: 80px;
            margin: 0;
            width: 100%;
        }




        /* BLOCK3 */
        .block3 {
            background-color: #000044;
            background-attachment: fixed;
            -webkit-background-size: cover;
            background-size: cover;
            background-position: center center;
            position: relative;
            overflow: hidden;
        }

        .block3 h2 {
            color: #fff;
            position: absolute;
            top: 40%;
        }

        .block3:before {
            content: "";
            position: absolute;
            height: 400px;
            width: 300%;
            background: #fff;
            top: -200px;
            left: -100%;
            -webkit-transform: rotate(8deg);
            -ms-transform: rotate(8deg);
            -o-transform: rotate(8deg);
            transform: rotate(8deg);
        }
    </style>
</head>
<body>
  <div class="header">
      <div id="intro" style="background-position: 50% 0px;">
          <div id="intro2">
              <div class="story">
                  <?php //共通ヘッダー ?>
                  <?php require_once("header.php");?>
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
  </div>
  <div class="block2">
      <div class="story">
          <div class="bg1" style="background-position: 50% 240px;"></div>
          <div class="bg2"></div>
          <div class="float-right">
              <h2>マウスだけでカンタン作成</h2>
              <img src="jQuery Parallax Plugin Demo_files/images/about.png">
          </div>
      </div> <!--.story-->
  </div>
  <div class="block3">
    <h2>BLOCK 3</h2>
  </div>

</body></html>