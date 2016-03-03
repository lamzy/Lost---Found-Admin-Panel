<?php require_once "Mobile_Detect.php";
require_once "functions_front.php";
$detect=new Mobile_Detect();
if (!$detect->
isMobile()) {
  jumpUrl("index.php");
  die();
 }
$detailspage=1;
 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
  <meta name="format-detection" content="telephone=no" />
  <title>Lost & Found 详情页</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/timeline_mobile.css">

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
        if(isset($_GET["table"]) && isset($_GET["ID"]) && isset($_GET["from"]))
        {
          $table=$purifier->purify($_GET["table"]);
          $ID=$purifier->purify($_GET["ID"]);
          $from=$purifier->purify($_GET["from"]);
          $database=new medoo();
          $uploader_UID="";
          $isfounded=0;
          if ($table=="items") {
            $data=$database->get($table,array("[>]types"=>array("type"=>"TID")),array("items.ID","title","description","contact","from","place","isfounded","type","imgurl","lostdate","uploaddate","types.typename","uploader_UID")
              ,array("items.ID"=>$ID));
            if ($data) {
              $script="";
              if ($from==0) 
                $script='<script>document.title="谁的东西丢了-%s-%s"</script>';
              else
                $script='<script>document.title="我的东西丢了-%s-%s"</script>';
              
              printf($script,$data["title"],$data["typename"]);
              $isfounded=$data["isfounded"];
              $uploader_UID=$data["uploader_UID"];
               echo ' <div class="form-group details-group">
                    <label>物品名称</label>
                    <p>'.$data["title"].'</p>
                    <label>类型</label>
                    <p>'.$data["typename"].'</p>
                    <label>图片(点击可以放大)</label>
                    <p>';
                    if ($data["imgurl"]=="") {
                      echo "没有图片信息";
                    }else{
                      echo '<a href="'.$data["imgurl"].'">
                       <img width="64px" height="64px" title="点击查看大图" src="'.$data["imgurl"].'">';
                    }
                    echo'</a>
                    </p>
                    <label>详细描述</label>
                    <p>'.($data["description"]==""?"没有详细信息":$data["description"]).'</p>';

                    if ($data["place"]!="") {
                      echo '<label>'.($data["from"]==0?"认领处":"丢失地点").'</label><p>'.$data["place"].'</p>';
                    }
                    if ($data["contact"]!="") {
                      echo '<label>联系方式</label><p>'.$data["contact"].'</p>';
                    }
                    echo '<label>'.($from?"丢失":"拾取").'日期</label>
                    <p>'.$data["lostdate"].'</p>
                    <label>信息发布日期</label>
                    <p>'.$data["uploaddate"].'</p>
                    <label>状态</label>
                    <div class="state-isfounded">
                      <span class="point-state '.($data["isfounded"]?"point-green":"point-yellow").'"></span>
                      <p>'.($data["isfounded"]?($from?"已找到":"已认领"):($from?"未找到":"未认领")).'</p>
                    </div>
                  </div>';
            }else{
                  echo '<div class="form-group details-group">
                  <label>错误</label>
                    <p>未找到此数据，请返回</p></div>';
             
            }
           
          }elseif($table=="cards"){

            $data=$database->get($table,array("[>]types"=>array("type"=>"TID")),array("cards.ID","name","num","place","from","isfounded","type","contact","college","lostdate","uploaddate","types.typename","uploader_UID")
              ,array("cards.ID"=>$ID));
            if ($data) {
              $script="";
              if ($from==0) 
                $script='<script>document.title="谁的卡丢了-%s-%s"</script>';
              else
                $script='<script>document.title="我的卡丢了-%s-%s"</script>';
              
              printf($script,subnum($data["num"]),$data["name"]);
              $isfounded=$data["isfounded"];
              $uploader_UID=$data["uploader_UID"];
               echo ' <div class="form-group details-group">
                    <label>姓名</label>
                    <p>'.$data["name"].'</p>
                    <label>卡号</label>
                    <p>'.subnum($data["num"]).'</p>
                    <label>类型</label>
                    <p>'.$data["typename"].'</p>';

                    if ($data["place"]!="") {
                      echo '<label>'.($data["from"]==0?"认领处":"丢失地点").'</label><p>'.$data["place"].'</p>';
                    }
                    if ($data["contact"]!="") {
                      echo '<label>联系方式</label><p>'.$data["contact"].'</p>';
                    }
                    if ($data["college"]!="") {
                       echo '<label>学院</label><p>'.$data["college"].'</p>';
                    }
                    echo '<label>'.($from?"丢失":"拾取").'日期</label>
                    <p>'.$data["lostdate"].'</p>
                    <label>信息发布日期</label>
                    <p>'.$data["uploaddate"].'</p>
                    <label>状态</label>
                    <div class="state-isfounded">
                      <span class="point-state '.($data["isfounded"]?"point-green":"point-yellow").'"></span>
                      <p>'.($data["isfounded"]?($from?"已找到":"已认领"):($from?"未找到":"未认领")).'</p>
                    </div>
                  </div>';
            }else{
                  echo '<div class="form-group details-group">
                  <label>错误</label>
                    <p>未找到此数据，请返回</p></div>';
             
            }
          }
          if(isset($_SESSION["UID"]) && $_SESSION["UID"]==$uploader_UID)
          {
            if(!$isfounded)
              echo '<button id="btnfound" type="button" class="btn btn-success pull-right">我已找到</button>';

            echo '<button id="btndelete" type="button" class="btn btn-danger pull-right">删除</button>';

          }
        }else{
          echo '<div class="form-group details-group">
                  <label>错误</label>
                    <p>参数错误，请返回</p></div>';
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
  <script type="text/javascript">
     $(document).ready(function() {
        $("#btndelete").click(function(){
            $.post("front_post.php",{
                          ID:"<?php if(isset($_GET["ID"]))echo $_GET["ID"];?>",
                          action:"delete",
                          table:"<?php if(isset($_GET["table"]))echo $_GET["table"];?>"},
                          function(data,status){
                          location.href="user.php";
                        });

        });
        $("#btnfound").click(function(){
              $.post("front_post.php",{
                          ID:"<?php if(isset($_GET["ID"]))echo $_GET["ID"];?>",
                          action:"found",
                          table:"<?php if(isset($_GET["table"]))echo $_GET["table"];?>"
                          },
                          function(data,status){
                          location.href="user.php";
                        });
        });
   });

  </script>
</body>
</html>