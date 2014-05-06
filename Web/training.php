<!DOCTYPE html>
<html>
<head>
<!-- Training Test Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>WCS Training</title>
</head>
<body>
<h1>Ping</h1>
<p>App:
<table border='1'>

<tr><th></th>
<?php 
require_once 'Work-Cell-Scheduler/App/trainingApp.php';
$t=new WCS\TrainingMatrix();
foreach($t->getWorkstations() as $w){
	echo "<th>$w\n";
}
?>
</tr>
<?php 
foreach($t->getPeople() as $p){
	echo "<tr><th>$p</th>";
	foreach($t->getWorkstations() as $w) {
		echo "<td>".$t->getTraining($p,$w)."</td>";
	}		
	echo "\n";
}
?>

</table>

</body>
</html>