<?php

//Exam part B IMSE 4420
// a) Model and solve the problem as a LP using PHP and os solver.php
require_once 'Work-Cell-Scheduler/WCS/os.php';

//------------------------------------------------------------------------------
//Create Stores and Suppliers
$numDepartments=5;
$numSuppliers=5;
$plantCost=4;
$numCostIndexes=$numDepartments*$numSuppliers;

$suppliers=array();
$departments=array();
$plantCost=array();

for($i=0;$i<($numSuppliers);$i++){
	$suppliers[]="S-$i";
}
for($i=0;$i<($numDepartments);$i++){
	$departments[]="D-$i";
}
print_r($departments);
print_r($suppliers);

//Create Supply and Demand Arrays
$capacity=array(600,300,200,500);
$demand=array(600,200,300,100,300);
$profitDisplay=array(20,30,40,25);
$profit=array(20,30,40,25,20,30,40,25,20,30,40,25);
$cost=array(2,3,3,5,2,4,3,3,8);
$plantCost=array(10,14,40,11);
$aProfit=array();

//Create Actual Profit Array
foreach ($cost as $key => $value) {
	foreach($plantCost as $key => $value)
	$aProfit[$key] = $profit[$key] - $cost[$key] - $plantCost[$key];
}
echo"\n";
//echo "aProfit";
//print_r($aProfit);

$aProfit1=array();
foreach($suppliers as $key=>$s){
	foreach($departments as $key=>$d){
		foreach($plantCost as $key=>$c){
		$aProfit1["{$s}_{$d}_{$c}"] = $aProfit[$key];
		}
	}
}
print_r($aProfit1);

//Create Indexed Array for Supply Capacity
$supplyVal=array();
for($i=0;$i<($numSuppliers);$i++){
	$supplyVal["S-$i"]=$capacity[$i];
}
//print_r($supplyVal);

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
		$dvariable[]="{$s}_{$d}_{$c}";
	}
}
//print_r($dvariable);

//Create OSIL file

$os=new WEBIS\OS;

foreach($dvariable as $dv){
	$v=$os->addVariable("$dv");
	$os->addObjCoef("$dv", $aProfit1[$dv]);
}

//Create Demand Constraints
foreach($departments as $d){
	$os->addConstraint(NULL,$demandVal[$d]);
	foreach($suppliers as $s){
		$os->addConstraintCoef("{$s}_{$d}_{$c}",1);
	}
}

//Create Supply Constraints

foreach($suppliers as $s){
	$os->addConstraint($supplyVal[$s],NULL);
	foreach($departments as $d){
		$os->addConstraintCoef("{$s}_{$d}_{$c}",1);
	}
}

//Create Plant
//print_r($os);


?>

<?php
//Create the HTML File
//---------------------------------------------------------------
?>
<html>
<meta charset="UTF-8">
<title>Decision Support Systems IMSE 4420 Final</title>
</head>
<body>
<h1> Caleb Boyer  -  CLB5X7  </h1>
<?php
foreach($suppliers as $s){
echo "<th>$s\n";
}
?>


<h3>Optimized Solution</h3>

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
echo "<tr><th>$d</th>";
foreach($suppliers as $s){
echo "<tr><th>$s</th>";{
foreach($demand as $c);{
echo"<tr><th>$c</th>";
echo "<td>".$os->getVariable("{$s}_{$d}_{$c}")."</td>";
echo "\n";
}
}
}
}
?>
</table>
<br>
</body>
</html>