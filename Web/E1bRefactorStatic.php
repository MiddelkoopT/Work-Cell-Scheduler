<?php

//Joe Ahlbrandt 
//Exam 1b
// (c) continued
//Refactoring the static problem so that it can be fun using a single function 

//refactoring of the static problem

function solveExamProblem($staticSuppliers,$staticDepartments,$demand,$profit,$capacity,$distance){

	include_once 'tdd.php';
	include_once 'Work-Cell-Scheduler/WCS/os.php';


	$numSuppliers = $staticSuppliers;
	$numDepartments = $staticDepartments;



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

	//this will add the demand and profit to each department based on the array that passes through
	for($i=0;$i<$numDepartments;$i++){
		$departmentDem["$departments[$i]"]=new Department($demand[$i],$profit[$i]);
	}

	class Supplier{
		public $capacity;

		function __construct($c){
			$this->capacity=$c;
		}
	}

	//this will set the capacities for each supplier based on the array that is passed
	for($i=0;$i<$numSuppliers;$i++){
		$supplierCap["$suppliers[$i]"] = new Supplier($capacity[$i]);
	}


	print_r($departmentDem);
	print_r($supplierCap);

	class Distance{

		public $distance;
		function __construct($dist){
			$this->distance=$dist;
		}
	}

	//obtains the distance between each station from the 2 dimensional array that is passed through function
	for($i=0;$i<$numSuppliers;$i++){
		for($x=0;$x<$numDepartments;$x++){
			$distanceMatrix["$suppliers[$i]-$departments[$x]"]=new Distance($distance[$i][$x]);
		}
	}


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

return $os->solution;
}

?>