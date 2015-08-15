<?php
require_once '../class.php';
$num = $_GET['mode'];
switch ($num){
    case 1:
        clothes($_GET['sql_mode'],$_GET['page']);
        break;
    case 2:
        tag_src($_GET['name']);
        break;
    default:
        echo "不正なアクセス";
}
function clothes($sql_mode,$page_num){
/******************
 *服の一覧の取得
 *
 *Publication が　2の公開状態のもののみ表示する
 *******************/
    $sql = json_decode(SQL_CLOTHES, true);
    $sql = array_merge($sql, array('WHERE' => 'Publication = 2'));
    if($sql_mode=="search"||$sql_mode=="max"){
        $sql_and=" ";//条件分岐時にAND句をつけるタイミングを調節するため
        $str_and=" ";
/****************
 * 種類
 ****************/
        if($_GET['select']!=""&&$_GET['select']!="all"){
            $sql_and = $sql_and." type= '".$_GET["select"]."'";
            $str_and="AND";
        }
/****************
 * 色検索
 ****************/
        if(count($_GET['color'])!=0){
            if(count($_GET['color'])>1) {
                $sql_and = $sql_and.$str_and."(";
                $or_str="";
                foreach ($_GET['color'] as $color) {
                    $sql_and = $sql_and .$or_str." color= '" . $color . "'";
                    $or_str="OR";
                }
                $sql_and = $sql_and.")";
            }
            else{
                $sql_and = $sql_and.$str_and." color= '" . $_GET['color'][0] . "'";
            }
            $str_and="AND";
        }
/***************
 * タグ
 ***************/
        if($_GET['tag']!=""&&$_GET['tag']!="all"){
            $sql_and = $sql_and.$str_and." tag_id= '".$_GET["tag"]."'";
            $str_and ="AND";
        }
/****************
 * キーワード検索
 ***************/
        if($_GET['title']!=""){
            $sql_and = $sql_and.$str_and." (title LIKE '%".$_GET['title']."%'";
            $sql_and = $sql_and."OR comment LIKE '%".$_GET['title']."%')";
            $str_and ="AND";
        }
        //echo $sql_and;
        $sql = array_merge($sql, array('AND' => $sql_and));
//       var_dump($sql);
    }
    if($sql_mode!="max") {
        if($page_num!=0){
            $page_num = ($page_num-1)*9;
        }
        $sql = array_merge($sql, array('LIMIT' => "$page_num,9"));
    }
    $SELECT = new SELECT();
    $SELECT_query = new SELECT_query();
    $temp = $SELECT -> SQL($sql,'');

//    var_dump($temp);
    /**
     *@param $sql2　予約の埋まり数を返すSQL
     **/

/*********************************
 *SQLを配列に格納しJSON形式にする
 ********************************/
    if($sql_mode!="max") {
        if ($list = $SELECT_query->SQL($temp)) {
            $clothes_list = array();
            $i = 0;
            foreach ($list as $data) {
                $clothes_list[$i] = array(
                    'name' => "a",
                    'id' => $data["clothes_id"],
                    'user_id' => $data["user_id"],
                    'type' => $data["type"],
                    'title' => $data["title"],
                    'comment' => $data["comment"],
                    'image_data' => $data["image_data"],
                );
                $i++;
            }
            // javascrit用に配列をエンコード
            header('Content-type: application/json; charset=UTF-8');
            $clothes_list = json_encode($clothes_list);
//送る
            echo $clothes_list;
//デバッグ用
            /*
            echo "<pre>";
            var_dump($clothes_list);
            echo "</pre>";
            */
        } else {
            echo "undefined";
        }
    }else{
        echo count($SELECT_query->SQL($temp));
    }
}



function tag_src($name){
//    $SELECT = new SELECT();
//    $SELECT_query = new SELECT_query();
//    $temp = $SELECT -> SQL($sql,'');
//    echo "ok";
}
