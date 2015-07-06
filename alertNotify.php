<?php
    include("include/connect.php");
	$doj = $_POST['doj'];
	session_start();
	$username = $_SESSION['userName'];
	$sql2 = "SELECT * FROM userportfolio WHERE doj = '$doj' AND username = '$username'";
	$result2 = mysql_query($sql2);
	if(mysql_num_rows($result2) > 0){
		while($row2 = mysql_fetch_array($result2)){
			$stockName = $row2['stockname'];
			$purchasePrice = $row2['purchaseprice'];
			$currentClose = getClose($stockName);
			$stopLoss = $row2['stoploss'];
			$remaining = $row2['no_of_stocks'];
			if($remaining == 0)
				continue;
			//echo $stockName . " " . $currentClose . " " . $stopLoss;
			if($currentClose < $stopLoss){
				$loss = ($currentClose - $purchasePrice) * $remaining;
				modifyGain($loss,$doj,$username);
				deleteRow($doj,$username,$purchasePrice,$stockName);
				echo "$stockName";
				exit(0);
			}
		}
	}
	echo "1";
	exit(0);

	function modifyGain($loss,$doj,$username){
	$sql2 = "SELECT * FROM investments WHERE doj = '$doj' AND username = '$username'";
	$result2 = mysql_query($sql2);
	if(mysql_num_rows($result2) > 0){
		while($row2 = mysql_fetch_array($result2)){
			$gainLoss = $row2['GainLoss'];
			$gainLoss = $gainLoss + $loss;
			$sqlUpdate2 = "UPDATE investments SET GainLoss = $gainLoss WHERE doj = '$doj' AND username = '$username'";
			mysql_query($sqlUpdate2);
		}
	}
	}

	function getClose($tableName){
	$sql1 = "SELECT close FROM $tableName ORDER BY date DESC LIMIT 1";
			$result1 = mysql_query($sql1);
			if(mysql_num_rows($result1) > 0){
				while($row1 = mysql_fetch_array($result1)){
					$close = $row1['close'];
					return $close;
				}
			}	
	}

	function deleteRow($doj,$username,$purchasePrice,$stockName){
		$sql1 = "UPDATE userportfolio SET no_of_stocks = 0 WHERE doj = '$doj' AND username = '$username' AND purchaseprice = $purchasePrice";
		mysql_query($sql1);
	}
?>