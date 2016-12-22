<?php
//setting header to json
header('Content-Type: application/json');

//database
define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'shobhit');
define('DB_PASSWORD', 'jkjk');
define('DB_NAME', 'userdata');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
} 

$timeframe = "1week";
$timeframe = $_GET['tf'];
$bs = "0";
$bs = $_GET['bs']; //bool_sentiment. What else could bs mean?

//TODO: Lots. Lots. Lots. Not proud of this piece.
// * Get rid of redundant code. Make functions.
// * "WHERE": don't hard code. Find today's date using GETDATE(). Then do GETDATE()-7 for 
//   timeframe == 1week, for example
// * Reduce the next 50 lines to 2 SQL queries, one for Sentiment graph, one for non-Sentiment

if($bs === "1") {
	if($timeframe == "1day") {
		$query = sprintf("
			SELECT BOT_ID as botid, Sentiment_Bool as sb, Count(Sentiment_Bool) as count, YEAR(Date_Field) as year, MONTH(Date_Field) as month, DAY(Date_Field) as day FROM userdata WHERE Date_Field <= '2016-12-19 00:00:00' AND Date_Field > '2016-12-18 00:00:00' GROUP BY BOT_ID, Sentiment_Bool, YEAR(Date_Field), MONTH(Date_Field), DAY(Date_Field)
			");
	}
	if($timeframe == "1week") {
		$query = sprintf("
			SELECT BOT_ID as botid, Sentiment_Bool as sb, Count(Sentiment_Bool) as count, YEAR(Date_Field) as year, MONTH(Date_Field) as month, DAY(Date_Field) as day FROM userdata WHERE Date_Field <= '2016-12-19 00:00:00' AND Date_Field > '2016-12-11 00:00:00' GROUP BY BOT_ID, Sentiment_Bool, YEAR(Date_Field), MONTH(Date_Field), DAY(Date_Field)
			");
	}
	if($timeframe == "1month") {
		$query = sprintf("
			SELECT BOT_ID as botid, Sentiment_Bool as sb, Count(Sentiment_Bool) as count, YEAR(Date_Field) as year, MONTH(Date_Field) as month, DAY(Date_Field) as day FROM userdata WHERE Date_Field <= '2016-12-19 00:00:00' AND Date_Field > '2016-11-19 00:00:00' GROUP BY BOT_ID, Sentiment_Bool, YEAR(Date_Field), MONTH(Date_Field), DAY(Date_Field)
			");
	}
	if($timeframe == "6months") {
		$query = sprintf("
			SELECT BOT_ID as botid, Sentiment_Bool as sb, Count(Sentiment_Bool) as count, YEAR(Date_Field) as year, MONTH(Date_Field) as month, DAY(Date_Field) as day FROM userdata WHERE Date_Field <= '2016-12-19 00:00:00' AND Date_Field > '2016-06-19 00:00:00' GROUP BY BOT_ID, Sentiment_Bool, YEAR(Date_Field), MONTH(Date_Field), DAY(Date_Field)
			");
	}
}

else {
	if($timeframe == "1day") {
		$query = sprintf("
			SELECT BOT_ID as botid, Count(BOT_ID) as count, YEAR(Date_Field) as year, MONTH(Date_Field) as month, DAY(Date_Field) as day FROM userdata WHERE Date_Field <= '2016-12-19 00:00:00' AND Date_Field > '2016-12-18 00:00:00' GROUP BY BOT_ID, YEAR(Date_Field), MONTH(Date_Field), DAY(Date_Field)
			");
	}
	else if($timeframe == "1week") {
		$query = sprintf("
			SELECT BOT_ID as botid, Count(BOT_ID) as count, YEAR(Date_Field) as year, MONTH(Date_Field) as month, DAY(Date_Field) as day FROM userdata WHERE Date_Field <= '2016-12-19 00:00:00' AND Date_Field > '2016-12-11 00:00:00' GROUP BY BOT_ID, YEAR(Date_Field), MONTH(Date_Field), DAY(Date_Field)
			");
	}
	else if($timeframe == "1month") {
		$query = sprintf("
			SELECT BOT_ID as botid, Count(BOT_ID) as count, YEAR(Date_Field) as year, MONTH(Date_Field) as month, DAY(Date_Field) as day  FROM userdata WHERE Date_Field <= '2016-12-19 00:00:00' AND Date_Field > '2016-11-19 00:00:00' GROUP BY BOT_ID, YEAR(Date_Field), MONTH(Date_Field), DAY(Date_Field)
			");
	}
	else if($timeframe == "6months") {
		$query = sprintf("
			SELECT BOT_ID as botid, Count(BOT_ID) as count, YEAR(Date_Field) as year, MONTH(Date_Field) as month, DAY(Date_Field) as day  FROM userdata WHERE Date_Field <= '2016-12-19 00:00:00' AND Date_Field > '2016-06-19 00:00:00' GROUP BY BOT_ID, YEAR(Date_Field), MONTH(Date_Field), DAY(Date_Field)
			");
	}
}

//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data);

?>