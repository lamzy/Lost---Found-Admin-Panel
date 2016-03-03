 <?php 
require_once "Mobile_Detect.php";

$detect=new Mobile_Detect();
$cards=$items2=$cards2="";
if ($detect->isMobile()) {
  $cards="m_z_cards.php";
  $items2="m_s_items.php";
  $cards2="m_s_cards.php";
 }else{
  $cards="c_z_cards.php";
  $items2="c_s_items.php";
  $cards2="c_s_cards.php";
 }
  
 ?>
 <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
     <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">菜单</button>
<?php 
            
            if(!isset($searchoption) && $detect->isMobile() && isset($detailspage)){
              echo '<a><img class="nav-center" src="img/details.png"></a><button type="button" onclick="onback();" class="nav-back btn btn-default navbar-right">返回</button>';
            }elseif($detect->isMobile() && isset($userpage)){
              echo '<a><img class="nav-center" src="img/user.png"><button type="button" onclick="location.href=\'user.php\';" class="nav-back btn btn-default navbar-right"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>主页</button>';
            }elseif($detect->isMobile()){
              echo ' <a>
          <img class="brand" src="img/su2.png">
          </a><button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-2"><span class="glyphicon glyphicon-search"></span></button>';
            }else{
              echo ' <a>
                  <img class="brand" src="img/su2.png">
                  </a>';
            }
            
         ?>
         <script>
          function onback(){
            str=document.referrer;
           
            if (str.substr(0,str.indexOf("/",7))=="http://newscript.duapp.com") {
              history.go(-1);
            }else{
              location.href="index.php";
            }
          }
         </script>
         
        
        
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <?php 
        if (isset($searchoption) && $detect->isMobile())
            {
              echo '<div class="collapse navbar-collapse" id="navbar-collapse-2">

            <form id="searchform" class="pull-left nav-top-search" method="GET">

            <div class="input-group">
            <div class="input-group-btn">
            
              '.$searchoption.'
            </div>
            <!-- /btn-group -->
             <input id="col" type="text" name="col" class="hidden">
            <input id="key" name="key" onkeyup="searchkeyup()" type="text" class="form-control" placeholder="请输入关键字" required>
            <span class="input-group-btn">
              <button type="button" id="searchbtn" class="btn btn-default">
                <span class="glyphicon glyphicon-search"></span>
                Go!
              </button>
            </span>
          </div>
          <div class="alert alert-danger fade-in"  id="searchmsg" style="display:none;" role="alert">

            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            <label id="labelmsg"></label>
          </div>
        </form>
        
        </div>';
            }
      ?>
      
      <div class="collapse navbar-collapse" id="navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span>
              招领 (有人捡到东西)
            </a>
            <ul class="dropdown-menu" role="menu">
              <li>
                <a href="index.php">
                  <span class="glyphicon glyphicon-book"></span>
                  物品
                </a>
              </li>
              <li>
                <a href="<?php echo $cards;?>">
                  <span class="glyphicon glyphicon-book"></span>
                  卡类
                </a>
              </li>
            </ul>
          </li>
        </ul>

        <ul class="nav navbar-nav ">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span>
              失物 (有人丢东西了)
            </a>
            <ul class="dropdown-menu" role="menu">
              <li>
                <a href="<?php echo $items2;?>">
                  <span class="glyphicon glyphicon-book"></span>
                  物品
                </a>
              </li>
              <li>
                <a href="<?php echo $cards2;?>">
                  <span class="glyphicon glyphicon-book"></span>
                  卡类
                </a>
              </li>
            </ul>
          </li>
        </ul>

        
        <?php 
            
            if ($detect->isMobile())
            {
          //     echo '<ul id="dropdownmenu" class="nav navbar-nav">
          //   <li class="dropdown">
          //     <a id="dropdownbtn" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
          //       搜索选项
          //       <span class="caret"></span>
          //     </a>
          //     '.$searchoption.'
          //   </li>
          // </ul>';
            }
            
         ?>

          
         <?php
          if(!$detect->isMobile()&& isset($searchoption))
          {
            echo '<form id="searchform" class="navbar-form navbar-left" method="GET">
            <div class="input-group">
            <div class="input-group-btn">
              <button id="dropdownbtn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                搜索选项
                <span class="caret"></span>
              </button>'.$searchoption.'
            </div>
            <!-- /btn-group -->
             <input id="col" type="text" name="col" class="hidden">
            <input id="key" name="key" onkeyup="searchkeyup()" type="text" class="form-control" placeholder="Search for..." required>
            <span class="input-group-btn">
              <button type="button" id="searchbtn" class="btn btn-default">
                <span class="glyphicon glyphicon-search"></span>
                Go!
              </button>
            </span>
          </div>
          <div class="alert alert-danger fade-in"  id="searchmsg" style="display:none;" role="alert">

            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            <label id="labelmsg"></label>
          </div>
        </form>
            ';
          }

        ?>
           
          

        <ul class="nav navbar-nav">
          <li>
            <a href="user.php<?php if(strpos($_SERVER['PHP_SELF'], "user.php"))echo '?signout';?>">
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
              <?php 
                    //$_SESSION["front_username"]="s";
                    if (isset($_SESSION["front_username"])) 
                    {
                      if (isset($userpage)) {
                        echo '退出当前用户';
                      }else
                        echo $_SESSION["front_username"];
                    }
                  else
                    echo "登录(丢失登记)";
              ?>
            </a>

          </li>
        </ul>
      </div>
      <!-- /.navbar-collapse --> </div>
    <!-- /.container-fluid --> </nav>