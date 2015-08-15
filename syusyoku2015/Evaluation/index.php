<?php
require_once 'func.php';
require_once 'class.php'; 

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
		if(!$url = CHECK(array($_POST['m_newbook']."-書籍名-n" , $_POST['price']."-書籍金額-n-m"))){
			$_SESSION['post_data'] = $_POST;
			header("location:comfirm.php");
		}
		}
		$value =  $_POST;
}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>無題ドキュメント</title>
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <link rel="stylesheet" type="text/css" href="multi-select/css/multi-select.css"/>
 <script type="text/javascript" src="multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript">
$(function(){
  $('#multi-select').multiSelect();
});
$(function(){
	//選択項目の記憶
  $(".ms-elem-selectable").click(function(){
	  var data = $("span",this).text();
	  alert(data);
	  $.ajax({
   			type: "POST",
   			url: "selected.php",
   			data: "select="+data+"&not= ",
   			success: function(msg){
    			alert( "Data Saved: " + msg );
   			}
 	 });
	});
	
	//選択項目の記憶解除
	 $(".ms-elem-selection").click(function(){
	  var data = $("span",this).text();
	  alert(data);
	  $.ajax({
   			type: "POST",
   			url: "selected.php",
   			data: "select= &not="+data,
   			success: function(msg){
     			alert( "Data Saved: " + msg );
   			}
 	  });
  });
  
});
</script>
</head>

<body>


<form action="" method="post">
<table border="1" class="table table-bordered" style="width:600px;">
    <tr>
        <th>書籍名</td>
        <td><div class="<?php if(isset($url[0]['m_newbook']['m_newbook_border'])){echo $url[0]['m_newbook']['m_newbook_border'];}?>">
              <input type="text" name="m_newbook" placeholder="書籍名を入力してください" value="<?php if(isset($value['m_newbook'])){echo $value['m_newbook'];}?>">
              <?php if(isset($url[0]['m_newbook']['m_newbook_border'])){?>
              <span class="help-inline">
                <?php if(isset($url[0]['m_newbook']['m_newbook_err'])){echo $url[0]['m_newbook']['m_newbook_err'];}?>
              </span><?php }?>
              </div>
        </td>
    </tr>
    <tr>
        <th>価格</th>
        <td>        
        <div class="<?php if(isset($url[0]['price']['price_border'])){echo $url[0]['price']['price_border'];}?>">
              <input type="text" name="price" placeholder="金額を入力してください" value="<?php if(isset($value['price'])){echo $value['price'];}?>">
              <?php if(isset($url[0]['price']['price_border'])){?>
              <span class="help-inline">
                <?php if(isset($url[0]['price']['price_err'])){echo $url[0]['price']['price_err'];}?>
              </span><?php }?>
              </div>
        </td>
    </tr>

    <tr>
        <th>著者名</th>
        <td>
       		<select multiple="multiple" id="multi-select" name="multi-select[]">
	   		<?php author_list(); ?>
            </select>     
            <span><a href="author.php">著者編集</a></span>
        </td>
    </tr>
    <tr>
        <th>出版社</th>
        <td>
        	<select name="m_newbook_publisher">
          <?php publisher_list(); ?>
        	</select>
            <span><a href="publisher.php">出版社編集</a></span>
        </td>
    </tr>
    <tr>
        <td>　</td>
        <td><input class="btn" type="submit" value="送信" name="ADD"/><input class="btn" type="reset" value="リセット" /></td>
    </tr>

</table>




</form>




</body>
</html>