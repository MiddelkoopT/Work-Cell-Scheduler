<?php
require_once 'Work-Cell-Scheduler/App/tdd.php';

$hours = NULL;
$worker = array();
$product = array();
$cell = array();

$hours = rand(1,3);
$numWorker = 5;
$numProduct = 6;
$numCell = 4;
$numProductProduced = 15;
$workersTrained = 20;

$i=NULL;


for ($i=1; $i<=5; $i++){
	$worker[]="worker-$i";
}

for ($i=1; $i<=4; $i++){
	$cell[]="cell-$i";
}

for ($i=1; $i<=6; $i++){
	$product[]="product-$i";
}

//print_r($worker);
//print_r($cell);
//print_r($product);

assertEquals($worker[1],"worker-2");
assertEquals($cell[1],"cell-2");
assertEquals($product[1],"product-2");

$randomWorker = rand(0,$numWorker-1);
//print_r($worker[$randomWorker]);

class Demand{

	public $product;
	public $cell;
	public $hours;

	function __construct($p, $c, $h){
		$this->hours=$h;
		$this->cell=$c;
		$this->product=$p;
	}

}

//create demand
for($i=0;$i<$numProductProduced;$i++){
	$newProduct=array_rand($product,1);
	$newCell=array_rand($cell,1);
	$demand[]=new Demand($newProduct,$newCell,$hours);
}

//print_r($demand);

class training{
	
	public $attribute;
	
	function __get($p){
		return $this->$p;
	}
	
	function __set($p, $prod){
		$this->$p=$prod;
	}
}
$t = new training();
$t->attribute = .80;

//populate Training Matrix with random productivity
//for($i=0;$i<$workersTrained;$i++){
	//$newWorker=array_rand($worker,1);
	//$newCell=array_rand($cell,1);
	//$setKey = "${newWorker}_${newCell}";
	//$randomProductivity = rand (50,100)/100;
	//$trainingMatrix[$setKey]= $randomProductivity;
//}

foreach ($worker as $newWorker){
	$newWorker=array_rand($worker,1);
	$newCell=array_rand($cell,1);
	$setKey = "${newWorker}_${newCell}";
	$randomProductivity = rand (50,100)/100;
	$trainingMatrix[$setKey]= $randomProductivity;
}

print_r($trainingMatrix);


//C





?>