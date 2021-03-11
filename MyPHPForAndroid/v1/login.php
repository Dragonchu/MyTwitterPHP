<?php

require_once '../includes/DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new Dboperations();
	if (isset($_POST['username']) and isset($_POST['password'])) {
		if($db->login($_POST['username'],$_POST['password'])){
			$user = $db->getUserInfo($_POST['username']);
			$response['error'] = false;
			$response['username'] = $user['username'];
			$response['email'] = $user['email'];
		}else{
			$response['error'] = true;
			$response['message'] = "The username or password is wrong";
		}		
	}else{
		$response['error'] = true;
		$response['message'] = "illegal input";
	}	
}else{
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

echo json_encode($response);