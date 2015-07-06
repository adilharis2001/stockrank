<?php
	include("include/connect.php");
	$startDate = '2014-11-01';
	$BUY = "BUY";
	$SELL = "SELL";
	$DN = "DO NOTHING";
	$rowConter = 0;
	$tpWeight = 0;
	$dma_5Weight = 0;
	$dma_10Weight = 0;
	$dma_20Weight = 0;
	$dma_50Weight = 0;
	$dma_100Weight = 0;
	$soWeight = 0;
	$cmiWeight = 0;
	$rsiWeight = 0;
	$file = fopen("tableName.txt","r");
	ini_set('max_execution_time', 900);
	while(!feof($file)){
		$tableName = fgets($file);
		calculateWeights($tableName);
	}
	fclose($file);
	
	echo "RC:". $rowCounter . "<br>TP:" . $tpWeight . "<br>5DMA " . $dma_5Weight . "<br>10DMA " . $dma_10Weight . "<br>20DMA " . $dma_20Weight . "<br>50DMA " . $dma_50Weight . "<br>100DMA " . $dma_100Weight . "<br>SO " . $soWeight . "<br>CMI " . $cmiWeight . "<br>RSI " . $rsiWeight;
	function getNextClose($id,$tableName){
		$nextID = $id + 1;
		$sql = "SELECT close FROM $tableName WHERE id = $nextID";
		$resultSet = mysql_query($sql);
		if(mysql_query($sql)){
			while($row = mysql_fetch_array($resultSet)){
				return $row['close'];
			}
			}else{
			return -1;
		}
	}
	function calculateWeights($tableName){
		//echo $tableName . "<br>";
		global $tpWeight,$dma_5Weight,$dma_10Weight,$dma_20Weight,$dma_50Weight,$dma_100Weight,$soWeight,$rsiWeight,$cmiWeight,$startDate,$BUY,$SELL,$DN,$rowCounter;
		$sql = "SELECT * FROM $tableName WHERE date > '$startDate'";
		$resultSet = $result = mysql_query($sql);	
		if(mysql_query($sql)){
			while($row = mysql_fetch_array($resultSet)){
				$rowCounter++;
				$tp = $row['TP'];
				$dma_5 = $row['DMA_5'];
				$dma_10 = $row['DMA_10'];
				$dma_20 = $row['DMA_20'];
				$dma_50 = $row['DMA_50'];
				$dma_100 = $row['DMA_100'];
				$rsi = $row['RSI'];
				$so = $row['SO'];
				$cmi = $row['CMI'];
				$close = $row['close'];
				$id = $row['id'];
				$nextDayClose = getNextClose($id,$tableName);
				//echo $tableName . " " . $id . " " .$close . " " . $nextDayClose . "<br>";
				if($nextDayClose != -1){
					if($nextDayClose > $close){
						if(strcmp($tp,$BUY) == 0){$tpWeight++;}
						if(strcmp($tp,$DN) == 0){}
						if(strcmp($dma_5,$BUY) == 0){$dma_5Weight++;}
						if(strcmp($dma_5,$DN) == 0){}
						if(strcmp($dma_10,$BUY) == 0){$dma_10Weight++;}
						if(strcmp($dma_10,$DN) == 0){}
						if(strcmp($dma_20,$BUY) == 0){$dma_20Weight++;}
						if(strcmp($dma_20,$DN) == 0){}
						if(strcmp($dma_50,$BUY) == 0){$dma_50Weight++;}
						if(strcmp($dma_50,$DN) == 0){}
						if(strcmp($dma_100,$BUY) == 0){$dma_100Weight++;}
						if(strcmp($dma_100,$DN) == 0){}
						if(strcmp($rsi,$DN) == 0){}
						if(strcmp($rsi,$BUY) == 0){$rsiWeight++;}
						if(strcmp($rsi,$SELL) == 0){$rsiWeight--;}
						if(strcmp($cmi,$SELL) == 0){$cmiWeight--;}
						if(strcmp($cmi,$BUY) == 0){$cmiWeight++;}
						if(strcmp($cmi,$DN) == 0){}
						if(strcmp($so,$DN) == 0){}
						if(strcmp($so,$BUY) == 0){$soWeight++;}
						if(strcmp($so,$SELL) == 0){$soWeight--;}
					}else if($close > $nextDayClose){
						if(strcmp($tp,$BUY) == 0){$tpWeight--;}
						if(strcmp($tp,$DN) == 0){}
						if(strcmp($dma_5,$BUY) == 0){$dma_5Weight--;}
						if(strcmp($dma_5,$DN) == 0){/*$dma_5Weight++;*/}
						if(strcmp($dma_10,$BUY) == 0){$dma_10Weight--;}
						if(strcmp($dma_10,$DN) == 0){/*$dma_10Weight++;*/}
						if(strcmp($dma_20,$BUY) == 0){$dma_20Weight--;}
						if(strcmp($dma_20,$DN) == 0){/*$dma_20Weight++;*/}
						if(strcmp($dma_50,$BUY) == 0){$dma_50Weight--;}
						if(strcmp($dma_50,$DN) == 0){/*$dma_50Weight++;*/}
						if(strcmp($dma_100,$BUY) == 0){$dma_100Weight--;}
						if(strcmp($dma_100,$DN) == 0){/*$dma_100Weight++;*/}
						if(strcmp($rsi,$DN) == 0){}
						if(strcmp($rsi,$BUY) == 0){$rsiWeight--;}
						if(strcmp($rsi,$SELL) == 0){$rsiWeight++;}
						if(strcmp($cmi,$SELL) == 0){$cmiWeight++;}
						if(strcmp($cmi,$BUY) == 0){$cmiWeight--;}
						if(strcmp($cmi,$DN) == 0){}
						if(strcmp($so,$DN) == 0){}
						if(strcmp($so,$BUY) == 0){$soWeight--;}
						if(strcmp($so,$SELL) == 0){$soWeight++;}
					}
				}
			}
		}
	}
?>