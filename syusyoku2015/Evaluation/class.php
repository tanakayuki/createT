<?php 
header("Content-Type: text/html; charset=UTF-8"); 
require_once 'dif.php';

  class DAO{
		//5件データ

		
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
		function __call( $Name, $Args )
			{
				echo "[".$Name."]method not exists!!\n";
				print_r( $Args );
			}
			
		  function SQL($sql,$mode){
			        $link = $this -> link();
					mysqli_set_charset($link,'utf8');
					$flg = "";
					$key= array_keys($sql);
					$sql_query ="";
					for($i = 0; $i<count($key) ; $i++){
							$sql_query = $sql_query.$key[$i]." ".$sql[$key[$i]]." ";
					}
					
					$sql_query = $sql_query.";";			
					switch ($mode){
						case 1:
							$flg="not_data";
						break;
					}

					//echo $sql_query;
					$result = mysqli_query($link , $sql_query);
					if (!$result) {
						$err_code = '1014';
						$err_place = 'SELECT_query';
						require_once('error.php');
						exit;
					}
				
					$data_list = "";
					
					if($flg!="not_data"){
						$data_list = array();
						while($row = mysqli_fetch_assoc($result)){
							//$data_list[] = array("id" => $row['id'],"name" => $row['name'] ,"age" => $row['age']);
							$data_list[] = array("id" => $row['id'],"name" => $row['name'] ,"name_kana" => $row['name_kana'] ,"updated_at" => $row['updated_at'],"created_at" => $row['created_at']);
						}
					}else{
						$row = mysqli_fetch_assoc($result);
						$data_list = $row['count(*)'];
					}
					mysqli_close($link);
					if(count($data_list)==0){
					return false;
					}
					return $data_list;
				}
				
				
				/*
				*ページング関数
				*
				*$idx 現在のページ数
				*/
				function pageing($idx,$max){
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
											echo '<li><a href=db.php?page='.$j.'>'.$j.'</a></li>';
										}
										if($idx>=5 && $j==1){
											echo '<li><a href=db.php?page=1>1</a></li>';
											echo '<li><a>...</a></li>';
										}
										if($idx<$page_once_temp-3 && $j==$page_once_temp){
											echo '<li><a>...</a></li>';
											echo '<li><a href=db.php?page='.$page_once_temp.'>'.$page_once_temp.'</a></li>';
										}
								}else{
									if($j==$idx){
											echo '<li class="active"><a>'.$j.'</a></li>';
									}
									if($j!=$idx){
										echo '<li><a href=db.php?page='.$j.'>'.$j.'</a></li>';
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
						echo '<li><a href=db.php?page='.$idx.'>戻る</a></li>';
					}
					else{
						echo "<li><a>戻る</a><li>";
					}
				}
				
				function next_page($page_point,$idx,$sql){
					$idx++;
					$page_point = $page_point+5;
					$sql = array_merge($sql, array('LIMIT' => $page_point.',5'));
					if($this -> SQL($sql,"")){
						echo '<li><a href=db.php?page='.$idx.'>進む</a></li>';
					}
					else{
						echo "<li><a>進む</a></li>";
					}
					
					
				}
			}



//著者名のセレクトボックス
/**
*selectedが入れば選択状態
*
*/
 function author_list(){
		$sql = array(
			'SELECT'=>'*',
			'FROM'=>TABLE_AUTHOR,
			);
require_once 'class.php'; 
/*************************************
*
*DAOクラスを継承
*
**************************************/
$DAO = new DAO();
if(!$list = $DAO -> SQL($sql,"")){
	//存在しない場合の記述
	
}else{
foreach($list as $data){
/*************************************
*$data['name'] は表示用
*$data['id']　は送信用とする
*$_SESSION["set"] はselected.php によって作られた記憶用のセッション
**************************************/
		if(isset($_SESSION["set"])){
		 	$temp_a = explode(",",$_SESSION["set"]);
			$flg = 0;
			foreach($temp_a as $val){
				if($val == $data['name']){
					echo '<option value="'.$data['id'].'" selected>'.$data['name'].'</option>';
					$flg = 1;
				}
			}
			if($flg != 1){
				 echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
			}
		 }else{
		 echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
		 }
	 }
	}
} 
 	
	
//出版社のセレクトボックス
function publisher_list(){
	$sql = array(
			'SELECT'=>'*',
			'FROM'=>TABLE_PUBLISHER,
			);
	require_once 'class.php'; 
	/*************************************
*
*DAOクラスを継承
*
**************************************/
$DAO = new DAO();
if(!$list = $DAO -> SQL($sql,"")){
	//存在しない場合の記述
	
}else{
foreach($list as $data){
/*************************************
*$data['name'] は表示用
*$data['id']　は送信用とする
*$_SESSION["set"] はselected.php によって作られた記憶用のセッション
**************************************/
		 echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
	 }
	}
} 