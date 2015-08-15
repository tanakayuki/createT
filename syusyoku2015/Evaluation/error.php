<?php 
$err_msg = array();
$err_msg['1011'] = '不正なアクセスです';
$err_msg['1012'] = '内部でエラーです';
$err_msg['1013'] = 'データベース接続時にエラーが発生しました。';
$err_msg['1014'] = '不正なSQL文が発行されました。';
$err_msg['1015'] = '不正なSQL文が発行されました。';
$err_msg['1016'] = '不正なSQL文が発行されました。';

//不正アクセス時
if(!isset($err_code) || isset($err_msg['$err_code'])){
	$err_code = '1011';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無題ドキュメント</title>
</head>

<body>
<p>エラーコード : <?php echo $err_code; ?></p>
<p>エラーメッセージ : <?php echo $err_msg[$err_code]; ?></p>
<p>エラー場所 : <?php echo $err_place; ?></p>
</body>
</html>