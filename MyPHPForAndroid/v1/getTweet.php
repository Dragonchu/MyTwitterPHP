<?php

require_once '../includes/DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['page_count']) and isset($_POST['page_size'])){
		$db = new Dboperations();
		$response = $db->getTweet($_POST['page_count'],$_POST['page_size']);
	}else{
		$response['error'] = true;
		$response['message'] = "Required fields are missing";
	}
}else{
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

echo json_encode($response);