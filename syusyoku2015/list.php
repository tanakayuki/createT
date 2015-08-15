<?php
require_once 'class.php';
//ログインしてない場合はトップへ
session_start();
if(!isset($_SESSION['login_id'])){
    header("location:index.php");
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
<script src="./plugin/simplePagination/jquery.simplePagination.js"></script>


    <script>
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
            function setPreference(){
                $.ajaxSetup({async: false});
                $.getJSON("js/ajax.php?"+query,{
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
            $("#search").click(function () {
                var flg = 0;
                var $form = $('#form1');
                query = $form.serialize();
//                var param = $form.serializeArray();
                var flg=0;
//                console.log(query);  // => "my-text=This+is+text.&my-multi-select=B&my-multi-select=C"
//                console.log(param);  // => [{name:"my-text",value:"This is text."},（省略）]
                $.ajax({
                    url: 'js/ajax.php?'+query,
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
                $.get("js/ajax.php?"+query,{mode:1,"sql_mode":"max","page":1}, function(max){
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
            flg=0;
            $.ajax({
                url: 'js/ajax.php?'+query,
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
                     <li class="clothes_list">
                     <div class="list_item">
                         <a href=""><img src="data:image/jpg;base64,{image}"/></a>
                         <div class="clothes_text">
                             <p class="clothes_title">{title}</p>
                             <p>{comment}</p>
                         </div>
                     </div>
                     </li>
                     */}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
                    html_str = html_str.replace("{image}",data_list[i]['image_data']);
                    html_str = html_str.replace("{title}",data_list[i]['title']);
                    html_str = html_str.replace("{comment}",data_list[i]['comment']);
                }
                html_str="<p>対象商品数："+new_max+"件見つかりました。</p>"+html_str;
                document.getElementById("clothes_view").innerHTML = html_str ;
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
</style>
</head>
<body>
<div class="wrapper">
  <?php //共通ヘッダー ?>
  <?php require_once("header.php");?>
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
            <tr class="search_type">
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
            <tr class="search_type">
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
           <p id="search" class="btn"> 探 す </p>
        </form>
        </div>      
    	
        
        
       <div id="C_cont">
           <header class="search_head">
       <p>SEARCH</p><span style="font-size: smaller;">検索結果</span>
           </header>
           <div id="paging"></div>
       <div>
           <ul id="clothes_view"></ul>
       </div>
       </div>
         
      </div>
        
      </div>
    <?php //共通フッター?>      
 	<?php require_once("footer.php"); ?>
</body>
</html>