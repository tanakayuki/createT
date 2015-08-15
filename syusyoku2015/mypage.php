<?php
require_once 'class.php';
//ログインしてない場合はトップへ
session_start();
if(!isset($_SESSION['login_id'])){
    header("location:index.php");
}
else{
    $SELECT_query = new SELECT_query();
    $SELECT = new SELECT();
    $sql_login = json_decode(SQL_LOGIN, true);
    $sql_login = array_merge($sql_login, array(
        'WHERE' => "ac_types='{$_SESSION['login_id']['type']}'",
        'AND' => "user_id='{$_SESSION['login_id']['id']}'"
    ));
    $temp = $SELECT->SQL($sql_login, '');
    if (!$list = $SELECT_query->SQL($temp)) {

    }else{
        $sql_user_color = json_decode(SQL_CLOTHES, true);
        $sql_user_color['SELECT']="color";
        $sql_user_color = array_merge($sql_user_color, array(
            'WHERE' => "Clothes.user_id='{$_SESSION['login_id']['id']}'",
            'GROUP BY' => "Clothes.user_id",
            'ORDER BY' => 'count(*) desc',
            'LIMIT' => '0,1'
        ));
        $temp = $SELECT->SQL($sql_user_color, '');
        if (!$color = $SELECT_query->SQL($temp)) {

        }
        else{
            $color = $color[0]['color'];
        }
    }
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>マイページ</title>
    <?php //js css 外部読み込み分のまとめ ?>
	<?php require_once("imput.php") ?>
  <style>
    .wrapper {
    	height: auto !important;
    	height: 100%;
    	margin: 0 auto; 
    	overflow: hidden;
	}
    .credit {
      text-align: center;
      color: #888;
      margin: 0 0 0 0;
      background: #f5f5f5;
      float: left;
      width: 100%;
    }
    .credit a {
      text-decoration: none;
      font-weight: bold;
      color: black;
    }
    .panorama {
      width: 100%;
      float: left;
      height: 600px;
      position: relative;
    }
    .panorama .credit {
      background: rgba(0,0,0,0.2);
      color: white;
      font-size: 12px;
      text-align: center;
      position: absolute;
      bottom: 0;
      right: 0;
      box-sizing: border-box;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      float: right;
    }
    
	h2{
		font-size:18px;
	}
	#name{
		width:150px;
		height:150px;
		  -webkit-border-radius: 75px;/* width,heightの半分 */
    -moz-border-radius: 75px;
    border-radius: 75px;
    background-color: #E2802F;/* 円の色 */
		position:absolute;
		top:500px;
		left:15%;
		text-align:center;
	}
	#name p{
		color:#FFF;
		font-size:80px;
		margin:0 auto;
		padding-top:60px;
	}
	#content{
		background-color:#FFF;
		width:980px;
		height:1000px;
		margin:0 auto;
		overflow:hidden;
		/*基点*/
		position : static;
	}
	#L_cont{
		float:left;
		width:200px;
		
	}
	#C_cont{
		float:left;
		width:400px;
		
		margin-left:20px;
	}
	#R_cont{
		float:right;
		width:220px;
		
		
	}
	#R_cont .sum ,#R_cont .sum img{
		width:50px;
		height:50px;
		float:left;
	}
	
#color-cip{
  -webkit-appearance: none;
  width:40px;
  height:40px;
  border:2px solid #19283C;
  border-radius:15px;
  opacity:0.5;
}
    .not{
        background:#fff;
    }
    .red{
        background:#F30;
    }
    .bule{
        background:#00F;
    }
    .green{
        background:#6F0;
    }
    .broun{
        background:#C93;
    }
</style>
	<script>
	// Use $(window).load() on live site instead of document ready. This is for the purpose of running locally only
	  $(document).ready(function(){
      $(".panorama").panorama_viewer({
        repeat: true
      });
		});
	</script>
</head>
<body>
<div class="wrapper"><?php require_once("header.php"); ?>
      <div class="panorama">
        <img src="demo_photo.jpg">
  	   	<div class="credit">
  	    	<p></p>
            <a class="btn btn-primary btn-large">プロフィール編集</a>
            <a class="btn btn-large" href="#"><i class="icon-star"></i> お気に入り</a>

        </div>
  	  </div>

      <div id="content" class="well">
        <div id="name">
        <p>T</p>
      </div>
          <div id="L_cont" class="well">
              <h2 class="page-header">検索結果</h2>
              <div class="row">
                  <div class="span9">
                      <ul class="thumbnails" id="clothes_view"></ul>
                      <div class="pagination" id="pageing_view" style="text-align:center">
                          <ul>


                          </ul>
                      </div>
                      <div id="paging"></div>
                  </div>
              </div>
          </div>

        <div id="R_cont" class="well">
         <h2 class="page-header">プロフィール</h2>
        <table class="table">
          <tr>
            <td>ユーザ名</td>
            <td><?php echo $list[0]['names']; ?></td>
          </tr>
          <tr>
            <td>人気ランキング</td>
            <td>２位</td>
          </tr>
          <tr>
            <td>アカウント</td>
            <td><?php echo $list[0]['ac_types']; ?></td>
          </tr>
           <tr>
            <td>よく使うタグ</td>
            <td>カフェ</td>
          </tr>
           <tr>
            <td>よく使う色</td>
            <td><div id="color-cip" class="<?php echo $color; ?>"></div></td>
          </tr>
        </table>
        <a class="btn btn-large" href="#"><i class="icon-ok"></i>ファン登録</a>
        </div>
      </div>
    </div>
</body>
</html>
