<?php
require_once 'func.php';

session_start();
if(isset($_GET['mode'])){
	$_SESSION['mode'] = $_GET['mode'];
}

if(isset($_GET['id'])){
	$table = EDIT($_GET['id']);
	$_SESSION['id'] = $_GET['id'];
}else{
	$table = EDIT($_SESSION['id']);
}

if(isset($_POST['edit_mode'])){
	if($_POST['edit_mode']=="del"){
		DELETE($_POST['id']);
		header('location:db.php');
	}
}
if(isset($_GET['update'])){
	UPDATE($_GET);
	header('location:db.php');
}



if(count($_POST)!=0 && $_SESSION['mode']!="del"){
	/********************************************************************
	*2014/06/13
	*入力チェック関数 CHECK(array)
	*判断値 - エラー表示名 - [n は未入力チェック、m は数値チェック　複数可]
	*汎用性　なし
	*********************************************************************
	*/
	if(!$url = CHECK(array($_POST['name']."-名前-n" , $_POST['age']."-年齢-n-m"))){
		ok($_POST);
		//header("location:comfirm.php");
	}
	else{
		$table = array();
		$table[] =  array("id"=>$_SESSION['id'] ,"name"=>$_POST['name'] , "age"=>$_POST['age']);
	}
}
if(isset($_SESSION['table2'])){
		$table  = $_SESSION['table2'];
		unset($_SESSION['table2']);
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<title>無題ドキュメント</title>
</head>

<body>
<form action="" method="POST">
<table class="table table-striped table-bordered table-condensed" style="text-align:center;width:200px;">

<tr>
<?php
foreach($table as $data){?>
	<th>ID</th>
    <td><?php echo $_SESSION['id'];?><input type="hidden" name="id" value="<?php echo $_SESSION['id'];?>"></td>
    </tr>
    <tr>
    <th>名前</th>
    <td>
	<?php if($_SESSION['mode']=="del"){ echo $data['name'];}else{?>
    
	<div class="<?php if(isset($url[0]['name']['name_border'])){echo $url[0]['name']['name_border'];}?>">
              <input type="text" name="name" placeholder="氏名を入力してください" value="<?php if(isset($data['name'])){echo $data['name'];}?>">
              <?php if(isset($url[0]['name']['name_border'])){?>
              <span class="help-inline">
                <?php if(isset($url[0]['name']['name_err'])){echo $url[0]['name']['name_err'];}?>
              </span><?php }?>
              </div>
            </td>
	
    <?php }?>
    </td>
    </tr>
    <tr>
    <th>年齢</th>
    <td>
    <?php if($_SESSION['mode']=="del"){ echo $data['age'];}else{?>    
                <div class="<?php if(isset($url[0]['age']['age_border'])){echo $url[0]['age']['age_border'];}?>">
              <input type="text" name="age" placeholder="年齢を入力してください" value="<?php if(isset($data['age'])){echo $data['age'];}?>">
              <?php if(isset($url[0]['age']['age_border'])){?>
              <span class="help-inline">
                <?php if(isset($url[0]['age']['age_err'])){echo $url[0]['age']['age_err'];}?>
              </span><?php }?>
              </div>
    
    
    <?php }?>
    </td>
<?php }?>
</tr>
</table>
<p>この内容でよろしいでしょうか？</p>
<input type="hidden" value="<?php echo $_SESSION['mode'];?>" name="edit_mode" />
<input type="submit" class="btn" value="確定" />
</form>
<form action="db.php" ><input type="submit" class="btn" value="戻る"/></form>
</body>
</html>