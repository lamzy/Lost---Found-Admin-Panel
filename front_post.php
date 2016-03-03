<?php
	include "functions_front.php";
	header("Content-Type: text/html;charset=UTF-8");
	if(!isset($_SESSION["UID"]))
		die("无访问权限");

	if(isset($_POST["ID"]) && isset($_POST["action"]) && isset($_POST["table"]))
	{
		$ID=$purifier->purify($_POST["ID"]);
		$action=$purifier->purify($_POST["action"]);
		$table=$purifier->purify($_POST["table"]);
		$database=new medoo();
		$data=$database->get($table,array("uploader_UID","verified"),array("ID"=>$ID));
		if ($data["uploader_UID"]!=$_SESSION["UID"]) {
			die("无操作权限");
		}
		$r=0;
		if ($action=="delete") {
			$r=$database->delete($table,array("ID"=>$ID));
		}elseif ($action=="found" && $data["verified"]) {
			$r=$database->update($table,array("isfounded"=>1));
		}
		if($r)
			setmsg("操作成功");
		else
			setmsg("操作失败","danger");
		jumpUrl("user.php");
	}



?>