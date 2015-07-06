<?php
$connect = mysql_connect('localhost','buckyboard','buckyboard');
if(!$connect){
die('Could not connect to datebase');
}
mysql_select_db("buckyboard",$connect);
?>