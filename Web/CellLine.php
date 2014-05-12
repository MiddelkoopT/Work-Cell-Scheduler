<?php

require_once 'Work-Cell-Scheduler/WCS/os.php';

//function solve($NumberofWorkers,$NumberofCells,$NumberofProducts,$NumberProductsProduced,$workerhourlimit){
	
function ContainsString($needle,$haystack){
	if (strpos($haystack,$needle)===FALSE){
		return FALSE;
	}
	return TRUE;
}

$NumberofWorkers=5;
$NumberofCells=4;
$NumberofProducts=6;
$NumberProductsProduced=11;
$workerhourlimit=8;

function assertEquals($expected,$result) {
	if(!($expected===$result)){
		$message="assertEquasl: |$expected|$result|\n";
		throw new Exception($message);
	}
}

function assertNotEquals($expected,$result) {
	if(($expected===$result)){
		$message="assertNoeEquasl: |$expected|$result|\n";
		throw new Exception($message);
	}
}

//Create Arrays
$worker=array();
for($i=0; $i<$NumberofWorkers; $i++) {
	$worker[]="Worker $i";
}

//print_r($worker);

$cell=array();
for($j=0; $j<$NumberofCells; $j++){
	$cell[]="Cell $j";
}

//print_r($cell);

$product=array();
for($k=0; $k<$NumberofProducts; $k++){
	$product[]="Product $k";
}

//print_r($product);

$randomworker=array_rand($worker,1);
//print_r($randomworker);


//Create Demand

$demand=array();

class Demand{
	public $cell, $product, $hour;
	function __construct($c,$p,$h) {
		$this->cell=$c;
		$this->product=$p;
		$this->hour=$h;
	}
}
for ($i=0; $i<$NumberProductsProduced; $i++){
	$curc=$cell[rand(0,($NumberofCells-1))];
	$curp=$product[rand(0,($NumberofProducts-1))];
	$demand[]=new Demand("$curc","$curp",rand(1,3));
}

//print_r($demand);

//Pull Demand
$cellhours=array();
foreach ($cell as $c){
	$cellhrs[$c]=0.0;
}
foreach ($demand as $d){
	if (array_key_exists($d->cell, $cellhrs)){
		$currcellhrs=$cellhrs[$d->cell];
		$cellhrs[$d->cell]=($currcellhrs + $d->hour);
	}
}
//print_r($cellhrs);

//Pull D (products & cells)
$prodcells=array();
foreach ($product as $p){
	$prodcells[$p]="";
}
foreach ($demand as $d){
	if (array_key_exists($d->product,$prodcells)){
		$currprodcells=$prodcells[$d->product];
		$prodcells[$d->product]=($currprodcells .= $d->cell);
	}
}
//print_r($prodcells);

//Create training matrix

$trainingmatrix = array ();

foreach ( $worker as $w ) {
	$w = $w;
	foreach ( $cell as $c ) {
		$p = rand ( 80, 100 ) / 100.0;
		$trainingmatrix["${w}_${c}"] = $p;
	}
}
//print_r($trainingmatrix);


function getWorkerProd($w,$c,$arraymatrix){
	$thiskey="${w}_${c}";
	if(array_key_exists($thiskey,$arraymatrix)) {
		return $arraymatrix[$thiskey];
	}
	else {
		return 0.85;
	}
}

//$productivity=getWorkerProd("Worker 1", "Cell 1",$trainingmatrix);
//echo "Worker 1_Cell 1 Productivity \n";
//print_r($productivity);
//echo "\n";


//Array for product values for each cell
$cellprod=array();
foreach($cell as $c){
	$cellprod[$c]="";
}
foreach($prodcells as $pc=>$cv){
	foreach($cellprod as $cp=>$pv){
		if (ContainsString($cp,$cv)==TRUE){
			echo "$pc \n";
			$currprodnumval="";
			for ($i=0; $i<$NumberProductsProduced; $i++){
				if(ContainsString("$i",$pc)==TRUE){
					$currprodnumval="$i";
				}
			}
			if ($cellprod[$cp]===""){
				$cellprod[$cp]=$currprodnumval;
			}
			else{
				$cellprod[$cp] .= " , $currprodnumval";
			}
		}
	}
}
//TDD
//print_r(array_keys($trainingmatrix));

//assert(array_key_exists('worker-1_cell-1', $trainingmatrix));

//Optimization
/**
 $os=New WebIS\OS;
 $os->addVariable('x11');
 $os->addObjCoef('x11','3');
 $os->addVariable('x12');
 $os->addObjCoef('x12','2');
 $os->addVariable('x21');
 $os->addObjCoef('x21','1');
 $os->addVariable('x22');
 $os->addObjCoef('x22','5');
 $os->addVariable('x31');
 $os->addObjCoef('x31','5');
 $os->addVariable('x32');
 $os->addObjCoef('x32','4');

 //contraints
 $os->addConstraint($ub=45);
 $os->addConstraintCoef('x11',1);
 $os->addConstraintCoef('x12',1);

 $os->addConstraint($ub=60);
 $os->addConstraintCoef('x21',1);
 $os->addConstraintCoef('x22',1);

 $os->addConstraint($ub=35);
 $os->addConstraintCoef('x31',1);
 $os->addConstraintCoef('x32',1);

 $os->addConstraint($lb=50);
 $os->addConstraintCoef('x11',1);
 $os->addConstraintCoef('x21',1);
 $os->addConstraintCoef('x31',1);

 $os->addConstraint($lb=60);
 $os->addConstraintCoef('x12',1);
 $os->addConstraintCoef('x22',1);
 $os->addConstraintCoef('x32',1);

 //Solve world hunger!
 $os->solve();
 */
 
 //print_r($os);


//OF
$os=New WebIS\OS;

$decvars=array();
foreach ($worker as $w){
	foreach ($cell as $c){
		$deckey="${w}_${c}";
		$decvars[$deckey]=0.0;
	}
}

//print_r($decvars);

//variables
foreach ($worker as $w){
	foreach ($cell as $c){
		$currkey="{$w}_{$c}";
		//print_r($currkey);
		$os->addVariable($currkey);
		$os->addObjCoef($currkey, 1);
	}
}

//constraints
foreach ($cellhrs as $c=>$v){
	$os->addConstraint(NULL,$v);
	foreach($worker as $w){
		$currkey="${w}_${c}";
		$conprod=getWorkerProd($w,$c,$trainingmatrix);
		$os->addConstraintCoef($currkey,$conprod);
	}
}
foreach ($worker as $w){
	$os->addConstraint($workerhourlimit,NULL);
	foreach($cell as $c){
		$currkey="${w}_${c}";
		$os->addConstraintCoef($currkey,1);
	}
}

//Solve
$os->Solve();
print_r($os);

$solutions=$os->value;
echo "\n";
//print_r($solutions);

//Tables for days
echo "<html><Head><Title>WebIS Optimization</Title></Head></body>";
//echo "Productivity Table \n";
echo "<table border='1' cellpadding='10'>";
echo "<th>Productivity";

foreach ($cell as $c){
	echo "<td>$c</td>";
}

foreach ($worker as $w){
	echo "<tr><td>$w</td>";
	foreach ($cell as $c){
		$WrkProd=getWorkerProd($w, $c, $trainingmatrix);
		echo "<td>$WrkProd</td>";
	}
	echo "</tr>";
}
echo "</table> \n";


//products made in each cell table
echo "\nProducts Made in Each Cell";
echo "<table border='1' cellpadding='10'>";
echo "<td></td>";
foreach ($cell as $c){
	echo"<td>$c</td>";
}
foreach ($worker as $w){
	echo "<tr><td>$w</td>";
	foreach ($cell as $c){
		$currkey="${w}_${c}";
		$hrsolns=$solutions[$currkey];
		if ($hrsolns>0){
			$prodtocell="$cellprod[$c]";
			echo "<td>$prodtocell</td>";
			}
		else{
			echo "<td>   </td>";
		}
	}
	echo "</t>";
}
echo "</table>";

//Hours worked in each cell table

echo "Worker assignments to cells in hours";
echo "<table border='1' cellpadding='10'>";
echo "<td></td>";
foreach ($cell as $c){
	echo "<td>$c</td>";
}
foreach ($worker as $w){
	echo "<tr><td>$w</td>";
	foreach ($cell as $c){
		$currkey="${w}_${c}";
		$assign=$solutions[$currkey];
		$assign=round($assign,2);
		echo "<td>$assign</td>";
	}
	echo "</tr>";
}

echo "</table>";
echo "</body>";

//}
?>

