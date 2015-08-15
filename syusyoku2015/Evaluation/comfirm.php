<?php
require_once 'func.php';
session_start();

$table = $_SESSION["post_data"];
	/*
if(isset($_GET['add'])){
	$name = $_GET['name'];
	$age  = $_GET['age'];
	INSERT($name , $age);
	header("location:comp.php");
}
if(isset($_GET['back'])){
	header("location:db.php");
}
*/
echo "<pre>";
var_dump($table);
echo "</pre>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<title>確認画面</title>
</head>

<body>

<h2>この内容で登録してよろしいでしょうか？</h2>
<table class="table table-striped table-bordered table-condensed" style="width:300px;">
<thead>
<th>項目</th>
<th>内容</th>
</thead>
<tbody>
<tr><td>名前</td><td><?php echo $table['name'];?></td></tr>
<tr><td>年齢</td><td><?php echo $table['age'];?></td></tr>
</tbody>
</table>

<form action="" method="get">
<input type="hidden" name="back">
<input class="btn" type="submit" value="入力画面に戻る">
</form>

<form action="" method="get">
<input type="hidden" name="name" value="<?php echo $table['name'];?>"/>
<input type="hidden" name="age" value="<?php echo $table['age'];?>"/>
<input type="hidden" name="add">
<input class="btn" type="submit" value="登録">
</form>


</body>
</html>