<?php
echo "<html><Head><Title>Pooval's Optimization</Title></Head><body>";

require_once 'Work-Cell-Scheduler/Web/topic-a7.php';
require_once 'Work-Cell-Scheduler/Web/Functions.php';

echo "Kurt Ehlers KJE7CF";
echo "<br><br>";

//SolveAssignmentProblemRandomly(8, 7, 9, 15, 8, 8);

//$matrixvals=array(.85,.95,.87,.94,.88,.96,.98,.89,.98,.82,.83,.93);

//$p=SetUpAssignmentProblem(4, 3, 5, $matrixvals, 8, 8);
//SolveSetUpAssignmentProblem($p);

$capacityarray = array(600,300,200);

$demandarray = array(600,200,300);

$profitarray = array(20,30,40,20,30,40,20,30,40);

$costarray = array(2,3,3,5,2,4,3,2,8);

//$k=SetUpRoutingProblem(3, 3, $capacityarray, $demandarray, $profitarray, $costarray);
//$k=SolveSetUpRoutingProblem($k);

$k=RandomlySolveRoutingProblemNew(4, 7);
MakeCapacityTable($k);
MakeDemandTable($k);
MakeProfitTable($k);
MakeCostTable($k);
MakeTotalProfitTable($k);
MakeOutputTable($k);

?>