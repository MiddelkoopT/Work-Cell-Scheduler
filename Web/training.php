<!DOCTYPE html>
<html>
<head>
<!-- Training Test Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>WCS Training Matrix </title>
<style>
caption {caption-side:bottom;}
</style>
</head>
<body>
<h1>WCS Training Matrix </h1>
<table border='1'>
<caption>Table 1.1 Employee Training Matrix. </caption>
<tr><th></th>

<?php 
require_once 'Work-Cell-Scheduler/App/trainingApp.php';
$t=new WCS\TrainingMatrix();
$subcells=$t->getsubcell();
sort($subcells);
foreach($subcells as $w){
	echo "<th>$w\n";
}
?>
</tr>
<?php 

foreach($t->getworkerID() as $p){
	echo "<tr><th>$p</th>";
	foreach($subcells as $s) {
		echo "<td>".$t->getTraining($p,$s)."</td>";
	}		
	echo "\n";
}
?>

</table>
<p><b>Note:</b>  Left column is the Worker_ID. Top row is the subcell</p><br>
<p><b>Coming Soon:</b>  On Page Live Edit of Static Training Matrix Display </p>
<br>
<a href="http://127.0.0.1:8000/Work-Cell-Scheduler/Web/">Back to Index Page</a> 
</body>
</html>