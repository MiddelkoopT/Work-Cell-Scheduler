<?php

require_once 'Work-Cell-Scheduler/WCS/os.php';

//define departments
$department=array();
$numDep=rand(5,10);
for($i=0;$i<$numDep;$i++){
	$department[]="D$i";
}
//print_r($department);

//define suppliers
$supplier=array();
$numSup=rand(5,10);
for($i=0;$i<$numSup;$i++){
	$supplier[]="S$i";
}
//print_r($supplier)

// define demand
$demand=array();
for($i=0;$i<$numDep;$i++){
	$demand["D$i"]=rand(20,1000);
}
//print_r($demand);

// define supply
$supply=array();
for($i=0;$i<$numSup;$i++){
	$supply["S$i"]=rand(50,800);
}
//print_r($supply);

// define decision variable
$decVar=array();
foreach($supplier as $s){
	foreach($department as $d){
		$decVar[]="{$s}_{$d}";
	}
}

// define profit
$profit=array();
foreach($demand as $key=>$d){
	$profit[$key]=rand(5,50);
}
//print_r($profit)

// create cost / distance 
$cost=array();
foreach($decVar as $key => $var){
	$cost[$var]=rand(2,10);
}
//print_r($cost)

// create real profit 
$realProfit=array();
foreach($department as $d){
	$value=$profit[$d];
	foreach ($supplier as $s){
		$realProfit["{$s}_{$d}"]=$value-$cost["{$s}_{$d}"];
	}
}
print_r($realProfit);

// create OSIL file

$os=new \WebIS\OS;

foreach ( $realProfit as $key => $value ) {
	$os->addVariable ( $key );
	$os->addObjCoef ( $key, $value );
}

$os -> solve();
print_r($os);



?>