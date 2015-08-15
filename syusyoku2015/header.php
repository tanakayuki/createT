<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="index.php">LOGO</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">TOP</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="list.php">Search</a></li>
               <li><a href="mypage.php">MyPage</a></li>
                <?php if(isset($_SESSION['login_id'])){
//                    var_dump($_SESSION['login_id']);?>
                <li><a href="./login/logout.php">LOGOUT</a></li>
                <li><a><?php echo $_SESSION['login_id']['name'];?></a></li>
                <?php }else{?>
                    <li><a>未ログイン</a></li>
                <?php }?>
            </ul>
          </div><!--/.nav-collapse -->
           <div class="btn btn-navbar" id="toggle">検索</div>
        </div>
      </div>
</div>