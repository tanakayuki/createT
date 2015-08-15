<?php 
/**********************
*服データ登録
*
*
***********************/
session_start();
if(!isset($_SESSION['$imageData'])){
	header('Location: casutam.php');
	exit;
}
else{
	/*
	*
	*動作させる項目の識別
	*
	*/
	if(isset($_GET['ok'])){
	/*
	*認証時
	*
	*/
	echo $_GET['ok'];
	}else{
	/*
	*拒否時
	*
	*/
	echo $_GET['no'];
	}
	$u_id = $_GET['user_id'];
	$c_id = $_GET['clothes_id'];
}
/**********************
*服データを受け取りセッションを即座に破棄する
*
*
***********************/
require_once 'db.php'; 
$DAO = new DAO();
$INSERT_auery = new INSERT_auery();
$SELECT_auery = new SELECT_auery();
$SELECT = new SELECT();

/**********************
*確認用のデータを求める
*
*
***********************/
$sql = array(
			'SELECT'=>'max(clothes_id)',
			'FROM'=>'Clothes',
			'WHERE'=>"user_id = '$u_id'",
			);
$temp = $SELECT -> SQL($sql,'2');
/**********
*$max : 現在の最大数を求める
*これに１＋してIDとする
***********/
$max = $SELECT_auery -> SQL($temp);
$c_id = $max+1;


/**********************
* 確認後アップデートをかける
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

</head>
<body>
  <div class="wrapper">
  <?php //共通ヘッダー ?>
  <?php require_once("header.php");?>
       
      <div id="content" class="well">
       <div id="C_cont" class="well">
       <h2 class="page-header">作成完了</h2>


<img src="data:image/jpg;base64,<?php echo $data[0]['image_data']; ?>" width="600"/>

<a href="#" class="btn btn-primary">マイページへ</a> <a href="#" class="btn">この服を注文する</a>




         
         </div>
        
      </div>
    <?php //共通フッター?>      
 	<?php require_once("footer.php"); ?>
    </div>
</body>
</html>