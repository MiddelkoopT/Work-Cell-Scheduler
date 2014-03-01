
<!DOCTYPE html>
<html>
<head>
<!-- Training Test Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>Training Matrix</title>
</head>
<body>
<h1>Training Matrix</h1>
<p>


<table border='1'>

<tr>
<?php
require_once 'Work-Cell-Scheduler/App/training.php';
$t=new WCS\TrainingMatrix();
?>

<?php 
//foreach($t->getCell() as $c){
//	echo "<th>$c\n";
//}
?>
<td>Name</td>
<td>Cell</td>
<td>Training</td>
<td>Ergonomic Score</td>

</tr>


<?php
foreach($t->getPeople() as $p){
	echo "<tr><td>$p</td>";
	foreach($t->getCell() as $c){
		echo "<td>$c</td>";
	}	
		foreach($t->getTraining() as $t) {
			echo "<td>$t</td>";
		}		
			foreach($t->getErgo as $e) {
				echo "<td>$e</td>";
			}

}
echo "\n";
?>

</table>


</body>
</html>
