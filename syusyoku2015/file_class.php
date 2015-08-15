<?php
session_start();
define("WIDTH", 600); //出力する画像の幅
define("HEIGHT", 600); //出力する画像の高さ

$co="lt_bule";
//$on_img="../analytics_two.png";
$no_img=base64_decode($_POST['image']);
$top = $_POST['top'];
$left = $_POST['left'];

var_dump($_POST);

//出力先の画像を作成
$dst_im = imagecreatetruecolor(WIDTH, HEIGHT);
//黒で塗りつぶしておく

$black = imagecolorallocate($dst_im, 0, 0, 0);
//黒色指定

imagecolortransparent($dst_im, $black);
//黒色を透明化

//コピーする画像1枚目を取得(赤色)
$src_im = imagecreatefrompng('./images/base/lt_bule.png');
//出力先の画像に貼り付け
imagecopy($dst_im, $src_im, 50, 50, 0, 0, 600, 600);
imagedestroy($src_im);


//コピーする画像2枚目を取得(黄色)
$src_im = imagecreatefromstring($no_img);
//出力先の画像に貼り付け
//この時、dst_x(貼り付け先のx座標)に200を指定することで、貼り付け位置を下にずらす
//imagecopy($dst_im, $src_im, $top, $left, 0, 0, 200, 200);
//imagedestroy($src_im);

//結果がわかりやすいように矩形で画像全体を囲む
//$black = imagecolorallocate($dst_im, 0x00, 0x00, 0x00);
//背景画像に、画像をコピーする
imagecopyresampled($dst_im,  // 背景画像
    $src_im,   // コピー元画像
    $left,        // 背景画像の x 座標
    $top,        // 背景画像の y 座標
    0,        // コピー元の x 座標
    0,        // コピー元の y 座標
    200,   // 背景画像の幅
    200,  // 背景画像の高さ
    200, // コピー元画像ファイルの幅
    200  // コピー元画像ファイルの高さ
);
// 画像を出力する
//imagerectangle($dst_im, 0, 0, WIDTH-1, HEIGHT-1, $black);
//ファイルの保存
imagedestroy($src_im);
imagepng($dst_im,'./test.png',80);

ob_start();
imagepng($dst_im,NULL,9);
$result = base64_encode(ob_get_clean());
$_SESSION['$imageData'] = $result;
//メモリ開放
imagedestroy($dst_im);
