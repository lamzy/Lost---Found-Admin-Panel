<?php
	include "functions_front.php";
	
	if (isset($_GET["table"])&&
		isset($_GET["from"])&&
		isset($_GET["page"])&&
		isset($_GET["pagesize"])&&
		isset($_GET["col"])&&
		isset($_GET["key"])) {

		$table=$purifier->purify($_GET["table"]);
		$from=$purifier->purify($_GET["from"]);
		$ipage=$purifier->purify($_GET["page"]);
		$ipagesize=$purifier->purify($_GET["pagesize"]);
		$col=$purifier->purify($_GET["col"]);
		$key=$purifier->purify($_GET["key"]);

		$where=array("AND"=>array("verified"=>1,"from"=>$from),
						"ORDER"=>array("uploaddate DESC","ID DESC"),
						"LIMIT"=>array($ipage*$ipagesize,$ipagesize));
		$selcol="";
		if($table=="items")
			$selcol=array("ID","title","uploaddate","isfounded","description","type","typename");
		elseif ($table=="cards")
			$selcol=array("ID","uploaddate","isfounded","name","num","type","typename");
		if($col!="" && $key!=""){

				// $where=array("AND"=>array("verified"=>1,"from"=>$from,$col."[~]"=>$key),
				// 					          "ORDER"=>array("uploaddate DESC","ID DESC"),
				// 					          "LIMIT"=>array($ipage*$ipagesize,$ipagesize));
				$where["AND"][$col."[~]"]=$key;
				//var_dump($where);
				}


		$database=new medoo();
		$datas=$database->select($table,array("[>]types"=>array("type"=>"TID")),$selcol,$where);
		if ($table=="cards") {
			foreach ($datas as &$row) {
				$row["num"]=subnum($row["num"]);
			}
		}
		echo json_encode($datas);  
		
	}
	if (isset($_GET["table"])&&isset($_GET["user"])){
		if(!isset($_SESSION["UID"]))
			die("无访问权限");
		$table=$purifier->purify($_GET["table"]);
		$selcol="";
		if($table=="items")
			$selcol=array("ID","title","uploaddate","isfounded","description","verified");
		elseif ($table=="cards")
			$selcol=array("ID","uploaddate","isfounded","name","num","verified");

		$database=new medoo();
		$datas=$database->select($table,$selcol,array("uploader_UID"=>$_SESSION["UID"]));
		if ($table=="cards") {
			foreach ($datas as &$row) {
				$row["num"]=subnum($row["num"]);
			}
		}
		echo json_encode($datas);  
	}
?>