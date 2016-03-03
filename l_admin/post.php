<!DOCTYPE html>
<html lang="zh-CN">
	<head>
    	<meta charset="utf-8">
	</head>
</html>
<?php 
require_once 'functions.php';
require_once 'loginstate.php';
date_default_timezone_set('PRC');

if($_SERVER['REQUEST_METHOD']!="POST" && isset($_POST))
	die("无效访问");
if(isset($_POST["title"]) && 
	isset($_POST["description"]) &&
	isset($_POST["place"]) &&
	isset($_POST["type"]) &&
	isset($_POST["lostdate"]) &&
	isset($_GET["referer"]) &&
	isset($_GET["action"]))
{
	$title=$description=$place=$imgurl=$uploader=$lostdate="";
	$title=$purifier->purify($_POST["title"]);
	$description=$purifier->purify($_POST["description"]);
	$place=$purifier->purify($_POST["place"]);
	$type=$purifier->purify($_POST["type"]);
	$lostdate=$purifier->purify($_POST["lostdate"]);
	$referer=$purifier->purify($_GET["referer"]);
	$action=$purifier->purify($_GET["action"]);
	
	

	if ($action=="add") {
		if (isset($_FILES["uploadfile"])) {
			$tp = array("image/gif","image/pjpeg","image/jpeg","image/png","image/bmp"); 
			if ($_FILES["uploadfile"]["size"]>1024*1024*5 || 
				$_FILES["uploadfile"]["size"]<=0 ||
				!in_array($_FILES["uploadfile"]["type"],$tp))
			{
				msgJump($referer,"只能上传jpg,png,bmp图片，且小于5mb","danger");
				die("error");
			}
			$suffix=substr($_FILES["uploadfile"]["name"],stripos($_FILES["uploadfile"]["name"],"."));
			$filepath="images/".date('Y-m-d')."_".md5_file($_FILES["uploadfile"]["tmp_name"]).$suffix;
			move_uploaded_file($_FILES["uploadfile"]["tmp_name"],"../".$filepath);

			$database=new medoo();
			$r =$database->insert("items",array(
				"title"=>$title,
				"description"=>$description,
				"place"=>$place,
				"lostdate"=>$lostdate,
				"imgurl"=>$filepath,
				"type"=>$type,
				"#uploaddate"=>"CURDATE()",
				"from"=>"0",
				"isfounded"=>"0",
				"uploader"=>$_SESSION["username"],
				"verified"=>1
				));
			if ($r>0) {
				
				msgJump($referer,"数据添加成功");
			}else{
				//var_dump($database->error());
				msgJump($referer,"数据添加失败","danger");
			}
		}else
			{
				msgJump($referer,"数据不完整，添加失败","danger");
			}

	}elseif ($action=="edit" || $action=="verify" && isset($_POST["ID"]) && isset($_POST["isfounded"])) {
		$ID=$purifier->purify($_POST["ID"]);
		$isfounded=$purifier->purify($_POST["isfounded"]);
		$database=new medoo();

		$uploader=$database->get("items","uploader",array("ID"=>$ID));
		if ($_SESSION["type"]>1 && $uploader!=$_SESSION["username"]) {
			msgJump($referer,"你没有权限修改其他管理员发布的数据","danger");
			die();
		}
		if (isset($_FILES["uploadfile"]) && $_FILES["uploadfile"]["size"]>0) {
			$tp = array("image/gif","image/pjpeg","image/jpeg","image/png","image/bmp"); 
			if ($_FILES["uploadfile"]["size"]>1024*1024*5 || 
				!in_array($_FILES["uploadfile"]["type"],$tp))
			{
				msgJump($referer,"只能上传jpg,png,bmp图片，且小于5mdb","danger");
				die("error");
			}
			$suffix=substr($_FILES["uploadfile"]["name"],stripos($_FILES["uploadfile"]["name"],"."));
			$filepath="images/".date('Y-m-d')."_".md5_file($_FILES["uploadfile"]["tmp_name"]).$suffix;
			move_uploaded_file($_FILES["uploadfile"]["tmp_name"],"../".$filepath);
			
			$row = $database->get("items","imgurl",array("ID"=>$ID));
			
			unlink("../".$row);
			$r=0;
			if ($action=="verify") {
				$r=$database->update("items",array(
					"title"=>$title,
					"description"=>$description,
					"place"=>$place,
					"lostdate"=>$lostdate,
					"imgurl"=>$filepath,
					"type"=>$type,
					"#uploaddate"=>"CURDATE()",
					"isfounded"=>$isfounded,
					"verified"=>1
					//"uploader"=>$_SESSION["username"],
					
					),array("ID"=>$ID));
			}else{
				$r=$database->update("items",array(
					"title"=>$title,
					"description"=>$description,
					"place"=>$place,
					"lostdate"=>$lostdate,
					"imgurl"=>$filepath,
					"type"=>$type,
					//"#uploaddate"=>"CURDATE()",
					//"from"=>"0",
					"isfounded"=>$isfounded,
					//"uploader"=>$_SESSION["username"]
					),array("ID"=>$ID));
			}
			if ($r>0) {
				msgJump($referer,"数据".($action=="verify"?"审核":"修改")."成功,数据ID为".$ID);
			}else{
				msgJump($referer,"数据".($action=="verify"?"审核":"修改")."失败,数据ID为".$ID,"danger");
			}
		}else{
			$r=0;
			if ($action=="verify") {
				$r=$database->update("items",array(
					"title"=>$title,
					"description"=>$description,
					"place"=>$place,
					"lostdate"=>$lostdate,
					"type"=>$type,
					"#uploaddate"=>"CURDATE()",
					//"from"=>"0",
					"isfounded"=>$isfounded,
					"verified"=>1
					//"uploader"=>$_SESSION["username"]
					),array("ID"=>$ID));
			}else
				$r=$database->update("items",array(
					"title"=>$title,
					"description"=>$description,
					"place"=>$place,
					"lostdate"=>$lostdate,
					"type"=>$type,
					//"#uploaddate"=>"CURDATE()",
					//"from"=>"0",
					"isfounded"=>$isfounded,
					//"uploader"=>$_SESSION["username"]
					),array("ID"=>$ID));
			if ($r>0) {
				msgJump($referer,"数据".($action=="verify"?"审核":"修改")."成功,数据ID为".$ID);
			}else{
				msgJump($referer,"数据".($action=="verify"?"审核":"修改")."失败,数据ID为".$ID,"danger");
			}
		}
		
	}else{
			msgJump($referer,"数据不完整，修改失败","danger");
		}
}
if (isset($_POST["delete"])&&isset($_POST["table"])) {
	$ID=$purifier->purify($_POST["delete"]);
	$DID="ID";
	if($_POST["table"]=="types")$DID="TID";
	$database=new medoo();
	$filepath=$database->get("items","imgurl",array($DID=>$ID));

	$uploader=$database->get("items","uploader",array($DID=>$ID));
		if ($_SESSION["type"]>1 && $uploader!=$_SESSION["username"]) {
			msgJump($referer,"你没有权限删除其管理员发布的数据","danger");
			die();
		}
	if($database->delete($_POST["table"],array($DID=>$ID))>0)
	{
		unlink("../".$filepath);
		setmsg("删除成功,数据ID为".$ID);
	}
	else
		setmsg("删除失败,数据ID为".$ID,"danger");
}
if (isset($_GET["action"]) && $_GET["action"]=="changepwd" &&
	isset($_POST["prepwd"])&&
	isset($_POST["newpwd"])&&
	isset($_POST["newpwdagain"])&&
	isset($_POST["username"])&&
	isset($_GET["referer"])) {

	$prepwd=$purifier->purify($_POST["prepwd"]);
	$newpwd=$purifier->purify($_POST["newpwd"]);
	$newpwdagain=$purifier->purify($_POST["newpwdagain"]);
	$username=$purifier->purify($_POST["username"]);
	$referer=$purifier->purify($_GET["referer"]);

	$database=new medoo();
	$pwd=$database->get("admins","userpwd",array("username"=>$username));

	if(md5("lam".$prepwd)!=$pwd)
	{
		
		msgJump($referer,"原密码错误，密码修改失败！","danger");
	}
	else if(strlen($newpwd)<5)
	{
		msgJump($referer,"密码必须大于5位","danger");
	}else if($newpwd!=$newpwdagain)
	{
		msgJump($referer,"两次输入的密码不同","danger");
	}else if ($database->update("admins",array("userpwd"=>md5("lam".$newpwd)),
		array("username"=>$username))>0) {
		msgJump($referer,"密码修改成功","success");
	}else
		msgJump($referer,"密码修改失败","danger");
		
}
if (isset($_GET["action"])&&
	isset($_POST["name"])&&
	isset($_POST["num"])&&
	isset($_POST["place"])&&
	isset($_POST["lostdate"])&&
	isset($_POST["type"])&&
	isset($_GET["referer"]))
{
	$action=$purifier->purify($_GET["action"]);
	$name=$purifier->purify($_POST["name"]);
	$num=$purifier->purify($_POST["num"]);
	$place=$purifier->purify($_POST["place"]);
	$lostdate=$purifier->purify($_POST["lostdate"]);
	$contact="";
	$college="";
	$type=$purifier->purify($_POST["type"]);
	$referer=$purifier->purify($_GET["referer"]);

	if(isset($_POST["contact"]))
		$contact=$purifier->purify($_POST["contact"]);
	if(isset($_POST["college"]))
		$college=$purifier->purify($_POST["college"]);
	$database=new medoo();
	if ($action=="addcard") {
		if($database->insert("cards",array(
			"name"=>$name,
			"num"=>$num,
			"place"=>$place,
			"lostdate"=>$lostdate,
			"contact"=>$contact,
			"college"=>$college,
			"type"=>$type,
			"uploader"=>$_SESSION["username"],
			"#uploaddate"=>"CURDATE()",
			"verified"=>1
		))>0){
			msgJump($referer,"数据添加成功");
		}else
			msgJump($referer,"数据添加失败","danger");
		
	}elseif (($action="editcard" || $action="verifycard") &&isset($_POST["ID"])&&isset($_POST["isfounded"])) {
		$ID=$purifier->purify($_POST["ID"]);
		$isfounded=$purifier->purify($_POST["isfounded"]);
		$uploader=$database->get("items","uploader",array("ID"=>$ID));
		if ($_SESSION["type"]>1 && $uploader!=$_SESSION["username"]) {
			msgJump($referer,"你没有权限删除其管理员发布的数据","danger");
			die();
		}
		$r=0;
		if ($action="verifycard") {
			$r=$database->update("cards",array(
			"name"=>$name,
			"num"=>$num,
			"place"=>$place,
			"lostdate"=>$lostdate,
			"contact"=>$contact,
			"college"=>$college,
			"type"=>$type,
			//"uploader"=>$_SESSION["username"],
			"#uploaddate"=>"CURDATE()",
			"isfounded"=>$isfounded,
			"verified"=>1
		),array("ID"=>$ID));
		}else
			$r=$database->update("cards",array(
			"name"=>$name,
			"num"=>$num,
			"place"=>$place,
			"lostdate"=>$lostdate,
			"contact"=>$contact,
			"college"=>$college,
			"type"=>$type,
			//"uploader"=>$_SESSION["username"],
			//"#uploaddate"=>"CURDATE()",
			"isfounded"=>$isfounded
		),array("ID"=>$ID));
		if ($r>0) {
				msgJump($referer,"数据".($action=="verifycard"?"审核":"修改")."成功,数据ID为".$ID);
			}else{
				msgJump($referer,"数据".($action=="verifycard"?"审核":"修改")."失败,数据ID为".$ID,"danger");
			}
	}
		
}	
if (isset($_GET["action"])&&
	isset($_POST["typename"])&&
	isset($_POST["table"])&&
	isset($_GET["referer"]))
{
	$action=$purifier->purify($_GET["action"]);
	$typename=$purifier->purify($_POST["typename"]);
	$table=$purifier->purify($_POST["table"]);
	$referer=$purifier->purify($_GET["referer"]);
	$database=new medoo();
	if ($action=="addtype") {
		$r=$database->insert("types",array(
				"typename"=>$typename,
				"table"=>$table
			));

		if ($r>0) {
				msgJump($referer,"数据添加成功");
			}else{
				//var_dump($database->error());
				msgJump($referer,"数据添加失败","danger");
			}
	}elseif($action=="edittype" && isset($_POST["ID"])){
		$ID=$purifier->purify($_POST["ID"]);
		$r=$database->update("types",array(
				"typename"=>$typename,
				"table"=>$table
			),array("ID"=>$ID));

		if ($r>0) {
				msgJump($referer,"数据修改成功,数据ID为".$ID);
			}else{
				msgJump($referer,"数据修改失败,数据ID为".$ID,"danger");
			}
	
	}
}



?>