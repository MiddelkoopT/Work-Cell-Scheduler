<?php
require_once 'Work-Cell-Scheduler/Web/tdd.php';
require_once 'Work-Cell-Scheduler/WCS/os.php';




$supply=array();
$demand=array();
$department=array();
$capacity=array();
$profit=array();

$numsuppliers=3;
for($i=0;$i<$numsuppliers;$i++){
	$supply[]="supply-${i}";
}
//print_r($supply);
assertEquals($numsuppliers,sizeof($supply));


$numdepartment=3;
for($i=0;$i<$numdepartment;$i++){
	$department[]="department-${i}";
}
//print_r($department);
assertEquals($numdepartment,sizeof($department));

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

//Test Get and Set
assertEquals(FALSE,$shipping->get('supply-0','department-0'));
$shipping->set('supply-0','department-0',0.90);
assertEquals(0.90,$shipping->get('supply-0','department-0'));

for($i=0;$i<20;$i++){
	$shipping->set($supply[array_rand($supply)],$department[array_rand($department)],rand(60,100)/100.0);
}


//print_r($shipping);

//Start Optimization

$os=new \WebIS\OS;
print_r($os->solve());
assertNotEquals('0',$os->solve());

foreach($supply as $s){
	foreach($department as $d){
		$var="${s}_${d}";
		$os->addVariable($var);
		$os->addObjCoef($var,1);
	}
}

assertNotEquals(0,$os->solve());



echo"End";
?>