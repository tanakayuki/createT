<?php
session_start();
if(!isset($_SESSION["post_data"])){
	header("location:db.php");
}
//セッションを削除
session_destroy();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />

<title>登録完了</title>
</head>

<body>

<h1>登録完了</h1>

<form action="db.php" method="get">
<input type="submit" class="btn" value="トップへ">
</form>
</body>
</html>