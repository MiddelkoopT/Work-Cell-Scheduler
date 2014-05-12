<?php

Require_once 'Work-Cell-Scheduler/WCS/os.php';

$NumSuppliers=5;
$NumDepts=5;

function SolveRdmTransportation($NumSuppliers,$NumDepts){

//capacity
$capacity=array();
for($i=0;$i<$NumSuppliers;$i++){
	$capacity["S{$i}"]=rand(200,800);
}
$totalcapacity=array_sum($capacity);
//print_r($capacity);
$demand=array();
for($i=0;$i<$NumDepts;$i++){
	$demand["D{$i}"]=rand(200,800);
}
$totaldemand=array_sum($demand);
//print_r($demand);


$dprofit=array();
foreach($demand as $key => $value){
	$dprofit[$key]=rand(20,40);	
}
//print_r($dprofit);

//total profit = profit - cost of transportation (distance)
$distance=array();
$tprofit=array();
foreach($capacity as $key => $value){
	foreach($dprofit as $k => $v){
		$newkey="{$key},{$k}";
		//print_r($distance[$newkey]);
		$distance[$newkey]=rand(1,9);
		if (isset($distance[$newkey])) {
			$tprofit[$newkey]= $v - $distance[$newkey];
		}
		else {
			$tprofit[$newkey]= $v;
		}
	}
}
//print_r($distance);
//print_r($tprofit);

$os=New WebIS\OS;

//OF

foreach($tprofit as $key => $value){
	$os->addVariable($key);
	$os->addObjCoef($key,$value);
}
//print_r($os);

//constraints

foreach($capacity as $key=>$value){
	$os->addConstraint($value,NULL);
	foreach($demand as $k=>$v){
		$newkey="{$key},{$k}";
		//print_r($newkey);
		$os->addConstraintCoef($newkey,1);
	}
}
/**
foreach($demand as $key=>$value){
	$os->addConstraint(NULL,$value);
	foreach($capacity as $k=>$v){
		$newkey="{$k},{$key}";
		//print_r($newkey);
		$os->addConstraintCoef($newkey,1);
	}
}
*/
if($totaldemand<=$totalcapacity){
	foreach ($demand as $key => $value){
		$os->addConstraint(NULL,$value);
		foreach ($capacity as $k => $v){
			$newkey="{$k},{$key}";
			$os->addConstraintCoef($newkey,1);
		}
	}
}
if($totaldemand>$totalcapacity){
	foreach ($demand as $key => $value){
		$os->addConstraint($value,NULL);
		foreach ($capacity as $k => $v){
			$newkey="{$k},{$key}";
			$os->addConstraintCoef($newkey,1);
		}
	}
}

$os->solve();
//print_r($os);

$solutions=$os->value;
$objval=(double)$os->osrl->optimization->solution->objectives->values->obj;
//Tables
echo "<html><h2>Lance Markert, LRMR47</h2>";
if($totaldemand>$totalcapacity){
	echo "<h3><font color='red'>Problem and Solution Shown Below:<br>Warning: Not all demand can be satisfied</font></h3>";
}   else
{echo "<h3>Problem and Solution Shown Below</h3>";
}
	
//echo "<br>";
//Table for suppliers
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Suppliers</th>
	  <th>Capacity</th></tr>";
foreach ($capacity as $key=>$value){
	echo "<tr><td><b>$key</td>
		  <td>$value</td></tr>";
}
echo "</table>";

//Table for departments
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Departments</th>
	  <th>Demand</th>
	  <th>Profit</th></tr>";
foreach ($demand as $key=>$value){
	echo "<tr><td><b>$key</td>
		  <td>$value</td>
		  <td>$dprofit[$key]</td></tr>";
}
echo "</table>";
echo "Total Supply=$totalcapacity<br>Total Demand=$totaldemand<br>";

//Table for distances
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Distances</th>";
foreach ($capacity as $key=>$value){
	echo "<th>$key</th>";
}
foreach ($demand as $key=>$value){
	echo "<tr><td><b>$key</td>";
	foreach ($capacity as $k=>$v){
		$newkey="${k},${key}";
		//print_r($newkey);
		$val=$distance[$newkey];
		$val=round($val,0);
		echo "<td>$val</td>";
	}
	echo "</tr>";
}

echo "</table>";

//Table for profit
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Total Profit</th>";
foreach ($capacity as $key=>$value){
	echo "<th>$key</th>";
}
foreach ($demand as $key=>$value){
	echo "<tr><td><b>$key</td>";
	foreach ($capacity as $k=>$v){
		$newkey="${k},${key}";
		//print_r($newkey);
		$val=$tprofit[$newkey];
		$val=round($val,0);
		echo "<td>$val</td>";
	}
	echo "</tr>";
}
echo "</table>";
echo "<font size='5'><b>Solution:</font>";
//Table for transportation assignments
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Assignments</th>";
foreach ($capacity as $key=>$value){
	echo "<th>$key</th>";
}
foreach ($demand as $key=>$value){
	echo "<tr><td><b>$key</td>";
	foreach ($capacity as $k=>$v){
		$newkey="${k},${key}";
		$assign=$solutions[$newkey];
		$assign=round($assign,0);
		echo "<td>$assign</td>";
	}
	echo "</tr>";
}
echo "</table>";
echo "<font size='5'><b>Objective Function Value = $objval</font>";
echo "</body>";
}
?>