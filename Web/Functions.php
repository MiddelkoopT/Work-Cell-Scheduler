<?php

class TotalInfo{
	public $supplier;
	public $department;
	public $solutionvalue;
	public $solutionarray;
	public $capacity;
	public $demand;
	public $routingmatrix;
	public $arrayprofit;
	public $arraycost;
	public $arrayprodcost;
	
}

function getMatrixValue($row, $col, $arraymatrix) {
	$thiskey = "{$row}_{$col}";
	if (array_key_exists ( $thiskey, $arraymatrix )) {
		return $arraymatrix [$thiskey];
	} else {
		return "no value";
	}
}
// how to pull productivity
// $productivity=getWorkerProd("Worker 1", "Cell 1",$trainingmatrix);
// echo "Worker 1_Cell 1 Productivity \n";
// print_r($productivity);
// echo "\n";

function RandomlySolveRoutingProblemNew($numsuppliers, $numdepartments) {
	$supplier = array ();
	$department = array ();

	// make workers, cells, products
	for($i = 1; $i <= $numsuppliers; $i ++) {
		$supplier [] = "Supplier $i";
	}
	for($i = 1; $i <= $numdepartments; $i ++) {
		$department [] = "Department $i";
	}

	$capacity = array();
	foreach ($supplier as $s){
		$randnum=rand(500,900);
		$capacity[$s]=$randnum;
	}

	$demand = array ();

	foreach ($department as $d){
		$randnum=rand(250,650);
		$demand [$d] = $randnum;
	}

	$sumcapacity=0.0;
	$sumdemand=0.0;
	
	foreach ($capacity as $s=>$v){
		$sumcapacity=$sumcapacity+$v;
	}
	
	foreach ($demand as $d=>$v){
		$sumdemand=$sumdemand+$v;
	}

	// assign productivity
	$routingmatrix=array();
	foreach ( $supplier as $s ) {
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$routingmatrix[$thiscurrkey]=0.0;
		}
	}

	$arrayprofit=array();
	foreach ($routingmatrix as $sd=>$v){
		$randnum=rand(15,50);
		$arrayprofit[$sd]=$randnum;
	}

	$arraycost=array();
	foreach ($routingmatrix as $sd=>$v){
		$randnum=rand(3,12);
		$arraycost[$sd]=$randnum;
	}

	$numroutes=($numsuppliers*$numdepartments);
	foreach ($routingmatrix as $sd=>$v){
		$routingmatrix [$sd] = ($arrayprofit[$sd]-$arraycost[$sd]);
	}

	// Solver
	$os = new WebIS\OS ();

	// Add variables
	foreach ( $supplier as $s ) {
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$os->addVariable ( $thiscurrkey );
			$os->addObjCoef ( $thiscurrkey, getMatrixValue($s, $d, $routingmatrix) );
		}
	}

	// add constraints to stay within capacity
	foreach ( $capacity as $s => $v ) {
		$os->addConstraint ( $v );
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$os->addConstraintCoef ( $thiscurrkey, 1 );
		}
	}

	echo "Sum Capacity: $sumcapacity <br><br>";
	echo "Sum Demand: $sumdemand <br><br>";
	if ($sumdemand>$sumcapacity){
		echo "WARNING: Demand is Greater Than Capacity<br><br>";
	}
	
	// add constraint to meet demand

	foreach ( $demand as $d => $v ) {
		$os->addConstraint ( $v );
		foreach ( $supplier as $s ) {
			$thiscurrkey = "{$s}_{$d}";
			$os->addConstraintCoef ( $thiscurrkey, 1 );
		}
	}


	// Sovle
	$os->solve ();

	//print_r($os);
	$solutionarray = $os->value;
	$solutionvalue = $os->osrl->optimization->solution->objectives->values->obj;
	settype($solutionvalue,"double");

	$p = new TotalInfo();
	$p->supplier = $supplier;
	$p->department = $department;
	$p->solutionvalue = $solutionvalue;
	$p->solutionarray = $solutionarray;
	$p->capacity=$capacity;
	$p->demand=$demand;
	$p->routingmatrix=$routingmatrix;
	$p->arrayprofit=$arrayprofit;
	$p->arraycost=$arraycost;
	return $p;

}



function RandomlySolveRoutingProblem($numsupanddept) {
	$supplier = array ();
	$department = array ();

	// make workers, cells, products
	for($i = 1; $i <= $numsupanddept; $i ++) {
		$supplier [] = "Supplier $i";
	}
	for($i = 1; $i <= $numsupanddept; $i ++) {
		$department [] = "Department $i";
	}

	$capacity = array();
	foreach ($supplier as $s){
		$randnum=rand(100,900);
		$capacity[$s]=$randnum;
	}
	
	$mixedup=array();
	foreach ($capacity as $s=>$v){
		$mixedup[]=$v;
	}
	shuffle($mixedup);
	
	$demand = array ();

	$counter=0;
	foreach ($department as $d){
		$demand [$d] = $mixedup[$counter];
		$counter=$counter+1;
	}

	$sumcapacity=0.0;
	$sumdemand=0.0;
	
	foreach ($capacity as $s=>$v){
		$sumcapacity=$sumcapacity+$v;
	}
	
	foreach ($demand as $d=>$v){
		$sumdemand=$sumdemand+$v;
	}
	
	echo "Sum Capacity: $sumcapacity <br><br>";
	echo "Sum Demand: $sumdemand <br><br>";
	if ($sumdemand>$sumcapacity){
	echo "WARNING: Demand is Greater Than Capacity<br><br>";
	}
	
	// assign productivity
	$routingmatrix=array();
	foreach ( $supplier as $s ) {
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$routingmatrix[$thiscurrkey]=0.0;
		}
	}

	$arrayprofit=array();
	foreach ($routingmatrix as $sd=>$v){
		$randnum=rand(15,50);
		$arrayprofit[$sd]=$randnum;
	}
	
	$arraycost=array();
	foreach ($routingmatrix as $sd=>$v){
		$randnum=rand(3,12);
		$arraycost[$sd]=$randnum;
	}
	
	$numroutes=($numsupanddept*$numsupanddept);
	foreach ($routingmatrix as $sd=>$v){
		$routingmatrix [$sd] = ($arrayprofit[$sd]-$arraycost[$sd]);
	}

// Solver
	$os = new WebIS\OS ();

	// Add variables
	foreach ( $supplier as $s ) {
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$os->addVariable ( $thiscurrkey );
			$os->addObjCoef ( $thiscurrkey, getMatrixValue($s, $d, $routingmatrix) );
		}
	}

	// add constraints to stay within capacity
	foreach ( $capacity as $s => $v ) {
		$os->addConstraint ( $v );
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$os->addConstraintCoef ( $thiscurrkey, 1 );
		}
	}

	// add constraint to meet demand

	foreach ( $demand as $d => $v ) {
		$os->addConstraint ( NULL, $v );
		foreach ( $supplier as $s ) {
			$thiscurrkey = "{$s}_{$d}";
			$os->addConstraintCoef ( $thiscurrkey, 1 );
		}
	}
	

	// Sovle
	$os->solve ();

	//print_r($os);
	$solutionarray = $os->value;
	$solutionvalue = $os->osrl->optimization->solution->objectives->values->obj;
	settype($solutionvalue,"double");

	$p = new TotalInfo();
	$p->supplier = $supplier;
	$p->department = $department;
	$p->solutionvalue = $solutionvalue;
	$p->solutionarray = $solutionarray;
	$p->capacity=$capacity;
	$p->demand=$demand;
	$p->routingmatrix=$routingmatrix;
	$p->arrayprofit=$arrayprofit;
	$p->arraycost=$arraycost;
	return $p;
	
}
	
//BREAK----------------------------------------------------
//Making Tables

Function MakeOutputTable ($p){

	$supplier = $p->supplier;
	$department = $p->department;
	$solutionvalue = $p->solutionvalue;
	$solutionarray = $p->solutionarray;
		
	// Start HTML
	echo "<br><br>";
	echo "Objective Function Value of $solutionvalue <br>";
	echo "<table border='1' cellpadding='10'>";
	
	echo "<td>Shipping</td>";
	foreach ( $department as $d ) {
		echo "<td>$d</td>";
	}
	foreach ( $supplier as $s ) {
		echo "<tr><td>$s</td>";
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$classicpooval = $solutionarray [$thiscurrkey];
			$classicpooval = round ( $classicpooval, 0 );
			echo "<td>$classicpooval</td>";
		}
		echo "</tr>";
	}

	echo "</table>";
	
}

Function MakeCapacityTable ($p){

	$capacity = $p->capacity;
	
	// Start HTML
	
	echo "<table border='1' cellpadding='10'>";
	// do a foreach for all the cells and workers
	echo "<td></td>";
	echo "<td>Capacity</td>";
	foreach ( $capacity as $s => $v) {
		echo "<tr><td>$s</td>";
		echo "<td>$v</td>";
		echo "</tr>";
	}

	echo "</table>";
	
}

Function MakeDemandTable ($p){

	$demand = $p->demand;

	// Start HTML
	echo "<br><br>";
	echo "<table border='1' cellpadding='10'>";
	// do a foreach for all the cells and workers
	echo "<td></td>";
	echo "<td>Demand</td>";
	foreach ( $demand as $d => $v) {
		echo "<tr><td>$d</td>";
		echo "<td>$v</td>";
		echo "</tr>";
	}

	echo "</table>";
	

}

Function MakeProfitTable ($p){
	
	$supplier = $p->supplier;
	$department = $p->department;
	$arrayprofit = $p->arrayprofit;
	
	// Start HTML
	echo "<br><br>";
	echo "<table border='1' cellpadding='10'>";
		// do a foreach for all the cells and workers
	echo "<td>Profit</td>";
	foreach ( $department as $d ) {
		echo "<td>$d</td>";
	}
	foreach ( $supplier as $s ) {
		echo "<tr><td>$s</td>";
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$classicpooval = $arrayprofit [$thiscurrkey];
			echo "<td>$classicpooval</td>";
		}
		echo "</tr>";
	}
	
	echo "</table>";
	
	
}

Function MakeCostTable ($p){

	$supplier = $p->supplier;
	$department = $p->department;
	$arraycost = $p->arraycost;

	// Start HTML
	echo "<br><br>";
	echo "<table border='1' cellpadding='10'>";
	// do a foreach for all the cells and workers
	echo "<td>Cost</td>";
	foreach ( $department as $d ) {
		echo "<td>$d</td>";
	}
	foreach ( $supplier as $s ) {
		echo "<tr><td>$s</td>";
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$classicpooval = $arraycost [$thiscurrkey];
			echo "<td>$classicpooval</td>";
		}
		echo "</tr>";
	}

	echo "</table>";

}

Function MakeTotalProfitTable ($p){

	$supplier = $p->supplier;
	$department = $p->department;
	$routingmatrix = $p->routingmatrix;

	// Start HTML
	echo "<br><br>";
	echo "<table border='1' cellpadding='10'>";
	// do a foreach for all the cells and workers
	echo "<td>Total Profit</td>";
	foreach ( $department as $d ) {
		echo "<td>$d</td>";
	}
	foreach ( $supplier as $s ) {
		echo "<tr><td>$s</td>";
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$classicpooval = $routingmatrix [$thiscurrkey];
			echo "<td>$classicpooval</td>";
		}
		echo "</tr>";
	}

	echo "</table>";

}

Function MakeProdCostTable ($p){

	$supplier = $p->supplier;
	$department = $p->department;
	$arrayprodcost = $p->arrayprodcost;

	// Start HTML
	echo "<br><br>";
	echo "<table border='1' cellpadding='10'>";
	// do a foreach for all the cells and workers
	echo "<td>Production Cost</td>";
	foreach ( $department as $d ) {
		echo "<td>$d</td>";
	}
	foreach ( $supplier as $s ) {
		echo "<tr><td>$s</td>";
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$classicpooval = $arrayprodcost [$thiscurrkey];
			echo "<td>$classicpooval</td>";
		}
		echo "</tr>";
	}

	echo "</table>";

}

Function MakePlantCostTable ($p){

	$supplier = $p->supplier;
	$department = $p->department;
	$arrayprodcost = $p->arrayprodcost;

	
	$plantcost = array ();
	foreach ( $supplier as $s ) {
		$plantcost [$s] = 0.0;
	}
	foreach ( $arrayprodcost as $sd => $av ) {
		foreach ( $plantcost as $s => $bv ) {
			if (ContainsString ( $s, $sd ) == TRUE) {
				$currplant = $s;
				for($i = 1; $i <= $numprodproduced; $i ++) {
					if (ContainsString ( "$i", $pc ) == TRUE) {
						// echo "toot";
						$currprodnumval = "$i";
					}
				}
				if ($cellprod [$cp] === "") {
					$cellprod [$cp] = "$currprodnumval";
				} else {
					$cellprod [$cp] .= " , $currprodnumval";
				}
			}
		}
	}
	
	
	// Start HTML
	echo "<br><br>";
	echo "<table border='1' cellpadding='10'>";
	// do a foreach for all the cells and workers
	echo "<td>Production Cost</td>";
	foreach ( $department as $d ) {
		echo "<td>$d</td>";
	}
	foreach ( $supplier as $s ) {
		echo "<tr><td>$s</td>";
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$classicpooval = $arrayprodcost [$thiscurrkey];
			echo "<td>$classicpooval</td>";
		}
		echo "</tr>";
	}

	echo "</table>";

}




//BREAK--------------------------------------------------
function SetUpRoutingProblem($numsuppliers, $numdepartments, $arraycapacity, $arraydemand, $arrayprofit, $arraycost, $arrayprodcost) {
	$supplier = array ();
	$department = array ();
	
	// make workers, cells, products
	for($i = 1; $i <= $numsuppliers; $i ++) {
		$supplier [] = "Supplier $i";
	}
	for($i = 1; $i <= $numdepartments; $i ++) {
		$department [] = "Department $i";
	}
	
	$counter=0;
	$capacity = array();
	foreach ($supplier as $s){
		$capacity[$s]=0.0;
	}
	foreach ($supplier as $s){
		$capacity [$s] = $arraycapacity[$counter];
		$counter=$counter + 1;
	}
	
	$counter=0;
	$demand = array ();
	foreach ($department as $d){
		$demand[$d]=0.0;
	}
	foreach ($department as $d){
		$demand [$d] = $arraydemand[$counter];
		$counter=$counter + 1;
	}
	
	$productionarray=array();
	$counter=0;
	foreach ($supplier as $s){
		$productionarray[$s]=0.0;
	}
	foreach ($supplier as $s){
		$productionarray [$s] = $arrayprodcost[$counter];
		$counter=$counter + 1;
	}
	
	$profitarray=array();
	$counter=0;
	foreach ($department as $d){
		$profitarray[$d]=0.0;
	}
	foreach ($department as $d){
		$profitarray [$d] = $arrayprofit[$counter];
		$counter=$counter + 1;
	}
	
	// assign productivity
	$routingmatrix=array();
	foreach ( $supplier as $s ) {
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$routingmatrix[$thiscurrkey]=0.0;
		}
	}

	$arrayprofitnew=array();
	$counter=0;
	foreach ($routingmatrix as $sd=>$v){
		$arrayprofitnew[$sd]=$arrayprofit[$counter];
		$counter=$counter + 1;
	}
	
	$arraycostnew=array();
	$counter=0;
	foreach ($routingmatrix as $sd=>$v){
		$arraycostnew[$sd]=$arraycost[$counter];
		$counter=$counter + 1;
	}
	
	$arrayprodcostnew=array();
	$counter=0;
	foreach ($routingmatrix as $sd=>$v){
		$arrayprodcostnew[$sd]=$arrayprodcost[$counter];
		$counter=$counter + 1;
	}
	
	foreach ($routingmatrix as $sd=>$v){
		$routingmatrix [$sd] = ($arrayprofitnew[$sd]-$arraycostnew[$sd]-$arrayprodcostnew[$sd]);
	}
	
	$sumcapacity=0.0;
	$sumdemand=0.0;
	$sumprodcost=0.0;
	$sumprofit=0.0;
	
	foreach ($capacity as $s=>$v){
		$sumcapacity=$sumcapacity+$v;
	}
	
	foreach ($demand as $d=>$v){
		$sumdemand=$sumdemand+$v;
	}
	
	foreach ($productionarray as $s=>$v){
		$sumprodcost=$sumprodcost+$v;
	}
	
	foreach ($profitarray as $d=>$v){
		$sumprofit=$sumprofit+$v;
	}
	
	echo "Sum Capacity: $sumcapacity <br><br>";
	echo "Sum Demand: $sumdemand <br><br>";
	if ($sumdemand>$sumcapacity){
	echo "WARNING: Demand is Greater Than Capacity<br><br>";
	}
	
	//print_r($capacity);
	//print_r($demand);
	//print_r($routingmatrix);
	
	
	$p = new TotalInfo();
	$p->supplier = $supplier;
	$p->department = $department;
	$p->capacity=$capacity;
	$p->demand=$demand;
	$p->routingmatrix=$routingmatrix;
	$p->arrayprofit=$arrayprofitnew;
	$p->arraycost=$arraycostnew;
	$p->arrayprodcost=$arrayprodcostnew;
	return $p;
	
}

// Solver
function SolveSetUpRoutingProblem($p) {
	$os = new WebIS\OS ();
	
	$supplier = $p->supplier;
	$department = $p->department;
	$capacity = $p->capacity;
	$demand = $p->demand;
	$routingmatrix = $p->routingmatrix;
	$arrayprofit = $p->arrayprofit;
	$arraycost = $p->arraycost;
	$arrayprodcost = $p->arrayprodcost;
	
	
	// Add variables
	foreach ( $supplier as $s ) {
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$os->addVariable ( $thiscurrkey );
			$os->addObjCoef ( $thiscurrkey, getMatrixValue($s, $d, $routingmatrix) );
		}
	}
	
	// add constraints to stay within capacity
	foreach ( $capacity as $s => $v ) {
		$os->addConstraint ( $v );
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$os->addConstraintCoef ( $thiscurrkey, 1 );
		}
	}
	
	foreach ( $capacity as $s => $v ) {
		$os->addConstraint ( NULL, 100 );
		foreach ( $department as $d ) {
			$thiscurrkey = "{$s}_{$d}";
			$os->addConstraintCoef ( $thiscurrkey, 1 );
		}
	}
	
	// add constraint to meet demand
	foreach ( $demand as $d => $v ) {
		$os->addConstraint ( NULL, $v );
		foreach ( $supplier as $s ) {
			$thiscurrkey = "{$s}_{$d}";
			$os->addConstraintCoef ( $thiscurrkey, 1 );
		}
	}
	
	// Sovle
	$os->solve ();
	
	//print_r($os);
	$solutionarray = $os->value;
	$solutionvalue = $os->osrl->optimization->solution->objectives->values->obj;
	settype($solutionvalue,"double");
	//print_r($solutionvalue);
	// print_r($solutionarray["Worker 1_Cell 2"]);
	// echo "\n";
	
	$p = new TotalInfo();
	$p->supplier = $supplier;
	$p->department = $department;
	$p->solutionvalue = $solutionvalue;
	$p->solutionarray = $solutionarray;
	$p->capacity=$capacity;
	$p->demand=$demand;
	$p->routingmatrix=$routingmatrix;
	$p->arrayprofit=$arrayprofit;
	$p->arraycost=$arraycost;
	$p->arrayprodcost=$arrayprodcost;
	return $p;
	
}

//BREAK ---------------------------------------------------------------
class WorkerProblemSetUp {
	public $worker;
	public $cell;
	public $cellhours;
	public $trainingmatrix;
	public $workerhourlimit;
	public $cellprod;
}

// how to pull productivity
// $productivity=getWorkerProd("Worker 1", "Cell 1",$trainingmatrix);
// echo "Worker 1_Cell 1 Productivity \n";
// print_r($productivity);
// echo "\n";

function SetUpAssignmentProblem($numworkers, $numcells, $numproducts, $arraymatrixval, $numprodproduced, $workerhourlimit) {
	$worker = array ();
	$cell = array ();
	$product = array ();

	// make workers, cells, products
	for($i = 1; $i <= $numworkers; $i ++) {
		$worker [] = "Worker $i";
	}
	for($i = 1; $i <= $numcells; $i ++) {
		$cell [] = "Cell $i";
	}

	for($i = 1; $i <= $numproducts; $i ++) {
		$product [] = "Product $i";
	}

	// print_r($worker);
	// print_r($cell);
	// print_r($product);

	$currentworker = $worker [rand ( 0, ($numworkers - 1) )];
	// print_r($currentworker);

	$demand = array ();
	class Demand {
		public $cell;
		public $product;
		public $hour;
		function __construct($c, $p, $h) {
			$this->cell = $c;
			$this->product = $p;
			$this->hour = $h;
		}
	}

	// assign demand
	for($i = 0; $i < $numprodproduced; $i ++) {
		$curc = $cell [rand ( 0, ($numcells - 1) )];
		$curp = $product [rand ( 0, ($numproducts - 1) )];
		$demand [] = new Demand ( "$curc", "$curp", rand ( 1, 3 ) );
	}

	// print_r($demand);

	// assign productivity
	$trainingmatrix=array();
	foreach ( $worker as $w ) {
		foreach ( $cell as $c ) {
			$thiscurrkey = "{$w}_{$c}";
			$trainingmatrix[$thiscurrkey]=0.0;
		}
	}

	$numworkerstrained=($numworkers*$numcells);
	$counter=0;
	foreach ($trainingmatrix as $wc=>$v){
		$trainingmatrix [$wc] = $arraymatrixval[$counter];
		$counter=$counter + 1;
	}

	//print_r($trainingmatrix);


	// Pull demand hours
	$cellhours = array ();
	foreach ( $cell as $c ) {
		$cellhours [$c] = 0.0;
	}
	foreach ( $demand as $d ) {
		if (array_key_exists ( $d->cell, $cellhours )) {
			$currcellhours = $cellhours [$d->cell];
			$cellhours [$d->cell] = ($currcellhours + $d->hour);
		}
	}
	// print_r($cellhours);

	// Pull demand product and cell
	$prodcells = array ();
	foreach ( $product as $p ) {
		$prodcells [$p] = "";
	}
	foreach ( $demand as $d ) {
		if (array_key_exists ( $d->product, $prodcells )) {
			$currprodcells = $prodcells [$d->product];
			$prodcells [$d->product] = ($currprodcells .= $d->cell);
		}
	}
	// print_r($prodcells);
	// Set up array with product values for each cell made in
	$cellprod = array ();
	foreach ( $cell as $c ) {
		$cellprod [$c] = "";
	}
	foreach ( $prodcells as $pc => $cv ) {
		foreach ( $cellprod as $cp => $pv ) {
			if (ContainsString ( $cp, $cv ) == TRUE) {
				$currprodnumval = "";
				for($i = 1; $i <= $numprodproduced; $i ++) {
					if (ContainsString ( "$i", $pc ) == TRUE) {
						// echo "toot";
						$currprodnumval = "$i";
					}
				}
				if ($cellprod [$cp] === "") {
					$cellprod [$cp] = "$currprodnumval";
				} else {
					$cellprod [$cp] .= " , $currprodnumval";
				}
			}
		}
	}
	// print_r($cellprod);

	$p = new WorkerProblemSetUp ();
	$p->worker = $worker;
	$p->cell = $cell;
	$p->cellhours = $cellhours;
	$p->trainingmatrix = $trainingmatrix;
	$p->workerhourlimit = $workerhourlimit;
	$p->cellprod = $cellprod;

	return $p;
}

// Solver
function SolveSetUpAssignmentProblem($problem) {
	$os = new WebIS\OS ();

	$worker = $problem->worker;
	$cell = $problem->cell;
	$cellhours = $problem->cellhours;
	$trainingmatrix = $problem->trainingmatrix;
	$workerhourlimit = $problem->workerhourlimit;
	$cellprod = $problem->cellprod;

	// Add variables
	foreach ( $worker as $w ) {
		foreach ( $cell as $c ) {
			$thiscurrkey = "{$w}_{$c}";
			$os->addVariable ( $thiscurrkey );
			$os->addObjCoef ( $thiscurrkey, 1 );
		}
	}

	// add constraints to meet cell hours
	foreach ( $cellhours as $c => $v ) {
		$os->addConstraint ( NULL, $v );
		foreach ( $worker as $w ) {
			$thiscurrkey = "{$w}_{$c}";
			$pooval = getMatrixValue( $w, $c, $trainingmatrix );
			$os->addConstraintCoef ( $thiscurrkey, $pooval );
		}
	}

	// constraint to restrict worker hours to 8
	foreach ( $worker as $w ) {
		$os->addConstraint ( $workerhourlimit );
		foreach ( $cell as $c ) {
			$thiscurrkey = "{$w}_{$c}";
			$os->addConstraintCoef ( $thiscurrkey, 1 );
		}
	}

	// Sovle
	$os->solve ();

	// print_r($os);
	$solutionarray = $os->value;
	echo "\n";
	// print_r($solutionarray);
	// print_r($solutionarray["Worker 1_Cell 2"]);
	// echo "\n";

	// Start HTML
	// Make productivity table
	echo "Productivity Table \n";
	echo "<table border='1' cellpadding='10'>";
	// do a foreach for all the cells and workers
	echo "<td></td>";
	foreach ( $cell as $c ) {
		echo "<td>$c</td>";
	}
	foreach ( $worker as $w ) {
		echo "<tr><td>$w</td>";
		foreach ( $cell as $c ) {
			$classicpooval = getMatrixValue ( $w, $c, $trainingmatrix );
			echo "<td>$classicpooval</td>";
		}
		echo "</tr>";
	}

	echo "</table>";

	// Make product made in each cell table
	echo "Products Made in Each Cell Table";
	echo "<table border='1' cellpadding='10'>";
	echo "<td></td>";
	foreach ( $cell as $c ) {
		echo "<td>$c</td>";
	}
	foreach ( $worker as $w ) {
		echo "<tr><td>$w</td>";
		foreach ( $cell as $c ) {
			$thiscurrkey = "{$w}_{$c}";
			$classicpooval = $solutionarray [$thiscurrkey];
			if ($classicpooval > 0) {
			$newpooval = "$cellprod[$c]";
			echo "<td>$newpooval</td>";
		} else {
		echo "<td>   </td>";
	}
	}
	echo "</tr>";
}

echo "</table>";

// Make hours worked in each cell table
echo "Hours worked in Each Cell Table";
echo "<table border='1' cellpadding='10'>";
echo "<td></td>";
foreach ( $cell as $c ) {
	echo "<td>$c</td>";
}
foreach ( $worker as $w ) {
echo "<tr><td>$w</td>";
foreach ( $cell as $c ) {
$thiscurrkey = "{$w}_{$c}";
	$classicpooval = $solutionarray [$thiscurrkey];
	$classicpooval = round ( $classicpooval, 2 );
	echo "<td>$classicpooval</td>";
}
echo "</tr>";
}

echo "</table>";

echo "</body>";
}
?>