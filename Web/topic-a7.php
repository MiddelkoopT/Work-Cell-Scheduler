<?php

require_once 'Work-Cell-Scheduler/WCS/os.php';
require_once 'Work-Cell-Scheduler/Web/TDD.php';

//Start
function SolveAssignmentProblemRandomly($numworkers, $numcells, $numproducts, $numprodproduced, $numworkerstrained, $workerhourlimit) {
	
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
	
	//print_r($demand);
	
	// assign productivity
	for($i = 0; $i < $numworkerstrained; $i ++) {
		$curw = $worker [rand ( 0, ($numworkers - 1) )];
		$curc = $cell [rand ( 0, ($numcells - 1) )];
		$strval = "${curw}_${curc}";
		$randnum = rand ( 80, 100 ) / 100.0;
		$trainingmatrix [$strval] = $randnum;
	}
	
	// print_r($trainingmatrix);
	
	// test pulling productivity
	function getWorkerProd($w, $c, $arraymatrix) {
		$thiskey = "{$w}_{$c}";
		if (array_key_exists ( $thiskey, $arraymatrix )) {
			return $arraymatrix [$thiskey];
		} else {
			return 0.8;
		}
	}
	// how to pull productivity
	// $productivity=getWorkerProd("Worker 1", "Cell 1",$trainingmatrix);
	// echo "Worker 1_Cell 1 Productivity \n";
	// print_r($productivity);
	// echo "\n";
	
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
				// echo "poop \n";
				// echo "$pc \n";
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
	
	
	// print_r($decisionvars);
	
	$os = new WebIS\OS ();
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
			$pooval = getWorkerProd ( $w, $c, $trainingmatrix );
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
			$classicpooval = getWorkerProd ( $w, $c, $trainingmatrix );
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