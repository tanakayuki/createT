<?php

$link = mysqli_connect('localhost','root','','img');
if (!$link) {
	$err_code = '1011';
	require_once('error.php');
	exit;
}

mysqli_set_charset($link,'utf8');

$sql = "SELECT num , cade64 FROM img_text";

$result = mysqli_query($link , $sql);
if (!$result) {
	$err_code = '1011';
	require_once('error.php');
	exit;
}

$msg = '' ;
$id = '' ;
$name = '' ;

for($i=1;$row = mysqli_fetch_assoc($result);$i++) {
	$id[] = $row['num'];
	$name[] = $row['cade64'];
}


mysqli_close($link);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SELECTサンプル</title>
</head>
<body>

<table>
<?php if($msg == ''){ ?>
<tr><td>ID</td><td><?php echo $id[0]; ?></td></tr>
<tr><td><img src="data:image/jpg;base64,<?php echo $name[2]; ?>" width="200"/></td></tr>
<?php }else{ ?>


<tr><td>(エラー)</td><td><?php echo $msg; ?></td></tr>

<?php } ?>

</table>

</body>
</html>