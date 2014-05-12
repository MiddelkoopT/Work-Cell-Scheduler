<?php

//Exam part B IMSE 7420
// b) Refactor a and b to use only a single function to model and solve the optimization problem

//------------------------------------------------------------------------------
require_once 'Work-Cell-Scheduler/WCS/os.php';

function solveRandom(){
//Number of Stores and Suppliers 
$numDepartments=rand(3,5);
$numSuppliers=rand(3,5);
//$numCostIndexes=$numDepartments*$numSuppliers;
$departments=array();
$suppliers=array();
$actualProfit=array();

//Supply and Demand Arrays
$demand=array();
for($i=0;$i<$numDepartments;$i++){
	$demand["D-$i"]=rand(150,300);
}
//print_r($demand);

$supply=array();
for($i=0;$i<$numSuppliers;$i++){
	$supply["S-$i"]=rand(200,600);
}
//print_r($supply);

//create Suppliers and departments Array
$departments=array();
$suppliers=array();

for($i=0;$i<($numDepartments);$i++){
	$departments[]="D-$i";
}
for($i=0;$i<($numSuppliers);$i++){
	$suppliers[]="S-$i";
}
//Create Decision Variable to use for random Cost generation
$dvariable=array();
foreach($suppliers as $s){
	foreach($departments as $d){
		$dvariable[]="{$s}_{$d}";
	}
}

//Create Random Profit
$profit=array();
foreach($demand as $key=>$d){
	$profit[$key]=rand(10,50);
}

//print_r($profit);

//create cost based off dVariable
$cost=array();
foreach($dvariable as $key=>$dv){
	$cost[$dv]=rand(2,8);
}
//print_r($cost);

//Create Actual Profit Array

$actualProfit1=array();
foreach($departments as $d){
	$v=$profit[$d];
	foreach($suppliers as $s){
		$actualProfit1["{$s}_{$d}"]=$v-$cost["{$s}_{$d}"];
	}
}

//print_r($dvariable);

//--------------------------------------------------------------------------
//Create OSIL file

$os=new WEBIS\OS;

foreach($dvariable as $dv){
	$v=$os->addVariable("$dv");
	$os->addObjCoef("$dv", $actualProfit1[$dv]);
}
//Create Demand Constraints
foreach($departments as $d){
	$os->addConstraint(NULL,$demand[$d]);
	foreach($suppliers as $s){
		$os->addConstraintCoef("{$s}_{$d}",1);
	}
}
//Create Supply Constraints

foreach($suppliers as $s){
	$os->addConstraint($supply[$s],NULL);
	foreach($departments as $d){
		$os->addConstraintCoef("{$s}_{$d}",1);
		}
	}
	//print_r($os);
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
<h3> J.D.Stumpf-------Jdspn6  </h3>
<h1>Decision Support Systems IMSE 7420 Final (E1)</h1>
<h2> Supply Data</h2>
<table border='1'>
<tr><td>Supplier</td>
<?php 
foreach ($suppliers as $s){
	echo"<td>$s</td>";
	}
echo"<tr><td>Supply</td>";
foreach($supply as $s){
	echo"<td>$s</td>";
	}
echo"<tr>";
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
foreach($demand as $d){
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
foreach($profit as $p){
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
foreach($actualProfit1 as $p){
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
	echo "<tr><td>$d</td>";
	foreach($suppliers as $s){
		echo "<td>".$os->getVariable("{$s}_{$d}")."</td>";
	}
}
?>
</table>
<br>
<a href="127.0.0.1:8000/">Back to Index Page</a> 
</body>
</html>
<?php 
}
echo solveRandom();
?>


