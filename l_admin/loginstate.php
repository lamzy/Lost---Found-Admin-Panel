<?php 
	session_start();
	header("Content-Type: text/html;charset=UTF-8");
	if (isset($_SESSION["username"]) && isset($_SESSION["pwd"])) {
		if (!signin($_SESSION["username"],$_SESSION["pwd"])) {
			jumpUrl("signin.php");
			die("未登录");
		}
	}else{
			jumpUrl("signin.php");
			die("未登录");
	}

?>