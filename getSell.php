<?php
	include("include/connect.php");
	$doj = $_POST['doj'];
	session_start();
	$username = $_SESSION['userName'];
	$exitArray = array();
	$sql = "SELECT * FROM sellscore";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) > 0){
		while($row = mysql_fetch_array($result)){
			$id = $row['id'];
			$name = trim($row['name']);
			$close = getClose($name);
			$score = $row['score'];
			$sql2 = "SELECT * FROM userportfolio WHERE stockname = '$name' AND doj = '$doj' AND username = '$username'";
			$result2 = mysql_query($sql2);
			if(mysql_num_rows($result2) > 0){
				while($row2 = mysql_fetch_array($result2)){
					$upID = $row2['id'];
					$purchaseprice = $row2['purchaseprice'];
					$numberofstocks = $row2['no_of_stocks'];
					if($numberofstocks == 0)
						continue;
					$arr = array("id" => $id ,"name" => $name,"score" => $score, "close" => $close,"pp" => $purchaseprice,"nos" => $numberofstocks,"upid" => $upID);
					array_push($exitArray,$arr);
				}
			}
		}
	}	
	echo json_encode($exitArray);

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

?>