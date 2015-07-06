<?php
	include("include/connect.php");
	function createURL($ticker,$tableName){
		$returnedDate = checkForExistingTable($tableName);
		if($returnedDate == -1){
			$currentMonth = date("n");
			$currentMonth = $currentMonth - 1;
			$currentDay = date("j");
			$currentYear = date("Y");
			return "http://real-chart.finance.yahoo.com/table.csv?s=$ticker&d=$currentMonth&e=$currentDay&f=$currentYear&g=d&a=5&b=1&c=2014&ignore=.csv";
			}else{
			$fromMonth = date("m",strtotime($returnedDate));
			$fromMonth = $fromMonth - 1;
			$fromDay = date("d",strtotime($returnedDate));
			$fromYear = date('Y',strtotime($returnedDate));
			$currentMonth = date("n");
			$currentMonth = $currentMonth - 1;
			$currentDay = date("j");
			$currentYear = date("Y");
			return "http://real-chart.finance.yahoo.com/table.csv?s=$ticker&d=$currentMonth&e=$currentDay&f=$currentYear&g=d&a=$fromMonth&b=$fromDay&c=$fromYear&ignore=.csv";
		}
	}
	
	function checkForExistingTable($tableName){
		if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$tableName."'"))==1) {
			$sql1 = "SELECT date FROM $tableName ORDER BY date DESC LIMIT 1";
			$result = mysql_query($sql1);
			if(mysql_num_rows($result) > 0){
				while($row = mysql_fetch_array($result)){
					$date = $row['date'];
					return $date;
				}
			}	
			}else{
			return -1;
		}
	}
	
	function getCSVFile($url,$outputFile){
		ini_set('max_execution_time', 900);
		$content = file_get_contents($url);
		$content = str_replace("Date,Open,High,Low,Close,Volume,Adj Close","",$content);
		$content = trim($content);
		file_put_contents($outputFile, $content);
	}
	function fileToDatabase($txtFile, $tableName){
		$check = checkForExistingTable($tableName);
		if($check == -1){
			echo $tableName;
			$sql2 = "CREATE TABLE $tableName(id int(11) not null,PRIMARY KEY(id),date DATE UNIQUE, open float, high float, low float, close float, volume INT,amount_change float,percent_change float,TP varchar(11),DMA_5 varchar(11),DMA_10 varchar(11),DMA_20 varchar(4),DMA_50 varchar(11),DMA_100 varchar(11),RSI varchar(11), CMI varchar(11), SO varchar(11))";
			mysql_query($sql2);
			$testFile = fopen($txtFile,"r");
			$counter = 0;
			while(!feof($testFile)){
				$line = fgets($testFile);
				$pieces = explode(",",$line);
				$high = $pieces[2];
				$low = $pieces[3];
				$volume = $pieces[5];
				if($volume == 0 && $high == $low){
					continue;
				}
				$counter++;
			}
			
			$file = fopen($txtFile,"r");
			while(!feof($file)){
				$line = fgets($file);
				$pieces = explode(",",$line);
				$date = $pieces[0];
				$open = $pieces[1];
				$high = $pieces[2];
				$low = $pieces[3];
				$close = $pieces[4];
				$volume = $pieces[5];
				if($volume == 0 && $high == $low){
					continue;
				}
				$amount_change = $close - $open;
				$percent_change = ($amount_change/$open) * 100;
				$sql3 = "INSERT IGNORE INTO $tableName(id,date,open,high,low,close,volume,amount_change,percent_change) VALUES($counter,'$date','$open','$high','$low','$close','$volume','$amount_change','$percent_change')";
				$counter--;
				mysql_query($sql3);	
			}
			fclose($testFile);
			fclose($file);
		}else{
			$sql1 = "SELECT id FROM $tableName ORDER BY id DESC LIMIT 1";
			$result = mysql_query($sql1);
			$lastID  = -1;
			if(mysql_num_rows($result) > 0){
				while($row = mysql_fetch_array($result)){
					$lastID = $row['id'];
				}
			}
			$file = fopen($txtFile,"r");
			while(!feof($file)){	
				$line = fgets($file);
				$pieces = explode(",",$line);
				$date = $pieces[0];
				$open = $pieces[1];
				$high = $pieces[2];
				$low = $pieces[3];
				$close = $pieces[4];
				$volume = $pieces[5];
				if($volume == 0 && $high == $low){
					continue;
				}
				$amount_change = $close - $open;
				$percent_change = ($amount_change/$open) * 100;
				$lastID++;
				$sql3 = "INSERT IGNORE INTO $tableName(id,date,open,high,low,close,volume,amount_change,percent_change) VALUES($lastID,'$date','$open','$high','$low','$close','$volume','$amount_change','$percent_change')";
				mysql_query($sql3);
			}
			fclose($file);	
		}
	}
	
	function createTableName($tableName){
		if (strpos($tableName,'.BO') !== false) {
			$tableName = str_replace('.BO','',$tableName);
		}
		if (strpos($tableName,'.NS') !== false) {
		$tableName = str_replace('.NS','',$tableName);
		}
		if (strpos($tableName,'&') !== false) {
			$tableName = str_replace('&','n',$tableName);
		}
		if (strpos($tableName,'%5') !== false) {
			$tableName = str_replace('%5','',$tableName);
		}
		return $tableName;
	}
	
	function main(){
		$mainTickerFile = fopen("tickerMaster.txt","r");
		$myfile = fopen("tableName.txt", "w");
		while(!feof($mainTickerFile)){
			$companyTicker = fgets($mainTickerFile);
			$companyTicker = trim($companyTicker);
			$tableName = createTableName($companyTicker);
			$fileURL = createURL($companyTicker,$tableName);
		$companyTxtFile = "txtFiles/".$companyTicker.".txt";
		getCSVFile($fileURL,$companyTxtFile);
		fileToDatabase($companyTxtFile, $tableName);	
		fwrite($myfile, $tableName . "\n");
		}
		fclose($myfile);
		}  
		main();
		?>		