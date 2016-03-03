<?php require_once "Mobile_Detect.php";
require_once "functions_front.php";
$detect=new Mobile_Detect();
if (!$detect->isMobile()) {
  jumpUrl("index.php");
  die();
 }
date_default_timezone_set('PRC');
 $userpage=1;
 $CASserver = "http://yigong.szu.edu.cn/CAS/";//身份认证URL**不能修改**
 $ReturnURL = "http://tw.szu.edu.cn/ns/l_f/user.php";//用户认证后跳回到您的网站，根据实际情况修改

 if (isset($_GET["signout"])) {
   unset($_SESSION['cas']);
   unset($_SESSION["front_username"]);
   unset($_SESSION["usernum"]);
   unset($_SESSION["UID"]);
   unset($_SESSION["banned"]);
   header("Location: http://tw.szu.edu.cn/ns/l_f/user.php?signout");
   die();
 }
if(isset($_SESSION["banned"]) && $_SESSION["banned"]==1)
{
  echo '<script>alert("此用户已被拉入黑名单！")</script>';
  header("Location: http://tw.szu.edu.cn/ns/l_f/user.php?signout");
  die("error");
}
 if(isset($_GET["ticket"]))//用户认证成功，得到有效ticket，获取用户的校园卡信息
   {
     $URL = $CASserver . "serviceValidate?ticket=" . $_GET["ticket"] . "&service=". urlencode($ReturnURL);
     $xmlString = file_get_contents($URL);//ticket短时间内一次请求有效，请自行保存session
     $_SESSION['cas']['casName']= RegexLog($xmlString, "PName");//姓名
     $_SESSION['cas']['OrgName']= RegexLog($xmlString, "OrgName");//单位
     $_SESSION['cas']['SexName']= RegexLog($xmlString, "SexName");//性别
     $_SESSION['cas']['StudentNo']= RegexLog($xmlString, "StudentNo");//学号
     $_SESSION['cas']['ICAccount']= RegexLog($xmlString, "ICAccount");//校园卡号
     $_SESSION['cas']['RankName']= RegexLog($xmlString, "RankName");//用户类别ID编号
     $_SESSION['cas']['personalid']= RegexLog($xmlString, "personalid");//证件号码
     header("Location: http://newscript.duapp.com/user.php");
     die();
   }
 if (!isset($_SESSION["cas"])) {
   header("Location: ". $CASserver ."login?service=". urlencode($ReturnURL));
   die("未登录");
 }else{
  $database=new medoo();
   $r=$database->get("l_users","*",array("usernum"=>$_SESSION['cas']['ICAccount']));
   if($r){
    $_SESSION["front_username"]=$r["username"];
    $_SESSION["usernum"]=$r["usernum"];
    $_SESSION["UID"]=$r["UID"];
    $_SESSION["banned"]=$r["banned"];
   }else{
    $UID=$database->insert("l_users",array("username"=>$_SESSION['cas']['casName'],
                                      "usernum"=>$_SESSION['cas']['ICAccount']
      ));
    if($UID>0){
      $_SESSION["front_username"]=$_SESSION['cas']['casName'];
      $_SESSION["usernum"]=$_SESSION['cas']['ICAccount'];
      $_SESSION["UID"]=$UID;
      $_SESSION["banned"]=0;
    }else{
      unset($_SESSION["cas"]);
      die("登录错误,添加新用户失败！");
    }
    
   }
 }

function RegexLog($xmlString,$subStr)
{
        preg_match('/<cas:'.$subStr.'>(.*)<\/cas:'.$subStr.'>/i',$xmlString,$matches);
        return $matches[1];  
}
 //POST
if (isset($_GET["card"]) || isset($_GET["item"])) {
  $database=new medoo();
  $r=0;
  if (isset($_POST["name"]) &&
    isset($_POST["num"])&&
    isset($_POST["lostdate"])&&
    isset($_POST["contact"])&&
    isset($_POST["type"]) &&
    isset($_POST["place"])) {

    $name=$purifier->purify($_POST["name"]);
    $num=$purifier->purify($_POST["num"]);
    $lostdate=$purifier->purify($_POST["lostdate"]);
    $contact=$purifier->purify($_POST["contact"]);
    $type=$purifier->purify($_POST["type"]);
    $place=$purifier->purify($_POST["place"]);

    if($name=="" ||
      $num=="" ||
      $lostdate==""||
      $contact==""||
      $type==""||
      $place==""){
      msgJump("user.php","信息不完整，登记失败!","danger");
        die("error");
    }

    $r=$database->insert("cards",array(
                "name"=>$name,
                "num"=>$num,
                "lostdate"=>$lostdate,
                "contact"=>$contact,
                "type"=>$type,
                "contact"=>$contact,
                "verified"=>1,
                "from"=>1,
                "place"=>$place,
                "#uploaddate"=>"CURDATE()",
                "isfounded"=>0,
                "uploader_UID"=>$_SESSION["UID"],
                "uploader"=>$_SESSION["front_username"]
      ));
  }elseif (isset($_POST["title"]) &&
    isset($_POST["description"])&&
    isset($_POST["lostdate"])&&
    isset($_FILES["uploadfile"])&&
    isset($_POST["type"]) &&
    isset($_POST["contact"]) &&
    isset($_POST["place"])) {

    $title=$purifier->purify($_POST["title"]);
    $description=$purifier->purify($_POST["description"]);
    $lostdate=$purifier->purify($_POST["lostdate"]);
    $type=$purifier->purify($_POST["type"]);
    $contact=$purifier->purify($_POST["contact"]);
    $place=$purifier->purify($_POST["place"]);
    $filepath="";

     if($title=="" ||
      $description=="" ||
      $lostdate==""||
      $contact==""||
      $type==""||
      $place==""){
      msgJump("user.php","信息不完整，登记失败!","danger");
        die("error");
    }

    $tp = array("image/gif","image/pjpeg","image/jpeg","image/png","image/bmp"); 
      if ($_FILES["uploadfile"]["size"]!=0 && ($_FILES["uploadfile"]["size"]>1024*1024*5 || 
        !in_array($_FILES["uploadfile"]["type"],$tp)))
      {
        msgJump("user.php","只能上传jpg,png,bmp图片，且小于5mb","danger");
        die("error");
      }elseif($_FILES["uploadfile"]["size"]!=0){
          $suffix=substr($_FILES["uploadfile"]["name"],stripos($_FILES["uploadfile"]["name"],"."));
          $filepath="images/user_".date('Y-m-d')."_".md5_file($_FILES["uploadfile"]["tmp_name"]).$suffix;
          move_uploaded_file($_FILES["uploadfile"]["tmp_name"],$filepath);
      }
      

      $r =$database->insert("items",array(
        "title"=>$title,
        "description"=>$description,
        "place"=>$place,
        "lostdate"=>$lostdate,
        "imgurl"=>$filepath,
        "type"=>$type,
        "#uploaddate"=>"CURDATE()",
        "from"=>"1",
        "isfounded"=>"0",
        "uploader_UID"=>$_SESSION["UID"],
        "uploader"=>$_SESSION["front_username"],
        "verified"=>1,
        "contact"=>$contact
        ));
  }

  if ($r>0)setmsg("登记成功,若发现有恶意信息，用户将被拉入黑名单！");
  else setmsg("登记失败！","danger");
  jumpUrl("user.php");
  die();
}


 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
  <meta name="format-detection" content="telephone=no" />
  <title>Lost & Found 用户中心</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/timeline_mobile.css">
  <link href="css/jquery-ui.min.css" rel="stylesheet">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<body>
  <?php require "nav.php";?>
  <div id="hold">
    <div class="container">
      <div style="height:65px;"></div>
      
      <?php 
          if (isset($_SESSION["front_msg"]) && isset($_SESSION["front_msgtype"])) {
                  echo '<div id="usermsg" class="alert alert-'.$_SESSION["front_msgtype"].' fade in">
              <strong>'.$_SESSION["front_msg"].'</strong>
            </div>';
                unset($_SESSION["front_msg"]);
                unset($_SESSION["front_msgtype"]);
          }

          if(!isset($_GET["action"])){
           echo '<a id="btncheckin" href="user.php?action=add" class="btn btn-default pull-right">丢失登记</a><div class="content" id="content">
      <article id="no"><section><span class="point-time point-blue"></span><aside><p class="title" id="ptitle">数据加载中</p><p class="brief" id="pbrief">正在读取数据</p></aside></section></article>
      </div>';
          }elseif ($_GET["action"]=="add") {
             echo '<div class="content" id="content">
             <article><h3>丢失登记</h3><section><span class="point-time point-yellow"></span><aside action="card"><p class="title">卡类</p><p class="brief">校园卡、银行卡、身份证等卡类物品丢失，请选此项</p></aside></section><section><span class="point-time point-yellow"></span><aside action="item"><p class="title">物品</p><p class="brief">U盘、雨伞、笔记本等物品丢失，请选此项</p></aside></section></article>
      </div>';
          }elseif ($_GET["action"]=="card") {
            echo '<form method="POST" action="?card">
                            <div class="form-group">
                              <label>姓名</label>
                              <input type="text" class="form-control" name="name" placeholder="姓名" required>

                              <label>卡号</label>
                              <input type="text" class="form-control"  name="num" placeholder="卡号" required>

                              <label>丢失地点</label>
                              <input type="text" class="form-control"  name="place" placeholder="丢失地点" required>
                              
                              <label>丢失日期</label>
                              <input type="text" class="form-control" name="lostdate" id="lostdate" placeholder="丢失日期" required>

                              <label>联系方式</label>
                              <input type="text"  class="form-control"  name="contact" placeholder="联系方式" required>

                              <label>学院(非必须)</label>
                              <input type="text" class="form-control" name="college" placeholder="学院" >

                              <label>类型</label>
                              <select class="form-control" name="type">';
                              createTypeSelect("cards");
                              echo'</select>
                            </div> 
                            <div class="pull-right">                  
                                <button type="reset" class="btn btn-default" data-dismiss="modal" style="margin-right:10px;">重置</button>
                                <button type="submit" class="btn btn-primary" name="submit">提交</button>
                            </div>
                             
                           </form>';
          }elseif ($_GET["action"]=="item"){
                echo '<form method="POST" action="?item" enctype="multipart/form-data">
                            <div class="form-group">
                              <label>物品名称</label>
                              <input type="text" class="form-control" name="title" placeholder="物品名称" required>

                              <label>详细描述</label>
                              <textarea class="form-control" rows="5" name="description" placeholder="详细描述" required></textarea>

                              <label>丢失地点</label>
                              <input type="text" class="form-control"  name="place" placeholder="丢失地点" required>
                              
                              <label>丢失日期</label>
                              <input type="text" class="form-control" name="lostdate" id="lostdate" placeholder="丢失日期" required>

                              <label>联系方式</label>
                              <input type="text"  class="form-control"  name="contact" placeholder="联系方式" required>

                              <label>图片(非必须)</label>
                              <input type="file" class="form-control" accept="image/*" name="uploadfile">

                              <label>类型</label>
                              <select class="form-control" name="type">';
                              createTypeSelect("items");
                              echo'</select>
                            </div> 
                            <div class="pull-right">                  
                                <button type="reset" class="btn btn-default" data-dismiss="modal" style="margin-right:10px;">重置</button>
                                <button type="submit" class="btn btn-primary" name="submit">提交</button>
                            </div>
                             
                           </form>';
          }
      ?>
    </div>
     <div style="height:105px;"></div>
    <?php require "footer.php"?>
  </div>
 


  <script src="js/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <script src="js/iscroll.js"></script>
  <script src="js/iscrollAssist.js"></script>
  <script src="js/purl.js"></script>
  <script src="js/jquery.finger.min.js"></script>
  <?php if(!isset($_GET["action"]))echo '<script src="js/user.js"></script>';
        elseif($_GET["action"]=="add"){
          echo '<script type="text/javascript">
             $(document).ready(function() {
                 $("aside[action]").on("tap", function() {
                     location.href="user.php?action="+$(this).attr("action");
                  });
             });
          </script>';}elseif ($_GET["action"]=="card" || $_GET["action"]=="item") {
            echo '<script src="js/jquery-ui.min.js"></script>
              <script type="text/javascript">
             $(document).ready(function() {
                  $text={
                closeText: "确认",  
              prevText: "<上月",  
              nextText: "下月>",  
              currentText: "现在",  
              monthNames: ["一月","二月","三月","四月","五月","六月",  
              "七月","八月","九月","十月","十一月","十二月"],  
              monthNamesShort: ["一","二","三","四","五","六",  
              "七","八","九","十","十一","十二"],  
              dayNames: ["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],  
              dayNamesShort: ["周日","周一","周二","周三","周四","周五","周六"],  
              dayNamesMin: ["日","一","二","三","四","五","六"],  
              weekHeader: "周",  
              dateFormat: "yy-mm-dd",  
              firstDay: 1,  
              isRTL: false,  
              showMonthAfterYear: true,  
              yearSuffix: "年"
                
              };
          $("#lostdate").datepicker($text);
          $("#lostdate").keydown(function(e){
            e.preventDefault();
                        });
             });

          

           
          </script>
            ';
          }
  ?>
</body>
</html>