<?php


$worker=array();
$numworker=5;

for($i=0;$i<$numworker;$i++){
	$worker[$i]="worker-".$i;
	//print_r ($worker[$i]."\n");
}

//print_r($worker);

$cell=array();
$numcell=5;

for($i=0;$i<$numcell;$i++){
	$cell[$i]="cell-".$i;
	//echo $cell[$i]."\n";
}

$product=array();
$numproduct=6;

for($i=0;$i<$numproduct;$i++){
	$product[$i]="product-".$i;
	//echo $product[$i]."\n";
}

assertequals($worker[3],"worker-3");
assertNotEquals($product[3],"product-4");

$w=rand(0,$numworker-1);
echo $worker[$w]."\n";


$hours=rand(1,3);
//print_r($hours."\n");

//Problem B3

class Demand{

	public $product=array();
	public $cell=array();
	public $hour=array();
	
	function __construct($p,$c,$h){
		$this->product=$p;
		//print_r($this->product);
		$this->cell=$c;
		$this->hour=$h;
	}
	
}

$demand=array();

foreach($product as $p){
	
	$demand[]=new Demand($p,"$ccell",rand(1,3));
}

//print_r($demand);


//Problem B4

class Training{
	
	
	public $worker=array();
	public $cellproductivity=array();

	function __construct($w,$cp){
		$this->worker=$w;
		$this->cellproductivity=$cp;
	}
	
	function set($p){
		if($p===NULL){
		$p=(rand(60,100))/100.0;
		}
		print_r($p);
	}
	
	function get($worker,$cell,$productivity){
		
	}
	
}

$traingingMatrix[]=array();


foreach($worker as $w){
	$w=$worker[rand(0,$numworker-1)];
	$c=$cell[rand(0,$numcell-1)];
	$value="${c}_${w}"."\n";
	$trainingMatrix[$value]=(rand(60,100)/100.0);
}

//print_r($value);

print_r($trainingMatrix);





echo"you made it to the end.";

?>