<?php

//Final Exam Part BIMSE 7420
// C)Refactor a and b to usle only a single function to model and solve the optimization problem
//------------------------------------------------------------------------------
//Number of Stores and Suppliers 

require_once 'Work-Cell-Scheduler/WCS/os.php';
function solveStatic($numSuppliers,$numDepartments,$capacity,$demand,$cost,$profit){
	

$departments=array();
$suppliers=array();

for($i=0;$i<($numDepartments);$i++){
	$departments[]="D-$i";
}
for($i=0;$i<($numSuppliers);$i++){
	$suppliers[]="S-$i";
}

$capacity=array(600,300,200);
$demand=array(600,200,300);
$profitDisplay=array(20,30,40);
$profit=array(20,30,40,20,30,40,20,30,40);
$cost=array(2,3,3,5,2,4,3,3,8);
$actualProfit=array();

//Create Actual Profit Array
foreach ($cost as $key => $value) {
	$actualProfit[$key] = $profit[$key] - $cost[$key];
}
$actualProfit1=array();
foreach($suppliers as $key=>$s){
	foreach($departments as $key=>$d){
		$actualProfit1["{$s}_{$d}"] = $actualProfit[$key];
	}
}

//Create Indexed Array for Supply Capacity
$supplyVal=array();
for($i=0;$i<($numSuppliers);$i++){
	$supplyVal["S-$i"]=$capacity[$i];
}

//Created Indexed Array for Store Demand
$demandVal=array();
for($i=0;$i<($numDepartments);$i++){
	$demandVal["D-$i"]=$demand[$i];
}
//Create Decision Variable
$dvariable=array();
foreach($suppliers as $s){
	foreach($departments as $d){
		$dvariable[]="{$s}_{$d}";
	}
}

//--------------------------------------------------------------------------
//Create OSIL file
$os=new WEBIS\OS;

foreach($dvariable as $dv){
	$v=$os->addVariable("$dv");
	$os->addObjCoef("$dv", $actualProfit1[$dv]);
}

//Create Demand Constraints
foreach($departments as $d){
	$os->addConstraint(NULL,$demandVal[$d]);
	foreach($suppliers as $s){
		$os->addConstraintCoef("{$s}_{$d}",1);
	}
}
//Create Supply Constraints
foreach($suppliers as $s){
	$os->addConstraint($supplyVal[$s],NULL);
	foreach($departments as $d){
		$os->addConstraintCoef("{$s}_{$d}",1);
	}
}

?>
<?php
//Create HTML File
//---------------------------------------------------------------
?>
<html>
<meta charset="UTF-8">
<title>Decision Support Systems IMSE 7420 Final</title>
</head>
<body>
<h1>Decision Support Systems IMSE 7420 Final (E1)</h1>
<h2> Supply Data</h2>
<table border='1'>
<tr><td>Supplier</td>
<?php 
foreach ($suppliers as $s){
	echo"<td>$s</td>";
	}
echo"<tr><td>Supply</td>";
foreach($supplyVal as $s){
	echo"<td>$s</td>";
	}
echo"</tr>";
?>
</tr>
</table>
<h2> Demand Data</h2>
<table border='1'>
<tr><td>Department</td>
<?php 
foreach ($departments as $d){
	echo"<td>$d</td>";
	}
echo"<tr><td>Demand</td>";
foreach($demandVal as $d){
	echo"<td>$d</td>";
	}
echo"<tr>";
?>
</tr>
</table>
<h2> Profit Data</h2>
<table border='1'>
<tr><td>Department</td>
<?php 
foreach ($departments as $d){
	echo"<td>$d</td>";
	}
echo"<tr><td>Profit</td>";
foreach($profitDisplay as $p){
	echo"<td>$p</td>";
	}
echo"<tr>";
?>
</tr>
</table>

<h2> Profit-Shipping Data</h2>
<table border='1'>
<tr><td>Supplier to Department</td>
<?php 
foreach ($dvariable as $d){
	echo"<td>$d</td>";
	}
echo"<tr><td>Actual Profit</td>";
foreach($actualProfit as $p){
	echo"<td>$p</td>";
	}
echo"</tr>";
?>
</tr>
</table>
<?php
echo "---------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
?>
<h2> OSIL OSRL Optimization Solution</h2>
<table border='1'>
<tr><td>Objective Value</td></tr>
<?php 
$objvalue=$os->solve();
echo "<tr><td>$objvalue</td><td>"
?>
</table>
<h2> Shipment Values</h2>
<table border='1'>
<tr><th></th>
<?php
foreach($suppliers as $s){
echo "<th>$s\n";
}
?>
</tr>
<?php
foreach($departments as $d){
echo "<tr><th>$d</th>";
foreach($suppliers as $s){
echo "<td>".$os->getVariable("{$s}_{$d}")."</td>";
echo "\n";
}
}
?>
</table>
</body>
</html>


<?php 
}
echo solveStatic(3,3,[600,300,200],[600,200,300],[2,3,3,5,2,4,3,3,8],[20,30,40,20,30,40,20,30,40]);
?>

