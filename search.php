<?php require_once "Mobile_Detect.php";
require_once "functions_front.php";
$detect=new Mobile_Detect();
if (!$detect->isMobile()) {
  jumpUrl("index.php");
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
  <title>Lost & Found 详情页</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/timeline_mobile.css">
  <link rel="stylesheet" type="text/css" href="css/search_mobile.css">
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
  <div class="hold"></div>
  <h3 class="toptitle">高级搜索</h3>
  <div class="container search">

    <form method="GET" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="text" id="ID" name="ID" class="hidden">
                  <label>标题</label>
                  <input type="text" class="form-control" id="title" name="title" placeholder="标题">

                  <label>详细描述</label>
                  <input class="form-control" id="description" name="description" placeholder="详细描述">
                  <label>认领处</label>
                  <input type="text" class="form-control" id="place" name="place" placeholder="认领处">

                <label>丢失日期</label>
                <div>
                <input type="text" class="form-control" readonly id="lostdate2" name="lostdate" placeholder="丢失日期">
                  <input type="text" class="form-control" readonly id="lostdate2" name="lostdate" placeholder="丢失日期">

                </div>
                

              <label>图片(如不更改，无需选择文件)</label>

              <input type="file" class="form-control" accept="image/*" id="imgurl" name="uploadfile">

              <label>类型</label>
              <select class="form-control" id="type" name="type">
                <option value="0">所有</option>
                <option value="1">U盘</option>
              </select>
              <label>状态</label>
              <select class="form-control" id="isfounded" name="isfounded">
                <option value="0">未认领</option>
                <option value="1">已认领</option>
              </select>
              <button type="submit">submit</button>
            </div>
            <?php 
              $dd=array("ID"=>1,"bb"=>3);
              $dd["QQ"]=2;
              var_dump($dd);
            ?>

          </form>
  </div>

  </div>




<script src="js/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <script src="js/iscroll.js"></script>
  <script src="js/iscrollAssist.js"></script>
  <script src="js/front.js"></script>
  <script src="js/purl.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
    $("#hold").css("height",$(document).height());
  });


  </script>
</body>
</html>