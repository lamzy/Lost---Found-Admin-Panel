<?php require_once "Mobile_Detect.php";
	require_once "functions_front.php";

?>



 <?php 

 $detect=new Mobile_Detect();
 if ($detect->isMobile()) {
 	require "front_mobile.php";
 }else
 	require "front_computer.php"
 ?>




 



