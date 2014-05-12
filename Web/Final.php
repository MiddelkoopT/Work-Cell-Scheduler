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

$capacityarray = array(600,300,200,500);

$demandarray = array(600,200,300,100,300);

$profitarray = array(20,30,40,25,25,20,30,40,25,25,20,30,40,25,25,20,30,40,25,25);

$costarray = array(2,3,3,3,3,5,2,4,4,2,3,2,8,2,2,3,2,4,2,2);

$prodcostarray = array(10,10,10,10,10,14,14,14,14,14,40,40,40,40,40,11,11,11,11,11);

$k=SetUpRoutingProblem(4, 5, $capacityarray, $demandarray, $profitarray, $costarray, $prodcostarray);
$k=SolveSetUpRoutingProblem($k);

//$k=RandomlySolveRoutingProblemNew(4, 7);
//$k=RandomlySolveRoutingProblem(5);

MakeCapacityTable($k);
MakeDemandTable($k);
MakeProfitTable($k);
MakeCostTable($k);
MakeProdCostTable($k);
MakeTotalProfitTable($k);
MakePlantCostTable($k);
MakeStoreProfitTable($k);
MakeOutputTable($k);

?>