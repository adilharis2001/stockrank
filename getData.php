<?php
	include("include/connect.php");
	session_start();
	$exitArray = array();
	$json = "[";
	$username = $_SESSION["userName"];
	$sql = "SELECT * FROM investments WHERE username = '$username'";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) > 0){
		while($row = mysql_fetch_array($result)){
			$json .= "{";
			$id = $row['id'];
			$doj = $row['doj'];
			$nameOfInv = $row['InvestmentName'];
			$username = $row['username'];
			$amount = $row['amount'];
			$left = $row['amount_left'];
			$arr = array("id" => $id ,"nameInv" => $nameOfInv,"username" => $username,"doj" => $doj, "amount" => $amount, "left" => $left);
			array_push($exitArray,$arr);
		}
	}	
	echo json_encode($exitArray);


?>