<?php
	include("include/connect.php");
	$startDate = '2014-11-01';
	$file = fopen("tableName.txt","r");
	ini_set('max_execution_time', 900);
	while(!feof($file)){
		$tableName = fgets($file);
		 calculateIndicators($tableName,$startDate);
	}
	fclose($file);
	function calculateTypicalPrice($id,$date,$high,$low,$close,$tableName){
		$typicalPrice = ($high+$low+$close)/3;
		if($typicalPrice>$close){
			$indication = "BUY";
		}else{
			$indication = "DO NOTHING";
		}
		$sqlUpdate = "UPDATE $tableName SET TP = '$indication' WHERE id = $id";
		$result = mysql_query($sqlUpdate);
	}
	function calculateFiveDMA($id,$date,$high,$low,$close,$tableName){
		$endId = $id - 4;
		$total = 0;
		$sqlSelect = "SELECT close from $tableName WHERE id BETWEEN $endId AND $id";
		$result = mysql_query($sqlSelect);
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$total += $row['close'];
			}
		}
		$fiveDMA = $total/5;
		if($fiveDMA>$close){
			$indication = "BUY";
		}else{
			$indication = "DO NOTHING";
		}
		$sqlUpdate = "UPDATE $tableName SET DMA_5 = '$indication' WHERE id = $id";
		$result = mysql_query($sqlUpdate);
	}
	function calculateTenDMA($id,$date,$high,$low,$close,$tableName){
		$endId = $id - 9;
		$total = 0;
		$sqlSelect = "SELECT close from $tableName WHERE id BETWEEN $endId AND $id";
		$result = mysql_query($sqlSelect);
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$total += $row['close'];
			}
		}
		$tenDMA = $total/10;
		if($tenDMA>$close){
			$indication = "BUY";
		}else{
			$indication = "DO NOTHING";
		}
		$sqlUpdate = "UPDATE $tableName SET DMA_10 = '$indication' WHERE id = $id";
		$result = mysql_query($sqlUpdate);
	}
	function calculateTwentyDMA($id,$date,$high,$low,$close,$tableName){
		$endId = $id - 19;
		$total = 0;
		$sqlSelect = "SELECT close from $tableName WHERE id BETWEEN $endId AND $id";
		$result = mysql_query($sqlSelect);
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$total += $row['close'];
			}
		}
		$twentyDMA = $total/20;
		if($twentyDMA>$close){
			$indication = "BUY";
		}else{
			$indication = "DO NOTHING";
		}
		$sqlUpdate = "UPDATE $tableName SET DMA_20 = '$indication' WHERE id = $id";
		$result = mysql_query($sqlUpdate);
	}
	function calculateFiftyDMA($id,$date,$high,$low,$close,$tableName){
		$endId = $id - 49;
		$total = 0;
		$sqlSelect = "SELECT close from $tableName WHERE id BETWEEN $endId AND $id";
		$result = mysql_query($sqlSelect);
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$total += $row['close'];
			}
		}
		$fiftyDMA = $total/50;
		if($fiftyDMA>$close){
			$indication = "BUY";
		}else{
			$indication = "DO NOTHING";
		}
		$sqlUpdate = "UPDATE $tableName SET DMA_50 = '$indication' WHERE id = $id";
		$result = mysql_query($sqlUpdate);
	}
	function calculateHundredDMA($id,$date,$high,$low,$close,$tableName){
		$endId = $id - 99;
		$total = 0;
		$sqlSelect = "SELECT close from $tableName WHERE id BETWEEN $endId AND $id";
		$result = mysql_query($sqlSelect);
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$total += $row['close'];
			}
		}
		$hundredDMA = $total/100;
		if($hundredDMA>$close){
			$indication = "BUY";
		}else{
			$indication = "DO NOTHING";
		}
		$sqlUpdate = "UPDATE $tableName SET DMA_100 = '$indication' WHERE id = $id";
		$result = mysql_query($sqlUpdate);
	}
	
	function getPreviousClose($id,$tableName){
		$prevID = $id - 1;
		$sqlSelect = "SELECT close FROM $tableName WHERE id = $prevID";
		$result = mysql_query($sqlSelect);
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				return $row['close'];
			}
		}else{return -1;}
	}
	
	function calculateRSI($id,$date,$high,$low,$close,$tableName){
		$endId = $id - 13;
		$totalGain = 0;
		$totalLoss = 0;
		$sqlSelect = "SELECT id,open,close FROM $tableName WHERE id BETWEEN $endId AND $id";
		$result = mysql_query($sqlSelect);
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$id = $row['id'];
				$close = $row['close'];
				$open = $row['open'];
				$previousClose = getPreviousClose($id,$tableName);
				if($close>$previousClose){
					$totalGain += ($close - $previousClose);
				}
				if($close<$previousClose){
					$totalLoss += ($previousClose - $close);
				}
			}
		}
		if($totalLoss != 0){
			$rs = $totalGain/$totalLoss;
		}else{
			$rs = -1;
		}
		if($rs >= 0)
			$rsi = 100 - (100/(1+$rs));
		else
			$rsi = 100;
		if($rsi >= 70){
			$indication = "SELL";
		}else if($rsi <= 30){
			$indication = "BUY";
		}else{
			$indication = "DO NOTHING";
		}
		$sqlUpdate = "UPDATE $tableName SET RSI = '$indication' WHERE id = $id";
		$result = mysql_query($sqlUpdate);
	}
	
	function calculateChaikin($id,$date,$high,$low,$close,$volume,$tableName){
		$sumFlowVolume21 = 0;
		$sumVolume21 = 0;
		$cmf = 0;
		$endId = $id - 20;
		$sqlSelect = "SELECT * FROM $tableName WHERE id BETWEEN $endId AND $id";
		$result = mysql_query($sqlSelect);
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$close = $row['close'];
				$open = $row['open'];
				$volume = $row['volume'];
				$high = $row['high'];
				$low = $row['low'];
				if($high - $low == 0)
				{
					continue;
				}
				$moneyFlowMultiplier = (($close - $low) - ($high - $close))/($high - $low);
				$moneyFlowVolume = $moneyFlowMultiplier * $volume;
				$sumVolume21 += $volume;
				$sumFlowVolume21 += $moneyFlowVolume;
			}
		}
		$cmf = $sumFlowVolume21/$sumVolume21;
		if($cmf >= 0.2){
			$indication = "BUY";
		}
		else if($cmf <= -0.2){
			$indication = "SELL";
		}
		else{
			$indication = "DO NOTHING";
		}
		$sqlUpdate = "UPDATE $tableName SET CMI = '$indication' WHERE id = $id";
		$result = mysql_query($sqlUpdate);	
	}
	
	function stochasticLoop($id,$high,$low,$close,$tableName){
		$endId = $id - 13;
		$lowestLow = $low;
		$highestHigh = $high;
		$sqlSelect = "SELECT * FROM $tableName WHERE id BETWEEN $endId AND $id";
		$result = mysql_query($sqlSelect);
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$low = $row['low'];
				$high = $row['high'];
				if($low < $lowestLow)
					$lowestLow = $low;
				if($high > $highestHigh)
					$highestHigh = $high;
			}
		}
		//echo $lowestLow . " " . $highestHigh . "<br>";
		$percK = (($close - $lowestLow)/($highestHigh - $lowestLow)) * 100;
		return $percK;
	}
	
	function calculateStochasticOscilator($curId,$date,$high,$low,$close,$volume,$tableName){
		$endId = $curId - 2;
		$soTotal = 0;
		$curPercK = 0;
		$sqlSelect = "SELECT * FROM $tableName WHERE id BETWEEN $endId AND $curId ";
		$result = mysql_query($sqlSelect);
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_array($result)){
				$id = $row['id'];
				$close = $row['close'];
				$high = $row['high'];
				$low = $row['low'];
				$percK = stochasticLoop($id,$high,$low,$close,$tableName);
				if($id == $curId)
					$curPercK = $percK;
				$soTotal += $percK;
			}
		}
		echo "<br>";
		$percD = $soTotal/3;
		//echo "percK: $percK percD: $percD <br>";
		if($percD > $percK)
			$indication = "SELL";
		else
			$indication = "BUY";
		$sqlUpdate = "UPDATE $tableName SET SO = '$indication' WHERE id = $curId";
		$result = mysql_query($sqlUpdate);	
	}
		
	
	function calculateIndicators($tableName,$startDate){
		$sql = "SELECT * FROM $tableName WHERE date >= '$startDate' ORDER BY date DESC";
		$result = mysql_query($sql);
		if(mysql_query($sql)){
			while($row = mysql_fetch_array($result)){
				$id = $row['id'];
				$date = $row['date'];
				$open = $row['open'];
				$close = $row['close'];
				$high = $row['high'];
				$low = $row['low'];
				$volume = $row['volume'];
				if(is_null($row['TP'])){
					calculateTypicalPrice($id,$date,$high,$low,$close,$tableName);
					calculateFiveDMA($id,$date,$high,$low,$close,$tableName);
					calculateTenDMA($id,$date,$high,$low,$close,$tableName);
					calculateTwentyDMA($id,$date,$high,$low,$close,$tableName);
					calculateFiftyDMA($id,$date,$high,$low,$close,$tableName);
					calculateHundredDMA($id,$date,$high,$low,$close,$tableName);
					calculateRSI($id,$date,$high,$low,$close,$tableName);
					calculateChaikin($id,$date,$high,$low,$close,$volume,$tableName);
					calculateStochasticOscilator($id,$date,$high,$low,$close,$volume,$tableName);
				}
			}
		}
	}
?>

