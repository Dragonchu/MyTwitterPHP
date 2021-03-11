<?php

require_once '../includes/DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new Dboperations();
	if($db->insertComment($_POST['commenter'],$_POST['tweetmId'],$_POST['tweetComment'])){
		$db->updateComment($_POST['tweetmId']);
		$response['error'] = false;
		$response['message'] = "success";
		}else{
			$response['error'] = true;
			$response['message'] = "Some error occured please try again";
		}
}else{
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

echo json_encode($response);