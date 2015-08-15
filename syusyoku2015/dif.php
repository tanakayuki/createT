<?php
/********************
*DB接続用定数
*
********************/
define("HOST"   ,    "localhost");
define("DB_NAME",    "iw3_hew");
define("DB_USER",   "root");
define("DB_PASS",   "root");

//define("HOST"   ,    "mysql.hostinger.jp");
//define("DB_NAME",    "u645319139_hew15");
//define("DB_USER",   "u645319139_hew15");
//define("DB_PASS",   "yuki6318");


/********************
*テーブル定数
*
********************/
//新刊情報マスタテーブル
define("TABLE_NEWBOOK",   "m_newbook");
//著者マスタテーブル
define("TABLE_AUTHOR",   "m_newbook_author");
//出版社マスタテーブル
define("TABLE_PUBLISHER",   "m_newbook_publisher");
//制作テーブル　　リレーション
define("TABLE_PRODUCTION",   "t_newbook_production");



/********************
*SQL
*
********************/
define("SQL_CLOTHES",json_encode(array(
    'SELECT'=>'*',
    'FROM'=>"Clothes",
    'INNER JOIN'=>'Tag_re',
    'ON'=>'Clothes.clothes_id=Tag_re.clothes_id'
)));

define("SQL_CLOTHES_MAX",json_encode(array(
    'SELECT'=>'count(*)',
    'FROM'=>"Clothes",
    'INNER JOIN'=>'Tag_re',
    'ON'=>'Clothes.clothes_id=Tag_re.clothes_id'
)));

define("SQL_TAGS",json_encode(array(
    'SELECT'=>'tag_name,tag_id',
    'FROM'=>"Tag_masta",
)));

define("SQL_LOGIN",json_encode(array(
    'SELECT'=>'*',
    'FROM'=>"Login",
)));

define("SQL_USER_TAGS",json_encode(array(
        'SELECT' => 'tag_name',
        'FROM' => 'Clothes',
        'INNER JOIN' => 'Tag_re ON Clothes.clothes_id=Tag_re.clothes_id
INNER JOIN Tag_masta ON Tag_re.tag_id=Tag_masta.tag_id',
        'WHERE' => "",
        'GROUP BY' => "Clothes.color",
        'ORDER BY' => 'count(*) desc',
        'LIMIT' => '0,1'
)));

define("SQL_USER_COLOR",json_encode(array(
    'SELECT'=>'color',
    'FROM' =>'Clothes',
    'INNER JOIN'=>'Tag_re ON Clothes.clothes_id=Tag_re.clothes_id',
    'WHERE' => "",
    'GROUP BY' => "Clothes.color",
    'ORDER BY' => 'count(*) desc',
    'LIMIT' => '0,1'
)));

define("SQL_USER_FAV",json_encode(array(
    'SELECT'=>'favorite_id',
    'FROM' =>'Favorite',
    'WHERE'=> ''
)));

