<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>物件詳細</title>
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
		left:20%;
		text-align:center;
	}
	#name p{
		color:#FFF;
		font-size:80px;
		margin:0 auto;
		padding-top:70px;
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
  background:#FF0;
}

footer{
	background-image:url(images/footer.png);
	background-repeat:repeat-x ;
	line-height:100px;
	text-align:center;
	padding-top:30px;
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
  <div class="wrapper">
 <?php //ヘッダー領域?>      
 <?php require_once("header.php"); ?>
       
      <div class="panorama">
  	  	<img src="ああ.jpg">
  	   	<div class="credit">
  	    	<p></p>
            <a class="btn btn-large" href="#"><i class="icon-star"></i> お気に入り</a>
        </div>
  	  </div>
      
      
      <div id="content" class="well">
        <div id="name">
        <p>T</p>
      </div>
      	<div id="L_cont" class="well">
       <h2 class="page-header">残す家具</h2>
<div class="row">
    <div class="span6">
        <ul class="thumbnails">
            <li class="span3">
                <div class="thumbnail">
                	 <a href="#" class="thumbnail">
                     <img src="../smatan 売買 不動産 検索 API β版できました Ｐ－ＲＥＸ_files/bn_marumie.jpg">
                    </a>
                    
                    <div class="caption">
                        <h5>タイトル</h5>
                        <p>高さは自動的に調整されるようですね。</p>
                        <p><a href="#" class="btn btn-primary">Action</a> <a href="#" class="btn">Action</a></p>
                    </div>
                </div>
                
     
                 <a href="#" class="thumbnail sum">
                     <img src="../smatan 売買 不動産 検索 API β版できました Ｐ－ＲＥＸ_files/bn_marumie.jpg">
                </a>
                <a href="#" class="thumbnail sum">
                     <img src="../smatan 売買 不動産 検索 API β版できました Ｐ－ＲＥＸ_files/bn_marumie.jpg">
                </a>
                <a href="#" class="thumbnail sum">
                     <img src="../smatan 売買 不動産 検索 API β版できました Ｐ－ＲＥＸ_files/bn_marumie.jpg">
                </a>
                <a href="#" class="thumbnail sum">
                     <img src="../smatan 売買 不動産 検索 API β版できました Ｐ－ＲＥＸ_files/bn_marumie.jpg">
                </a>
                  <a href="#" class="thumbnail sum">
                     <img src="../smatan 売買 不動産 検索 API β版できました Ｐ－ＲＥＸ_files/bn_marumie.jpg">
                </a>
                <a href="#" class="thumbnail sum">
                    <img src="../smatan 売買 不動産 検索 API β版できました Ｐ－ＲＥＸ_files/bn_marumie.jpg">
                </a>
            </li>
        </ul>
        <p>もっと</p>
    </div>

</div>
	
        </div>      
    	<div id="C_cont" class="well">
        <h2 class="page-header">最新情報</h2>
       <table class="table">
       <tr><td>
      	 <blockquote>
   			 <p>Twitter BootstrapはCSS フレームワークです。</p>
   		 	<small>SmokyJp <cite title="wivern.com">「TwitterBootstrap入門」</cite></small>
		 </blockquote>
		<p>aaaaa</p>
       </td></tr>
               <tr><td>
      	 <blockquote>
   			 <p>Twitter BootstrapはCSS フレームワークです。</p>
   		 	<small>SmokyJp <cite title="wivern.com">「TwitterBootstrap入門」</cite></small>
		 </blockquote>
		<p>aaaaa</p>
       </td></tr>
               <tr><td>
      	 <blockquote>
   			 <p>Twitter BootstrapはCSS フレームワークです。</p>
   		 	<small>SmokyJp <cite title="wivern.com">「TwitterBootstrap入門」</cite></small>
		 </blockquote>
		<p>aaaaa</p>
       </td></tr>
               <tr><td>
      	 <blockquote>
   			 <p>Twitter BootstrapはCSS フレームワークです。</p>
   		 	<small>SmokyJp <cite title="wivern.com">「TwitterBootstrap入門」</cite></small>
		 </blockquote>
		<p>aaaaa</p>
       </td></tr>
        
        
        </table>

        </div>
	   	
        <div id="R_cont" class="well">
         <h2 class="page-header">物件プロフィール</h2>
        <table class="table">
          <tr>
            <td>ユーザ名</td>
            <td>TANAKA</td>
          </tr>
          <tr>
            <td>人気ランキング</td>
            <td>２位</td>
          </tr>
          <tr>
            <td>引っ越し時期</td>
            <td>2014年3月12日</td>
          </tr>
          <tr>
            <td>入居日</td>
            <td>2012年3月12日</td>
          </tr>
           <tr>
            <td>ジャンル</td>
            <td>カフェ</td>
          </tr>
           <tr>
            <td>色</td>
            <td><div id="color-cip"></div></td>
          </tr>
        </table>
        <a class="btn btn-large" href="#"><i class="icon-ok"></i>受付番号発行</a>
            
        </div>
      </div>
	<?php //フッター領域?>      
 	<?php require_once("footer.php"); ?>
    </div>
</body>
</html>
