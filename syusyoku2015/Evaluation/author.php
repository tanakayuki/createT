<?php
require_once 'func.php';
require_once 'dif.php';

session_start();
if(isset($_SESSION['post_data'])){
	$value = $_SESSION['post_data'];
	session_destroy();
}

if(count($_POST)!=0){
	/********************************************************************
	*2014/06/13
	*入力チェック関数 CHECK(array)
	*判断値 - エラー表示名 - [n は未入力チェック、m は数値チェック　複数可]
	*汎用性　なし
	*********************************************************************
	*/
	if($_POST['ADD']){
		if(!$url = CHECK(array($_POST['name']."-名前-n" , $_POST['age']."-年齢-n-m"))){
			$_SESSION['post_data'] = $_POST;
			header("location:comfirm.php");
		}
		}
		$value =  $_POST;
}
/**********
*ページングのページの先頭ポインタの計算
***********
*/
$idx = 1;
if(isset($_GET['page'])){
	$idx = $_GET['page'];
}
//現在のページの先頭
	$page_point = $idx;
	if($page_point!=0){
	$page_point = ($idx-1)*5;
	}
/**************
*検索
***************
*/
if(isset($_GET['clear'])){
	unset($_SESSION['sql_data']);
}

if(!isset($_SESSION['sql_data'])){
			/*************************************
			*
			*$sql　   表示用
			*$sql_all　カウント用
			*
			**************************************/
			$sql = array(
			'SELECT'=>'*',
			'FROM'=>TABLE_AUTHOR,
			);
			
			$sql_all = array(
			'SELECT'=>'count(*)',
			'FROM'=>TABLE_AUTHOR,
			);
			
			$_SESSION['sql_data'] = array('sql' => $sql,'sql_all' => $sql_all);
}else{
	$sql = $_SESSION['sql_data']['sql'];
	$sql_all = $_SESSION['sql_data']['sql_all'];
}


echo "<pre>";
var_dump($sql);
echo "</pre>";
echo "<pre>";
var_dump($sql_all);
echo "</pre>";
			/****************************************
				*リミット追加
				*****************************************/
		
			$sql = array_merge($sql, array('LIMIT' => $page_point.',5'));	
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WP32_DB_check</title>
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#wrap{
	width:1500px;
	overflow:hidden;
}
#cont {
	float: left;
}
#table {
	float: left;
	width:700;
}
th{
	background-color:#CCC;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>

<body>
<?php
/****************************************************
*入力フォーム
*エラーチェック
*エラー時のテキストボックスの色変更　
*　赤　失敗
*　緑　成功
*div の class $url[0]['＊＊＊']['＊＊＊_border']によってエラーと成功時のレイアウトの変更を行う
*placeholde　によりテキストボックス内に文字を表示
*****************************************************
*/ 
?>
<div id="wrap">
    <form action="" method="POST">
      <table id="cont" class="table table-bordered" style="width:500px;">
        <tr>
          <td>氏名</td>
          <td>
            <div class="<?php if(isset($url[0]['name']['name_border'])){echo $url[0]['name']['name_border'];}?>">
              <input type="text" name="name" placeholder="氏名を入力してください" value="<?php if(isset($value['name'])){echo $value['name'];}?>">
              <?php if(isset($url[0]['name']['name_border'])){?>
              <span class="help-inline">
                <?php if(isset($url[0]['name']['name_err'])){echo $url[0]['name']['name_err'];}?>
              </span><?php }?>
              </div>
          </td>
        </tr>
        <tr>
        <td>年齢</td>
          <td>
            <div class="<?php if(isset($url[0]['age']['age_border'])){echo $url[0]['age']['age_border'];}?>">
              <input type="text" name="age" placeholder="年齢を入力してください" value="<?php if(isset($value['age'])){echo $value['age'];}?>">
              <?php if(isset($url[0]['age']['age_border'])){?>
              <span class="help-inline">
                <?php if(isset($url[0]['age']['age_err'])){echo $url[0]['age']['age_err'];}?>
              </span><?php }?>
              </div>
          </td>
       </tr>
          <tr>
          	<td></td>
          	<td><input class="btn" type="submit" name="ADD" value="登録" /></td>
         </tr>
       </form>
      </table>
  
  
  
  <div id="table">
    <table class="table table-striped table-bordered table-condensed" style="width:1000px;">
      <tbody>
      <th>書籍ID</th>
        <th>書籍名</th>
        <th>仮名</th>
        <th>更新日</th>
        <th>作成日</th>
        <th>エディット</th>
         
        </tbody>
		
		
		
		<?php require_once 'class.php'; 
	 //ページ数
/*************************************
*
*DAOクラスを継承
*
**************************************/
$DAO = new DAO();

if(!$list = $DAO -> SQL($sql,"")){
	echo "データが存在しません";
}
else{
	foreach($list as $data){?>
		<tr>
		  <td><?php echo $data['id'];?></td>
		  <td><?php echo $data['name'];?></td>	
		  <td><?php echo $data['name_kana'];?></td>
          <td><?php echo $data['updated_at'];?></td>
          <td><?php echo $data['created_at'];?></td>
          <td><a href="edit.php?id=<?php echo $data['id'];?>&mode=del">削除</a>　<a href="edit.php?id=<?php echo $data['id'];?>&mode=updete">編集</a></td>
		</tr>
	  <?php }?>
	</table>
		
	<div class="pagination" style="text-align:center">
	<ul>
	<?php
		//全件数取得
		$data_all = $DAO -> SQL($sql_all,'1');
		//３種類のページングの表示
		$DAO->back_page($idx);
		$DAO->pageing($idx,$data_all);
		$DAO->next_page($page_point,$idx,$_SESSION['sql_data']['sql']);
	?>
	</ul>
	</div>
<?php }?>
  </div>
</div>
</body>
</html>