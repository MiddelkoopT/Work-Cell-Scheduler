<?php

//Exam part B IMSE 4420
// b) Model and solve the following problem with random suppliers, capacity, departments, demand, profit, and distance

//------------------------------------------------------------------------------
require_once 'Work-Cell-Scheduler/WCS/os.php';


//Number of Stores and Suppliers
$numDepartments=rand(3,6);
$numSuppliers=rand(3,6);
//$numCostIndexes=$numDepartments*$numSuppliers;
$departments=array();
$suppliers=array();
$aProfit=array();

//Supply and Demand Arrays
$demand=array();
for($i=0;$i<$numDepartments;$i++){
	$demand["D-$i"]=rand(100,500);
}
print_r($demand);

$supply=array();
for($i=0;$i<$numSuppliers;$i++){
	$supply["S-$i"]=rand(100,600);
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
	$profit[$key]=rand(10,70);
}

print_r($profit);

//create cost based off dVariable
$cost=array();
foreach($dvariable as $key=>$dv){
	$cost[$dv]=rand(5,7);
}
print_r($cost);

//Create Actual Profit Array

$aProfit1=array();
foreach($departments as $d){
	$v=$profit[$d];
	foreach($suppliers as $s){
		$aProfit1["{$s}_{$d}"]=$v-$cost["{$s}_{$d}"];
	}
}
//print_r($actualProfit1);




//print_r($dvariable);

//--------------------------------------------------------------------------
//Create OSIL file

$os=new WEBIS\OS;

foreach($dvariable as $dv){
	$v=$os->addVariable("$dv");
	$os->addObjCoef("$dv", $aProfit1[$dv]);
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
</head>
<body>
<h1> Caleb Boyer  -  CLB5X7 </h1>

<table border='1'>
<tr><td>Objective Value</td></tr>
<?php 
$objvalue=$os->solve();
echo "<tr><td>$objvalue</td><td>"
?>
</table>

<h4> Shipping Values</h4>

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
</body>
</html>
