<?php
require 'Work-Cell-Scheduler/WCS/os.php';
///
//build the array
$department= array();
$supplier=array();


$supplierNum=3;
$departmentNum=3;

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
$capacity["supplier-1"] = 600;
$capacity["supplier-2"] = 300;
$capacity["supplier-3"] = 200;
//echo "capacity:\n";
//print_r($capacity);

$demand = array();
$demand["department-1"] = 600;
$demand["department-2"] = 200;
$demand["department-3"] = 300;
//echo "demand:\n";
//print_r($demand);

//

$profit = array();
$profit["department-1"] = 20;
$profit["department-2"] = 30;
$profit["department-3"] = 40;
//echo "profit:\n";
//print_r($profit);

$distance=array();
$distance["supplier-1_department-1"] = 2;
$distance["supplier-1_department-2"] = 3;
$distance["supplier-1_department-3"] = 3;
$distance["supplier-2_department-1"] = 5;
$distance["supplier-2_department-2"] = 2;
$distance["supplier-2_department-3"] = 4;
$distance["supplier-3_department-1"] = 3;
$distance["supplier-3_department-2"] = 2;
$distance["supplier-3_department-3"] = 8;
//echo "distance:\n";
//print_r($distance);

// profit - distance (cost)
$paralist=array();
foreach ($department as $D){
	foreach ($supplier as $S){
		$paralist["{$S}_{$D}"] = $profit["$D"]-$distance["{$S}_{$D}"];
		
	}
}
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
print_r($OF->getSolution());

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








