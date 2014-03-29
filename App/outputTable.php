<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<body>
<p>Training </p>
<?php
//include ("config.php");
//include 'config.php';

static $dbhost='127.0.0.1';
static $dbuser='root';
static $dbpassword='webis';
static $dbdatabase='WCS';

$dbConn = mysql_connect ($dbhost, $dbuser, $dbpassword) or die ('MySQL connect failed. ' . mysql_error());
mysql_select_db($dbdatabase,$dbConn) or die('Cannot select database. ' . mysql_error());


//$dbConn = mysql_connect ($sDbHost, $sDbUser, $sDbPwd) or die ('MySQL connect failed. ' . mysql_error());
//mysql_select_db($sDbName,$dbConn) or die('Cannot select database. ' . mysql_error());


 // Collects data from "TrainingMatrix" and ScheduleMatrix table 
$trainingMatrix = mysql_query("SELECT * FROM TrainingMatrix") or die(mysql_error()); 
$scheduleMatrix = mysql_query("SELECT * FROM ScheduleMatrix") or die(mysql_error()); 

$trainingInfo = mysql_fetch_array( $trainingMatrix );
Print "<table border cellpadding=3>";
while($trainingInfo = mysql_fetch_array( $trainingMatrix )){ 
	Print "<tr>"; 
	Print "<th>Name:</th> <td>".$trainingInfo['person'] . "</td> "; 
	Print "<th>Cell:</th> <td>".$trainingInfo['cell'] . "</td> ";
	Print "<th>Training:</th> <td>".$trainingInfo['training'] . "</td> ";
	Print "<th>Ergo:</th> <td>".$trainingInfo['ergo'] . " </td></tr>"; 
};
Print "</table>";
?>

<br></br>

<p>Schedule</p>
<?php 
 $scheduleInfo = mysql_fetch_array( $scheduleMatrix );
 Print "<table border cellpadding=3>";
 while($scheduleInfo = mysql_fetch_array( $scheduleMatrix )){
 	Print "<tr>";
 	Print "<th>Name:</th> <td>".$scheduleInfo['person'] . "</td> ";
 	Print "<th>Cell:</th> <td>".$scheduleInfo['cell'] . "</td> ";
 	Print "<th>Period:<thb> <td>".$scheduleInfo['period'] . "</td></tr>";
 };
 Print "</table>";
 ?> 
 <br></br>
 
<form action="insert.php" method="post">
person: <input type="text" name="name">
cell: <input type="text" name="cell">
training: <input type="text" name="training">
ergo: <input type="text" name="ergo">
<input type="submit">
</form>
 
</body>
</html>