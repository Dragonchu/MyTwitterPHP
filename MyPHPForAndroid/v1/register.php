<?php

require_once '../includes/DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db = new Dboperations();
	if (isset($_POST['username']) and isset($_POST['email']) and isset($_POST['password'])) {
		if($db->checkUsername($_POST['username'])){
			$response['error'] = true;
			$response['message'] = "The username or email already exists";
		}else{
			if($db->register($_POST['username'],$_POST['email'],$_POST['password'])){
			$response['error'] = false;
			$response['message'] = "success";
			}else{
			$response['error'] = true;
			$response['message'] = "Some error occured please try again";
			}
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