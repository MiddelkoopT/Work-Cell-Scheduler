<?php
require_once 'Work-Cell-Scheduler/WCS/os.php';
require_once 'tdd.php';

function examB(){
	$os=New WebIS\OS;
	/*$os->addVariable('x11');
	$os->addObjCoef('x11','2');
	$os->addVariable('x12');
	$os->addObjCoef('x12','5');
	$os->addVariable('x13');
	$os->addObjCoef('x13','3');
	$os->addVariable('x14');
	$os->addObjCoef('x14','3');
	$os->addVariable('x21');
	$os->addObjCoef('x21','3');
	$os->addVariable('x22');
	$os->addObjCoef('x22','2');
	$os->addVariable('x23');
	$os->addObjCoef('x23','2');
	$os->addVariable('x24');
	$os->addObjCoef('x24','2');
	$os->addVariable('x31');
	$os->addObjCoef('x31','3');
	$os->addVariable('x32');
	$os->addObjCoef('x32','4');
	$os->addVariable('x33');
	$os->addObjCoef('x33','8');
	$os->addVariable('x34');
	$os->addObjCoef('x34','4');
	$os->addVariable('x41');
	$os->addObjCoef('x41','3');
	$os->addVariable('x42');
	$os->addObjCoef('x42','4');
	$os->addVariable('x43');
	$os->addObjCoef('x43','2');
	$os->addVariable('x44');
	$os->addObjCoef('x44','2');
	$os->addVariable('x51');
	$os->addObjCoef('x51','3');
	$os->addVariable('x52');
	$os->addObjCoef('x52','2');
	$os->addVariable('x53');
	$os->addObjCoef('x53','2');
	$os->addVariable('x54');
	$os->addObjCoef('x54','2');
	*/

	$supplier = array(1,2,3,4);
	$department = array(1,2,3,4,5);
	$shipping = array(
			array(2,5,3,3),
			array(3,2,2,2),
			array(3,4,8,4),
			array(3,4,2,2),
			array(3,2,2,2),
	);
	$capacity = array(600,200,300,500);
	$profit = array(20,30,40,25,25);
	$demand = array(600,200,300,100,300);
	$prodCosts = array(10,14,40,11);
	
	//print_r($shipping);
	//random shipping&suppliers
	foreach ($supplier as $newSupplier){
		$newSupplier=array_rand($supplier,1);
		$newDepartment=array_rand($department,1);
		$setKey = "${newSupplier}_${newDepartment}";
		$shippingMatrix[$setKey]= $shipping;
	}
	//print_r($shippingMatrix);
	
	foreach(array_combine($department, $demand) as $dp => $dm){
		$os->addConstraint(NULL, $dp);
		
	}
	foreach(array_combine($supplier, $capacity) as $sup => $cap){
		$os->addConstraint(NULL, $sup);
		
	}
	
	//$os->solve();
}

examB();

?>