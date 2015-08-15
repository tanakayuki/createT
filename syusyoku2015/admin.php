<?php
require_once 'class.php';

$DAO = new DAO();
$SELECT = new SELECT();
$UPDATA_query = new UPDATA_query(); 
$SELECT_query = new SELECT_query();
/******************
*服の一覧の取得
*
*Publication が　2の公開状態のもののみ表示する
*******************/
$sql = array(
			'SELECT'=>'clothes_id,user_id,image_data',
			'FROM'=>'Clothes',
			'WHERE'=>"Publication = 1",
			);	
$temp = $SELECT -> SQL($sql,'');



/******************
*服の一覧の取得
*
*Publication が　2の公開状態のもののみ表示する
*******************/
if(isset($_GET['ok'])){
	$id = $_GET['clothes_id'];
	$sql = array(
		'UPDATE'=>'Clothes',
		'SET'=>' ',
		'Publication'=>"= 2",
		'WHERE'=>'clothes_id='."$id",
	);
	$temp = $SELECT -> SQL($sql,'');
	$UPDATA_query -> SQL($temp);

    /**********************
     *メール送信
     *
     *
     ***********************/
    $mail="ohs25003@sirusoba.com";
    $temp_val ="投稿された服について";
    $text = <<<EOD
    あなたが投稿した服が承認されました。
EOD;
    mb_language('Japanese');
    mb_internal_encoding('UTF-8');
    mb_send_mail($mail,$temp_val,$text,"FROM:".$mail);
	header("location:admin.php");
}
/******************
 *服の一覧の取得
 *
 *Publication が　2の公開状態のもののみ表示する
 *******************/
if(isset($_GET['no'])){
    $id = $_GET['clothes_id'];
    $sql = array(
        'UPDATE'=>'Clothes',
        'SET'=>' ',
        'Publication'=>"= 9",
        'WHERE'=>'clothes_id='."$id",
    );
    $temp = $SELECT -> SQL($sql,'');
    $UPDATA_query -> SQL($temp);

    /**********************
     *メール送信
     *
     *
     ***********************/
    $mail="ohs25003@osaka.hal.ac.jp";
    $temp_val ="投稿された服について";
    $text = <<<EOD
    あなたが投稿した服は拒否されました。
EOD;
    mb_language('Japanese');
    mb_internal_encoding('UTF-8');
    mb_send_mail($mail,$temp_val,$text,"FROM:".$mail);
    header("location:admin.php");
}
?>



<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>認証待ちリスト</title>
    <?php //js css 外部読み込み分のまとめ ?>
	<?php require_once("imput.php") ?>
    <?php //共通レイアウト ?>
	<link rel="stylesheet" type="text/css" href="css/css.css">
    <script>
        $(document).ready(function(){
            respon_width();
        });
    </script>
</head>
<body>
  <div class="wrapper">
      <style>
          #C_cont {
              width: 90%;
          }
      </style>
      <div id="content">
       <div id="C_cont" style="background-color: transparent;">
       <h3>公開認証待ちリスト</h3>
       <div class="span9">
        		<ul class="thumbnails">
                <?php
                if(!$list = $SELECT_query -> SQL($temp)){
					echo "データが存在しません";
				}else{
					foreach($list as $data){?>	
            			<li class="span3">
                		<div class="thumbnail">
                    		<img src="data:image/jpg;base64,<?php echo $data['image_data']; ?>" width="200"/>	
        
                    		<div class="caption">
                        		<h5>服のタイトルa</h5>
                                <form action="#">
                        		<input type="hidden" name="clothes_id" value="<?php echo $data['clothes_id']; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
                        		<input type="submit" class="btn btn-primary" name="ok" value="認　証" >
                                <input type="submit" name="no" class="btn" value="拒　否" >
                                </form>
                    		</div>
                		</div>
            			</li>
              <?php
              }
			  }?>
               </ul>
         </div>
        
      </div>
    </div>
</body>
</html>
