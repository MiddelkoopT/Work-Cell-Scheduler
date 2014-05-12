<?php
require_once 'Work-Cell-Scheduler/WCS/os.php';
include 'Work-Cell-Scheduler/Web/tdd.php';

$numstores=3;
$numplants=3;
$supliers=array();
$departments=array();

for ($i=0; $i<$numstores; $i++){
	$supliers[]="S - $i";
}
for ($i=0; $i<$numplants; $i++){
	$departments[]="D - $i";
}
$i=0;
$fromS0=array();
foreach($departments as $d){
	$fromS0[]= "(S - 0)_($d)";
	$i++;
}
$i=0;
$netS0=array();
$costS0=array(2,3,3);
$profitDepartment=array(20,30,40);
foreach($profitDepartment as $p){
	$netS0[]=$p-$costS0[$i];
	$i++;
}
//print_r($netS0);

$i=0;

$fromS1=array();
foreach($departments as $d){
	$fromS1[]= "(S - 1)_($d)";
	$i++;
}
$i=0;
$netS1=array();
$costS1=array(5,2,4);
$profitDepartment=array(20,30,40);
foreach($profitDepartment as $p){
	$netS1[]=$p-$costS1[$i];
	$i++;
}
//print_r($netS1);

$i=0;

$fromS2=array();
foreach($departments as $d){
	$fromS2[]= "(S - 2)_($d)";
	$i++;
}
$i=0;
$netS2=array();
$costS2=array(3,2,8);
$profitDepartment=array(20,30,40);
foreach($profitDepartment as $p){
	$netS2[]=$p-$costS2[$i];
	$i++;
}
//print_r($netS2);
//print_r($from);



$i=0;
$net=array_merge($netS0,$netS1,$netS2);
foreach($supliers as $s){
	foreach($departments as $d){
		$fromto["($s)_($d)"]= $net[$i];
		$i++;
	}
	
}
//print_r($fromto);

function getnet($suppliers,$department,$fromto){
	return $fromto["($suppliers)_($department)"];
}

$v=getnet("S - 1", "D - 1", $fromto);
//print_r($v);

//$suppliers=array_merge($fromS0,$fromS1,$fromS2);

//print_r($suppliers);
$capacity=array(600,300,200);
$demand=array(600,200,300);

$os=New WebIS\OS;

foreach($supliers as $s){
	foreach($departments as $d){
		$os->addVariable("($s)_($d)");
		$os->addObjCoef("($s)_($d)", $obj=getnet($s,$d,$fromto));
	}
}
//print_r($os);
$i=0;
$demand=array(600,200,300);
foreach($departments as $d){
	$demandconstraint[$d]=$demand[$i];
	$i++;
}
//print_r($demandconstraint);


$capacity=array(600,300,200);
$i=0;
foreach($supliers as $s){
	$supplierconstraint[$s]=$capacity[$i];
	$i++;
}
//print_r($supplierconstraint);

foreach ($demandconstraint as $key=>$demcon){
	$os->addConstraint($demcon);
	foreach($supliers as $s){
		$os->addConstraintCoef("($s)_($key)", 1);
	}
}

foreach ($supplierconstraint as $key=>$supcon){
	$os->addConstraint($supcon);
	foreach($departments as $d){
		$os->addConstraintCoef("($key)_($d)", 1);
	}
}
$os->solve();
//print_r($os);
//echo $os->solve();
$v=rand(2,8);
//echo $v;

//random b

$numrandsuppliers=rand(3,7);
$numrandplants=rand(3,7);
$randsupliers=array();
$randdepartments=array();

for ($i=0; $i<$numrandsuppliers; $i++){
	$randsupliers[]="S - $i";
}
for ($i=0; $i<$numrandplants; $i++){
	$randdepartments[]="D - $i";
}
$randnet=array();
$randfromto=array();
$i=0;
foreach($randsupliers as $s){
	foreach($randdepartments as $d){
		$randfromto["($s)_($d)"]= $randnet[$i]=(rand(20,40)-rand(1,8));
		$i++;
	}

}
//print_r($randnet);

function getrandnet($suppliers,$department,$fromto){
	return $fromto["($suppliers)_($department)"];
}

$v=getrandnet("S - 1", "D - 1", $randfromto);

//print_r($v);
//print_r($fromto);
//print_r($supliers);
//print_r($departments);
for ($i=0; $i<$numrandsuppliers; $i++){
	$randcapacity[]=rand(200,600);
}
//print_r($capacity);

for ($i=0; $i<$numrandplants; $i++){
	$randdemand[]=rand(200,600);
}

$i=0;
foreach($randsupliers as $s){
	$randsupplierconstraint[$s]=$randcapacity[$i];
	$i++;
}

//print_r($randsupplierconstraint);
$i=0;
foreach($randdepartments as $d){
	$randdemandconstraint[$d]=$randdemand[$i];
	$i++;
}
//print_r($randdemandconstraint);
//print_r($demand);
$randos=New WebIS\OS;

foreach($randsupliers as $s){
	foreach($randdepartments as $d){
		$randos->addVariable("($s)_($d)");
		$randos->addObjCoef("($s)_($d)", $obj=getnet($s,$d,$randfromto));
	}
}

foreach ($randdemandconstraint as $key=>$demcon){
	$randos->addConstraint($demcon);
	foreach($randsupliers as $s){
		$randos->addConstraintCoef("($s)_($key)", 1);
	}
}

foreach ($randsupplierconstraint as $key=>$supcon){
	$randos->addConstraint($supcon);
	foreach($randdepartments as $d){
		$randos->addConstraintCoef("($key)_($d)", 1);
	}
}

$randos->solve();
//print_r($randos);
//echo $randos->solve();
//print_r($demandconstraint);
//print_r($demand);



//print_r($os);
// refactor to set up function to solve random and formulated
$randsolve=solve($randsupliers,$randdepartments,$randnet,$randcapacity,$randdemand);
$solve=solve($supliers,$departments,$net,$capacity,$demand);
function solve($suppliers=array(),$departments=array(),$net=array(),$capacity=array(),$demand=array()){
	
	$os=New WebIS\OS;
	$i=0;
	foreach($suppliers as $s){
		foreach($departments as $d){
			
			$os->addVariable("($s)_($d)");
			$os->addObjCoef("($s)_($d)", $net[$i]);
			$i++;
		}
	}
	$i=0;
	
	foreach($departments as $d){
		$demandconstraint[$d]=$demand[$i];
		$i++;
	}
	//print_r($demandconstraint);
	
	
	
	$i=0;
	foreach($suppliers as $s){
		$supplierconstraint[$s]=$capacity[$i];
		$i++;
	}
	//print_r($supplierconstraint);
	
	foreach ($demandconstraint as $key=>$demcon){
		$os->addConstraint($demcon);
		foreach($suppliers as $s){
			$os->addConstraintCoef("($s)_($key)", 1);
		}
	}
	
	foreach ($supplierconstraint as $key=>$supcon){
		$os->addConstraint($supcon);
		foreach($departments as $d){
			$os->addConstraintCoef("($key)_($d)", 1);
		}
	}
	echo $os->solve();
	
	
}





?>
<table border=1>
<?php
//print_r($os);
//echo $os->getSolution();
$header=array('Suppliers', 'Department-0','Department-1','Department-2');
foreach($header as $h){
	echo "<th>$h</th>";
	}
foreach ($supliers as $s){
	echo "<tr><th>$s</th>";
	foreach ($departments as $d){
		echo  "<td>".$fromto["($s)_($d)"]."</td>";
		 
	}		
	echo "\n";
	
}
?>
</table>

<table border=1>
<?php


$header=array('Suppliers', 'Department-0','Department-1','Department-2');
foreach($header as $h){

	echo "<th>$h</th>";
}
foreach ($supliers as $s){
	echo "<tr><th>$s</th>";
	foreach ($departments as $d){
		echo  "<td>".$os->getVariable("($s)_($d)")."</td>";
			
	}
	echo "\n";

}



?>
</table>

<table border=1>
<?php
//print_r($os);
//echo $os->getSolution();


$sup=array("Suppliers");
$randheader=array_merge($sup, $randdepartments);
foreach($randheader as $h){

	echo "<th>$h</th>";
}
foreach ($randsupliers as $s){
	echo "<tr><th>$s</th>";
	foreach ($randdepartments as $d){
		echo  "<td>".$randos->getVariable("($s)_($d)")."</td>";
			
	}
	echo "\n";

}



?>
</table>
<table border=1>
<?php
//print_r($os);
//echo $os->getSolution();

foreach($randheader as $h){
	echo "<th>$h</th>";
	}
	$i=0;
foreach ($randsupliers as $s){
	echo "<tr><th>$s</th>";
	foreach ($randdepartments as $d){
		echo  "<td>".$randnet[$i]."</td>";
		 $i++;
	}		
	echo "\n";
	
}
?>
</table>

