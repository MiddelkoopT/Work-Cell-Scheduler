<?php

echo "IMSE 4420 Final - Part A\n";

require_once 'Work-Cell-Scheduler/WCS/os.php';

//$supplier =array('S1'=>600,'S2'=>300,'S3'=>200);
//$department=array('D1'=>600,'D2'=>200,'D3'=>300);
//$dprofit=array('profit-1'=>20,'profit-2'=>30,'profit-3'=>40);

$supplier = array ();
$numSupplier = 3;
for($i = 1; $i <= $numSupplier; $i ++) {
	$supplier [] = "S" . $i;
}

$numDepart = 3;
for($i = 1; $i <= $numDepart; $i ++) {
	$department [] = "D" . $i;
}

$numProfit=3;
for ($i=1; $i<=$numProfit; $i++) {
$dprofit[]="profit-".$i;
}

//print_r($supplier)."\n";
//print_r($department)."\n";

$distance = array (
		'D1_S1' => 2,
		'D1_S2' => 5,
		'D1_S3' => 3,
		'D2_S1' => 3,
		'D2_S2' => 2,
		'D2_S3' => 2,
		'D3_S1' => 3,
		'D3_S2' => 4,
		'D3_S3' => 8 
);

// print_r($distance);

$capacity = array (0,600,300,200);
$demand = array (0,600,200,300);
$dProfit = array ('D1' => 20,'D2' => 30,'D3' => 40 );
$realProfit = array ();
// print_r($dProfit);

foreach ( $supplier as $key => $value ) {
	foreach ( $dProfit as $k => $v ) {
		$newkey = "{$k}_{$value}";
		$realProfit [$newkey] = $v - $distance [$newkey];
	}
}
// print_r($realProfit);

// create supply capacity
$supplyVar = array ();
for($i = 1; $i <= $numSupplier; $i ++) {
	$supplyVar ["S$i"] = $capacity [$i];
}
// print_r($supplyVar);

// create department demand
$demandVar = array ();
for($i = 1; $i <= $numDepart; $i ++) {
	$demandVar ["D$i"] = $demand [$i];
}
// print_r($demandVar);

// create decision variable
$decVar = array ();
foreach ( $supplier as $s ) {
	foreach ( $department as $d ) {
		$decVar [] = "{$s}_{$d}";
	}
}
// print_r($decVar);

// create OSIL

$os = new \WebIS\OS ();

foreach ( $realProfit as $key => $value ) {
	$os->addVariable ( $key );
	$os->addObjCoef ( $key, $value );
}

// create supply constraint
//foreach ( $supplier as $s ) {
	//$os->addConstraint ( $supplyVar [$s], NULL );
	//foreach ( $department as $d ) {
		//$os->addConstraintCoef ( "{$s}_{$d}", 1 );
	//}
//}

// create demand constraint
//foreach ( $department as $d ) {
	//$os->addConstraint ( NULL, $demandVar [$d] );
	//foreach ( $supplier as $s ) {
		//$os->addConstraintCoef ( "{$s}_{$d}", 1 );
	//}
//}

print_r ( $os );

?>