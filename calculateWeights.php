<?php
	include("include/connect.php");
	$startDate = '2014-12-01';
	$sql = "SELECT * FROM ebsesn WHERE date > '$startDate'";
	$resultSet = mysql_query($sql);
	$BUY = "BUY";
	$SELL = "SELL";
	$DN = "DO NOTHING";
	$tpWeight = 0;
	$dma_5Weight = 0;
	$dma_10Weight = 0;
	$dma_20Weight = 0;
	$dma_50Weight = 0;
	$dma_100Weight = 0;
	$soWeight = 0;
	$cmiWeight = 0;
	$rsiWeight = 0;
	if(mysql_query($sql)){
		while($row = mysql_fetch_array($resultSet)){
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
			$nextDayClose = getNextClose($id);
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
	echo "TP:" . $tpWeight . "<br>5DMA " . $dma_5Weight . "<br>10DMA " . $dma_10Weight . "<br>20DMA " . $dma_20Weight . "<br>50DMA " . $dma_50Weight . "<br>100DMA " . $dma_100Weight . "<br>SO " . $soWeight . "<br>CMI " . $cmiWeight . "<br>RSI " . $rsiWeight;
	toArray();
	
	function toArray(){
		global $tpWeight,$dma_5Weight,$dma_10Weight,$dma_20Weight,$dma_50Weight,$dma_100Weight,$soWeight,$cmiWeight,$rsiWeight;
		$indicators = array(0 => $tpWeight,1 => $dma_5Weight,2 => $dma_10Weight, 3 => $dma_20Weight , 4 => $dma_50Weight , 5 => $dma_100Weight , 6 =>  $cmiWeight, 7 => $rsiWeight , 8 => $soWeight * 2 );
		$minValue = min($indicators); 
		$minValue = abs($minValue) * 2;
		$length = count($indicators);
		$weights = array();
		for($i=0;$i<$length;$i++){
			$indicators[$i] = $indicators[$i] + $minValue;
		//	echo " ".$indicators[$i] . " ";
			array_push($weights,$indicators[$i]/40);
		}
		insertIntoWeightsTable($weights);
		//print_r($weights);
	}
	
	function insertIntoWeightsTable($weights){
		$sqlEmpty = "TRUNCATE weights";
		mysql_query($sqlEmpty);
		$sql = "INSERT INTO weights VALUES($weights[0],$weights[1],$weights[2],$weights[3],$weights[4],$weights[5],$weights[6],$weights[7],$weights[8])";
		mysql_query($sql);
	}
	function getNextClose($id){
		$nextID = $id + 1;
		$sql = "SELECT close FROM ebsesn WHERE id = $nextID";
		$resultSet = mysql_query($sql);
		if(mysql_query($sql)){
			while($row = mysql_fetch_array($resultSet)){
				return $row['close'];
			}
		}else{
			return -1;
		}
	}
	?>