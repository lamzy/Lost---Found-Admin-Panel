 $(document).ready(function() {
   // $("#hold").css("min-height",$(document).height());
      function subdescription($str){

    if($str.length>150){
      return $str.substr(0,150)+"......";
    }else
      return $str;
   }

   if($("#usermsg").length>0){
    $("#btncheckin").hide();
    setTimeout(function(){
      $("#usermsg").alert('close');
      $("#btncheckin").show();
    },3000);
   }


   
      $.getJSON('front_get.php', {table:"items",user:0}, function(json) {
              if (json.length>0) {
                $("#no").remove();
                 $.each(json, function(index, val) {
                    $tmp='<section><span class="point-time '+(val.isfounded>0?"point-green":"point-yellow")+'"></span><aside data="'+val.ID+'" table="items"><p class="title">'+val.title+'</p><p class="brief"><span class="text-white"><b>描述:</b>'+subdescription(val.description)+'</span></p></aside></section>';
                    if(val.verified>0)
                    {
                      if($("#userarticle_v").length<=0)
                          $("#content").append('<article id="userarticle_v"><h3>已审核</h3></article>');
                      $("#userarticle_v").append($tmp);
                      
                    }else{
                      if($("#userarticle_nv").length<=0)
                        $("#content").append('<article id="userarticle_nv"><h3>未审核</h3></article>');
                      $("#userarticle_nv").append($tmp);

                    }     
                });
              }else{
                $("#ptitle").text('没有数据');
                $("#pbrief").text('你没有登记任何失物');
              }
              bindtap();
          });


         $.getJSON('front_get.php', {table:"cards",user:0}, function(json) {
              if (json.length>0) {
                $("#no").remove();
                 $.each(json, function(index, val) {
                    $tmp='<section><span class="point-time '+(val.isfounded>0?"point-green":"point-yellow")+'"></span><aside data="'+val.ID+'" table="cards"><p class="title">卡号: '+val.num+'</p><p class="brief"><span class="text-white"><b>姓名:</b>'+subdescription(val.name)+'</span></p></aside></section>';
                    if(val.verified>0)
                    {
                      if($("#userarticle_v").length<=0)
                          $("#content").append('<article id="userarticle_v"><h3>已审核</h3></article>');
                      $("#userarticle_v").append($tmp);
                      
                    }else{
                      if($("#userarticle_nv").length<=0)
                        $("#content").append('<article id="userarticle_nv"><h3>未审核</h3></article>');
                      $("#userarticle_nv").append($tmp);

                    }
                  
                  
                });
              }else{
                $("#ptitle").text('没有数据');
                $("#pbrief").text('你没有登记任何失物');
              }
              bindtap();
          });

    bindtap();
  });
  function bindtap(){
  $("aside[data]").on('tap', function() {
      
        $param=$.param({ID:$(this).attr("data"),table:$(this).attr("table"),from:1});
           location.href="details.php?"+$param;
     
           
        });
}