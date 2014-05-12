<?php

require_once 'Work-Cell-Scheduler/WCS/os.php';
include 'Work-Cell-Scheduler/Web/tdd.php';

$numstores=5;
$numplants=4;
$suppliers=array();
$departments=array();

for ($i=0; $i<$numplants; $i++){
	$suppliers[]="S - $i";
}
for ($i=0; $i<$numstores; $i++){
	$departments[]="D - $i";
}
//print_r($suppliers);
//print_r($departments);
$profitDepartment=array(20,30,40,25,25);
$productioncost=array(10,14,40,11);
$costS0=array(2,3,3,3,3);
$costS1=array(5,2,4,2,2);
$costS2=array(3,2,8,2,2);
$costS3=array(2,2,4,2,2);
$capacity=array(600,300,200,500);
$demand=array(600,200,300,100,300);

$i=0;
foreach($profitDepartment as $p){
	$profit[]=$p-$costS0[$i];
	$i++;
}
$i=0;
foreach($profitDepartment as $p){
	$profit[]=$p-$costS1[$i];
	$i++;
}
$i=0;
foreach($profitDepartment as $p){
	$profit[]=$p-$costS2[$i];
	$i++;
}
$i=0;
foreach($profitDepartment as $p){
	$profit[]=$p-$costS2[$i];
	$i++;
}
$i=0;
//print_r($profit);
foreach($suppliers as $s){
	foreach($departments as $d){
		$fromtoprofit["($s)_($d)"]= $profit[$i];
		$i++;
	}

}
// this will solve without production cost $solve=solve($suppliers,$departments,$fromtoprofit,$capacity,$demand);

//part f
$i=0;
foreach($profitDepartment as $p){
	$net[]=$p-$costS0[$i]-$productioncost[0];
	$i++;
}
//print_r($netS0);


$i=0;
foreach($profitDepartment as $p){
	$net[]=$p-$costS1[$i]-$productioncost[1];
	$i++;
}
//print_r($net);

$i=0;
foreach($profitDepartment as $p){
	$net[]=$p-$costS2[$i]-$productioncost[2];
	$i++;
}
//print_r($net);
//print_r($net);

$i=0;
foreach($profitDepartment as $p){
	$net[]=$p-$costS2[$i]-$productioncost[3];
	$i++;
}
//print_r($net);
$i=0;
foreach($suppliers as $s){
	foreach($departments as $d){
		$fromto["($s)_($d)"]= $net[$i];
		$i++;
	}

}

//print_r($fromto);
$capacity=array(600,300,200,500);
$demand=array(600,200,300,100,300);

$solve=solve($suppliers,$departments,$fromto,$capacity,$demand);
function solve($suppliers=array(),$departments=array(),$fromto=array(),$capacity=array(),$demand=array()){

	$os=New WebIS\OS;
	$i=0;
	foreach($suppliers as $s){
		foreach($departments as $d){
				
			$os->addVariable("($s)_($d)");
			$os->addObjCoef("($s)_($d)", $fromto["($s)_($d)"]);
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
	
	
	
       
	foreach ($suppliers as $s){
		$os->addConstraint(NULL, 100);
		foreach($departments as $d){
			$os->addConstraintCoef("($s)_($d)", 1);
		}
	}
	echo "Optimal solution for having at least 100 supplier production plan"," ","="," ","$", $os->solve();
    //print_r($os);
    ?>
    <table border=1>
    <?php
    
    
    $header=array('Suppliers', 'D-0','D-1','D-2','D-3','D-4');
    foreach($header as $h){
    
    	echo "<th>$h</th>";
    }
    foreach ($suppliers as $s){
    	echo "<tr><th>$s</th>";
    	foreach ($departments as $d){
    		echo  "<td>".$os->getVariable("($s)_($d)")."</td>";
    			
    	}
    	echo "\n";
    
    }
    
    
    
    ?>
    </table>
    <?php 
    
  
    
    
}
?>


