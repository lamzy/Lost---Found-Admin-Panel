<?php 
require_once "Mobile_Detect.php";
require_once "functions_front.php";
 $table="cards";
 $from="0";
 $searchoption='<button id="dropdownbtn" data="num" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                卡号
                <span class="caret"></span>
              </button>
 <ul class="dropdown-menu" id="dropdownmenu" role="menu">
 <li>
                  <a data="num">卡号</a>
                </li>
                <li>
                  <a data="name">姓名</a>
                </li>
                <li>
                  <a data="contact">联系方式</a>
                </li>
                <li>
                  <a data="college">学院</a>
                </li>
              </ul>';
 $detect=new Mobile_Detect();
if (!$detect->
isMobile()) {
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
  <title>Lost & Found</title>
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

  <?php require "nav.php"?>
  <div id="hold">
    <div class="hold"></div>
    <div id="wrapper" style="position:absolute;width:100%;height:100%;overflow:hidden;margin:0;">
      <div class="timelincontainer">
        <h2 class="text-white"> <b>招领（卡类）</b>
        </h2>

        <div class="content">
          <div id="content">
            <?php 
            $where="";
        if (isset($_GET["col"]) && isset($_GET["key"])) {
          $where=array(
          "AND"=>array("verified"=>1,"from"=>$from,$_GET["col"]."[~]"=>$_GET["key"]),
          "ORDER"=>array("uploaddate DESC","ID DESC"),
          "LIMIT"=>10,
          );
        }else{
           $where=array("AND"=>array("verified"=>1,"from"=>$from),
          "ORDER"=>array("uploaddate DESC","ID DESC"),
          "LIMIT"=>10
        );
         }
      createTable($table,$where);

    ?>
          </div>
        </div>
        <div class="alert alert-info fade-in" id="loadmsg" style="display:none;" role="alert">
          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
          <label id="labelmsg">没有更多数据</label>
        </div>
        <div class="hold"></div>
       <?php require "footer.php"?>

      </div>

    </div>
  </div>
  <div id="backtotop" class="navbar-fixed-bottom"></div>
  <input type="text" id="table" value="cards" class="hidden">
  <input type="text" id="from" value="0" class="hidden">
  <script src="js/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <script src="js/iscroll.js"></script>
  <script src="js/iscrollAssist.js"></script>
  <script src="js/front.js"></script>
  <script src="js/purl.js"></script>
  <script src="js/jquery.finger.min.js"></script>
  <script type="text/javascript">
  jQuery(document).ready(function($) {
    $("#hold").css("height",$(document).height());
   
     (function($){
    $(function(){
     
      var pullupAction = function(){
        page++;
        $col=$.url().param('col');
        $key=$.url().param('key');
        if(typeof($col)=="undefined" || typeof($key)=="undefined")
          $col=$key="";
        $.getJSON('front_get.php', {table:"cards",from:0,page:page,pagesize:10,col:$col,key:$key}, function(json) {
              if (json.length>0) {
                $new=false;
                 $.each(json, function(index, val) {
                 // console.log(val.uploaddate);
                  $content=$("#"+val.uploaddate);
                  if ($content.length>0) {
                    //console.log(val.title);
                    $tmp='<section><span class="point-time '+(val.isfounded>0?"point-green":"point-yellow")+'"></span><aside data="'+val.ID+'"><p class="title">卡号: '+val.num+'</p><p class="brief"><b>姓名: </b>'+subdescription(val.name)+'<br><b>类型: </b>'+val.typename+'</p></aside></section>';
                    $content.append($tmp);
                  }else{
                    $new=true;
                    $uploaddate=val.uploaddate;
                    $tmp='<article id="'+$uploaddate+'"><h3>'+$uploaddate.substr($uploaddate.indexOf("-")+1)+'</h3>';
                    $("#content").append($tmp);
                    $tmp='<section><span class="point-time '+(val.isfounded>0?"point-green":"point-yellow")+'"></span><aside data="'+val.ID+'"><p class="title">卡号: '+val.num+'</p><p class="brief"><b>姓名: </b>'+subdescription(val.name)+'<br><b>类型: </b>'+val.typename+'</p></aside></section>';
                    $("#"+val.uploaddate).append($tmp);
                    //console.log(json.length,index+1);
                    //console.log($uploaddate.substr($uploaddate.indexOf("-")+1));
                  }
                  if ($new) {
                    $("#content").append('</article>');
                    $new=false;
                  }
                });
              }else
              {
                
                $("#loadmsg").show();
                setTimeout(function(){
                  $("#loadmsg").hide();
                  iscrollObj.refresh();
                },2000);
                
              }
              bindtap();
              iscrollObj.refresh();
          });
        
        
        
      };
      var iscrollObj = iscrollAssist.newVerScrollForPull($('#wrapper'),null,pullupAction);
      var page=0;
      iscrollObj.refresh();
      $("#backtotop").on('tap', function() {
           iscrollObj.scrollTo(0,0);
        });
    });
  })(jQuery);



  });

  </script>
</body>
</html>