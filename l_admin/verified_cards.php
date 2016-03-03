<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Lost & Found Admin Panel</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
   
    <link href="../css/jquery-ui.min.css" rel="stylesheet">
    
 
      
  
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
  </head>
  <?php 
  require_once "functions.php"; 
  require_once "loginstate.php"; 
  if (isset($_GET["signout"])) {
    session_destroy();
    jumpUrl("signin.php");
    return;
  }
  if ($_SESSION["type"]>1) {
    die("当前用户没有权限访问此页面");
  }
?>
  <body>



    <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand">Lost & Found Admin Panel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

        
      <div class="navbar-form navbar-left" role="search" act>
        <div class="input-group">
             <div class="input-group-btn">
              <button id="dropdownbtn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">搜索选项 <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu" id="dropdownmenu">
                  <li><a href="#" data="ID">ID </a></li>
                  <li><a href="#" data="name">姓名 </a></li>
                  <li><a href="#" data="num">卡号 </a></li>
                  <li><a href="#" data="uploader">上传者 </a></li>
                  <li><a href="#" data="contact">联系方式 </a></li>
                  <li><a href="#" data="college">学院 </a></li>
                </ul>
                

               </div><!-- /btn-group -->
            <input id="searchinput" type="text" class="form-control" placeholder="Search for..." >
            <span class="input-group-btn">
              <button id="searchbtn" class="btn btn-default" onclick="onSearchClick('verified_cards.php')">
              <span class="glyphicon glyphicon-search"></span> Go!</button>
            </span>

         </div>
        
      </div>
      <ul class="nav navbar-nav navbar-right">   
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
          <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $_SESSION["username"];?> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#" data-target="#changepwdModal" data-toggle="modal"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>修改密码</a></li>
            <li class="divider"></li>
            <li ><a href="?signout"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> 退出</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


      
<div class="container-fluid">
  <div class="row">
  
    <div class="col-sm-3 limit-side-width">
        <?php require_once "side.php"; ?>
        
        
      
    </div>
    
    <div class="col-sm-9">
       <?php 
            if(isset($_SESSION["msg"]))
            {
                  
                  echo '<div class="alert alert-'.$_SESSION["msgtype"].' fade in">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                   </button>
                   <strong>'.$_SESSION["msg"].'</strong>
                    </div>';
                unset($_SESSION["msg"]);
            }
      ?>
        <div class="panel panel-default">
          <div class="panel-heading"><label>管理招领数据</label></div>
          <div class="panel-body">
          可以在此面板编辑、删除招领数据(卡类)<br />点击<b>列表头</b>可以进行排序，点击标题显示详细信息
          </div>
          <table class="table table-hover table-striped"> 
            <thead>
                      <tr id="table-head">
                      <th><a href="<?php echo GetOrderPara("ID");?>">ID</a></th>
                      <th><a href="<?php echo GetOrderPara("name");?>">姓名</a></th>
                      <th><a href="<?php echo GetOrderPara("num");?>">卡号</a></th>
                      <th><a href="<?php echo GetOrderPara("uploader");?>">上传者</a></th>
                      <th><a href="<?php echo GetOrderPara("type");?>">类型</a></th>
                      <th><a href="<?php echo GetOrderPara("isfounded");?>">状态</a></th>
                      <th><a href="<?php echo GetOrderPara("uploaddate");?>">上传时间</a></th>
                    </tr>
            </thead>
            <tbody id="tablebody">
                
                   <?php 
                      
                   		$maxpage=0;
          						if (isset($_GET["col"]) && isset($_GET["key"])) {
          						    $col=trim($purifier->purify($_GET["col"]));
          						    $key=trim($purifier->purify($_GET["key"]));

                          $datebase=new medoo();
          						    global $maxpage;
          						    $maxpage=ceil($datebase->count("cards",array(
                             "AND"=>array(($col."[~]")=>$key,"AND"=>array("from"=>1,"verified"=>1))
                            ))/20)-1;

          						   
          						}else{
                         $datebase=new medoo();
                         global $maxpage;
                         $maxpage=ceil($datebase->count("cards",array("AND"=>array("from"=>1,"verified"=>1)))/20)-1;

          						}
            $where;
            $order=GetSelectOrder();
            if (isset($_GET["page"])) {
                          $page=$purifier->purify($_GET["page"]);
                          $page=$page<0?0:$page;
                          $page=$page>$maxpage?$maxpage:$page;
                          if (isset($_GET["col"]) && isset($_GET["key"])) {
            							    $col=trim($purifier->purify($_GET["col"]));
            							    $key=trim($purifier->purify($_GET["key"]));
            							     $where=array("LIMIT"=>array($page*20,20),
                                                  "AND"=>array(($col."[~]")=>$key,"from"=>1,"verified"=>1)
                                                 ,"ORDER"=> $order);
            							}else
                         		$where=array("LIMIT"=>array($page*20,20),"ORDER"=> $order,"AND"=>array("from"=>1,"verified"=>1));
              }else{
                        	if (isset($_GET["col"]) && isset($_GET["key"])) {
          							    $col=trim($purifier->purify($_GET["col"]));
          							    $key=trim($purifier->purify($_GET["key"]));
                            
          							   $where=array("LIMIT"=>20,
                            "AND"=>array(($col."[~]")=>$key,"from"=>1,"verified"=>1)
                            ,"ORDER"=> $order);
							           }else
                          		$where=array("LIMIT"=>20,"ORDER"=> $order,"AND"=>array("from"=>1,"verified"=>1));
                      }
                      createTable_cards($where);  
                        
                      
              ?>
                
            </tbody>
          </table>
          <?php require_once "pager.php"?>
          <div class="panel-footer">
                
            
          </div>
          
        </div>
    <div class="container">
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" 
         aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" 
                     data-dismiss="modal" aria-hidden="true">
                        &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            <label>审核数据</label>
                        </h4>
                    </div>
                <div class="modal-body">
                          <form method="POST" action="post.php?referer=verified_cards.php&action=editcard" enctype="multipart/form-data">
                            <div class="form-group">
                              <input type="text" id="ID" name="ID" class="hidden">
                             <label>姓名</label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="姓名" required>

                              <label>卡号</label>
                              <input id="num" type="text" class="form-control"  name="num" placeholder="卡号" required>

                              <label>认领处</label>
                              <input id="place" type="text" class="form-control" name="place" placeholder="认领处" required>
                              
                              <label>丢失日期</label>
                              <input type="text" class="form-control" readonly name="lostdate" id="lostdate2" placeholder="丢失日期" required>

                              <label>联系方式(非必须)</label>
                              <input id="contact"  type="text" class="form-control"  name="contact" placeholder="联系方式">

                              <label>学院(非必须)</label>
                              <input id="college" type="text" class="form-control" name="college" placeholder="学院" >

                              <label>类型</label>
                              <select class="form-control" id="type" name="type">
                                <?php createTypeSelect("cards");?>
                              </select>

                              <label>状态</label>
                              <select class="form-control" id="isfounded" name="isfounded">
                                <option value="0">未找到</option>
                                <option value="1">已找到</option>
                              </select>

                            </div>

                             <div class="modal-footer">
                                <button type="button" table="cards" class="btn btn-danger" id="delete" data-dismiss="modal">删除</button>
                                <button type="submit" class="btn btn-primary" name="submit">提交</button>
                              </div>
                          </form>
                           
               </div>
              
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->  
        </div>
        <div class="modal fade" id="changepwdModal" tabindex="-1" role="dialog" 
         aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" 
                     data-dismiss="modal" aria-hidden="true">
                        &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            <label>修改密码</label>
                        </h4>
                    </div>
                <div class="modal-body">
                          <form id="formpwd" method="POST" action="post.php?referer=signin.php&action=changepwd">
                            <div class="form-group">
                              <input type="text" name="username" value="<?php echo $_SESSION['username'];?>" class="hidden">
                              <label>原密码</label>
                              <input type="password" class="form-control" id="prepwd" name="prepwd" placeholder="请输入原密码" onkeyup="pwdkeyup()" required>

                              <label>新密码</label>
                              <input type="password" class="form-control" id="newpwd" name="newpwd" placeholder="请输入新密码" onkeyup="pwdkeyup()" required>

                              <label>确认新密码</label>
                              <input type="password" class="form-control" id="newpwdagain" name="newpwdagain" placeholder="请确认新密码" onkeyup="pwdkeyup()" required>
                              <div class="alert alert-danger fade-in" style="display: none;" id="pwdmsg" role="alert">
                                
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                <label id="labelpwdmsg">两次输入的密码不一样</label>
                              </div>
                            </div>

                             
                          </form>
                          <div class="modal-footer">
                                <button class="btn btn-primary" onclick="pwd()">提交</button>
                          </div>
                           
               </div>
              
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->  
        </div>
    </div>
</div>
  
</div>
<hr />
<footer class="footer">
  <p>© 2015 NewScript @lam</p>
  <p class="pull-right"><a href="#">Back to top</a></p>
</footer>

 
 
    <script src="../js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    
    <script src="../js/js.js"></script>
          
  </body>
</html>