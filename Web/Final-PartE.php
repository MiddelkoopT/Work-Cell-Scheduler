<?php
require_once 'Work-Cell-Scheduler/Web/tdd.php';
require_once 'Work-Cell-Scheduler/WCS/os.php';


$supply=array();
$demand=array();
$department=array();
$capacity=array();
$profit=array();

$numsuppliers=4;

for($i=0;$i<$numsuppliers;$i++){
	$supply[]="supply-${i}";
}
//print_r($supply);
assertEquals($numsuppliers,sizeof($supply));
$capacity=array();
$capacity[0]=600;
$capacity[1]=300;
$capacity[2]=200;
$capacity[3]=500;
//print_r($su);


$numdepartment=5;
for($i=0;$i<$numdepartment;$i++){
	$department[]="department-${i}";
}

assertEquals($numdepartment,sizeof($department));
$demand=array();
$demand[0]=600;
$demand[1]=200;
$demand[2]=300;
$demand[3]=100;
$demand[4]=300;

//print_r($demand);

$profit=array();
$numprofit=5;
for($i=0;$i<$numprofit;$i++){
	$profit[]="profit-${i}";
}
$profit[0]=20;
$profit[1]=30;
$profit[2]=40;
$profit[3]=25;
$profit[4]=25;


$a=$demand[0]*$profit[0];
//print_r($a);
$b=$demand[1]*$profit[1];
$c=$demand[2]*$profit[2];
$d=$demand[3]*$profit[3];
$e=$demand[4]*$profit[4];

//$revenue=$a+$b+$c+$d+$e;
//print_r($revenue."\n");



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
$shipping->set('supply-0','department-0',2);
assertEquals(2,$shipping->get('supply-0','department-0'));
$shipping->set('supply-0','department-1',3);
$shipping->set('supply-0','department-2',3);
$shipping->set('supply-0','department-3',3);
$shipping->set('supply-0','department-4',3);

$shipping->set('supply-1','department-0',5);
$shipping->set('supply-1','department-1',2);
$shipping->set('supply-1','department-2',4);
$shipping->set('supply-1','department-3',4);
$shipping->set('supply-1','department-4',2);

$shipping->set('supply-2','department-0',3);
$shipping->set('supply-2','department-1',2);
$shipping->set('supply-2','department-2',8);
$shipping->set('supply-2','department-3',2);
$shipping->set('supply-2','department-4',2);

$shipping->set('supply-3','department-0',3);
$shipping->set('supply-3','department-1',2);
$shipping->set('supply-3','department-2',4);
$shipping->set('supply-3','department-3',2);
$shipping->set('supply-3','department-4',2);


//print_r($shipping);
//print_r($shipping->get($supply[0],$department[0]));

$d0=array(20,30,40,25,25);
//print_r($d0[1]);

$revenue=array();
foreach($supply as $s){
	foreach(array_combine($department,$d0) as $d => $d1){
		$var="${s}_${d}";
		$revenue[$var]=$d1-$shipping->get($s,$d,NULL);
		//print_r($revenue[$var]."\n");
	}
}


//Start Optimization

$os=new \WebIS\OS;

//print_r($os->solve());
assertTrue($os->solve());

foreach($supply as $s){
	foreach($department as $d){
		$var="${s}_${d}";
		//print_r($var."\n");
		$os->addVariable($var);
		$os->addObjCoef($var,$revenue[$var]);
	}
}

//print_r($os);
//echo"here\n";

foreach(array_combine($department,$demand) as $dep => $dem){
	$os->addConstraint($dem,NULL);
	//print_r($dem."\n");
	//print_r($dep."\n");
	foreach($supply as $s){
		$vari="${s}_${dep}";
		//print_r($vari."\n");
		$os->addConstraintCoef($vari,1);
	}
}



foreach(array_combine($capacity,$supply) as $c => $s){
	$os->addConstraint(NULL,$c);
	foreach($department as $d){
		$vari="${s}_${d}";
		$os->addConstraintCoef($vari,1);
	}
}



assertTrue($os->solve());



$os->solve();
$maxprofit=$os->getsolution();
print_r($maxprofit."\n");



//echo"End";
?>