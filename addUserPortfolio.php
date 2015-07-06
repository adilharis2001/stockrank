<?php
include("include/connect.php");
session_start();
$doj = $_POST['doj'];
$unitClosePrice = $_POST['closePrice'];
$numberOfShares = $_POST['numberOfShares'];
$username = $_SESSION["userName"]; 
$stockName = $_POST['stockName'];
$balanceLeft = $_POST['balanceLeft'];
$totalCost = $_POST['totalCost'];
$sql = "UPDATE investments SET amount_left = $balanceLeft WHERE doj = '$doj' AND username = '$username'";
mysql_query($sql);
$sql2 = "SELECT * FROM userportfolio WHERE username = '$username' AND doj = '$doj' AND purchaseprice = '$unitClosePrice' AND stockname = '$stockName'";
$result = mysql_query($sql2);
if(mysql_num_rows($result) > 0){
	while($row = mysql_fetch_array($result)){
		$number = $row["no_of_stocks"];
		$number = $number + $numberOfShares;
		$initial = $row["initialNumber"];
		$initial = $initial + $numberOfShares;
		$sql3 = "UPDATE userportfolio SET initialNumber = $initial, no_of_stocks = $number WHERE username = '$username' AND doj = '$doj' AND purchaseprice = '$unitClosePrice' AND stockname = '$stockName'";
		mysql_query($sql3);
	}
}else{
	$stopLoss = $unitClosePrice * 0.95;
	$sql1 = "INSERT INTO userportfolio(username,stockname,purchaseprice,stoploss,no_of_stocks,initialNumber,doj) VALUES('$username','$stockName','$unitClosePrice','$stopLoss','$numberOfShares','$numberOfShares','$doj')";
	mysql_query($sql1);
}
echo "Your investment in $stockName has been processed!";
?>