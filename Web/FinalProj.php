<?php

Require_once 'Work-Cell-Scheduler/WCS/os.php';
Require_once 'Work-Cell-Scheduler/Web/rdmTrans.php';
Require_once 'Work-Cell-Scheduler/Web/Transp.php';

//SOLVE ASSIGNED PROBLEM

//1.  Set up arrays

//key=supplier, value=capacity
$supplier = array(
		"S1" => 600,
		"S2" => 300,
		"S3" => 200
);

//key=dept, value=demand
$department = array(
		"D1" => 600,
		"D2" => 200,
		"D3" => 500
);
//assign profit per sale for each dept
$dprofit = array(
		"D1" => 20,
		"D2" => 30,
		"D3" => 40
);
//assign distance=cost from S to D
$distance = array(
		"S1_D1" => 2,
		"S1_D2" => 3,
		"S1_D3" => 3,
		"S2_D1" => 5,
		"S2_D2" => 2,
		"S2_D3" => 4,
		"S3_D1" => 3,
		"S3_D2" => 2,
		"S3_D3" => 8
);

//2.Solve using SolveTransportation
SolveTransportation($supplier,$department,$dprofit,$distance);
echo "<br><br><br>";

//SOLVE RANDOM TRANSPORTATION PROBLEM
$NumDepts=rand(5,10);
$NumSuppliers=rand(5,10);
SolveRdmTransportation($NumSuppliers,$NumDepts);


