<?php

require_once '../includes/DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new Dboperations();
	if($db->checkMentions($_POST['follower'],$_POST['following'])){
		$response['error'] = false;
		$response['message'] = "following";
		}else{
			$response['error'] = false;
			$response['message'] = "unfollowing";
		}
}else{
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

echo json_encode($response);