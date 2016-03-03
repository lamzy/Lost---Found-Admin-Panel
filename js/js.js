$(document).ready(function(){
        	$text={
            closeText: '确认',  
          prevText: '<上月',  
          nextText: '下月>',  
          currentText: '现在',  
          monthNames: ['一月','二月','三月','四月','五月','六月',  
          '七月','八月','九月','十月','十一月','十二月'],  
          monthNamesShort: ['一','二','三','四','五','六',  
          '七','八','九','十','十一','十二'],  
          dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],  
          dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],  
          dayNamesMin: ['日','一','二','三','四','五','六'],  
          weekHeader: '周',  
          dateFormat: 'yy-mm-dd',  
          firstDay: 1,  
          isRTL: false,  
          showMonthAfterYear: true,  
          yearSuffix: '年'
            
          };
        	$("#lostdate").datepicker($text);
          $("#lostdate2").datepicker($text);
          $("#lostdate").keydown(function(e){
            e.preventDefault();
                        });
          $("#lostdate2").keydown(function(e){
            e.preventDefault();
                        });
          $("ul#dropdownmenu li a").click(function(){
                    $("#dropdownbtn").html($(this).text()+'<span class="caret"></span>');
                    $("#dropdownbtn").attr("data",$(this).attr("data"));
                  });
          $("#delete").click(function(){
            $.post('post.php', {delete: $("#ID").val(),table:$(this).attr("table")}, function(data, textStatus, xhr) {
              location.reload(true);
            });
            
          });
        });
		function onSearchClick($referer)
		{
			if (!$("#dropdownbtn").attr("data")) {
				alert("请选择搜索类型");
			}else{
				if ($("#searchinput").val()=="") {
				alert("请输入搜索内容");
				}else{

					location.href=$referer+"?col="+$("#dropdownbtn").attr("data")+"&key="+$("#searchinput").val();
				}
			}
			
		}
       function fun($element)
        {
          
          $.getJSON('get.php', {ID: $element.attr('data-id'),table:"items"}, function(json) {
              $("#ID").val(json.ID);
              $("#title").val(json.title);
              $("#description").val(json.description);
              $("#place").val(json.place);
              $("#lostdate2").val(json.lostdate);
              //$("#uploader").val(json.uploader);
             // $("#imgUrl").val(json.imgUrl);
              $("#type option[value='"+json.type+"']").attr('selected', 'selected');
              $("#isfounded").get(0).selectedIndex=json.isfounded;
          });
        }
        function fun2($element)
        {
          
          $.getJSON('get.php', {ID: $element.attr('data-id'),table:"cards"}, function(json) {
              $("#ID").val(json.ID);
              $("#name").val(json.name);
              $("#num").val(json.num);
              $("#place").val(json.place);
              $("#lostdate2").val(json.lostdate);

              $("#contact").val(json.contact);
              $("#college").val(json.college);
              $("#type option[value='"+json.type+"']").attr('selected', 'selected');
              $("#isfounded").get(0).selectedIndex=json.isfounded;
          });
        }
        function fun3($element)
        {
          
          $.getJSON('get.php', {TID: $element.attr('data-id'),table:"types"}, function(json) {
              $("#ID").val(json.TID);
              $("#typename").val(json.typename);
              $("#type option[value='"+json.table+"']").attr('selected', 'selected');
              //$("#type").get(0).selectedIndex=json.type;
              //$("#isfounded").get(0).selectedIndex=json.isfounded;
          });
        }
        function pwd()
        {
          $prepwd=$("#prepwd").val();
          $pwd=$("#newpwd").val();
          $pwdagain=$("#newpwdagain").val();
          if ($prepwd==""||$pwd==""||$pwdagain=="") {
            $("#labelpwdmsg").text('未填完整');
            $("#pwdmsg").show();
            

          }else
          {
            if ($pwd.length>=5) 
            {
              if ($pwd==$pwdagain)
                $("#formpwd").submit();
              else
              {
                $("#labelpwdmsg").text('两次输入的密码不一样');
                $("#pwdmsg").show();
              }
            }else{
                $("#labelpwdmsg").text('密码长度必须大于5位');
                $("#pwdmsg").show();
              
              }
          }
          
        }
         function pwdkeyup()
        {
          $("#pwdmsg").hide();
        }