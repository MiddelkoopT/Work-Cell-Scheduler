<?php
//Joe Ahlbrandt
//Exam PART B 
//1a (solve the static problem)

include_once 'tdd.php';
include_once 'Work-Cell-Scheduler/WCS/os.php';

$numSuppliers = 3;
$numDepartments = 3;
$combos = $numSuppliers * $numDepartments;


for ($i=1; $i<=$numSuppliers; $i++){ //creates suppliers array that contains each supplier
	$suppliers[]="S$i";
}
print "Suppliers\n";
print_r($suppliers);


for ($i=1; $i<=$numDepartments; $i++){ //creates departments array that contains each department
	$departments[]="D$i";
}
//print "Departments\n";
print_r($departments);


class Department{ 		//department class gives demand and profit attributes to each department

	public $demand;
	public $profit;

	function __construct($dem,$p){
		$this->demand=$dem;
		$this->profit=$p;
	}
}

	$departmentDem["$departments[0]"]=new Department(600,20);
	$departmentDem["$departments[1]"]=new Department(200,30);
	$departmentDem["$departments[2]"]=new Department(300,40);


class Supplier{
	public $capacity;
	
	function __construct($c){
		$this->capacity=$c;
	}
}


	$supplierCap["$suppliers[0]"] = new Supplier(600);
	$supplierCap["$suppliers[1]"] = new Supplier(300);
	$supplierCap["$suppliers[2]"] = new Supplier(200);

print_r($departmentDem);
print_r($supplierCap);

class Distance{
	
	public $distance;
	function __construct($dist){
		$this->distance=$dist;	
	}
}


	$distanceMatrix["$suppliers[0]-$departments[0]"]=new Distance(2);
	$distanceMatrix["$suppliers[0]-$departments[1]"]=new Distance(3);
	$distanceMatrix["$suppliers[0]-$departments[2]"]=new Distance(5);
	$distanceMatrix["$suppliers[1]-$departments[0]"]=new Distance(5);
	$distanceMatrix["$suppliers[1]-$departments[1]"]=new Distance(2);
	$distanceMatrix["$suppliers[1]-$departments[2]"]=new Distance(4);
	$distanceMatrix["$suppliers[2]-$departments[0]"]=new Distance(3);
	$distanceMatrix["$suppliers[2]-$departments[1]"]=new Distance(2);
	$distanceMatrix["$suppliers[2]-$departments[2]"]=new Distance(8);


print_r($distanceMatrix);

$os=new \WebIS\OS;
//assertTrue($os->solve());


//echo $distanceMatrix["S1-D1"]->distance;

//setting up the objective function
foreach($suppliers as $s){
	foreach($departments as $d){
		$var="${s}-${d}";
		$os->addVariable($var);
		$os->addObjCoef($var,$departmentDem[$d]->profit - $distanceMatrix["$var"]->distance);
		print $departmentDem[$d]->profit - $distanceMatrix["$var"]->distance;
		print "\n";
		//print "$var\n";
	
	}
}

//adding the constraints

$x=0;
foreach($supplierCap as $s ){
	$x+=1;
	$ub = $s->capacity;
	//print $ub;
	//print $s;
	$os->addConstraint(NULL,$ub);
	foreach($departments as $key){
		$currentKey="S$x-${key}";
		$os->addConstraintCoef($currentKey,1);
		//print $currentKey;
	}	
}

$x=0;
foreach($departmentDem as $d ){
	$x+=1;
	$lb = $d->demand;
	$os->addConstraint($lb,NULL);
	foreach($suppliers as $k){
		$currKey="${k}-D$x";
		$os->addConstraintCoef($currKey,1);
		//print $currentKey;
	}
}

$os->solve();

print_r($os);



