<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>loast & found</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
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
      <a class="navbar-brand">L&F Admin Panel</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search" act>
        <div class="input-group">
             <div class="input-group-btn">
              <button id="dropdownbtn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">搜索选项 <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu" id="dropdownmenu">
                  <li><a href="#">ID </a></li>
                  <li><a href="#">Title </a></li>
                  <li><a href="#">Content </a></li>
                  <li><a href="#">Uploader </a></li>
                  <li class="divider"></li>
                  <li><a href="#">type </a></li>
                  <li><a href="#">state </a></li>
                </ul>
                

               </div><!-- /btn-group -->
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit">Go!</button>
            </span>

         </div>
        
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


      <?php
        $con = mysql_connect("localhost","root","usbw");
        if (!$con)
          {
          die('Could not connect: ' . mysql_error());
          }
        mysql_select_db("test",$con);
        $result = mysql_query("select * from items");
      ?>
<div class="container-fluid">
  <div class="row">

    <div class="col-sm-3 limit-side-width">
      
        <ul class="nav nav-pills nav-stacked limit-side-width">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#">Profile</a></li>
          <li><a href="#">Messages</a></li>
        </ul>
      
    </div>

    <div class="col-sm-9">
        <?php 
      if($_SERVER['REQUEST_METHOD']=="GET" && isset($_GET["status"]))
      {
        if ($_GET['status']==1) 
        {
          echo '<div class="alert alert-success fade in">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
               </button>
               <strong>数据添加成功</strong>
                </div>';
        }else{
        echo '<div class="alert alert-danger fade in">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>数据添加失败</strong>
    </div>';
             }
      }
    
    ?>
    
      <table class="table table-hover"> 
        <thead>
                  <tr>
                  <th><a>ID</a></th>
                  <th><a>Name</a></th>
                  <th><a>pic</a></th>
                  <th><a>Uploader</a></th>
                  <th><a>type</a></th>
                  <th><a>state</a></th>
                  <th><a>uploaddate</a></th>
                </tr>
        </thead>
        <tbody>
               <?php 
               while($row = mysql_fetch_array($result))
               {
                  echo '<tr>
                    <td>'.$row["ID"].'</td>
                    <td>
                      <h4>
                        <a>'.$row["title"].'</a>
                      </h4>
                      <p>'.$row["content"].'</p>
                      
                    </td>
                    <td><img width="32px" height="32px" src="'.$row["imgUrl"].'"></td>
                    <td>'.$row["uploader"].'</td>
                    <td>'.$row["type"].'</td>
                    <td>'.($row["state"]==0?"未找到":"已找到").'</td>
                    <td>'.$row["uploaddate"].'</td>
          </tr>';
                  
               }
               mysql_close($con);
          ?>
          
        </tbody>

      </table>
      <button data-target="#myModal" data-toggle="modal" class="btn btn-default">添加</button>

    </div>
  </div>
  
</div>
<div class="container">
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               <label>添加数据</label>
            </h4>
         </div>
         <div class="modal-body">
                    <form method="POST" action="post.php">
                      <div class="form-group">
                        <label>title</label>
                        <input type="text" class="form-control" name="title" placeholder="title" required>
                     
                        <label>content</label>
                        <textarea class="form-control" rows="5" name="content" placeholder="content" required></textarea>

                        <label>remarks</label>
                        <textarea class="form-control" rows="5" name="remarks" placeholder="remarks" required></textarea>
                      
                        <label>imgurl</label>
                        <input type="text" class="form-control" name="imgurl" placeholder="imgurl" required>

                        <label>type</label>
                        <select class="form-control" name="type">
                          <option value="0">校卡</option>
                          <option value="1">物品</option>
                        </select>

                        <label>uploader</label>
                        <input type="text" class="form-control" name="uploader" placeholder="uploader" required>

                      </div>

                       <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                          <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                       
                     </form>
         </div>
         
      </div><!-- /.modal-content -->
    </div><!-- /.modal -->
  
  </div>
</div>

 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
            $(document).ready(function(){
              $("ul#dropdownmenu li a").click(function(){
                $("#dropdownbtn").html($(this).text()+'<span class="caret"></span>');
               

              });

            });
          </script>
  </body>
</html>