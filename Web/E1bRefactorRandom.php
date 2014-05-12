<?php
//Joe Ahlbrandt
//Exam PART B 
// (c)
// refactor to use a single function


include_once 'tdd.php';
include_once 'Work-Cell-Scheduler/WCS/os.php';

//solveRandomProblem(5,7);

function solveRandomProblem($passSuppliers,$passDepartments){ // Refactoring of random problem 
	
	$numSuppliers = $passSuppliers;
	$numDepartments = $passDepartments;

	
	
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
	
	for ($i=0; $i<$numDepartments;$i++){
		$cd=$departments[$i]; //cd = current department
		$departmentDem["$departments[$i]"]=new Department(rand(0,500),rand(10,50));
	}
	
	class Supplier{
		public $supplier;
		public $capacity;
	
		function __construct($s,$c){
			$this->supplier=$s;
			$this->capacity=$c;
		}
	}
	
	for ($x=0; $x<$numSuppliers;$x++){
		$cs=$suppliers[$x]; //cs = current supplier
		$supplierCap["$suppliers[$x]"] = new Supplier($cs,rand(100,800));
	}
	print_r($departmentDem);
	print_r($supplierCap);
	
	class Distance{
	
		public $distance;
		function __construct($dist){
			$this->distance=$dist;
		}
	}
	
	for ($x=0; $x<$numSuppliers;$x++){
		for ($i=0; $i<$numDepartments;$i++){
			$cs=$suppliers[$x]; //cs = current supplier
			$cd=$departments[$i]; //cd = current department
			$distanceMatrix["$suppliers[$x]-$departments[$i]"]=new Distance(rand(1,8));
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
			//print $departmentDem[$d]->profit - $distanceMatrix["$var"]->distance;
			//print "\n";
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
		foreach($departments as $k){
			$currentKey="S$x-${k}";
			$os->addConstraintCoef($currentKey,1);
		}
	}
	
	$x=0;
	foreach($departmentDem as $d ){
		$x+=1;
		$lb = $d->demand;
		$os->addConstraint($lb,NULL);
		foreach($suppliers as $k){
			$currentKey="${k}-D$x";
			$os->addConstraintCoef($currentKey,1);
		}
	}
	
	$os->solve();
	print_r($os);
	return $os->solution;
}

?>