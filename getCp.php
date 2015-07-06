<?php
include("include/connect.php");
$doj = $_POST['doj'];
session_start();
$username = $_SESSION['userName'];
$exitArray = array();
$sql1 = "SELECT * FROM userportfolio WHERE username = '$username' AND doj = '$doj'";
$result = mysql_query($sql1);
$sql2 = "SELECT * FROM investments WHERE username = '$username' AND doj = '$doj'";
$result2 = mysql_query($sql2);
$gain = 0;
if(mysql_num_rows($result2) > 0){
	while($row2 = mysql_fetch_array($result2)){
		$gain = $row2['GainLoss'];
	}
}
if(mysql_num_rows($result) > 0){
	while($row = mysql_fetch_array($result)){
		$stockName = $row['stockname'];
		$purchasePrice = $row['purchaseprice'];
		$stopLoss = $row['stoploss'];
		$sharesRemaining = $row['no_of_stocks'];
		$sharesInitiallyPurchased = $row['initialNumber'];
		$currentClose = getClose($stockName);
		$arr = array("stockName" => $stockName, "purchasePrice" => $purchasePrice, "sharesRemaining" => $sharesRemaining,"stopLoss" => $stopLoss, "sharesInitiallyPurchased" => $sharesInitiallyPurchased, "currentClose" => $currentClose);
		array_push($exitArray,$arr);
	}
}
if(mysql_num_rows($result) > 0){
	array_push($exitArray,$gain);
}
echo(json_encode($exitArray));

function getClose($tableName){
	$sql2 = "SELECT close FROM $tableName ORDER BY date DESC LIMIT 1";
	$result1 = mysql_query($sql2);
	if(mysql_num_rows($result1) > 0){
		while($row1 = mysql_fetch_array($result1)){
			$close = $row1['close'];
			return $close;
		}
	}	
}

?>