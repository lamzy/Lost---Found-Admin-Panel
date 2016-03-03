$(document).ready(function() {
	var bMenuOpen=false;
	$("#col").val($("#dropdownbtn").attr("data"));
	bindtap();
	if ($(".footer").parent("div").height()>$(document).height()) {
		$("#arr").before('<p class="text-white">上拉可以加载更多</p>');

	}


	$("#dropdownmenu li a").click(function(){
					$("#searchmsg").hide();
                    $("#dropdownbtn").html($(this).text()+'<span class="caret"></span>');
                    
                  });
	$("#dropdownbtn").click(function() {
		if (bMenuOpen) {
			bMenuOpen=false;
			$("#searchform").css('margin-bottom', 8);
		}
		else{
			bMenuOpen=true;
			$("#searchform").css('margin-bottom', $("#dropdownmenu").height()+25);
		}
		
	});
	$("#dropdownbtn").blur(function() {
		setTimeout(function(){
		bMenuOpen=false;
		$("#searchform").css('margin-bottom', 8);
	},1);
		
	});
	//$("#nav-head").stickUp();
	$("#searchbtn").click(function() {
		if ($("#col").val()=="")
		{
			$("#labelmsg").text("请选择搜索选项");
			$("#searchmsg").show();
			$("#dropdownbtn").dropdown();
		}
		else if($("#key").val()=="")
		{
			$("#labelmsg").text("请输入搜索关键字");
			$("#searchmsg").show();
		}
		else
			$("#searchform").submit();
	});
	$("a[href='help.html']").on('tap', function() {
           	location.href="help.html";
			
           
        });
	
});

function bindtap(){
	$("aside[data]").on('tap', function() {
			$param=$.param({ID:$(this).attr("data"),table:$("#table").val(),from:$("#from").val()});
           	location.href="details.php?"+$param;
			
           
        });
	
            
        
}
function searchkeyup()
        {
          $("#searchmsg").hide();
        }
function subdescription($str){

    if($str.length>150){
      return $str.substr(0,150)+"......";
    }else if($str=="")
      return "没有详细信息";
    else
      return $str;
  }