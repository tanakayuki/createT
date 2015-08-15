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

    <?php //js css 外部読み込み分のまとめ ?>
	<?php require_once("imput.php") ?>    
    <?php //ダイアログ関連 ?>
    <script type="text/javascript" src="./js/js.js"></script>
    <script type="text/javascript"src="./js/jquery-ui.min.js"></script>
    <link href="./css/jquery-ui-1.8.12.custom.css" rel="stylesheet" type="text/css">
    <?php //共通レイアウト ?>
	<link rel="stylesheet" type="text/css" href="css/css.css">

<script>
$(function(){
	$(".tag").click(function(){
		$(".val1").toggle();
		$(".val2").toggle();
		$("#tag1").slideToggle('fast');
		$("#tag2").slideToggle('fast');
        //トグル時に内容削除
        $("#tag2 input").val('');
	});
});

//ヘルプスイッチ
$(function(){
$("#help_img").click(function(){
$(this).toggleClass('off');
$(this).toggleClass('on');
$(".fix").fadeToggle("slow", "linear");
$("#help_text").fadeToggle("slow", "linear");;
});
});

$(document).ready(function(){
    respon_width();
    body_fade();
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

<title>デザイン作成ページ</title>
</head>
<body>
<div class="wrapper"> 
	<?php //共通ヘッダー ?>
	<?php require_once("header.php");?>
      <div id="content" >
      	<div id="L_cont" class="well">
       <h2 class="page-header">作成メニュー</h2>
  		<form action="comfrem.php" id="Form" method="POST">
        <table class="table">
            <tr>
                <td>
                    <label>服のタイトル</label>
                    <div class="<?php if(isset($url[0]['title']['title_border'])){echo $url[0]['title']['title_border'];}?>">
                        <input type="text" name="title" placeholder="タイトルを入力してください" value="<?php if(isset($value['title'])){echo $value['title'];}?>">
                        <?php if(isset($url[0]['title']['title_border'])){?>
                            <span class="help-inline">
                            <?php if(isset($url[0]['title']['title_err'])){echo $url[0]['title']['title_err'];}?>
                            </span><?php }?>
                    </div>
                </td>
            </tr>
            <tr>
           <td><label>服の種類</label>
	        
            <select name="select" id="select">
            	<option value="st">Tシャツ（半袖）</option>
    	    	<option value="lt">Tシャツ（長袖）</option>
         		<option value="p">パーカー</option>
            </select>
            
          </td>
          </tr>
           <tr>
           <td><label>服の色</label>
            <input type="radio" name="color" id="not" value="white" checked="">
            <input type="radio" name="color" id="red" value="red">
            <input type="radio" name="color" id="bule" value="bule">
            <input type="radio" name="color" id="green" value="green">
            <input type="radio" name="color" id="broun" value="gray">
           </td>
          </tr>
          
           <tr>
           <td><label>タグ</label>
           <input type="button" class="btn tag val1" value="新規タグ" style="display:block"/>
           <input type="button" class="btn tag val2" value="戻る"  style="display:none"/>
           <section id="tag1">
           <select name="tag1" id="" style="display:block">
               <?php tag_list();?>
            </select>
            </section>
            <section id="tag2" style="display:none">
            <label>タグ名：</label><input type="text" name="tag2" />
            </section>
           </td>
          </tr>
            <tr>
                <td>
                    <label>コメント<br><sapn>*公開時に服をアピールするコメントです</sapn></label>
                    <textarea name="comment" rows="" cols=""></textarea>
                </td>
            </tr>
           <?php 
			/******************
			*公開情報用
			*
			********************/?>
          <tr>
           <td>
           <input type="checkbox" name="open" value="1"/>
           全体に公開する
           </td>
          </tr>
           <tr>
            <td>
            <?php 
			/******************
			*情報送信用のhidden
			*情報はAjaxにより更新する
			********************/?>
            <input type="hidden" id="syu" value="st"  />
            <input type="hidden" id="color" value="white"  />
            <input type="button" class="btn" id="edi" value="作　成"  />
            </form>
            </td>
          </tr>
        </table>

       
        </div>      
    	
        
       <div id="C_cont" class="well">
       <div class="fix">
        <img id="help2" src="images/help2.png" />
         <img id="help1" src="images/help1.png" />
          <img id="help3" src="images/help3.png" />
        </div>
       <div class="page-header">
       <h2>制作シート</h2>
       <div id="help">
         <p id="help_img" class="on"></p>
         <p id="help_text">ヘルプ表示中</p>
       </div>
       </div>
        <div class="imageCover6">
            <canvas id="jsImageCoverCanvas"></canvas>
        </div>
		
        <div class="imageCover6_2">
            <canvas id="jsImageCoverCanvas_2"></canvas>
        </div>
	
		<p></p>
        
        
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