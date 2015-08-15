<?php
ini_set( 'display_errors', 1 );
require_once 'class.php';
//ログインしてない場合はトップへ
session_start();
if(!isset($_SESSION['login_id'])){
    header("location:index.php");
}
else{
    $tag_name="";
    $color="";
    $temp="";

    $SELECT_query = new SELECT_query();
    $SELECT = new SELECT();
    $sql_login = json_decode(SQL_LOGIN, true);
    $sql_login = array_merge($sql_login, array(
        'WHERE' => "ac_types='{$_SESSION['login_id']['type']}'",
        'AND' => "user_id='{$_SESSION['login_id']['id']}'"
    ));
    $temp = $SELECT->SQL($sql_login, '');
    if (!$list = $SELECT_query->SQL($temp)) {

    }else{
//        ユーザーお気に入り
        $sql_user_fav = json_decode(SQL_USER_FAV, true);
        $sql_user_fav['WHERE']="favorite.user_id!='{$_SESSION['login_id']['id']}'";
//        ユーザーカラー
        $sql_user_color = json_decode(SQL_USER_COLOR, true);
        $sql_user_color['WHERE']="Clothes.user_id='{$_SESSION['login_id']['id']}'";
//        ユーザータグ
        $sql_user_tag = json_decode(SQL_USER_TAGS, true);
        $sql_user_tag['WHERE']="Clothes.user_id='{$_SESSION['login_id']['id']}'";
        $temp = $SELECT->SQL($sql_user_color, '');
        if ($color = $SELECT_query->SQL($temp)) {
            $color = $color[0]['color'];
        }
        $temp = $SELECT->SQL($sql_user_tag, '');
        if ($tag_name = $SELECT_query->SQL($temp)) {
            $tag_name = $tag_name[0]['tag_name'];
        }
        $temp = $SELECT->SQL($sql_user_fav, '');
//       var_dump($temp);
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>服検索</title>
<?php //js css 外部読み込み分のまとめ ?>
<?php require_once("imput.php") ?>
<?php //共通レイアウト ?>
<link rel="stylesheet" type="text/css" href="css/css.css">
<link rel="stylesheet" type="text/css" href="./plugin/simplePagination/simplePagination.css" />
<link rel="stylesheet" type="text/css" href="./css/common.css" />
<script src="./plugin/simplePagination/jquery.simplePagination.js"></script>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">


<script>

$(document).ready(function() {
    $('.top_nav ul li').removeClass('active');
    $('.top_nav ul li:eq(2)').addClass('active');
});

jQuery(window).load(function(){
    // #loading は、ローディングの画像（を囲む）要素名に置き換えてください。
    jQuery("#loading").hide();
});
    /***************
     * 定数
     ***************/
    var one_page_max = 9;
    var max = 8;
    var query="select=&color[]=white&tag=&title=";
    var new_max=0;
    /***************
     * 変数宣言
     **************/
    var html_str="";
    /********************
     * エンターでのsubmitを防ぐ
     ********************/
    $(function() {
        $(document).on("keypress", "input:not(.allow_submit)", function(event) {
            return event.which !== 13;
        });
    });
    /********************
     * 初回ロード
     ********************/
    $(document).ready(function(){
        respon_width();
        page_max(1);
        next_back();
    });
    /********************
     * 初回読み込みデータ
     ********************/
    function next_back(){
        html_str = "";
        itemlist = new Array();
        setPreference();
        inner_str(itemlist);
        jQuery("#loading").hide();
        function setPreference(){
            $.ajaxSetup({async: false});
            $.getJSON("js/Ajax.php?"+query,{
                mode:1,
                sql_mode:"all",
                "page":"1"
            }, function(data){
                itemlist = data;
            });
            $.ajaxSetup({async: true});
        }
    }
    /***********************
     * 検索
     ************************/
    $(function() {
        $("#srch").click(function () {
            jQuery("#loading").show();
            var flg = 0;
            var $form = $('#form1');
            query = $form.serialize();
//                var param = $form.serializeArray();
            var flg=0;
//                console.log(query);  // => "my-text=This+is+text.&my-multi-select=B&my-multi-select=C"
//                console.log(param);  // => [{name:"my-text",value:"This is text."},（省略）]
            $.ajax({
                url: 'js/Ajax.php?'+query,
                dataType: 'json',
                data: {// 送信データ
                    "mode": 1,
                    "sql_mode":"search",
                    "page":1
                },
                success : function(response){
//alert("データ件数"+response.length);
                    itemlist = new Array();
                    itemlist = response;
                },
                error: function(response){
                    itemlist = new Array();
                    flg=1;
//                      return response;
                },
                complete : function(){
                    html_str = "";
                    if(flg==0) {
                        page_max(1);
                        inner_str(itemlist);
                    }else{
                        err_str();
                    }
                }
            });
        });
    });
    /**************************
     * ページング（最大件数を求める）
     **************************/
    function page_max(page_now){
        new_max=0;
        setPreference();
        function setPreference(){
            $.ajaxSetup({async: false});
            $.get("js/Ajax.php?"+query,{mode:1,"sql_mode":"max","page":1}, function(max){
                new_max = max;
            });
            $.ajaxSetup({async: true});
        }
//max件数
//alert("max件数"+new_max);
        max= Math.ceil(new_max/one_page_max);
//ページャー数
//alert("ページャー数"+max);
        $("#paging").pagination({
            items: max, //ページングの数
            displayedPages: 4, //表示したいページング要素数
            prevText: '前', //前へのリンクテキスト
            nextText: '次', //次へのリンクテキスト
            cssStyle: 'light-theme', //テーマ"dark-theme"、"compact-theme"があります
            currentPage:page_now,//現在のページ
            onPageClick: function(pageNumber){pageing(pageNumber)}
        })
    }
    /**************************
     * ページング（指定したページの内容を取る）
     **************************/
    function pageing(page){
        jQuery("#loading").show();
        flg=0;
        $.ajax({
            url: 'js/Ajax.php?'+query,
            dataType: 'json',
            data: {// 送信データ
                "mode": 1,
                "sql_mode":"search",
                "page":page
            },
            success : function(response){
//alert("データ件数"+response.length);
                itemlist = new Array();
                itemlist = response;
            },
            error: function(response){
                itemlist = new Array();
                flg=1;
//                      return response;
            },
            complete : function(){
//                      console.log(itemlist);
                html_str = "";
                if(flg==0) {
                    inner_str(itemlist);
                    page_max(page);
                }else{
                    err_str();
                }
            }
        });
    }
    /********************
     * html要素作成
     ********************/
    function inner_str(data_list){
        $(function(){
            for(var i = 0; i < data_list.length; i++) {
                html_str  += (function () {/*
                 <li class="wdc_post" id="post-1830">
                 <div class="wdc_inner">
                 <div>
                 <img src="data:image/jpg;base64,{image}" class="attachment-medium wp-post-image" alt=""></div>
                 <div class="wdc_cap">
                 <p class="wdc_t">作品名：{title}</p>
                 <p class="wdc_u">{comment}</p>
                 <ul>
                 <li class="launch"><a href="" target="_blank">お気に入り</a></li>
                 <li class="detail"><a href="">ファン登録</a></li>
                 </ul>
                 </div>
                 <div class="myclip"><img src="" alt="Loading" class="wpfp-hide wpfp-img">
                 <a class="wpfp-link myclip_off" href="" rel="nofollow">&nbsp;</a></div></div>
                 </li>
                 */}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
                html_str = html_str.replace("{image}",data_list[i]['image_data']);
                html_str = html_str.replace("{title}",data_list[i]['title']);
                html_str = html_str.replace("{comment}",data_list[i]['comment']);
            }
            html_str="<p>対象商品数："+new_max+"件見つかりました。</p>"+html_str;
            document.getElementById("clothes_view").innerHTML="";
            jQuery("#loading").fadeOut("slow");
            setTimeout(function() {
                document.getElementById("clothes_view").innerHTML = html_str ;
            }, 600);
        });
    }
    /**********************
     * 検索結果が0件もしくはAjaxエラー時
     **********************/
    function err_str(){
        document.getElementById("clothes_view").innerHTML = "<p>検索結果は0件です。</p>";
    }

    $(function(){
        $("#toggle").click(function(){
            $("#L_cont").slideToggle();
            //return false;
        });
    });
</script>

<style>
    /*チェックボックスの装飾*/
    input[type="checkbox"]{
        -webkit-appearance: none;
        width:40px;
        height:40px;
        border:2px solid #19283C;
        border-radius:15px;
        opacity:0.5;
    }
    input[type="checkbox"]:checked{
        border:8px solid #F00;
        border-radius:50%;
    }

    #color-cip{
        -webkit-appearance: none;
        width:40px;
        height:40px;
        border:2px solid #19283C;
        border-radius:15px;
        opacity:0.5;
    }
    .not{
        background:#fff;
    }
    .red{
        background:#F30;
    }
    .bule{
        background:#00F;
    }
    .green{
        background:#6F0;
    }
    .broun{
        background:#C93;
    }





#search{
    display: inline-block;
    padding: 4px 12px;
    margin-bottom: 0;
    font-size: 14px;
    line-height: 20px;
    color: #333333;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    vertical-align: middle;
    cursor: pointer;
    background-color: #f5f5f5;
    background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
    background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
    background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
    background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
    background-repeat: repeat-x;
    border: 1px solid #cccccc;
    border-color: #e6e6e6 #e6e6e6 #bfbfbf;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    border-bottom-color: #b3b3b3;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
    -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
    }
</style>
</head>
<body>
<div class="wrapper">
    <?php //共通ヘッダー ?>
    <?php require_once("header.php");?>
    <div id="header_text">
        <div id="page_text">
        <h1>Search page</h1>
        <span>検索ページ</span>
        </div>
    </div>
    <div id="content">
        <div id="L_cont">
            <h2 class="search_select">検索方法</h2>
            <form id="form1">
                <table>
                    <tr class="search_type">
                        <td>服の種類</td>
                    </tr>
                    <tr class="search_type_now">
                        <td>
                            <select name="select" id="select">
                                <option value="all">- 選択 -</option>
                                <option value="st">Tシャツ（半袖）</option>
                                <option value="lt">Tシャツ（長袖）</option>
                                <option value="p">パーカー</option>
                            </select>
                            <span class="example">例）Tシャツ（半袖）</span>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr class="search_type" style="padding-left: 10%;">
                        <td>服の色</td>
                    </tr>
                    <tr class="search_type_now">
                        <td>
                            <input type="checkbox" name="color[]" id="not" value="white" checked="">
                            <input type="checkbox" name="color[]" id="red" value="red">
                            <input type="checkbox" name="color[]" id="bule" value="bule">
                            <input type="checkbox" name="color[]" id="green" value="green">
                            <input type="checkbox" name="color[]" id="broun" value="gray"><br>
                            <span class="example">*探したい色を選択してください</span>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr class="search_type" style="padding-left: 20%;">
                        <td>タグ</td>
                    </tr>
                    <tr class="search_type_now">
                        <td><select name="tag">
                                <option value="all">- 選択 -</option>
                                <?php tag_list();?>
                            </select>
                            <span class="example">例）かわいい</span>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr class="search_type">
                        <td>キーワード入力</td>
                    </tr>
                    <tr class="search_type_now">
                        <td>
                            <input type="text" name="title" placeholder="キーワードを入力できます">
                            <span class="example">例）HAL</span>
                        </td>
                    </tr>
                </table>
                <p id="srch" class="btn_custom">検索する</p>
<!--                <p id="search"><img src="images/search.png "></p>-->
            </form>
        </div>



        <div id="C_cont">
            <header class="search_head">
                <span style="font-size: smaller;">検索結果</span>
            </header>
            <div id="paging"></div>
            <div class="wdc_area">
                <div id="loading"><img src="images/loading.gif"></div>
                <ul class="wdc_contents" id="clothes_view">
                </ul>
            </div>
        </div>

        <div id="R_cont">
            <h2 class="search_select">あなたの情報</h2>
            <table class="table">
                <tr>
                    <td>人気ランキング</td>
                    <td>２位</td>
                </tr>
                <tr>
                    <td>アカウント</td>
                    <td><?php echo $list[0]['ac_types']; ?></td>
                </tr>
                <tr>
                    <td>よく使うタグ</td>
                    <td><?php echo $tag_name; ?></td>
                </tr>
                <tr>
                    <td>よく使う色</td>
                    <td><div id="color-cip" class="<?php echo $color; ?>"></div></td>
                </tr>
            </table>
            <h2 class="search_select">気になる</h2>
            <table>
                <tr class="search_type_now">
                    <td>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</div>
<?php //共通フッター?>
<?php require_once("footer.php"); ?>
</body>
</html>