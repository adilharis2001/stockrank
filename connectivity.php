<?php 
	define('DB_HOST', 'localhost'); 
	define('DB_NAME', 'buckyboard'); 
	define('DB_USER','buckyboard'); 
	define('DB_PASSWORD','buckyboard'); 
	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
	$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());
	/* $ID = $_POST['user']; $Password = $_POST['pass']; */
	function SignIn() { 
		session_start();
		//starting the session for user profile page
		if(!empty($_POST['user'])) 
		//checking the 'user' name which is from Sign-In.html, is it empty or have some text 
		{ $query = mysql_query("SELECT * FROM UserName where userName = '$_POST[user]' AND pass = '$_POST[pass]'"); 
			$row = mysql_fetch_array($query);
			if(!empty($row['userName']) AND !empty($row['pass'])) {
				  $_SESSION['userName'] = $row['userName'];
				  header('Location: index.php');
			} else { echo "SORRY... YOU ENTERD WRONG ID AND PASSWORD... PLEASE RETRY..."; } }
			} if(isset($_POST['submit'])) { 
			SignIn();
	} ?>
		