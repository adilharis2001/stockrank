<?php
	include("include/connect.php");
	$file = fopen("tableName.txt","r");
	ini_set('max_execution_time', 900);
	while(!feof($file)){
		$tableName = fgets($file);
		if(strcmp(trim($tableName),"EBSESN") == 0)
			continue;
		 calculateBuyScore($tableName);
		 calculateSellScore($tableName);		 
		 echo "<br>";
	}
	fclose($file);
	
	function calculateSellScore($tableName){
		
		$BUY = "BUY";
		$SELL = "SELL";
		$DN = "DO NOTHING";
		$counter = 0;
		$sql = "SELECT * FROM $tableName ORDER BY date DESC LIMIT 30";
		$resultSet = mysql_query($sql);
		if(mysql_query($sql)){
			while($row = mysql_fetch_array($resultSet)){
				$finalScore = 0;
				$date = $row['date'];
				$rsi = $row['RSI'];
				$so = $row['SO'];
				$cmi = $row['CMI'];
				if(strcmp($rsi,$SELL) == 0){
					$rsiScore = getWeight("RSI");
					$finalScore += $rsiScore;
				}
				if(strcmp($so,$SELL) == 0){
					$soScore = getWeight("SO");
					$finalScore += $soScore;
				}
				if(strcmp($cmi,$SELL) == 0){
					$cmiScore = getWeight("CMI");
					$finalScore += $cmiScore;
				}	
				insertIntoSellScore($tableName,$finalScore,$counter);
				$counter++;
			}
		}
	}
	
	function calculateBuyScore($tableName){
		
		$BUY = "BUY";
		$SELL = "SELL";
		$DN = "DO NOTHING";
		$counter = 0;
		$sql = "SELECT * FROM $tableName ORDER BY date DESC LIMIT 30";
		$resultSet = mysql_query($sql);
		if(mysql_query($sql)){
			while($row = mysql_fetch_array($resultSet)){
				$finalScore = 0;
				$date = $row['date'];
				$tp = $row['TP'];
				$dma_5 = $row['DMA_5'];
				$dma_10 = $row['DMA_10'];
				$dma_20 = $row['DMA_20'];
				$dma_50 = $row['DMA_50'];
				$dma_100 = $row['DMA_100'];
				$rsi = $row['RSI'];
				$so = $row['SO'];
				$cmi = $row['CMI'];
				if(strcmp($tp,$BUY) == 0){
					$tpScore = getWeight("TP");
					$finalScore += $tpScore;
				}
				if(strcmp($dma_5,$BUY) == 0){
					$dma_5Score = getWeight("DMA_5");
					$finalScore += $dma_5Score;
				}
				if(strcmp($dma_10,$BUY) == 0){
					$dma_10Score = getWeight("DMA_10");
					$finalScore += $dma_10Score;
				}
				if(strcmp($dma_20,$BUY) == 0){
					$dma_20Score = getWeight("DMA_20");
					$finalScore += $dma_20Score;
				}
				if(strcmp($dma_50,$BUY) == 0){
					$dma_50Score = getWeight("DMA_50");
					$finalScore += $dma_50Score;
				}
				if(strcmp($dma_100,$BUY) == 0){
					$dma_100Score = getWeight("DMA_100");
					$finalScore += $dma_100Score;
				}
				if(strcmp($rsi,$BUY) == 0){
					$rsiScore = getWeight("RSI");
					$finalScore += $rsiScore;
				}
				if(strcmp($so,$BUY) == 0){
					$soScore = getWeight("SO");
					$finalScore += $soScore;
				}
				if(strcmp($cmi,$BUY) == 0){
					$cmiScore = getWeight("CMI");
					$finalScore += $cmiScore;
				}	
				insertIntoBuyScore($tableName,$finalScore,$counter);
				$counter++;
			}
		}
	}
	
	function insertIntoBuyScore($tableName,$finalScore,$counter){
		$sql = "CREATE TABLE IF NOT EXISTS buyscore_$counter(id int(11) auto_increment not null primary key,name varchar(50) not null,score DECIMAL(6,5) not null)";
	    mysql_query($sql);
		$sql = "INSERT INTO buyScore_$counter(name,score) VALUES('$tableName',$finalScore)";
		mysql_query($sql);
		echo $tableName . " " . $finalScore . "<br>";
	}
	
	function insertIntoSellScore($tableName,$finalScore,$counter){
		$sql = "CREATE TABLE IF NOT EXISTS sellscore_$counter(id int(11) auto_increment not null primary key,name varchar(50) not null,score DECIMAL(6,5) not null)";
		mysql_query($sql);
		$sql = "INSERT INTO sellScore_$counter(name,score) VALUES('$tableName',$finalScore)";
		mysql_query($sql);
		echo $tableName . " " . $finalScore . "<br>";
	}
	
	function getWeight($column){
		$sql = "SELECT $column FROM weights";
		$resultSet = mysql_query($sql);
		if(mysql_query($sql)){
			while($row = mysql_fetch_array($resultSet)){
				return $row[$column];
			}
		}
	}
	
?>