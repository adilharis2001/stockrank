<?php
	include("include/connect.php");
	$exitArray = array();
	$sql0 = "SELECT * FROM buyScore ORDER BY score DESC LIMIT 5";
	$result0 = mysql_query($sql0);
	if(mysql_num_rows($result0) > 0){
		while($row0 = mysql_fetch_array($result0)){
			$id = $row0['id'];
			$name = trim($row0['name']);
			$close = getClose($name);
			$score = $row0['score'];
			$arr = array("id" => $id ,"name" => $name,"score" => $score, "close" => $close);
			array_push($exitArray,$arr);
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