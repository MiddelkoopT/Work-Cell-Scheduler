<!DOCTYPE html>
<html>
<head>
<!-- Training Test Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>WCS Training</title>
</head>
<body>
<h1>WCS Training Matrix</h1>

<table border='1'>

<tr><th>Employee ID \ Subcell</th>
<?php 
require_once 'Work-Cell-Scheduler/App/trainingApp.php';
$t=new WCS\TrainingMatrix();
foreach($t->getSubcell() as $w){
	echo "<th>$w</td>";
}
?>
</tr>

<?php 
foreach($t->getEmployeeid() as $p){
	echo "<tr><th>$p</th>";
	foreach($t->getSubcell() as $w) {
		echo "<td>".$t->getTraining($p,$w)."</td>";
	}		
	"</tr>";
}


?>



</table>


<br></br>

Add training below:
<?php
$a=new \WCS\TrainingMatrixApp();
$a->process("training.php");
?>


<br></br>


<a
href="http://127.0.0.1:8000/Work-Cell-Scheduler/Web/">
Go to index page
</a>







</body>
</html>