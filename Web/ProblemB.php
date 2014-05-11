<?php
require 'Work-Cell-Scheduler/WCS/os.php';

//build the array
$department= array();
$supplier=array();


$supplierNum=rand(3,5);
$departmentNum=rand(2,4);

for($i=1;$i<=$departmentNum;$i++){

	$department[]="department-$i";

}
//echo "department:\n";
//print_r($department);

for($i=1;$i<=$supplierNum;$i++){

	$supplier[]="supplier-$i";

}
//echo "supplier:\n";
//print_r($supplier);

//constrains
$capacity = array();
foreach($supplier as $S){
		$capacity["$S"]=rand(300,600);
}

//echo "capacity:\n";
//print_r($capacity);

$demand = array();
foreach ($department as $D){
	$demand["$D"]=rand(200,500);
}
//echo "demand:\n";
//print_r($demand);

//

$profit = array();
foreach($department as $D){
	$profit["$D"]=rand(20,50);
}

//echo "profit:\n";
//print_r($profit);

$distance=array();
foreach ($supplier as $S){
	foreach ($department as $D){
		$distance["{$S}_{$D}"] = rand(2,8);
		
	}
}

//echo "distance:\n";
//print_r($distance);

// profit - distance (cost)
$paralist=array();
foreach ($department as $D){
	foreach ($supplier as $S){
		$paralist["{$S}_{$D}"] = $profit["$D"]-$distance["{$S}_{$D}"];

	}
}
//echo "paralist:\n";
//print_r($paralist);

// build the objective function
$OF = new WebIS\OS;
//add varialbes
foreach ($supplier as $S){
	foreach ($department as $D){
		$OF->addVariable("{$S}_{$D}");
		$OF->addObjCoef("{$S}_{$D}", $paralist["{$S}_{$D}"]);
	}
}
//add constrains
foreach ($capacity as $key => $C){
	$OF->addConstraint(NULL,$C);
	foreach ($department as $D){
		$OF->addConstraintCoef("{$key}_{$D}",1);

	}
}

foreach ($demand as $key => $D){
	$OF->addConstraint($D,NULL);
	foreach ($supplier as $S){
		$OF->addConstraintCoef("{$S}_{$key}",1);

	}
}

// solve problem

$OF->solve();

if(($OF->getSolution()==NULL))
	echo "this total number of demand larger than capacity total, you cannot get the solution.";
else
{echo "The solution:\n";
print_r($OF->getSolution());}



//display
//$tmp = 0;
echo "<table border='1'><tr><td>\n";
foreach($supplier as $S){
	echo "<th>$S</th>";
}
foreach($department as $D){
	echo "<tr><th>{$D}: ";
	foreach($supplier as $S){
		$var="${S}_${D}";
		$var=$OF->getVariable($var);
		echo "<td>$var</td>";
}
echo "<tr>\n";
}


echo "\n</table>";

echo "\n</body></html>\n";

//print_r($OF);


?>







