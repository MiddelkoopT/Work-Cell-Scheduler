<?php
// Model basics Copyright 2014 by WebIS Spring 2014 License Apache 2.0
echo "Model Basics\n";

// Problem: Maximize productivity in a work-cell line.
// Workers are assigned a productivity score for each work-cell.
// Products are given a demand in normalized hours on a work-cell.
// Production is equal to (hours allocated) * (productivity on machine)

// A: Setup.

// A1: Use TDD functions from osbasic and store in tdd.php
// Use TDD from osbasic and place in tdd.php
require_once 'tdd.php';
assertEquals(TRUE,TRUE);

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
	$demand[]=new Demand($p,$cell[array_rand($cell)],rand(10,30));
}

assertEquals($products,sizeof($demand));
//print_r($demand);

// B2: Create training matrix class to hold worker/cell productivity
//    If a worker/cell does not exist return a default value.
//    access with set(worker,cell,productivity) and get(...)
//    Use an array with the key as a string.

class Training {
	private $default=0.80;
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
assertEquals(0.80,$training->get('worker-1','cell-1'));
$training->set('worker-1','cell-1',0.99);
assertEquals(0.99,$training->get('worker-1','cell-1'));

// B3: Populate training with a number of random trainings
for($i=0;$i<20;$i++){
	$training->set($worker[array_rand($worker)],$cell[array_rand($cell)],rand(70,100)/100.0);
}
//print_r($training);



echo "\ndone\n";
?>
