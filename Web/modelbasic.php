<?php
// Model basics Copyright 2014 by WebIS Spring 2014 License Apache 2.0
echo "<html><title>modelbasic.php</title><body>\n";

// Problem: Maximize productivity in a work-cell line.
// Workers are assigned a productivity score for each work-cell.
// Products are given a demand in normalized hours on a work-cell.
// Production is equal to (hours allocated) * (productivity on machine)

// A: Setup.

// A1: Use TDD functions from osbasic and store in tdd.php
// Use TDD from osbasic and place in tdd.php
require_once 'Work-Cell-Scheduler/WCS/os.php';
require_once 'tdd.php';
assertEquals(TRUE,TRUE);
assertTrue(TRUE);
assertFalse(FALSE);

// B: Setup problem and data structures.

$workers=5;
$cells=4;
$products=6;

// B1: Create arrays of workers, cells and products (worker-1, cell-3, product-4)
//    called worker,cell, and product

$worker=array();
for($i=0;$i<$workers;$i++){
	$worker[]="worker-${i}";
}
assertEquals($workers,sizeof($worker));
//print_r($worker);

$cell=array();
for($i=0;$i<$cells;$i++){
	$cell[]="cell-${i}";
}
assertEquals($cells,sizeof($cell));

$product=array();
for($i=0;$i<$products;$i++){
	$product[]="product-${i}";
}
assertEquals($products,sizeof($product));

// B2: Pick at random a worker and test using TDD. 
// make sure the first and last get picked.

$w=0;
while($worker[$w] != 'worker-1'){
	$w=array_rand($worker);
	//print_r($w);
}

// B1: Create demand using a structure/class that holds (product,cell,hours).
// Hours is between 1 and 3 hours: rand(1,3)

class Demand {
	public $product=NULL;
	public $cell=NULL;
	public $hours=NULL;
	function __construct($product,$cell,$hours){
		$this->product=$product;
		$this->cell=$cell;
		$this->hours=$hours;
	}
}

$demand=array();
foreach($product as $p){
	$demand[]=new Demand($p,$cell[array_rand($cell)],rand(1,3));
}

assertEquals($products,sizeof($demand));
//print_r($demand);

// B2: Create training matrix class to hold worker/cell productivity
//    If a worker/cell does not exist return a default value (which could be FALSE).
//    access with set(worker,cell,productivity) and get(...)
//    Use an array with the key as a string, join elements with the underscore symbol ('_')
//    Note in the "" syntax use the form ${worker} instead of $worker.

class Training {
	private $default=FALSE;
	private $matrix=array();
	function set($worker,$cell,$productivity){
		$this->matrix["${worker}_${cell}"]=$productivity;
	}
	function get($worker,$cell){
		if(array_key_exists("${worker}_${cell}",$this->matrix)){
			return $this->matrix["${worker}_${cell}"];
		}
		return $this->default;
	}
}

$training=new Training;

// B2.1 Use TDD to check get/set

assertEquals(FALSE,$training->get('worker-1','cell-1'));
$training->set('worker-1','cell-1',0.99);
assertEquals(0.99,$training->get('worker-1','cell-1'));

// B3: Populate training with a number of random trainings

for($i=0;$i<20;$i++){
	$training->set($worker[array_rand($worker)],$cell[array_rand($cell)],rand(70,100)/100.0);
}
//print_r($training);


// C: Optimization

// C0: Solve empty problem.
$os=new \WebIS\OS;
assertTrue($os->solve());

// C1: Setup objective function, minimize worker hours on each cell
foreach($worker as $w){
	foreach($cell as $c){
		$var="${w}_${c}";
		$os->addVariable($var);
		$os->addObjCoef($var,1);
	}
}

assertTrue($os->solve());
//print_r($os);

// C2: build production requirement, 
// How much work is required on each cell.
// Calculate total production hours (used to check later).

$celltotal=array();
foreach($cell as $c){
	$celltotal[$c]=0.0;
}
foreach($demand as $d){
	$celltotal[$d->cell]+=$d->hours;
}
//print_r($celltotal);

$required=0.0;
foreach($celltotal as $c=>$v){
	$required+=$v;
}
assertTrue($required>0.0);
//print_r("total: $required\n");


// C3: Generate constraints off this (note OS changed to $ub,$lb and made required) and solve.
// Multiply the hours worked by productivity to get the amount of hours that are needed to work
// to fulfill the requirements.
// If there is no training do not include in problem.
 
foreach($celltotal as $c=>$lb){
	$os->addConstraint($lb,NULL);
	foreach($worker as $w){
		$var="${w}_${c}";
		$val=$training->get($w,$c);
		if($val!==FALSE){
			$os->addConstraintCoef("${w}_${c}",$val);
		}
	}
}

assertTrue($os->solve());
$solution=$os->getSolution();
//print_r("solution: $solution\n");

// C4: check that the total hours allocated is at least the total required.

$worked=0.0;
foreach($worker as $w){
	foreach($cell as $c){
		$var="${w}_${c}";
		$val=$os->getVariable($var);
		$worked+=$val;
	}
}

assertTrue($worked>=$required);

// C5: Cap worker hours to 8 a day.

foreach($worker as $w){
	$os->addConstraint(NULL,8);
	foreach($cell as $c){
		$var="${w}_${c}";
		$val=$training->get($w,$c);
		if($val!==FALSE){
			$os->addConstraintCoef("${w}_${c}",1);
		}
		
	}
}

assertTrue($os->solve());
$solution=$os->getSolution();
//print_r("solution: $solution\n");

// D: Verify solution.

// D1: Dump solution to a html table (readable in the console as well), and verify solution by hand.
// include productivity and product.
// Worker as rows, cells as columns.

echo "<table border='1'><tr><td>\n";
foreach($cell as $c){
	echo "<th>$c</th>";
}
foreach($worker as $w){
	echo "<tr><th>${w}: ";
	foreach($cell as $c){
		$var="${w}_${c}";
		$val=$os->getVariable($var);
		$t=$training->get($w,$c);
		echo "<td>$val $t <strong>".$val*$t."</strong></td>";
	}
	echo "<tr>\n";
}
echo "<tr><th>Total</th>";
foreach($celltotal as $ct){
	echo "<td>$ct</td>";
}
echo "</tr>";

echo "\n</table>";


// Done
echo "\n</body></html>\n";
?>
