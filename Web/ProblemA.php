<?php
require 'Work-Cell-Scheduler/WCS/os.php';
////
//build the array
$department= array();
$supplier=array();


$supplierNum=4;
$departmentNum=5;

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
$capacity["supplier-4"] = 500;
//echo "capacity:\n";
//print_r($capacity);

$demand = array();
$demand["department-1"] = 600;
$demand["department-2"] = 200;
$demand["department-3"] = 300;
$demand["department-4"] = 100;
$demand["department-5"] = 300;
//echo "demand:\n";
//print_r($demand);

//

$profit = array();
$profit["department-1"] = 20;
$profit["department-2"] = 30;
$profit["department-3"] = 40;
$profit["department-4"] = 25;
$profit["department-5"] = 25;
//echo "profit:\n";
//print_r($profit);

$productionCost = array();
$productionCost["supplier-1"] = 10;
$productionCost["supplier-2"] = 14;
$productionCost["supplier-3"] = 40;
$productionCost["supplier-4"] = 11;

$distance=array();
$distance["supplier-1_department-1"] = 2;
$distance["supplier-1_department-2"] = 3;
$distance["supplier-1_department-3"] = 3;
$distance["supplier-1_department-4"] = 3;
$distance["supplier-1_department-5"] = 3;
$distance["supplier-2_department-1"] = 5;
$distance["supplier-2_department-2"] = 2;
$distance["supplier-2_department-3"] = 4;
$distance["supplier-2_department-4"] = 4;
$distance["supplier-2_department-5"] = 2;
$distance["supplier-3_department-1"] = 3;
$distance["supplier-3_department-2"] = 2;
$distance["supplier-3_department-3"] = 8;
$distance["supplier-3_department-4"] = 2;
$distance["supplier-3_department-5"] = 2;
$distance["supplier-4_department-1"] = 3;
$distance["supplier-4_department-2"] = 2;
$distance["supplier-4_department-3"] = 4;
$distance["supplier-4_department-4"] = 2;
$distance["supplier-4_department-5"] = 2;

//echo "distance:\n";
//print_r($distance);

// profit - distance (cost)
$paralist=array();
foreach ($department as $D){
	foreach ($supplier as $S){
		$paralist["{$S}_{$D}"] = $profit["$D"]-$distance["{$S}_{$D}"] - $productionCost["$S"];
		
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

foreach ($supplier as $S){
	$OF->addConstraint(100,NULL);
	foreach($department as $D){
		$OF->addConstraintCoef("{$S}_{$D}", 1);
	}
}



// solve problem

$OF->solve();
echo "<h3>Jianghong Li</h3>";
echo "<h3>14149339</h3>";
echo "<h3>Pawprint: jlrzf</h3>";
echo "solution is :";
print_r($OF->getSolution());


$supplierCost=array();

foreach ($supplier as $S){
		$supplierCost["$S"] = 0;
}
foreach ($supplier as $S){
	foreach($department as $D){
		$supplierCost["$S"]+=$OF->getVariable("{$S}_{$D}")*$productionCost["$S"];

	}
}

//echo "supplierCost";
//print_r($supplierCost);

$departProfit=array();

foreach ($department as $D){
	$departProfit["$D"] = 0;
}
foreach ($supplier as $S){
	foreach($department as $D){
		$departProfit["$D"]+=$OF->getVariable("{$S}_{$D}")*$profit["$D"];

	}
}

//echo "departProfit";
//print_r($departProfit);



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
echo "<br/>";

echo "supplier cost:";
echo "<table border='1'>\n";
foreach($supplier as $S){
	echo "<tr><th>$S</th>";
	echo "<td>$supplierCost[$S]</td></tr>";
}
echo "\n</table>";
echo "<br/>";

echo "department profit:";
echo "<table border='1'>\n";
foreach($department as $D){
	echo "<tr><th>$D</th>";
	echo "<td>$departProfit[$D]</td></tr>";
}
echo "\n</table>";
echo "<br/>";


echo "\n</body></html>\n";

//print_r($OF);

?>








