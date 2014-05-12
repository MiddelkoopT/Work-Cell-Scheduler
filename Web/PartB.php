<?php

function assertEquals($expected,$result) {
	if(!($expected===$result)){
		$message="assertEquasl: |$expected|$result|\n";
		throw new Exception($message);
	}
}

function assertNotEquals($expected,$result) {
	if(($expected===$result)){
		$message="assertNoeEquasl: |$expected|$result|\n";
		throw new Exception($message);
	}
}


//A: Model and Solve the Linear Program using php and os.php
$capacity=array(600,300,200); //(s0,s1,s2)
$demand=array(600,200,300); //(d0,d1,d2)
$profit=array(20,30,40); //(d0,d1,d2)
$cost=array(2,3,3,5,2,4,3,2,8); //(s0d0,s0d1,s0d2,s1d0,s1d1,s1d2,s2d0,s2d1,s2d2)
$numSupply=3;
$numDepartments=3;

$supply=array();
$departments=array();

for($i = 0; $i < $numSupply; $i++) {
	$supply[] = "s-$i";
}
for($i = 0; $i < $numDepartments; $i++) {
	$departments[] = "d-$i";
}

//create decision variable
$dvariable=array();
foreach($supply as $s){
	foreach ($departments as $d){
		$dvariable[]="{$s}_{$d}";
	}
}
//print_r($dvariable)

//create array that assosiates capacities with supply
$capacityconst[$s]=array();
foreach ($supply as $s){
	$capacityconst[$s]=0;
}
foreach ($supply as $key=>$s){
	$capacityconst[$s]=$capacity[$key];
}
//print_r($capacityconst);
assertEquals(600, $capacityconst["s-0"]);
assertNotEquals(600, $capacityconst["s-1"]);

//create array that associates transportation cost with decision variables
$cost1=array();
foreach($dvariable as $key=>$dv) {
	$cost1[$dv]= $cost[$key];
}
//print_r($cost1);
assertEquals(5, $cost1["s-1_d-0"]);

//create array that associates profit with each department
$profitList=array();
foreach($departments as $key=>$d) {
	$profitList[$d]= $profit[$key];
}
//print_r($profitList);


//assign the correct profit to each decision variable and calculate objective coefficients
$prof=array();
foreach($supply as $s){
	foreach($departments as $d){
		$prof["{$s}_{$d}"]=$profitList[$d];
	}
}
//print_r($prof);
assertEquals(30, $prof["s-1_d-1"]);

$oFCoef=array();
foreach($supply as $s){
	foreach($departments as $d){
		$oFCoef["{$s}_{$d}"]=$prof["{$s}_{$d}"]-$cost1["{$s}_{$d}"];
	}
}
//print_r($oFCoef);
assertEquals(28, $oFCoef["s-2_d-1"]);
assertNotEquals(18, "s-2_d-0");

//Solve empty problem
require_once 'Work-Cell-Scheduler/WCS/os.php';
$a=new WebIS\OS();
$a->solve();
//print_r($a);

//Setup obj function
foreach($dvariable as $dv){
	$b=$a->addVariable("$dv");
	$a->addObjCoef("$dv", $oFCoef[$dv]);
}
//print_r($a);

//Generate Capacity Constraint
foreach ($supply as $s){
	$a->addConstraint($capacityconst[$s],NULL);
	foreach ($departments as $d){
		$a->addConstraintCoef("{$s}_{$d}", 1);
	}
}

//Generate Demand Constraint
foreach($departments as $key=>$d){
	$a->addConstraint(NULL,$demand[$key]);
	foreach ($supply as $s){
		$a->addConstraintCoef("{$s}_{$d}", 1);
	}
}

//echo $a->solve();




//B: Model a random problem with random suppliers, capacity, department stores, demand, profit, and distance between supply and demand

//B1: Generate random suppliers, capacity, department stores, demand, profit, and distance between supply and demand
$numSupply=rand(1,3);
$numDepartments=rand(1,3);

$supply=array();
$departments=array();
for($i = 0; $i < $numSupply; $i++) {
	$supply[] = "s-$i";
}
for($i = 0; $i < $numDepartments; $i++) {
	$departments[] = "d-$i";
}

$capacity=array(); //(s0,s1,s2)
foreach($supply as $s){
	$capacity[]=rand(3,6)*100;
}

$demand=array(); //(d0,d1,d2) 
$profit=array(); //(d0,d1,d2)
foreach($departments as $d){
	$demand[]=rand(1,2)*100;
	$profit[]=rand(3,6)*10;
}

$cost=array(); //(s0d0,s0d1,s0d2,s1d0,s1d1,s1d2,s2d0,s2d1,s2d2)
foreach($supply as $s){
	foreach ($departments as $d){
		$cost[]=rand(1,5);
	}
}

//B2: Solve problem using same code as above
$dvariable=array();
foreach($supply as $s){
	foreach ($departments as $d){
		$dvariable[]="{$s}_{$d}";
	}
}
//print_r($dvariable)

$capacityconst[$s]=array();
foreach ($supply as $s){
	$capacityconst[$s]=0;
}
foreach ($supply as $key=>$s){
	$capacityconst[$s]=$capacity[$key];
}
//print_r($capacityconst);


$cost1=array();
foreach($dvariable as $key=>$dv) {
	$cost1[$dv]= $cost[$key];
}
//print_r($cost1);


$profitList=array();
foreach($departments as $key=>$d) {
	$profitList[$d]= $profit[$key];
}
//print_r($profitList);

$prof=array();
foreach($supply as $s){
	foreach($departments as $d){
		$prof["{$s}_{$d}"]=$profitList[$d];
	}
}
//print_r($prof);

$oFCoef=array();
foreach($supply as $s){
	foreach($departments as $d){
		$oFCoef["{$s}_{$d}"]=$prof["{$s}_{$d}"]-$cost1["{$s}_{$d}"];
	}
}
//print_r($oFCoef);



//Solve empty problem
require_once 'Work-Cell-Scheduler/WCS/os.php';
$a=new WebIS\OS();
$a->solve();
//print_r($a);

//Setup obj function
foreach($dvariable as $dv){
	$b=$a->addVariable("$dv");
	$a->addObjCoef("$dv", $oFCoef[$dv]);
}
//print_r($a);


//Generate Capacity Constraint
foreach ($supply as $s){
	$a->addConstraint($capacityconst[$s],NULL);
	foreach ($departments as $d){
		$a->addConstraintCoef("{$s}_{$d}", 1);
	}
}


//Generate Demand Constraint
foreach($departments as $key=>$d){
	$a->addConstraint(NULL,$demand[$key]);
	foreach ($supply as $s){
		$a->addConstraintCoef("{$s}_{$d}", 1);
	}
}

//echo $a->solve();
//print_r($a);



//C: Refactor a and b to use only a single function to model and solve the optimizaiton problem
//D: HTML output is within function created to refactor 


function solveProblem($numSupply,$numDepartments,$capacity,$demand,$profit,$cost){
	$supply=array();
	$departments=array();
	for($i = 0; $i < $numSupply; $i++) {
		$supply[] = "s-$i";
	}
	for($i = 0; $i < $numDepartments; $i++) {
		$departments[] = "d-$i";
	}

	//If problem is random, input 0 for capacity, demand, profit, cost
	if($capacity===0){
		$capacity=array(); //(s0,s1,s2)
		foreach($supply as $s){
			$capacity[]=rand(3,6)*100;
		}
	}

	if($demand===0){
		$demand=array(); //(d0,d1,d2)
		foreach($departments as $d){
			$demand[]=rand(1,2)*100;
		}
	}

	if($profit===0){
		$profit=array(); //(d0,d1,d2)
		foreach($departments as $d){
			$profit[]=rand(3,6)*100;
		}
	}

	if($cost===0){
		$cost=array(); //(s0d0,s0d1,s0d2,s1d0,s1d1,s1d2,s2d0,s2d1,s2d2)
		foreach($supply as $s){
			foreach ($departments as $d){
				$cost[]=rand(1,5);
			}
		}
	}

	//print_r($capacity);
	//print_r($supply);
	//print_r($departments);
	//print_r($demand);
	//print_r($profit);
	//print_r($cost);

	$dvariable=array();
	foreach($supply as $s){
		foreach ($departments as $d){
			$dvariable[]="{$s}_{$d}";
		}
	}
	//print_r($variable)

	$capacityconst[$s]=array();
	foreach ($supply as $s){
		$capacityconst[$s]=0;
	}
	foreach ($supply as $key=>$s){
		$capacityconst[$s]=$capacity[$key];
	}
	//print_r($capacityconst);


	$cost1=array();
	foreach($dvariable as $key=>$dv) {
		$cost1[$dv]= $cost[$key];
	}
	//print_r($cost1);


	$profitList=array();
	foreach($departments as $key=>$d) {
		$profitList[$d]= $profit[$key];
	}
	//print_r($profitList);

	$prof=array();
	foreach($supply as $s){
		foreach($departments as $d){
			$prof["{$s}_{$d}"]=$profitList[$d];
		}
	}
	//print_r($prof);

	$oFCoef=array();
	foreach($supply as $s){
		foreach($departments as $d){
			$oFCoef["{$s}_{$d}"]=$prof["{$s}_{$d}"]-$cost1["{$s}_{$d}"];
		}
	}
	//print_r($oFCoef);

	//Solve empty problem
	require_once 'Work-Cell-Scheduler/WCS/os.php';
	$a=new WebIS\OS();
	$a->solve();
	//print_r($a);

	//Setup obj function
	foreach($dvariable as $dv){
		$b=$a->addVariable("$dv");
		$a->addObjCoef("$dv", $oFCoef[$dv]);
	}
	//print_r($a);

	//Generate Capacity Constraint
	foreach ($supply as $s){
		$a->addConstraint($capacityconst[$s],NULL);
		foreach ($departments as $d){
			$a->addConstraintCoef("{$s}_{$d}", 1);
		}
	}

	//Generate Demand Constraint
	foreach($departments as $key=>$d){
		$a->addConstraint(NULL,$demand[$key]);
		foreach ($supply as $s){
			$a->addConstraintCoef("{$s}_{$d}", 1);
		}
	}

	$solution= $a->solve();
	//print_r($a);
	?>

	<h2>Problem Formulation:</h2>

	<b>Number of suppliers:</b> <?php echo $numSupply?>
	<br>
	<b>Number of departments:</b> <?php echo $numDepartments?>
	<br>
	<br>
	
	<b>Capacity for each Supplier:</b>
	<p>
	<table border='1'>
	<tr>
	<?php
	foreach($supply as $s){
		echo "<th>$s</b></th>";	
	}	
	echo '</tr>';
	
	echo '<tr>';
	foreach($supply as $key=>$s){
		echo "<td>".$capacity[$key]."</td>";
	}
	echo '</tr>';

	?>
	</table>
	<br>
	<b>Demand for each Department:</b>
	<p>
	<table border='1'>
	<tr>
	<?php
	foreach($departments as $d){
		echo "<th>$d</b></th>";	
	}	
	echo '</tr>';
	
	echo '<tr>';
	foreach($departments as $key=>$d){
		echo "<td>".$demand[$key]."</td>";
	}
	echo '</tr>';

	?>
	</table>
	<br>

	<b>Profit for each Department:</b>
	<p>
	<table border='1'>
	<tr>
	<?php
	foreach($departments as $d){
		echo "<th>$d</b></th>";	
	}	
	echo '</tr>';
	
	echo '<tr>';
	foreach($departments as $key=>$d){
		echo "<td>".$profit[$key]."</td>";
	}
	echo '</tr>';

	?>
	</table>
	
	<br>
	<b>Transportation Cost from Supplier to Department</b>
	<p>
	<table border='1'>
	
	<tr><th></th>
	<?php
	foreach($supply as $s){
		echo "<th>$s\n";
	}
	?>
	</tr>
	<?php 
	foreach($departments as $d){
		echo "<tr><th>$d</th>";	
		foreach($supply as $s){
			echo "<td>".$cost1["{$s}_{$d}"]."</td>";		
			echo "\n";
		}	
	}
	?>
	
	</table>
	
	
	<br>
	
	<b>Objective Function:</b> <br>MAXIMIZE 
	<?php 
	foreach ($dvariable as $d){
		echo "$oFCoef[$d]($d) + ";
	}
	?>
	<br>
	<br>
	<b>Constraints:</b><br>
	1) Capacity Constraint on each supplier
	<br>
	<?php 
	foreach ($supply as $s){
		foreach($departments as $d){
			echo "{$s}_{$d} + ";
		}
		echo " <= $capacityconst[$s]";
		echo '<br>';
	}
	?>
	<br>
	2) Demand Constraint for each department
	<br>
	<?php 
	foreach ($departments as $key=>$d){
		foreach($supply as $s){
			echo "{$s}_{$d} + ";
		}
		echo " >= $demand[$key]";
		echo '<br>';
	}
	

	?>	
	
	<h2>Solution:</h2>

	<b>Total Profit: </b>
	<?php echo $solution?>
	<br>Note: If no solution shown, problem is infeasible<br>
	<br>
	<br>
	<b>Shipping Plan</b>
	<p>
	<table border='1'>
	
	<tr><th></th>
	<?php
	foreach($supply as $s){
		echo "<th>$s\n";
	}
	?>
	</tr>
	<?php 
	foreach($departments as $d){
		echo "<tr><th>$d</th>";	
		foreach($supply as $s){
			echo "<td>".$a->getVariable("{$s}_{$d}")."</td>";		
			echo "\n";
		}	
	}
	?>
	
	</table>
	
	
	
	<?php 	
	echo "-----------------------------------------------------------------------------------------------------------------------------------------------------";
	echo '<br>';
	echo '<br>';
	
}



echo "Name: Jennifer Bergman";
echo '<br>';
echo "Pawprint: JJBY95";
echo '<br>';

echo '<h1>Part A (given problem):</h1>';
solveProblem(3, 3, [600,300,200],[600,200,300],[20,30,40],[2,3,3,5,2,4,3,2,8]);


echo '<h1>Part B (random problem):</h1>';
//echo '<br>';
solveProblem(rand(1,3), rand(1,3), 0,0,0,0);

?>





