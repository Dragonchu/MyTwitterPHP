<?php
	
	class Dboperations{

		private $con;

		function __construct(){
			require_once dirname(__FILE__).'/DbConnect.php';

			$db = new DbConnect();

			$this->con = $db->connect();
		}

		function insertTweet($content,$mId,$name,$handle,$minutes,$conImg,$prof,$comment,$rt,$like){
			$stmt = $this->con->prepare("INSERT INTO `Tweet` (`content`,`mId`,`name`,`handle`,`minutes`,`conImg`,`prof`,`comment`,`rt`,`like`) values (?,?,?,?,?,?,?,?,?,?);");
			$stmt->bind_param("ssssssssss",$content,$mId,$name,$handle,$minutes,$conImg,$prof,$comment,$rt,$like);
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		function getTweet($page_count,$page_size){
			$stmt = $this->con->prepare("SELECT * FROM Tweet LIMIT ?,?");
			$stmt->bind_param("ii",$page_count,$page_size);
			$stmt->execute();
			$result = $stmt->get_result();
			$tweets = $result->fetch_all(MYSQLI_ASSOC);
			return $tweets;
		}

		function getComment($page_count,$page_size,$tweetmId){
			$stmt = $this->con->prepare("SELECT * FROM comments WHERE tweetmId = ? LIMIT ?,?");
			$stmt->bind_param("sii",$tweetmId,$page_count,$page_size);
			$stmt->execute();
			$result = $stmt->get_result();
			$tweets = $result->fetch_all(MYSQLI_ASSOC);
			return $tweets;
		}

		function insertComment($commenter,$tweetmId,$tweetComment){
			$stmt = $this->con->prepare("INSERT INTO `comments` (`commenter`,`tweetmId`,`tweetComment`) VALUES (?,?,?);");
			$stmt->bind_param("sss",$commenter,$tweetmId,$tweetComment);
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		function updateComment($tweetmId){
			$stmt = $this->con->prepare("UPDATE Tweet SET comment = comment +1 WHERE mId = ?;");
			$stmt->bind_param("s",$tweetmId);
			$stmt->execute();
		}

		function getTweetById($tweetmId){
			$stmt = $this->con->prepare("SELECT * FROM Tweet WHERE mId = ?");
			$stmt->bind_param("s",$tweetmId);
			$stmt->execute();
			$result = $stmt->get_result();
			$tweets = $result->fetch_all(MYSQLI_ASSOC);
			return $tweets;
		}

		function register($username,$email,$pass){
			$password = md5($pass);
			$stmt = $this->con->prepare("INSERT INTO `users` (`username`,`password`,`email`) VALUES (?,?,?)");
			$stmt->bind_param("sss",$username,$password,$email);
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		function checkUsername($username){
			$stmt = $this->con->prepare("SELECT * FROM `users` WHERE `username` = ?");
			$stmt->bind_param("s",$username);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}

		function login($username,$pass){
			$password = md5($pass);
			$stmt = $this->con->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");
			$stmt->bind_param("ss",$username,$password);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}

		function getUserInfo($username){
			$stmt = $this->con->prepare("SELECT * FROM `users` WHERE `username` = ?");
			$stmt->bind_param("s",$username);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}

		function like($commenter,$tweetmId){
			$stmt = $this->con->prepare("INSERT INTO love (mId,commenter) VALUES (?,?)");
			$stmt->bind_param("ss",$tweetmId,$commenter);
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		function unlike($commenter,$tweetmId){
			$stmt = $this->con->prepare("DELETE FROM love WHERE mId = ? AND commenter = ?");
			$stmt->bind_param("ss",$tweetmId,$commenter);
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		function updateLike($number,$mId){
			$stmt = $this->con->prepare("UPDATE `Tweet` SET `like` = `like`+? WHERE `mId`=?");
			$stmt->bind_param("is",$number,$mId);
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		function checkLike($commenter,$tweetmId){
			$stmt = $this->con->prepare("SELECT * FROM love WHERE mId = ? AND commenter = ?");
			$stmt->bind_param("ss",$tweetmId,$commenter);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}

		function insertMentions($follower,$following){
			$stmt = $this->con->prepare("INSERT INTO Mentions (follower,following) VALUES (?,?)");
			$stmt->bind_param("ss",$follower,$following);
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		function deleteMentions($follower,$following){
			$stmt = $this->con->prepare("DELETE FROM Mentions WHERE follower = ? AND following = ?");
			$stmt->bind_param("ss",$follower,$following);
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		function checkMentions($follower,$following){
			$stmt = $this->con->prepare("SELECT * FROM Mentions WHERE follower = ? AND following = ?");
			$stmt->bind_param("ss",$follower,$following);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}
	}