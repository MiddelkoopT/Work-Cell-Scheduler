<?php
require_once 'Work-Cell-Scheduler/Web/tdd.php';
require 'Work-Cell-Scheduler/WCS/os.php';

$worker = array ();
$cell = array ();
$product = array ();

$numworker = 5;
$numcell = 4;
$numpro = 6;

for($i = 0; $i < $numworker; $i ++) {
	$worker [] = "worker-$i";
}
for($i = 0; $i < $numcell; $i ++) {
	$cell [] = "cell-$i";
}
for($i = 0; $i < $numpro; $i ++) {
	$product [] = "product-$i";
}

print_r ( $worker );
print_r ( $cell );
print_r ( $product );

// test

$testworker = $worker [array_rand ( $worker )];
assertContains ( $testworker, array (
"worker-1",
"worker-2",
"worker-3",
"worker-4",
"worker-0"
) );

//
class Demand {
	public $product = NULL;
	public $cell = NULL;
	public $hours = NULL;
	function __construct($product, $cell) {
		$this->hours = rand ( 1, 3 );
		$this->product = $product;
		$this->cell = $cell;

		// return $product;
	}
}





class TrainingMatrix {
	public $worker = NULL;
	public $cell = NULL;
	public $productivity = NULL;
	function set($w, $c, $proty) {
		$this->worker = $w;
		$this->cell = $c;
		$this->productivity = $proty;
		return true;
	}
	function getworker() {
		return $this->worker;
	}
	function getcell() {
		return $this->cell;
	}
	function getproductivity() {
		return $this->productivity;
	}
}

//$a = new Demand ();

$demandlist=array();
for ($i=0;$i<10;$i++){


	$tmp1=$product[array_rand($product)];
	$tmp2=$cell[array_rand($cell)];

	while(array_key_exists("{$tmp1}_{$tmp2}",$demandlist)){
		$tmp1=$product[array_rand($product)];
		$tmp2=$cell[array_rand($cell)];
	}
	$c=new Demand($tmp1,$tmp2);
	$demandlist["{$tmp1}_{$tmp2}"] = $c;
}
echo "Demandlist:";
print_r($demandlist);




$producti=array();
for ($i=0;$i<20;$i++){

	$b= new TrainingMatrix();
	$tmp1=$worker[array_rand($worker)];
	$tmp2=$cell[array_rand($cell)];

	while(array_key_exists("{$tmp1}_{$tmp2}",$producti)){
		$tmp1=$worker[array_rand($worker)];
		$tmp2=$cell[array_rand($cell)];
	}
	$b->set($tmp1,$tmp2,rand(0,100)/100);
	$producti["{$b->getworker()}_{$b->getcell()}"] = $b->getproductivity() ;
}
echo "TrainingList:";
print_r($producti);




// echo $a->cell;
// for(i=10,)
	// $a->cell=$cell[1];
	// $a->prodect=$product[3];

/*foreach($worker as $w ){
 foreach($cell as $c){
$abc["{$w}_{$c}"]=rand(0,100)/100;

}
}
print_r($abc);
*/
function getPro($w_c, array $trainingarray){

	if(array_key_exists($w_c,$trainingarray)==FALSE){
		return false;
	}

	$theProducti=$trainingarray[$w_c];//pay attention to the [] not () for array;
	return $theProducti;
}

//$a=getPro("worker-3_cell-3",$producti);
//echo $a;


$cellhour=array();
foreach($cell as $c){
	$cellhour[$c]=0;
}
foreach($demandlist as $D){
	$cellhour[$D->cell] += $D->hours;

}
echo "cell_hours:";
print_r($cellhour);

$OF=new WebIS\OS();
//$OF->solve();


foreach($worker as $w){
	foreach($cell as $c){

		$OF->addVariable("{$w}_{$c}");
		$OF->addObjCoef("{$w}_{$c}",1);

	}
}

foreach($cellhour as $key => $hourvalue){
	$OF->addConstraint(NULL,$hourvalue);
	foreach($worker as $w){
		$OF->addConstraintCoef("{$w}_{$key}", getPro("{$w}_{$key}", $producti));
	}
}
foreach($worker as $w){
	$OF->addConstraint(8,NULL);
	foreach($cell as $c){
	 $OF->addConstraintCoef("{$w}_{$c}", 1);

	}

}
$OF->solve();
//print_r($OF);
//print_r($OF->solve());-
//echo "\n";
echo "minimum hour: ";
print_r($OF->getSolution());
echo "\n";
foreach ($worker as $w){
	foreach ($cell as $c){

		echo "{$w}_{$c}:";
		print_r($OF->getVariable("{$w}_{$c}"));
		echo "\n";

	}


}

//print_r($OF->getVariable("worker-4_cell-3"));
//$OF->getSolution();















?>