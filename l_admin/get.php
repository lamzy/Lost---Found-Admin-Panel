<?php
	require_once 'functions.php';
 	require_once 'loginstate.php';

	if ((isset($_GET["ID"])||isset($_GET["TID"]))&&isset($_GET["table"])) {
		$ID;
		$DID;
		if (isset($_GET["ID"])) {
			$ID=$purifier->purify($_GET["ID"]);
			$DID="ID";
		}
		else {
			$ID=$purifier->purify($_GET["TID"]);
			$DID="TID";
		}
		$table=$purifier->purify($_GET["table"]);
		$database=new medoo();
		$data=$database->get($table,"*",array($DID=>$ID));
		echo json_encode($data);  
		
	}
?>