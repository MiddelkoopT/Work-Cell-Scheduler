<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<body>
<p>Training </p>
<?php
include("config.php");



 // Collects data from "TrainingMatrix" and ScheduleMatrix table 
$trainingMatrix = mysql_query("SELECT * FROM TrainingMatrix") or die(mysql_error()); 
$scheduleMatrix = mysql_query("SELECT * FROM ScheduleMatrix") or die(mysql_error()); 

$trainingInfo = mysql_fetch_array( $trainingMatrix );
Print "<table border cellpadding=3>";
while($trainingInfo = mysql_fetch_array( $trainingMatrix )){ 
	Print "<tr>"; 
	Print "<th>Name:</th> <td>".$trainingInfo['person'] . "</td> "; 
	Print "<th>Cell:</th> <td>".$trainingInfo['cell'] . "</td> ";
	Print "<th>Work Station:</th> <td>".$trainingInfo['workstation'] . "</td> ";
	Print "<th>WCP:</th> <td>".$trainingInfo['wcp'] . "</td> ";
	Print "<th>WSP:</th> <td>".$trainingInfo['wsp'] . " </td></tr>"; 
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
</body>
</html>