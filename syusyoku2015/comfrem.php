<?php
session_start();
require_once 'db.php';
$INSERT_auery = new INSERT_auery();
$SELECT_auery = new SELECT_auery();
$SELECT = new SELECT();

$tag;
$tag_name;
$title;
$comment;
/**********************
*服データ登録
*
*
***********************/
if(!isset($_SESSION['$imageData'])){
	header('Location: casutam.php');
	exit;
}
else{
	$u_id = $_SESSION['login_id']['id'];
//    echo $u_id;
	$type = $_POST['select'];
	$color = $_POST['color'];
    $title = $_POST['title'];
    $comment = $_POST['comment'];
    /**
     * 公開するかしないか
     */
if(isset($_POST['open'])){
    $open = $_POST['open'];
}else{
    $open =0;
}
    if($_POST['tag2']!=""){
        $tag_name = $_POST['tag2'];
        //新規タグなので登録してIDをかえす
        /**********************
         *データのINSERT
         *
         *エラー処理無し
         ***********************/
        $sql_new_tag = array(
            'INSERT INTO'=>"`Tag_masta` (`tag_name`) ",
            'VALUES'=>"('$tag_name')",
        );
        $temp = $SELECT -> SQL($sql_new_tag,'');
        $list = $INSERT_auery -> SQL($temp);
        /**********************
         *作った服IDを求める
         *
         *エラー処理無し
         ***********************/
        $sql3 = array(
            'SELECT'=>'tag_id',
            'FROM'=>'Tag_masta',
            'WHERE'=>"tag_name = '$tag_name'",
        );
        $temp2 = $SELECT -> SQL($sql3,'');
        $data = $SELECT_auery -> SQL($temp2);
        $tag = $data[0]['tag_id'];
    }else {
        $tag = $_POST['tag1'];
    }
}
$imageData = $_SESSION['$imageData'];
/**********************
*服データを受け取りセッションを即座に破棄する
*
*
***********************/
unset($_SESSION['$imageData']);
/**********************
*服IDを求める
*
*
***********************/
$sql = array(
			'SELECT'=>'max(clothes_id)',
			'FROM'=>'Clothes',
//			'WHERE'=>"user_id = '$u_id'",
			);
$temp = $SELECT -> SQL($sql,'2');
/**********
*$max : 現在の最大数を求める
*これに１＋してIDとする
***********/
$max = $SELECT_auery -> SQL($temp);
$c_id = $max+1;

/**********************
*データのINSERT
*
*
***********************/
//echo $c_id;
$sql_tag = array(
			'INSERT INTO'=>"`Tag_re` (`clothes_id`, `tag_id`) ",
			'VALUES'=>"('$c_id','$tag')",
			);
$temp = $SELECT -> SQL($sql_tag,'');
//var_dump($temp);
$list = $INSERT_auery -> SQL($temp);

$sql2 = array(
    'INSERT INTO'=>"`Clothes` (`clothes_id`, `user_id`, `type`, `color`, `title`, `comment`, `Publication`, `image_data`) ",
    'VALUES'=>"('$c_id', '$u_id', '$type', '$color', '$title', '$comment', '$open', '$imageData')",
);
$temp = $SELECT -> SQL($sql2,'');
$list = $INSERT_auery -> SQL($temp);
//コミットする

/**********************
*作った服IDを求める
*
*
***********************/
$sql3 = array(
			'SELECT'=>'clothes_id,user_id,image_data',
			'FROM'=>'Clothes',
			'WHERE'=>"user_id = '$u_id'",
			'AND'=>"clothes_id = $c_id",
			);
$temp2 = $SELECT -> SQL($sql3,'');
$data = $SELECT_auery -> SQL($temp2);
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>服検索</title>
    <?php //js css 外部読み込み分のまとめ ?>
	<?php require_once("imput.php") ?>
    <?php //共通レイアウト ?>
	<link rel="stylesheet" type="text/css" href="css/css.css">
    <script>
    /********************
    * 初回ロード
    ********************/
    $(document).ready(function(){
        respon_width();
        body_fade();
        $(function () {
            $("h2").css({opacity: '0'});
            setTimeout(function () {
                $("h2").stop().animate({opacity: '1'}, 700);
            }, 700);
        });
        $(function () {
            $("#R_cont").css({display: 'none'});
            setTimeout(function () {
                $("#R_cont").fadeToggle('slow');
            }, 800);
        });
    });


    </script>
    <style>
        #R_cont img:hover{
            -webkit-transition: 0.3s ease-in-out;
            -moz-transition: 0.3s ease-in-out;
            -o-transition: 0.3s ease-in-out;
            transition: 0.3s ease-in-out;
            opacity: 0.6;
            filter: alpha(opacity=60);
        }
        #C_cont{
            width: 44%;
            margin: 0 auto;
        }
        #R_cont{
            width: 20%;
            position: absolute;
            top: 80%;
            right: 20%;
            width: 30%;
        }
        #comp{
           padding-right: 5%;
        }
    </style>
</head>
<body>
  <div class="wrapper">
      <?php //共通ヘッダー ?>
      <?php require_once("header.php");?>
      <div id="header_text">
          <div id="page_text">
              <h1>Completion page</h1>
              <span>完了ページ</span>
          </div>
      </div>

      <div id="content" >
       <div id="C_cont" >
           <div id="comp">
               <img src="data:image/jpg;base64,<?php echo $data[0]['image_data']; ?>"/>
           </div>
       </div>
          <div id="R_cont">
              <a class="btn_custom2" href="./list.php" >
                  みんなの作品を見に行く
              </a>
              <a class="btn_custom2" href="#" >
                 この服を注文する
              </a>
              <a class="btn_custom2" href="#" >
                  マイページ
              </a>

          </div>
      </div>
    <?php //共通フッター?>      
 	<?php require_once("footer.php"); ?>
    </div>
</body>
</html>