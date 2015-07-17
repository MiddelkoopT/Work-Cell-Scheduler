namespace WCS;
<!DOCTYPE html>
<html>
<head>
<!-- Employee Edit Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>WCS</title>
</head>
<body>
<?php 

require_once 'Work-Cell-Scheduler/App/employeeApp.php';
$a=new \WCS\EmployeeApp();
$a->process("employee.php");

?>

<table border='1'>

<tr><th></th>
<?php 
require_once 'Work-Cell-Scheduler/App/EmployeeApp.php';
$t=new WCS\Employee();
foreach($t->displayEmployee() as $w){
	echo "<th>$w\n";
}
?>
</tr>
<?php 
foreach($t->displayEmployee() as $p){
	echo "<tr><th>$p</th>";
	foreach($t->getEmployee() as $w) {
		echo "<td>".$t->getEmployee($p,$w)."</td>";
	}		
	echo "\n";
}
?>

</table>



</body>
</html>