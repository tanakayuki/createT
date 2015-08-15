<style>
    .top_nav_on ul li p{
        color: #1A1A1A;
        width: 140%;
    }
    .top_nav_all{
        position:absolute;
        z-index: 10000;
        /*background-color:rgba(255,255,255,0.7);*/
        padding-bottom:0%;
        font-family: 'Open Sans', sans-serif;
        width: 100%;
    }
    .top_nav a:hover{
        background-color: #D8D8D8;
        -webkit-transition: 0.3s ease-in-out;
        -moz-transition: 0.3s ease-in-out;
        -o-transition: 0.3s ease-in-out;
        transition: 0.3s ease-in-out;
        opacity: 0.6;
        filter: alpha(opacity=60);
        color: #1e1e1e;
    }
    /*訪問済みリンク　の　色を　green　にする。*/
    .top_nav a:visited{
        color: #1A1A1A;
    }
    .top_nav a:link{
        color: #1A1A1A;
    }
    .top_nav a{
        display: block;
        text-decoration: none;
    }
    .top_nav_all a img {
        width:16%;
        float: left;
        padding: 0.5% 2% 0% 15%;
    }
    .top_nav_all #top_text{
        float: right;
        padding: 0.5% 15% 0% 0%;
    }
    .top_nav_on{
        overflow: hidden;
        width: 100%;
        /*background-color: #fff;*/
        margin: 0 auto;
        position: absolute;
        top: 70px;
        /*box-shadow: 0px 2px 3px rgba(0,0,0,0.2);*/
        /*-webkit-box-shadow: 0px 2px 3px rgba(0,0,0,0.2);*/
        /*-moz-box-shadow: 0px 2px 3px rgba(0,0,0,0.2);*/
    }
    .top_nav{
        overflow: hidden;
        margin: 0 auto;
        width: 70%;
        height: 100%;
    }
    .top_nav ul li a{
        display: block;
        font-family: 'Lato', sans-serif;
        font-weight: 100;
    }
    .top_nav ul li p{
        margin: 0;
        width: 130%;
        color: #D8D8D8;
    }
    .top_nav ul li {
        background-color: #fff;
        float: left;
        width:19%;
        height: 100%;
        border: 1px #e3e1dc solid;
        text-align: center;
        line-height: 300%;
    }
    .top_nav_on ul li:first-child{
        /*border-left: solid 1px #666;*/
    }
    #top_text{
        float: left;
    }
    .top_nav_all{
        padding-bottom: 1%;
    }
    .left_nav .left_nav1,.left_nav .left_nav2{
        width: 10%;
        float: right;
        font-size: 15px;
        line-height: 200%;
        background-color: #464646;
        border-left:solid 1px #fff;
    }
    .left_nav li a{
        display: block;
        text-decoration: none;
    }
    .left_nav li a:link,.left_nav li a:visited{
        color: #fff;
    }
    .left_nav ul{
        margin-right: 10%;
        text-align: center;
    }
    .left_nav3{
       position: absolute;
        left: 73%;
        top:100%;
    }
    .left_nav3 span{
        background-color: #f8f98a;
    }
    .left_nav3 a{
        font-size: smaller;
        line-height: 200%;
        padding: 1% 0 1% 0 ;
        background-color: #464646;
    }
    .left_nav3 a:link,.left_nav3 a:visited{
        color: #ffffff;
    }
    /*#logo_nav{*/
        /*width: 10%;*/
        /*padding-left: 10%;*/
    /*}*/
    .top_nav .active{
        background-color: #4e4134;
    }
    .top_nav .active a{
        color: #fff;
    }

    #box_svg{
        position: absolute;
        left: 10%;
    }
</style>
<div class="top_nav_all">
    <div id="box_svg">
<!--        <a href="index.php"><img src="images/logo.png"></a>-->
    </div>
    <div class="left_nav">
        <ul>
            <li class="left_nav1"><a href="#">Contact</a></li>
            <li class="left_nav2"><a href="#">Shopping</a></li>
        </ul>
        <p class="left_nav3"> <?php if(isset($_SESSION['login_id'])){?>
        ようこそ<span><?php echo $_SESSION['login_id']['name'];?></span>さん
                <a href="login/logout.php">ログアウト</a>
        <?php }?>
        </p>
    </div>
<div class="top_nav_on">
    <div class="top_nav">
            <ul>
                <li><a href="index.php">TOP</a></li>
                <li><a href="#">ABOUT</a></li>
                <li><a href="list.php">SREACH</a></li>
                <li><a href="casutam.php">CREATE</a></li>
                <li><a href="#">MYPAGE</a></li>
            </ul>
        </div>
</div>
    </div>
