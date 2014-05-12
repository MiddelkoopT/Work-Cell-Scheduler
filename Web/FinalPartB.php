<?php
require_once 'Work-Cell-Scheduler/Web/tdd.php';
require_once 'Work-Cell-Scheduler/WCS/os.php';


$supply=array();
$demand=array();
$department=array();
$capacity=array();
$profit=array();

$numsuppliers=rand(10,20);
for($i=0;$i<$numsuppliers;$i++){
	$supply[]="supply-${i}";
}
//print_r($supply);
assertEquals($numsuppliers,sizeof($supply));

for($i=0;$i<$numsuppliers;$i++){
	$capacity[]=rand(200,600);
}


$numdepartment=rand(10,20);
for($i=0;$i<$numdepartment;$i++){
	$department[]="department-${i}";
}
//print_r($department);
assertEquals($numdepartment,sizeof($department));


$profit=array();
$numprofit=rand(10,20);
for($i=0;$i<$numprofit;$i++){
	$profit[]="profit-${i}";
}
//print_r($profit);


for($i=0;$i<$numdepartment;$i++){
	$demand[]=rand(200,600);
}


//print_r($demand);


class ShippingClass{
	private $matrix=array();
	
	function set($supply,$department,$shipping){
		$this->matrix["${supply}_${department}"]=$shipping;
	}
	
	function get($supply,$department){
		if(array_key_exists("${supply}_${department}",$this->matrix)){
			return $this->matrix["${supply}_${department}"];
		}
		return FALSE;
	}
}

$shipping=new ShippingClass;

foreach($supply as $s){
$shipping->set($s,$department[array_rand($department)],rand(1,8));
}


//print_r($shipping);



//Start Optimization

$os=new \WebIS\OS;

//print_r($os->solve());
assertTrue($os->solve());

foreach($supply as $s){
	foreach($department as $d){
		$var="${s}_${d}";
		//print_r($var."\n");
		$os->addVariable($var);
		$os->addObjCoef($var,$shipping->get($s,$d));
	}
}



foreach(array_combine($demand,$department) as $dem => $dep){
	$os->addConstraint(NULL,$dem);
	//print_r($dem."\n");
	//print_r($dep."\n");
	foreach($supply as $s){
		$vari="${s}_${dep}";
		//print_r($vari."\n");
		$os->addConstraintCoef($vari,1);
	}
}



foreach(array_combine($capacity,$supply) as $c => $s){
	$os->addConstraint($c,NULL);
	foreach($department as $d){
		$vari="${s}_${d}";
		//print_r($vari."\n");
		$os->addConstraintCoef($vari,1);
	}
}




assertTrue($os->solve());
//echo"here";

//print_r($os);

$os->solve();
$minshippingcost=$os->getsolution();
print_r($minshippingcost);
//$maxprofit=$revenue-$minshippingcost;
//print_r("max profit: ".$maxprofit."\n");


//echo"End";
?>