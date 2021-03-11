<?php

require_once '../includes/DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new Dboperations();
	if($db->insertTweet($_POST['content'],$_POST['mId'],$_POST['name'],$_POST['handle'],$_POST['minutes'],$_POST['conImg'],$_POST['prof'],$_POST['comment'],$_POST['rt'],$_POST['like'])){
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