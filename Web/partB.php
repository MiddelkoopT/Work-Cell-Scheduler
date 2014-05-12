
<?php

//Exam part B IMSE 7420
// a) Model and solve the following problem as a linear program using PHP and os.php
require_once 'Work-Cell-Scheduler/WCS/os.php';

//------------------------------------------------------------------------------
//Number of Stores and Suppliers
$numDepartments=5;
$numSuppliers=4;
$numCostIndexes=$numDepartments*$numSuppliers;

$sumOne=0;
$sumTwo=0;
$sumThree=0;
$sumFour=0;

$departments=array();
$suppliers=array();

for($i=0;$i<($numDepartments);$i++){
	$departments[]="D-$i";
}
for($i=0;$i<($numSuppliers);$i++){
	$suppliers[]="S-$i";
}
print_r($departments);
print_r($suppliers);

//Supply and Demand Arrays
$capacity=array(600,300,200,500);
$demand=array(600,200,300,100,300);
$profitDisplay=array(20,30,40,25,25);
$profit=array(20,30,40,25,25,20,30,40,25,25,20,30,40,25,25,20,30,40,25,25);
$cost=array(2,3,3,3,3,5,2,4,4,2,3,2,2,2,2,3,2,4,2,2);
$actualProfit=array();
$productionCost=array(10,14,40,11,10,14,40,11,10,14,40,11,10,14,40,11,10,14,40,11);
$supplyMin=array(100,100,100,100);

//Create Actual Profit Array
foreach ($cost as $key => $value) {
	$actualProfit[$key] = $profit[$key] - $cost[$key]-$productionCost[$key];
}
echo"\n";
echo "ActualProfit";
print_r($actualProfit);

$actualProfit1=array();
foreach($suppliers as $key=>$s){
	foreach($departments as $key=>$d){
		$actualProfit1["{$s}_{$d}"] = $actualProfit[$key];
	}
}
print_r($actualProfit1);

//Create Indexed Array for Supply Capacity
$supplyVal=array();
for($i=0;$i<($numSuppliers);$i++){
	$supplyVal["S-$i"]=$capacity[$i];
}
echo "SupplyVal";
print_r($supplyVal);

//Created Indexed Array for Store Demand
$demandVal=array();
for($i=0;$i<($numDepartments);$i++){
	$demandVal["D-$i"]=$demand[$i];
}
//echo "demandVal";
//print_r($demandVal);

//Create Decision Variable
$dvariable=array();
foreach($suppliers as $s){
	foreach($departments as $d){
		$dvariable[]="{$s}_{$d}";
	}
}
print_r($dvariable);

//--------------------------------------------------------------------------
//Create OSIL file

$os=new WEBIS\OS;

foreach($dvariable as $dv){
	$v=$os->addVariable("$dv");
	$os->addObjCoef("$dv", $actualProfit1[$dv]);
}
print_r($dvariable);
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
//print_r($os);
//Create minimum 100 constraint
foreach($suppliers as $s){
	$os->addConstraint(NULL,$supplyMin[$s]);
	foreach($departments as $d){
		$os->addConstraintCoef("{$s}_{$d}",1);
	}
}
?>

<?php
	$sumOne=$os->getVariable("S-0_D-0");
	$sumOne=$sumOne+$os->getVariable("S-0_D-1");
	$sumOne=$sumOne+ $os->getVariable("S-0_D-1");

echo"Print SumOne";
echo $sumOne;


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
<br>
<h2>Revenues</h2>
<table border='1'>
<tr><th>Supplier</th>
<?php 
foreach($suppliers as $s){
	echo "<td>$s </td>";
		}
?>

<tr><td>Revenues </td>

</table>

<a href="127.0.0.1:8000/Work-Cell-Scheduler/Web/">Back to Index Page</a> 
</body>
</html>









