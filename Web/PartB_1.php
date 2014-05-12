<?php
function solveProblem($numSupply,$numDepartments,$capacity,$demand,$profit,$cost,$prodCost){
	$supply=array();
	$departments=array();
	for($i = 0; $i < $numSupply; $i++) {
		$supply[] = "s-$i";
	}
	for($i = 0; $i < $numDepartments; $i++) {
		$departments[] = "d-$i";
	}

	if($capacity===0){
		$capacity=array(); //(s0,s1,s2,s3)
		foreach($supply as $s){
			$capacity[]=rand(3,6)*100;
		}		
	}
	
	if($prodCost===0){
		$prodCost=array(); //(s0,s1,s2,s3)
		foreach($supply as $s){
			$prodCost[]=rand(1,5)*10;
		}
	}
	
	if($demand===0){
		$demand=array(); //(d0,d1,d2,d3,d4)
		foreach($departments as $d){
			$demand[]=rand(1,2)*100;
		}
	}
	
	if($profit===0){
		$profit=array(); //(d0,d1,d2,d3,d4)
		foreach($departments as $d){
			$profit[]=rand(3,6)*10;
		}
	}

	if($cost===0){
		$cost=array(); //(s0d0,s0d1,s0d2,s0d3,s0d4,s1d0,s1d1,s1d2,s1d3,s1d4,s2d0,s2d1,s2d2,s2d3,s2d4,s3d0,s3d1,s3d2,s3d3,s3d4)
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
	
	//associate Production Cost with supplier
	$prodCost1=array();
	foreach($supply as $key=>$s){
		$prodCost1[$s]=$prodCost[$key];
	}
	//print_r($prodCost1);
	
	$prodCost2=array();
	foreach($supply as $s){
		foreach($departments as $d){
			$prodCost2["{$s}_{$d}"]=$prodCost1[$s];
		}
	}
	//print_r($prodCost2);
	
	$oFCoef=array();
	foreach($supply as $s){
		foreach($departments as $d){
			$oFCoef["{$s}_{$d}"]=$prof["{$s}_{$d}"]-$cost1["{$s}_{$d}"]-$prodCost2["{$s}_{$d}"];
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
	
	//Plants must produce 100 units each constraint
	foreach($supply as $s){
		$a->addConstraint(NULL,100);
		foreach($departments as $d){
			$a->addConstraintCoef("{$s}_{$d}", 1);
		}
	}
	
	//echo $a->solve();
	$solution= $a->solve();
	//print_r($a);
	
	
	$plantProd=array();
	foreach($supply as $s){
		$plantProd[$s]=0;
	}
	

	foreach($departments as $d){
		foreach ($supply as $s){
			$plantProd[$s] += $a->getVariable("{$s}_{$d}");
		}
	}
	
	print_r($plantProdCost);
	$plantProdCost=array();
	foreach($supply as $s){
		$plantProdCost[$s]=$prodCost1[$s]*$plantProd[$s];
	}
	
	print_r($plantProdCost);
	
	
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
solveProblem(4, 5, [600,300,200,500],[600,200,300,100,300],[20,30,40,25,25],[2,3,3,3,3,5,2,4,4,2,3,2,8,2,2,3,2,4,2,2],[10,14,40,11]);
//(s0d0,s0d1,s0d2,s0d3,s0d4,s1d0,s1d1,s1d2,s1d3,s1d4,s2d0,s2d1,s2d2,s2d3,s2d4,s3d0,s3d1,s3d2,s3d3,s3d4)

//echo '<h1>Part B (random problem):</h1>';
//echo '<br>';
//solveProblem(rand(1,3), rand(1,3), 0,0,0,0,0);




?>


