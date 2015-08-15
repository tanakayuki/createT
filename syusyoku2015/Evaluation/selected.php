<?php
/**
*選択項目の記憶処理
*CSV形式にて入力しexplodeで配列にして整理を行いimplodeでCSVに戻して使用
*Ajax + php
*/
session_start();
//session_destroy();
if(isset($_SESSION["set"])){
	$temp =  $_SESSION["set"];
	if($_POST['select']!=""){
	$temp = $temp.",".$_POST['select'];	
	}
	$temp_a = explode(",",$temp);
	//配列内の空白削除　
	//一回目に発生
	$temp_a  = array_filter($temp_a, "strlen");
	//添字を振り直す
	$temp_a  = array_values($temp_a);
	$temp_a = array_unique($temp_a);
	if($_POST['not']!=""){
		foreach($temp_a as $key => $val){
			if($val == $_POST['not']){
				unset($temp_a[$key]);
			}
		}
	}
	var_dump($temp_a);
	$temp = implode(",",$temp_a);	
}
else{
	$temp = $_POST['select'];
}
	$_SESSION["set"] = $temp;
	echo $temp;

