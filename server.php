<?php 
	session_start();
	// connect to database
	$db = mysqli_connect('localhost', 'root', 'suckall', 'tetris');

	
	// variable declaration
	$err = 1;
	$search = 0;
	$username = "";
	$email    = "";
	$errors = array(); 
	$_SESSION['success'] = "";

	

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO users (username, email, password, Banned) 
					  VALUES('$username', '$email', '$password', 0)";
			mysqli_query($db, $query);

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		}

	}
 

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}
		$query = "SELECT Banned FROM users WHERE username = '$username';";		// recupero ban/no ban
		$results = mysqli_query($db, $query);
		$results = mysqli_fetch_array($results);
		if ($results['Banned'] == 1){ // se l'utente è bannato, lo segnalo negli errori;		0 ACTIVE; 1 BANNED;
			array_push($errors, "Your account is banned.");
		}

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "Logged in";
				if ($username == "admin")
					header('location: amministratore.php');
				else
					header('location: index.php');
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

		//ADMIN CHECK
			if (isset($_POST['finduser_btn'])) {
				$search = 1;
	            $username = mysqli_real_escape_string($db, $_POST['finduser']);

	            if (empty($username)) {
	                array_push($errors, "Username is required");
	            }
	            if ($username == "admin"){
	            	array_push($errors, "Admin account cannot be managed");
	            }
	            $query = "SELECT Username FROM users WHERE username = '$username';";      // recupero ban/no ban
	            $results = mysqli_query($db, $query);
	            if (mysqli_num_rows($results) == 0) { // non ci sono record, AKA non esiste questo user
	                array_push($errors, "Username does not exists");
	            } 
	            
        	}


        	//ADMIN SCORE DELETE
        	if (isset($_POST['scoreDel'])) {
        		$username = mysqli_real_escape_string($db, $_POST['scoreD']);
        		$query = "DELETE FROM scores WHERE name = '$username';";
	            $results = mysqli_query($db, $query);
	            unset($noerr);
        	}

        	//ADMIN USER BAN -> which is not deleting the account
        	if (isset($_POST['userDel'])) {
        		$username = mysqli_real_escape_string($db, $_POST['userD']);
        		$query = "UPDATE users SET Banned = 1 WHERE username = '$username';";
	            $results = mysqli_query($db, $query);
	            unset($noerr);

        	}

        	//USER UNBAN -> account activation
        	if (isset($_POST['userBack'])) {
        		$username = mysqli_real_escape_string($db, $_POST['userB']);
        		$query = "UPDATE users SET Banned = 0 WHERE username = '$username';";
	            $results = mysqli_query($db, $query);
	            unset($noerr);
        	}


?>