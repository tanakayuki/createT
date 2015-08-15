<?php
require_once 'class.php';
//ログインしてない場合はトップへ
session_start();
if(!isset($_SESSION['login_id'])){
    header("location:index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--    js css 外部読み込み分のまとめ-->
    <?php require_once("imput.php") ?>
<!--    ダイアログ関連-->
    <script type="text/javascript" src="./js/func.js"></script>
    <script type="text/javascript" src="./js/js.js"></script>
    <script type="text/javascript"src="./js/jquery-ui.min.js"></script>
    <link href="./css/jquery-ui-1.8.12.custom.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<!--    共通レイアウト-->
    <link rel="stylesheet" type="text/css" href="css/css.css">
    <script type="text/javascript"src="./js/jquery-ui-1.11.2.custom/jquery-ui.js"></script>
<!--    スマホ用-->
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <script>
        //ヘルプスイッチ
        $(function(){

            $(".tag").click(function(){
                $(".val1").toggle();
                $(".val2").toggle();
                $("#tag1").slideToggle('fast');
                $("#tag2").slideToggle('fast');
                //トグル時に内容削除
                $("#tag2 input").val('');
            });

            $("#help_img").click(function(){
                $(this).toggleClass('off');
                $(this).toggleClass('on');
                $(".fix").fadeToggle("slow", "linear");
                $("#help_text").fadeToggle("slow", "linear");
                $("#jquery-ui-draggable-wrap").fadeToggle("slow", "linear");
            });
        });

        $(document).ready(function(){
                $('.top_nav ul li').removeClass('active');
                $('.top_nav ul li:eq(3)').addClass('active');
            respon_width();
//    body_fade();
            $(function () {
                $(".fix").css({opacity: '0'});
                setTimeout(function () {
                    $(".fix").stop().animate({opacity: '1'}, 700);
                }, 700);
            });
        });

        $(function(){
            $("#toggle").click(function(){
                $("#L_cont").slideToggle();
                //return false;
            });
        });
    </script>
    <style>
        #jquery-ui-draggable-wrap {
            display: block;
            width: 300px;
            height:460px;
            margin: 0;
            border-style: dashed;
            border-radius: 10px;
            position: absolute;
            top:36%;
            right: 30%;
        }
        .move_img{
            cursor: pointer;
            width: 200px;
            height: 200px;
            z-index: 20;
        }
        .move_img:hover{
            background-color: rgba(255,255,255,0.4);
        }
        .move_text{
            cursor: pointer;
            overflow: visible;
            width: 30%;
            z-index: 30;
        }
        .move_text:hover{
            background-color: rgba(255,255,255,0.4);
        }
        .select_now{
            border: dashed 1px #000000;
        }
        .imageCover6{
            width: 100%;
            width: 100%;
        }
    </style>

    <title>デザイン作成ページ</title>
</head>
<body>
<div class="wrapper">
    <?php //共通ヘッダー ?>
    <?php require_once("header.php");?>
    <div id="header_text">
        <div id="page_text">
            <h1>Creation page</h1>
            <span>作成ページ</span>
        </div>
    </div>
    <div id="content" >
        <div id="L_cont" style="width: 25%;">
            <h2 class="page-header search_select">作成メニュー</h2>
            <form action="comfrem.php" id="Form" method="POST">
                <table>
                    <tr class="search_type">
                        <td>服のタイトル</td>
                    </tr>
                    <tr class="search_type_now">
                        <td>
                            <div class="<?php if(isset($url[0]['title']['title_border'])){echo $url[0]['title']['title_border'];}?>">
                                <input type="text" name="title" placeholder="タイトルを入力してください" value="<?php if(isset($value['title'])){echo $value['title'];}?>">
                                <?php if(isset($url[0]['title']['title_border'])){?>
                                    <span class="help-inline">
                                    <?php if(isset($url[0]['title']['title_err'])){echo $url[0]['title']['title_err'];}?>
                                    </span><?php }?>
                            </div>
                        </td>
                </table>
                <table>
                    <tr class="search_type">
                        <td>服の種類</td>
                    </tr>
                    <tr class="search_type_now">
                        <td>
                            <select name="select" id="select">
                                <option value="st">Tシャツ（半袖）</option>
                                <option value="lt">Tシャツ（長袖）</option>
                                <option value="p">パーカー</option>
                            </select>
                </table>
                <table>
                    <tr class="search_type">
                        <td>服の色</td>
                    </tr>
                    <tr class="search_type_now">
                        <td>
                            <input type="radio" name="color" id="not" value="white" checked="">
                            <input type="radio" name="color" id="red" value="red">
                            <input type="radio" name="color" id="bule" value="bule">
                            <input type="radio" name="color" id="green" value="green">
                            <input type="radio" name="color" id="broun" value="gray">
                        </td>
                    </tr>
                </table>
                <table>
                    <tr class="search_type">
                        <td>タグ</td>
                    </tr>
                    <tr class="search_type_now">
                        <td>
                            <input type="button" class="btn tag val1" value="新規タグ" style="display:block"/>
                            <input type="button" class="btn tag val2" value="戻る"  style="display:none"/>
                            <section id="tag1">
                                <select name="tag1" id="" style="display:block">
                                    <?php tag_list();?>
                                </select>
                            </section>
                            <section id="tag2" style="display:none">
                                <label>タグ名：</label><input type="text" name="tag2" id="tag2_val"/>

                            </section>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr class="search_type">
                        <td>コメント <br><sapn class="tyuu">*公開時に服をアピールするコメントです</sapn></td>
                    </tr>
                    <tr class="search_type_now">
                        <td>
                            <textarea name="comment" rows="" cols=""></textarea>
                        </td>
                    </tr>
                </table>
                <?php
                /******************
                 *公開情報用
                 *
                 ********************/?>
                <table>
                    <tr class="search_type">
                        <td>
                            <input type="checkbox" name="open" value="1"/>
                            全体に公開する
                        </td>
                    </tr>
                </table>
                <table style="background-color: transparent;"><tr>
                        <td>
                            <?php
                            /******************
                             *情報送信用のhidden
                             *情報はAjaxにより更新する
                             ********************/?>
                            <input type="hidden" id="syu" value="st"  />
                            <input type="hidden" id="color" value="white"  />
                            <p id="edi" class="btn_custom">作　成</p>
<!--                        <input type="button" class="btn" id="edi" value="作　成"  />-->
            </form>
            </td>
            </tr>
            </table>
        </div>

        <div id="C_cont" style="width: 60%;">
            <div class="fix">
                <img id="help2" src="images/help2.png" />
                <img id="help1" src="images/help1.png" />
            </div>
            <div class="page-header">
                <h2 class="search_select">制作シート</h2>
                <div id="help">
                    <span>ヘルプの表示切り替え</span>
                    <p id="help_img" class="on"></p>
                    <p id="help_text"></p>
                </div>
                <div id="text_input">
                    スタンプテキスト<br>
                    <input type="text"><br>
                    <span>*テキストを入力すると作成シートに表示されます</span>
                </div>
            </div>
            <div class="imageCover6">
                <canvas id="jsImageCoverCanvas"></canvas>
                <div id="jquery-ui-draggable-wrap">
                <div class="move_text"><p></p></div>
                <div class="move_img">
<!--                <canvas id="jsImageCoverCanvas2"></canvas>-->
                </div>
                </div>
            </div>
        </div>



    </div>
    <?php //共通フッター?>
    <?php require_once("footer.php"); ?>
</div>

<div id="jquery-ui-dialog" title="確認ダイアログ">
    <p>このデザインで作成しますか？</p>
</div>

</body>
</html>