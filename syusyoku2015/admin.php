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
  <?php //共通ヘッダー ?>
  <?php require_once("header.php");?>
       
      <div id="content">
      
      	<div id="L_cont" class="well">
       <h2 class="page-header">検索方法</h2>
       <form action="">
        <table class="table">
          <tr>
            <td><label>タグ</label><input type="text"></td>
          </tr>
            <tr>
           <td><label>都道府県</label>
	        <select name="blood">
            	<option value="">-- 選 択 --</option>
    	    	<option value="A">兵庫県</option>
         		<option value="B">京都府</option>
           		<option value="O">滋賀県</option>
           		<option value="AB">大阪府</option>
                <option value="B">奈良県</option>
           		<option value="O">和歌山県</option>
            </select>
          </td>
          </tr>
          <tr>
            <td><label>作成時期</label><input type="date" name="example1"></td>
          </tr>
           <tr>
           <td><label>ジャンル</label>
	        <select name="blood">
            	<option value="">-- 選 択 --</option>
    	    	<option value="A">カフェ</option>
         		<option value="B">モダン</option>
           		<option value="O">ポップ</option>
           		<option value="AB">シック</option>
            </select>
          </td>
          </tr>
           <tr>
           <td><label>色</label>
            <input type="radio" name="s2" id="not" value="" checked="">
            <input type="radio" name="s2" id="red" value="1">
            <input type="radio" name="s2" id="bule" value="2">
            <input type="radio" name="s2" id="green" value="3">
            <input type="radio" name="s2" id="broun" value="4">
           </td>
          </tr>
           <tr>
            <td><button type="submit" class="btn"> 検 索 </button></td>
          </tr>
        </table>
        </form>
       
        </div>      
    	
        
        
       <div id="C_cont" class="well">
       <h2 class="page-header">検索結果</h2>
       <h3>公開認証待ちリスト</h3>
       <div class="row">
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
                      <div class="pagination" style="text-align:center;">
<ul>
<li><a href="#">Prev</a></li>
<li class="active">
<a href="#">1</a>
</li>
<li><a href="#">2</a></li>
<li><a href="#">3</a></li>
<li><a href="#">4</a></li>
<li><a href="#">Next</a></li>
</ul>
</div>
         </div>
         </div>
         
         </div>
        
      </div>
    <?php //共通フッター?>      
 	<?php require_once("footer.php"); ?>
    </div>
</body>
</html>
