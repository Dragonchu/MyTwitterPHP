<?php

require_once '../includes/DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new Dboperations();
	if($db->like($_POST['commenter'],$_POST['tweetmId'])){
		$db->updateLike(1,$_POST['tweetmId']);
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