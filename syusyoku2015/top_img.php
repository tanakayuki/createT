<?php
require_once 'class.php';
$sql = json_decode(SQL_CLOTHES, true);
$sql = array_merge($sql, array('WHERE' => 'Publication = 2'));
$sql = array_merge($sql, array('LIMIT' => "0,21"));
$SELECT = new SELECT();
$SELECT_query = new SELECT_query();
$temp = $SELECT -> SQL($sql,'');
$num =0;
//19
$num_array = array(33,22,11,33,11,11,22,11,22,11,22,11,22,22,11,11,11,11,11,11,11);
?>

<style>
#content {
    /*background-image: -moz-linear-gradient(top, #eee, #fff);*/
    /*background-image: -ms-linear-gradient(top, #eee, #fff);*/
    /*background-image: -o-linear-gradient(top, #eee, #fff);*/
    /*background-image: -webkit-gradient(linear, center top, center bottom, from(#eee), to(#fff));*/
    /*background-image: -webkit-linear-gradient(top, #eee, #fff);*/
    /*background-image: linear-gradient(top, #eee, #fff);*/
    opacity: 1;
    filter: alpha(opacity = 1);
}
.box img{
    opacity: 0.2;
}
</style>
<div id="content" style="position: relative; height: 600px;">
<!--            <div class="box size11" style="border:dashed 1px;">1x1</div>-->
<!--            <div class="box size13" style="border:dashed 1px;">1x3</div>-->
<!--            <div class="box size21" style="border:dashed 1px;">2x1</div>-->
<!--            <div class="box size23" style="border:dashed 1px;">2x3</div>-->
<!--            <div class="box size31" style="border:dashed 1px;">3x1</div>-->
<!--            <div class="box size12" style="border:dashed 1px;">1x2</div>-->
<!---->
<!--            <div class="box size22" style="border:dashed 1px;">2x2</div>-->
<!--            <div class="box size33" style="border:dashed 1px;">3x3</div>-->
<!--            <div class="box size32" style="border:dashed 1px;">3x2</div>-->
<!--            <div class="box size11" style="border:dashed 1px;">1x1</div>-->
<!--            <div class="box size13" style="border:dashed 1px;">1x3</div>-->
<!--            <div class="box size21" style="border:dashed 1px;">2x1</div>-->
<!---->
<!--            <div class="box size21" style="border:dashed 1px;">2x1</div>-->
<!--            <div class="box size41" style="border:dashed 1px;">4x1</div>-->
<!--            <div class="box size12" style="border:dashed 1px;">1x2</div>-->
<!--            <div class="box size21" style="border:dashed 1px;">2x1</div>-->
<!--            <div class="box size21" style="border:dashed 1px;">2x1</div>-->
<!--            <div class="box size33" style="border:dashed 1px;">3x3</div>-->
<!--            <div class="box size32" style="border:dashed 1px;">3x2</div>-->
<?php
if ($list = $SELECT_query->SQL($temp)) {
    foreach ($list as $data) {
        if($num<21){
            echo '<div class="box size';
            echo $num_array[$num].'"style="">';
            echo '<img src="data:image/jpg;base64,'.$data["image_data"].'" alt=""></div>';
            $num++;
        }
    }
}?>
        </div>
		<!--<script src="./sample2_files/jquery-1.10.2.min.js"></script>-->
		<script src="./sample2_files/jquery.nested.js"></script>
		<script>
			settings = {
				selector: '.box', // セレクタはboxクラス
				minWidth: 110, // ボックスの幅の単位は100px
				minColumns: 10, // 最低10単位(100px x 10単位 = 1000px)の幅のボックスをレイアウトする
				gutter: 10, // ボックス間の間隔は10px
				resizeToFit: true, // 空白より大きなボックスを空白に合うまでリサイズする
				resizeToFitOptions: {
						resizeAny: true // 空白より大きいまたは小さなボックスを空白に合うまでリサイズする
				},
				animate: true, // ボックスのレイアウトにアニメーションを使用
				animationOptions: {
						speed: 200, // 各要素のレンダリング速度は200ms
						duration: 150, // アニメーション実行間隔は300msごと
						queue: true // 要素を1つずつ順番にアニメーションさせる
//						complete: function () { alert("Animation Completed."); } // アニメーション完了後にアラートを表示する
				}
			};
			$("#content").nested(settings);
		</script>