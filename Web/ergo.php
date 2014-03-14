<!DOCTYPE html>
<html>
<head>
<!-- Ergonomic Score Test Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>WCS Ergo Score</title>
</head>
<body>
<h1>WCS Ergo Score Matrix</h1>


<table border='1'>


<tr> <th></th>
<?php
require_once 'Work-Cell-Scheduler/App/ergoApp.php';
$e=new WCS\ErgoMatrix();
	foreach($e->getSubcell() as $s){
		echo "<th>$s</th>";
	}
?>
</tr>

<?php 
	foreach($e->getEmployeeid() as $id){
		echo "<tr><th>$id</th>";
		foreach ($e->getSubcell() as $s){
			echo "<td>".$e->getErgo($id, $s)."</td>";
		}
	"</tr>";	
	}		
?>
		
	
			
			
			







</table>

</body>
</html>