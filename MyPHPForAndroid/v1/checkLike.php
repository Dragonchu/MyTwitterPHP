<?php

require_once '../includes/DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new Dboperations();
	if($db->checkLike($_POST['commenter'],$_POST['tweetmId'])){
		$response['error'] = false;
		$response['message'] = "like";
		}else{
			$response['error'] = false;
			$response['message'] = "unlike";
		}
}else{
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

echo json_encode($response);