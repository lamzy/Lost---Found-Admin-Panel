
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>登录后台</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/signin.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <?php 
      
    ?>
    <form class="form-signin" method="POST" >
      
       <?php 
       include "functions.php";
            if (isset($_POST["username"]) && isset($_POST["pwd"])) {
                $username=$purifier->purify($_POST["username"]);
                $pwd=md5("lam".$purifier->purify($_POST["pwd"]));
                if(signin($username,$pwd))
                {
                  
                  echo '<div class="alert alert-success fade in">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                   </button>
                   <strong>登录成功，1秒后跳转</strong>
                    </div>';
                  session_start();
                  $_SESSION["username"]=$username;
                  $_SESSION["pwd"]=$pwd;
                  $database=new medoo();
                  $data=$database->get("admins","type",array("username"=>$username));
                  $_SESSION["type"]=$data;
                  delayJump("index.php",1000);
                }else{
                  
                  echo '<div class="alert alert-info fade in">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                   </button>
                   <strong>用户名或密码错误</strong>
                    </div>';
                }
            }
            
                  
                  
                
      ?>
        <h2 class="form-signin-heading"><label>登录</label></h2>
        <label for="inputEmail" class="sr-only">用户名</label>
        <input type="text" id="inputEmail" class="form-control" name="username" placeholder="用户名" required="" autofocus="">
        <label for="inputPassword" class="sr-only">密码</label>
        <input type="password" id="inputPassword" class="form-control" name="pwd" placeholder="密码" required="">
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> 记住我
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
      </form>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>