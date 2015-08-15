<?php 
header("Content-Type: text/html; charset=UTF-8");
/************
*設定ファイル
*
*************/
require_once 'dif.php';

class DAO{
function link(){
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
function __call( $Name, $Args ){
	echo "[".$Name."]method not exists!!\n";
	print_r( $Args );
}
}

/*********************************
*select文の作成とフラグ処理
*
*重要な変数
*
*
*
*
**********************************/
class SELECT{
function SQL($sql,$mode){
//取り出すデータの判別フラグ
	$flg = "";
	$key= array_keys($sql);
	$sql_query ="";
	$selecter ="";
	for($i = 0; $i<count($key) ; $i++){
			$sql_query = $sql_query.$key[$i]." ".$sql[$key[$i]]." ";
		/*********************************
		*セレクトの取り出し項目を抜き出す
		*
		*
		**********************************/
		if($key[$i]=="SELECT"){
			//echo $sql[$key[$i]];
			$selecter[] = explode(',',$sql[$key[$i]]);
		}
	}
	$sql_query = $sql_query.";";	
	
	//echo $sql_query;
	/*********************************
	*データが必要な場合はここで取り出す
	*
	**********************************/	
	switch ($mode){
		case 1:
			$flg="count";
			break;
		case 2:
			$flg="max";
			break;	
	}
	$point  = array("query" => $sql_query,"flg" => $flg ,$selecter);
	return $point;
	}
  }
  
/*********************************
*select文の実行
*注意：SELECT関数との依存関係にあるため単体では実行できない
*重要な変数
*
*
*
*
**********************************/
class SELECT_query extends DAO{
function SQL($point){	
	//DBとのリンクを作る
	count($point[0][0]);
	//echo  $point['query'];
	for($i = 0; $i<count($point[0][0]); $i++){	
		$temp[] = $point[0][0][$i];
	}
	$link = $this -> link();
	//var_dump($point['query']);
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link , $point['query']);
	/**************
	*sqlエラー
	*
	***************/
	if (!$result) {
		$err_code = '1014';
		$err_place = 'SELECT_query';
		require_once('error.php');
		exit;
	}
	$data_list = "";	
	if($point['flg']!="count"&&$point['flg']!="max"){
	/*********************************
	*データが必要な場合はここで取り出す
	*
	**********************************/
	$data_list = array();
		while($row = mysqli_fetch_assoc($result)){
			/******************
			*結果を連想配列に変換
			*
			*
			*******************/
			$data_list[] = $row;
		}
	}else{
	/*********************************
	*件数のみの場合の処理
	*
	**********************************/
	$row = mysqli_fetch_assoc($result);
	if($point['flg']=="count"){
		$data_list = $row['count(*)'];
	}else if($point['flg']=="max"){
		$data_list = $row['max'];
	}
}	
mysqli_close($link);
if(count($data_list)==0){
return false;
}
return $data_list;
}
}

/*********************************
*INSERT文の実行
*
*
*
*
**********************************/
class INSERT_query extends DAO{
function SQL($point){	
	//DBとのリンクを作る
	//echo $point['query'];
	$link = $this -> link();
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link , $point['query']);
	/**************
	*sqlエラー
	*
	*
	***************/
	if (!$result) {
		$err_code = '1014';
		$err_place = 'SELECT_query';
		require_once('error.php');
		exit;
	}
mysqli_close($link);
return true;
}
}

/*********************************
*UPDATA文の実行
*
*
*
*
**********************************/
class UPDATA_query extends DAO{
function SQL($point){	
	//DBとのリンクを作る
	$link = $this -> link();
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link , $point['query']);
	/**************
	*sqlエラー
	*
	*
	***************/
	if (!$result) {
		$err_code = '1014';
		$err_place = 'SELECT_query';
		require_once('error.php');
		exit;
	}
mysqli_close($link);
return true;
}
}


/*********************************
*DELETE文の実行
*
*
*
*
**********************************/
class DELETE_query extends DAO{
function SQL($point){
	$link = $this -> link();
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link , $point['query']);
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
}
  
  
/******************以下使用していない***********************/		
class PAGEING {
				/*
				*ページング関数
				*
				*$idx 現在のページ数
				*/
				function pageing($idx = null,$max = null){
					//echo "現在のポインタは".$page_point;
					//テーブルの件数
					$page_suu = $max;
					//echo $page_suu."件";
					//現在のページ数
					$page_once = $page_suu/5;
					//切り捨てます
					$page_once =  ceil($page_once);
					$page_once_temp = $page_once;

					if($page_once>1){
							//echo "ページングは";	
							for($j=1;$page_once>0;$j++){
								if($page_once_temp>=6){
										if($j==$idx){
											echo '<li class="active"><a>'.$j.'</a></li>';
										}else if($idx-3<=$j && $idx+3>=$j){
											echo '<li><a href=?page='.$j.'>'.$j.'</a></li>';
										}
										if($idx>=5 && $j==1){
											echo '<li><a href=?page=1>1</a></li>';
											echo '<li><a>...</a></li>';
										}
										if($idx<$page_once_temp-3 && $j==$page_once_temp){
											echo '<li><a>...</a></li>';
											echo '<li><a href=?page='.$page_once_temp.'>'.$page_once_temp.'</a></li>';
										}
								}else{
									if($j==$idx){
											echo '<li class="active"><a>'.$j.'</a></li>';
									}
									if($j!=$idx){
										echo '<li><a href=?page='.$j.'>'.$j.'</a></li>';
									}
								}
						$page_once--;
					}					
						return ;
					}
					else{
						return false;
					}
				}
				
				function back_page($idx){
					if($idx!=1){
						$idx--;
						echo '<li><a href=?page='.$idx.'>戻る</a></li>';
					}
					else{
						echo "<li><a>戻る</a><li>";
					}
				}
				
				function next_page($page_point,$idx,$sql){
					$idx++;
					$page_point = $page_point+5;
					$sql = array_merge($sql, array('LIMIT' => $page_point.',5'));
					$SELECT = new SELECT();
					$temp = $SELECT -> SQL($sql,'');
					$SELECT_query = new SELECT_query();
					if($list = $SELECT_query -> SQL($temp)){
						echo '<li><a href=?page='.$idx.'>進む</a></li>';
					}
					else{
						echo "<li><a>進む</a></li>";
					}
					
					
				}
			}
//出版社のセレクトボックス
function tag_list(){
	require_once 'class.php';
/*************************************
*DAOクラスを継承
**************************************/
$SELECT = new SELECT();
$SELECT_query = new SELECT_query();
$temp = $SELECT->SQL(json_decode(SQL_TAGS,true),'');

if(!$list = $SELECT_query -> SQL($temp)){
	//存在しない場合の記述
}else{
foreach($list as $data){
/*************************************
*$data['name'] は表示用
*$data['id']　は送信用とする
*$_SESSION["set"] はselected.php によって作られた記憶用のセッション
**************************************/
		 echo '<option value="'.$data['tag_id'].'">'.$data['tag_name'].'</option>';
	 }
	}
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
        if($data[1]=="名前"){
            $text = "name";
        }
        else if($data[1]=="検索氏名"){
            $text = "name2";
        }
        else if($data[1]=="年齢"){
            $text = "age";
        }
        else if($data[1]=="年齢1"){
            $text = "age1";
        }
        else if($data[1]=="年齢2"){
            $text = "age2";
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
