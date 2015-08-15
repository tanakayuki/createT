<?php
header("Content-Type: text/html; charset=UTF-8");
require_once 'dif.php';

function DAO(){
	$link = mysqli_connect(HOST , DB_USER , DB_PASS , DB_NAME);
	//接続失敗
	if (!$link) {
		$err_code = '1013';
		$err_place = 'データリンク';
		require_once('error.php');
		exit;
	}
	return $link;
}


/**
*登録処理
*/
function INSERT($val1,$val2){
	$link = DAO();
	mysqli_set_charset($link,'utf8');
	$sql = "INSERT INTO ".TABLE_AUTHOR." (name , age) VALUES ('$val1' , $val2);";
	$result = mysqli_query($link , $sql);
	//SQLエラー
	if (!$result) {
		$err_code = '1014';
		$err_place = 'INSERT_query';
		require_once('error.php');
		exit;
	}
	mysqli_close($link);
return true;
}



/*
*入力チェック
*
*/
function CHECK($arr){
	//今回は名前なのでこれ
	$msg[] = array("err"=>"");
	//引数カウンタ
	$i = 0 ;
		foreach($arr as $val){
			$data =  explode("-",$val);
			/*連想配列の添え字作成
			*汎用性なし
			*/
			if($data[1]=="書籍名"){
				$text = "m_newbook";
			}
			else if($data[1]=="書籍金額"){
				$text = "price";
			}
			else{
				//URLパラメータでの例外エラー
				return false;
			}
			//エラーの優先度
			$flg = 0;
			
			$data_chk = array_slice($data, 2); //3番目以降を取得
			//配列内検索
			if(in_array("n", $data_chk)){
				//未入力チェック 引数 n	
				if($data[0]==""){
					$i++;
					$err_code = array($text."_val" => $data[0] , $text."_err" => $data[1]."が未入力です" , $text."_border" => "control-group error");
					$msg[0] += array($text => $err_code);
					$msg[0]["err"] = $i;
					$flg = 1 ;
				}
				else if(!in_array("m", $data_chk)){
				$err_code = array($text."_val" => $data[0] , $text."_err" => "OK" , $text."_border" => "control-group success");
				$msg[0] += array($text => $err_code);
				}
			}
			if(in_array("m", $data_chk) && $flg != 1){
				//数値チェック 引数 n	
				if(!is_numeric(($data[0]))){
					$i++;
					$err_code = array($text."_val" => $data[0] , $text."_err" => $data[1]."が数値ではありません" , $text."_border" => "control-group error");
					$msg[0] += array($text => $err_code);
					$msg[0]["err"] = $i;
				}
				else{
				$err_code = array($text."_val" => $data[0] , $text."_err" => "OK" , $text."_border" => "control-group success");
				$msg[0] += array($text => $err_code);

				}
			}
		}
	//デバッグ用
	//var_dump($msg);
/**
*エラーカウンタが０だったらfalseを返す
*エラーカウンタが０以外だったらエラーメッセージを返す
**/
	if($i==0){
		return false;	
	}else{
		return $msg;
	}
}


/**
*UPDATE
*/
function UPDATE($updete_list){
$link = DAO();
	$link = DAO();
	mysqli_set_charset($link,'utf8');
	@$sql = "UPDATE ".TABLE_AUTHOR." SET `name`='".$updete_list['name']."',`age`=".$updete_list['age'];
	@$sql = $sql." WHERE `id`=".$updete_list['id'].";";
	echo $sql;
	$result = mysqli_query($link , $sql);
	//SQLエラー
	if (!$result) {
		$err_code = '1015';
		$err_place = 'UPDATE_query';
		require_once('error.php');
		exit;
	}
	mysqli_close($link);
return true;
}
/**
DELETE
*/
function DELETE($id){
	$link = DAO();
	mysqli_set_charset($link,'utf8');
	@$sql = "DELETE FROM `".TABLE_AUTHOR."` WHERE `id`=".$id.";";
	$result = mysqli_query($link , $sql);
	//SQLエラー
	if (!$result) {
		$err_code = '1016';
		$err_place = 'DELETE_query';
		require_once('error.php');
		exit;
	}
	mysqli_close($link);
return true;
}

function ok($temp){
	require_once('func2.php');
	echo "確認画面";
	echo "以下の内容で更新しますがよろしいですか？";
	echo '<form action=""><table class="table table-striped table-bordered table-condensed" style="text-align:center;width:200px;">';
	echo '<tr><th>ID</th><td>'.$temp['id'].'<input type="hidden" value="'.$temp['id'].'" name="id"></td></tr>';
	echo '<tr><th>名前</th><td>'.$temp['name'].'<input type="hidden" value="'.$temp['name'].'" name="name"></td></tr>';
	echo '<tr><th>年齢</th><td>'.$temp['age'].'<input type="hidden" value="'.$temp['age'].'" name="age"></td></tr>';
	echo '</table><input class="btn" type="submit" name="update" value="確定"></form>';
	echo '<form><input class="btn" type="submit" name="back" value="戻る">';
	$table2 = array();
	$table2[] =  array("id"=>$temp['id'] ,"name"=>$temp['name'] , "age"=>$temp['age']);
	$_SESSION['table2'] =$table2;
	echo '</form>';
	exit;
}
/*
*UPDATE
*DELETE
*時の確認処理
*SELECTの関数とほぼ同じ
*/
function EDIT($id){
	$link = DAO();
	mysqli_set_charset($link,'utf8');
	$sql = "SELECT * FROM ".TABLE_NAME." WHERE id=".$id.";";	
	$result = mysqli_query($link , $sql);
	if (!$result) {
		$err_code = '1014';
		$err_place = 'SELECT_query';
		require_once('error.php');
		exit;
	}
	$msg = '' ;
	$id = '' ;
	$name = '' ;
	$data_list = array();
	while($row = mysqli_fetch_assoc($result)){
		$data_list[] = array("id" => $row['id'],"name" => $row['name'] ,"age" => $row['age']);
	}
	//echo $sql;
	//var_dump($data_list);
	mysqli_close($link);
	if(count($data_list)==0){
		return false;
	}else{
		//asort($data_list);
		//array_reverse($data_list);
		//戻り値はリスト
 		return $data_list;
	}
	
}


