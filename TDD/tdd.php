<?php
//A. Simple TDD

function assertEquals($expected,$result){
		if(!($expected===$result)){
			throw new Exception("not equal");
		}
}


function assertNotEquals($expected,$result){
	if(($expected===$result)){
		throw new Exception("Refactor Fail");
	}
}

//B. setup problem

$numworkers=5;
$numcells=4;
$numproducts=6;

for($i=0; $i < $numworkers; $i++){
	$workers[] = "worker - $i";
}


for($i=0; $i < $numcells; $i++){
	$cells[] = "cell - $i";
}


for($i=0; $i < $numproducts; $i++){
	$products[] = "product - $i";
}


//B2 pick random worker

assertEquals('worker - 1', $workers[1]);

//B3 create demand

$demand=array();

class Demand{
	
	public $product;
	public $cell;
	public $hours;
	
	function __construct($p,$c,$h){
		$this->product=$p;
		$this->cell=$c;
		$this->hours=$h;
	}
}

$numlist = 10;

for ($i=0; $i < $numlist;$i++){
	$demandlist[]= new Demand($products[array_rand($products)],$cells[array_rand($cells)],rand(1,3));
}


print_r($demandlist);

//B4 create matrix

//SET
$productivity=array();
foreach($workers as $w){
	foreach($cells as $c){
		$productivity["($w)_($c)"]= rand(0,100)/100.0;
	}
}

//print_r($productivity);

//GET
function getProductivity($worker,$cell,$productivity){
	if(array_key_exists("($worker)_($cell)",$productivity)===FALSE){
		return 0.5;
	}
	return $productivity["($worker)_($cell)"];
}

getProductivity("worker - 1","cell - 1",$productivity);

//Training Matrix alread populated

//C. Optimization
//C. 0
require_once 'Work-Cell-Scheduler/WCS/os.php';
$a=new WebIS\OS();
//$a->solve();

//C. 1
foreach($workers as $w){
	foreach($cells as $c){
		$b=$a->addVariable("($w)_($c)");
		$a->addObjCoef("($w)_($c)",1);
	}
}
//print_r($a);

//C. 2

$crequirements=array();
foreach($cells as $c){
	$crequirements[$c] = 0;
}

foreach($demandlist as $d){
	$crequirements[$d->cell] += $d->hours;
}
//print_r($crequirements);

$totalcreq=0;

foreach($crequirements as $cr){
	$totalcreq = $totalcreq + $cr;
}
//print_r($totalcreq);

//C. 3
//generate constraints calculate hours needed (productivity*hours worked)

foreach($crequirements as $key=>$cr){
	$const=$a->addConstraint(NULL,$cr);
	foreach($workers as $w){
		$a->addConstraintCoef(("($w)_($key)"),$productivity["($w)_($key)"]);	
	}
}

//print_r($a);

//C4 check
assert($a->solve()>=$totalcreq);
//assert(4>=5);

//C5 Cap
foreach($workers as $w){
	$a->addConstraint(8,NULL);
	foreach($cells as $c){
		$a->addConstraintCoef(("($w)_($c)"),1);
	}
}

echo $a->solve();

//print_r($a);

//D Make Table


echo 'done';
?> 