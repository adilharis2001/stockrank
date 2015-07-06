<?php
include("include/connect.php");
session_start();
$doj = $_POST['doj'];
$username = $_SESSION["userName"]; 
$currentValue = $_POST['currentValue'];
$sharesPurchased = $_POST['numberOfShares'];
$stockName = $_POST['stockName'];
$sellingPrice = $_POST['sellingPrice'];
$sharesRemaining = $_POST['sharesRemaining'];
$sharesInitially = $_POST['sharesInitially'];
$purchasePrice = $_POST['purchasePrice'];
$sqlUpdate = "UPDATE userportfolio SET no_of_stocks = $sharesRemaining WHERE doj = '$doj' AND stockname = '$stockName' AND username = '$username' AND purchaseprice = $purchasePrice";
mysql_query($sqlUpdate);
/*else{
	$sqlDelete = "DELETE FROM userportfolio WHERE doj = '$doj' AND stockname = '$stockName' AND username = '$username' AND purchaseprice = $purchasePrice ";
	mysql_query($sqlDelete);
}*/
$sqlSelect = "SELECT * FROM investments WHERE doj = '$doj' AND username = '$username'";
$resultSelect = mysql_query($sqlSelect);
if(mysql_num_rows($resultSelect) > 0){
	while($row = mysql_fetch_array($resultSelect)){
		$net = ($currentValue * $sharesPurchased) - ($purchasePrice * $sharesPurchased);
		$gainLoss = $row['GainLoss'];
		$gainLoss = $gainLoss + $net;
		$sqlUpdate2 = "UPDATE investments SET GainLoss = $gainLoss WHERE doj = '$doj' AND username = '$username'";
		mysql_query($sqlUpdate2);
	}
}
echo "Your shares in $stockName were sold successfully!";
?>