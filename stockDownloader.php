<?php
	include("include/connect.php");
	function createURL($ticker){
		$currentMonth = date("n");
		$currentMonth = $currentMonth - 1;
		$currentDay = date("j");
		$currentYear = date("Y");
		return "http://real-chart.finance.yahoo.com/table.csv?s=$ticker&d=$currentMonth&e=$currentDay&f=$currentYear&g=d&a=5&b=1&c=2014&ignore=.csv";
	}
	
	function getCSVFile($url,$outputFile){
		ini_set('max_execution_time', 900);
		$content = file_get_contents($url);
		$content = str_replace("Date,Open,High,Low,Close,Volume,Adj Close","",$content);
		$content = trim($content);
		file_put_contents($outputFile, $content);
	}
	function fileToDatabase($txtFile, $tableName){
		if (strpos($tableName,'.BO') !== false) {
			$tableName = str_replace('.BO','',$tableName);
		}
		if (strpos($tableName,'.NS') !== false) {
			$tableName = str_replace('.NS','',$tableName);
		}
		if (strpos($tableName,'&') !== false) {
			$tableName = str_replace('&','n',$tableName);
		}
		echo $tableName;
		$sqlDrop = "DROP TABLE IF EXISTS $tableName";
		mysql_query($sqlDrop);
		$sql2 = "CREATE TABLE $tableName(id int(11) auto_increment not null,PRIMARY KEY(id),date DATE, open float, high float, low float, close float, volume INT,amount_change float,percent_change float,tp varchar(4),dma_5 varchar(4),dma_10 varchar(4),dma_20 varchar(4),dma_50 varchar(4),dma_100 varchar(4),rsi varchar(4), cmi varchar(4))";
		mysql_query($sql2);
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
			$amount_change = $close - $open;
			$percent_change = ($amount_change/$open) * 100;
			$sql3 = "INSERT INTO $tableName(date,open,high,low,close,volume,amount_change,percent_change) VALUES('$date','$open','$high','$low','$close','$volume','$amount_change','$percent_change')";
			mysql_query($sql3);
		}
		fclose($file);
		return $tableName;
		
	}
	
	function main(){
		$mainTickerFile = fopen("tickerMaster.txt","r");
		$myfile = fopen("tableName.txt", "w");
		while(!feof($mainTickerFile)){
			$companyTicker = fgets($mainTickerFile);
			$companyTicker = trim($companyTicker);
			$fileURL = createURL($companyTicker);
			$companyTxtFile = "txtFiles/".$companyTicker.".txt";
			getCSVFile($fileURL,$companyTxtFile);
			$tableName = fileToDatabase($companyTxtFile, $companyTicker);	
			fwrite($myfile, $tableName . "\n");
		}
		fclose($myfile);
	}  
	main();
?>