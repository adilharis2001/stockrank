<?php
	include("include/connect.php");
	session_start();
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["date"])) {
			$nameErr = "Date is required";
		} else {
			$doj = $_POST["date"];
		}

		if (empty($_POST["amount"])) {
			$emailErr = "Enter value in the field!";
		} else {
			$amount = $_POST["amount"];
		}

		if (empty($_POST["name"])) {
			$emailErr = "Enter value in the field!";
		} else {
			$nameInv = $_POST["name"];
		}
	}
	$name = $_SESSION["userName"]; 
	$sql0 = "SELECT * FROM investments WHERE username = '$name' AND doj = '$doj' AND InvestmentName = '$nameInv'";
	$result = mysql_query($sql0);
	if(mysql_num_rows($result) > 0){
		while($row1 = mysql_fetch_array($result)){
			$amountExist = $row1['amount'];
			$balanceExist = $row1['amount_left'];
			$newAmount = $amount + $amountExist;
			$newBalance = $amount + $balanceExist;
			$sql1 = "UPDATE investments SET amount = $newAmount, amount_left = $newBalance WHERE username = '$name' AND doj = '$doj' AND InvestmentName = '$nameInv'";
			mysql_query($sql1);
		}
	}else{
		$sql1= "INSERT INTO investments(username,InvestmentName,doj,amount,amount_left) VALUES('$name','$nameInv','$doj',$amount,$amount)";
		mysql_query($sql1);
	}
	header('Location: index.php');
	?>