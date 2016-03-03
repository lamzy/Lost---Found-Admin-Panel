<?php
	header("Content-Type: text/html;charset=UTF-8");
  	require_once "v.php";
	require "medoo.php";
	require_once 'library/HTMLPurifier.auto.php';
	if(!defined("l_v") || constant("l_v")!="lam's masterpiece" || !isset($l_v_masterpiece)){echo "未授权!";die();}
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);
	session_start();
	function createTable($table,$where){
		$database=new medoo();
		$datas=$database->select($table,array("[>]types"=>array("type"=>"TID")),"*",$where);
		$date="";
		if ($datas) {
			if($table=="items"){
				foreach ($datas as $row) {
			
					if ($date!=$row["uploaddate"]) {
						if($date!="")
							echo '</article>';
						$date=$row["uploaddate"];
						echo ' <article id="'.$date.'">
		    				<h3>'.GetMD($date).'</h3>';
		    			
					}
					
					echo '<section>
						      <span class="point-time '.($row["isfounded"]?"point-green":"point-yellow").'"></span>
						      <aside data="'.$row["ID"].'">
						      	<p class="title">'.$row["title"].'</p>
						      	<p class="brief"><b>描述:</b>
						        '.subdescription($row["description"]).'</p>
						      </aside>
						   </section>';
					
					}
					echo '</article>';
				}else{
					foreach ($datas as $row) {
					
					if ($date!=$row["uploaddate"]) {
						if($date!="")
							echo '</article>';
						$date=$row["uploaddate"];
						echo ' <article id="'.$date.'">
		    				<h3>'.GetMD($date).'</h3>';
		    			
					}
					
					echo '<section>
						      <span class="point-time '.($row["isfounded"]?"point-green":"point-yellow").'"></span>
						      <aside data="'.$row["ID"].'">
						      	<p class="title">卡号: '.subnum($row["num"]).'</p>
						      	<p class="brief"><b>姓名:</b>
						      	'.subdescription($row["name"]).'<br><b>类型: </b>'.$row["typename"].'</p>
						      </aside>
						   </section>';
					
					}
					echo '</article>';


				}
		}else{
			echo '<article><section>
			<span class="point-time point-red"></span>
			<aside><p class="title">没有任何数据</p><p class="brief">请重试</aside>
			</section></article>';

		}
	}
	function subdescription($str){
		if(strlen($str)>150){
			return mb_substr($str,0,150,"utf8")."......";
		}else if($str=="")
			return "没有详细信息";
		else
			return $str;
	}
	function subnum($num){
		$len=strlen($num);
		if($len>10){

			return substr($num,0,5).str_repeat("*",$len-8).substr($num,-3);
		}else
			return $num;
	}
	function GetMD($date){
		return substr($date,strpos($date,"-")+1);
	}

	function jumpUrl($url)
	{

		echo '<script>window.location.href="'.$url.'";</script> ';
	}
	function setmsg($msg,$type="success")
  	{
	    $_SESSION["front_msg"]=$msg;
	    $_SESSION["front_msgtype"]=$type;
  	}
  	function msgJump($url,$msg,$type="success")
	  {
	    setmsg($msg,$type);
	    jumpUrl($url);
	  }
  	function createTypeSelect($table){
      $database=new medoo();
      $datas=$database->select("types","*",array("table"=>$table));
      
      if ($datas) {
         foreach($datas as $row)
        {
          echo '<option value="'.$row["TID"].'">'.$row["typename"].'</option>';
        }
      }

  }
?>