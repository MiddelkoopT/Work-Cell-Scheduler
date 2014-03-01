
<!DOCTYPE html>
<html>
<head>
<!-- Training Test Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>Schedule</title>
</head>
<body>
<h1>Schedule</h1>
<p>


<table border='1'>

<tr>
<?php
require_once 'Work-Cell-Scheduler/App/training.php';
$t=new WCS\Schedule();
?>

<?php 
//foreach($t->getCell() as $c){
//	echo "<th>$c\n";
//}
?>
<td>Name</td>
<td>Cell</td>


</tr>


<?php
foreach($t->getPerson() as $p){
	echo "<tr><td>$p</td>";
	foreach($t->getWorkcell() as $c){
		echo "<td>$c</td>";
	}	
}
echo "\n";
?>

</table>


</body>
</html>

