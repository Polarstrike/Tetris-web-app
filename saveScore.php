<?php
include('server.php');
	
	$s =  $_GET['s'];
	//$db = mysqli_connect('localhost', 'root', 'suckall', 'tetris');
	
	//Score inserted into DB only if player is logged in.
	//Only for score > 0 avoid filling the DB with AwayFromKeyboard player.	
	if(isset($_SESSION['username']) && $s != 0){
		$username = $_SESSION['username'];
		$query = "INSERT INTO scores (name, score) VALUES ('$username' , '$s')";
		mysqli_query($db, $query);
	}
?>