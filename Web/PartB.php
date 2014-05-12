<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Andrew Lazalier (ARLXCF)</title>
</head>
<body>
<table border='1'>
<tr><th></th>
<?php
//A.

$numsuppliers=3;
$numdepartments=3;

$suppliers=array();
$departments=array();
for($i=0; $i < $numsuppliers; $i++){
	$suppliers[] = "s - $i";
}
for($i=0; $i < $numdepartments; $i++){
	$departments[] = "d - $i";
}

$demand=array(600,200,300);
$supply=array(600,300,200);


$fromto=array();
foreach($suppliers as $s){
	foreach($departments as $d){
		$fromto[]= "($s)_($d)";
	}
}



//print_r($fromto);
$sales=array(20,20,20,30,30,30,40,40,40);
$transCost=array(2,3,3,5,2,4,3,2,8);


$profit=array();
foreach($sales as $key=>$s){
	$profit[$key]=$s-$transCost[$key];
}
//print_r($profit);

require_once 'Work-Cell-Scheduler/WCS/os.php';
$a=new WebIS\OS();

foreach($fromto as $key=>$ft){
		$b=$a->addVariable("$ft");
		$a->addObjCoef("$ft",$profit[$key]);
}

foreach($demand as $demi=>$dem){
	$a->addConstraint($dem,NULL);
	foreach($suppliers as $s){
		$a->addConstraintCoef("($s)_($departments[$demi])",1);
	}
}

foreach($supply as $suppi=>$supp){
	$a->addConstraint(NULL,$supp);
	foreach($departments as $d){
		$a->addConstraintCoef("($suppliers[$suppi])_($d)",1);
	}
}

//echo $a->solve();
//print_r($a);

//B.

$numsuppliers=rand(1,5);
$numdepartments=$numsuppliers;
$suppliers=array();
$departments=array();
$demand=array();
$supply=array();

for($i=0; $i < $numsuppliers; $i++){
	$suppliers[] = "s - $i";
}
for($i=0; $i < $numdepartments; $i++){
	$departments[] = "d - $i";
}

foreach($suppliers as $s){
	$supply[]=rand(100,500);
}
foreach($departments as $key=>$d){
	$demand[]=$supply[$key];
}

//print_r($supply);
//print_r($demand);


$fromto=array();
foreach($suppliers as $s){
	foreach($departments as $d){
		$fromto[]= "($s)_($d)";
	}
}
//print_r($fromto);
$sales=array();

foreach($fromto as $ft){
	$sales[]=rand(10,50);
}
//print_r($sales);
$transCost=array();
foreach($fromto as $ft){
	$transCost[]=rand(2,8);
}

$profit=array();
foreach($sales as $key=>$s){
	$profit[$key]=$s-$transCost[$key];
}
//print_r($profit);

require_once 'Work-Cell-Scheduler/WCS/os.php';
$a=new WebIS\OS();

foreach($fromto as $key=>$ft){
	$b=$a->addVariable("$ft");
	$a->addObjCoef("$ft",$profit[$key]);
}

foreach($demand as $demi=>$dem){
	$a->addConstraint($dem,NULL);
	foreach($suppliers as $s){
		$a->addConstraintCoef("($s)_($departments[$demi])",1);
	}
}

foreach($supply as $suppi=>$supp){
	$a->addConstraint(NULL,$supp);
	foreach($departments as $d){
		$a->addConstraintCoef("($suppliers[$suppi])_($d)",1);
	}
}

//echo $a->solve();
//print_r($a);

//C.

function SetUpSolve($numsuppliers,$numdepartments,$demand,$supply,$sales,$transCost){
	
	$suppliers=array();
	$departments=array();
	for($i=0; $i < $numsuppliers; $i++){
		$suppliers[] = "s - $i";
	}
	for($i=0; $i < $numdepartments; $i++){
		$departments[] = "d - $i";
	}
	
	$fromto=array();
	foreach($suppliers as $s){
		foreach($departments as $d){
			$fromto[]= "($s)_($d)";
		}
	}
	
	$profit=array();
	foreach($sales as $key=>$s){
		$profit[$key]=$s-$transCost[$key];
	}
	
	require_once 'Work-Cell-Scheduler/WCS/os.php';
	$a=new WebIS\OS();
	
	foreach($fromto as $key=>$ft){
		$b=$a->addVariable("$ft");
		$a->addObjCoef("$ft",$profit[$key]);
	}
	
	foreach($demand as $demi=>$dem){
		$a->addConstraint($dem,NULL);
		foreach($suppliers as $s){
			$a->addConstraintCoef("($s)_($departments[$demi])",1);
		}
	}

	foreach($supply as $suppi=>$supp){
		$a->addConstraint(NULL,$supp);
		foreach($departments as $d){
			$a->addConstraintCoef("($suppliers[$suppi])_($d)",1);
		}
	}
	/// Render HTML table
	echo "Net Profit: $".$a->solve();
	
	foreach($suppliers as $key=>$s){
		echo "<th>Supplier ($s)\n";
		echo "Supplies: ".$supply[$key]." items";
	}
	foreach($departments as $key=>$d){
		echo "<tr><th>$d Needs: $demand[$key]</th>";
		foreach($suppliers as $s) {
			echo "<td> Sent: ".$a->getVariable(("($s)_($d)"))." items"."</td>";
		}
		echo "\n";
	}
	//echo $a->solve();
	//print_r($a);
}
// Refactor A
$demandA=array(600,200,300);
$supplyA=array(600,300,200);
$salesA=array(20,20,20,30,30,30,40,40,40);
$transCostA=array(2,3,3,5,2,4,3,2,8);
//SetUpSolve(3,3,$demandA,$supplyA,$salesA,$transCostA);

// Refactor B

$numsuppliers=rand(1,5);
$numdepartments=$numsuppliers;
$demandB=array();
$salesB=array();
$supplyB=array();
$transCostB=array();

for($i=0; $i < $numsuppliers; $i++){
	$demandB[] = rand(100,500);
}
for($i=0; $i < $numsuppliers; $i++){
	$supplyB[] = $demandB[$i];
}
for($i=0; $i < $numsuppliers*$numdepartments; $i++){
	$salesB[] = rand(10,50);
}
for($i=0; $i < $numsuppliers*$numdepartments; $i++){
	$transCostB[] = rand(2,8);
}
SetUpSolve($numsuppliers,$numdepartments,$demandB,$supplyB,$salesB,$transCostB);

//D. Display

//See End of Function SetUpSolve

?>

</body>

</html>
