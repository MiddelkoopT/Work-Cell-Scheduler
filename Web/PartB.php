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
//SetUpSolve($numsuppliers,$numdepartments,$demandB,$supplyB,$salesB,$transCostB);

//D. Display

//See End of Function SetUpSolve

//E. Add Plant
$demandE=array(600,200,300,100,300);
$supplyE=array(600,300,200,500);
$salesE=array(20,20,20,20,30,30,30,30,40,40,40,40,25,25,25,25,25,25,25,25);
$transCostE=array(2,5,3,3,3,2,2,2,3,4,8,4,3,4,2,2,3,2,2,2);

//SetUpSolveE(4,5,$demandE,$supplyE,$salesE,$transCostE);

function SetUpSolveE($numsuppliers,$numdepartments,$demand,$supply,$sales,$transCost){

	$suppliers=array();
	$departments=array();
	for($i=0; $i < $numsuppliers; $i++){
		$suppliers[] = "s - $i";
	}
	for($i=0; $i < $numdepartments; $i++){
		$departments[] = "d - $i";
	}

	$fromto=array();
	foreach($departments as $d){
		foreach($suppliers as $s){
			$fromto[]= "($s)_($d)";
		}
	}

	$profit=array();
	foreach($sales as $key=>$s){
		$profit[$key]=($s-$transCost[$key]);
	}

	require_once 'Work-Cell-Scheduler/WCS/os.php';
	$a=new WebIS\OS();

	foreach($fromto as $key=>$ft){
		$b=$a->addVariable("$ft");
		$a->addObjCoef("$ft",$profit[$key]);
	}

	foreach($demand as $demi=>$dem){
		$a->addConstraint(NULL,$dem);
		foreach($suppliers as $s){
			$a->addConstraintCoef("($s)_($departments[$demi])",1);
		}
	}

	foreach($supply as $suppi=>$supp){
		$a->addConstraint($supp,NULL);
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
}

//F.
$demandF=array(600,200,300,100,300);
$supplyF=array(600,300,200,500);
$salesF=array(20,20,20,20,30,30,30,30,40,40,40,40,25,25,25,25,25,25,25,25);
$transCostF=array(2,5,3,3,3,2,2,2,3,4,8,4,3,4,2,2,3,2,2,2);
$prodCostF=array(10,14,40,11,10,14,40,11,10,14,40,11,10,14,40,11,10,14,40,11);

//SetUpSolveF(4,5,$demandF,$supplyF,$salesF,$transCostF,$prodCostF);

function SetUpSolveF($numsuppliers,$numdepartments,$demand,$supply,$sales,$transCost,$prodCost){

	$suppliers=array();
	$departments=array();
	for($i=0; $i < $numsuppliers; $i++){
		$suppliers[] = "s - $i";
	}
	for($i=0; $i < $numdepartments; $i++){
		$departments[] = "d - $i";
	}

	$fromto=array();
	foreach($departments as $d){
		foreach($suppliers as $s){
			$fromto[]= "($s)_($d)";
		}
	}

	$profit=array();
	foreach($sales as $key=>$s){
		$profit[$key]=($s-$transCost[$key]-$prodCost[$key]);
	}

	require_once 'Work-Cell-Scheduler/WCS/os.php';
	$a=new WebIS\OS();

	foreach($fromto as $key=>$ft){
		$b=$a->addVariable("$ft");
		$a->addObjCoef("$ft",$profit[$key]);
	}

	foreach($demand as $demi=>$dem){
		$a->addConstraint(NULL,$dem);
		foreach($suppliers as $s){
			$a->addConstraintCoef("($s)_($departments[$demi])",1);
		}
	}

	foreach($supply as $suppi=>$supp){
		$a->addConstraint($supp,NULL);
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
}

//G.
$demandG=array(600,200,300,100,300);
$supplyG=array(600,300,200,500);
$salesG=array(20,20,20,20,30,30,30,30,40,40,40,40,25,25,25,25,25,25,25,25);
$transCostG=array(2,5,3,3,3,2,2,2,3,4,8,4,3,4,2,2,3,2,2,2);
$prodCostG=array(10,14,40,11,10,14,40,11,10,14,40,11,10,14,40,11,10,14,40,11);

SetUpSolveG(4,5,$demandG,$supplyG,$salesG,$transCostG,$prodCostG);

function SetUpSolveG($numsuppliers,$numdepartments,$demand,$supply,$sales,$transCost,$prodCost){

	$suppliers=array();
	$departments=array();
	$prodMin=array(100,100,100,100);
	$salesPrice=array(20,30,40,25,25);
	
	for($i=0; $i < $numsuppliers; $i++){
		$suppliers[] = "s - $i";
	}
	for($i=0; $i < $numdepartments; $i++){
		$departments[] = "d - $i";
	}

	$fromto=array();
	foreach($departments as $d){
		foreach($suppliers as $s){
			$fromto[]= "($s)_($d)";
		}
	}

	$profit=array();
	foreach($sales as $key=>$s){
		$profit[$key]=($s-$transCost[$key]-$prodCost[$key]);
	}

	require_once 'Work-Cell-Scheduler/WCS/os.php';
	$a=new WebIS\OS();

	foreach($fromto as $key=>$ft){
		$b=$a->addVariable("$ft");
		$a->addObjCoef("$ft",$profit[$key]);
	}

	foreach($demand as $demi=>$dem){
		$a->addConstraint(NULL,$dem);
		foreach($suppliers as $s){
			$a->addConstraintCoef("($s)_($departments[$demi])",1);
		}
	}

	foreach($supply as $suppi=>$supp){
		$a->addConstraint($supp,NULL);
		foreach($departments as $d){
			$a->addConstraintCoef("($suppliers[$suppi])_($d)",1);
		}
	}
	foreach($prodMin as $pm){
	$a->addConstraint(NULL,100);
		foreach($departments as $d){
			foreach($suppliers as $s){
				$a->addConstraintCoef("($s)_($d)",1);
			}
		}
	}
	/// H. Display
	echo "Net Profit: $".$a->solve();

	foreach($suppliers as $key=>$s){
		echo "<th>Supplier ($s)\n";
		echo "Total Prod. Cost: $".$supply[$key]*$prodCost[$key];
	}
	foreach($departments as $key=>$d){
		echo "<tr><th>$d Total Profit: $$demand[$key]$salesPrice[$key]</th>";
		foreach($suppliers as $s) {
			echo "<td> Sent: ".$a->getVariable(("($s)_($d)"))." items"."</td>";
		}
		echo "\n";
	}
	
}

?>

</body>
</html>


