<?php
//Joe Ahlbrandt
//Exam 1 part b
// (c) continued

//running the refactored static problem (you can set all of the value--
//--this page sets all values for a 4 supplier, 4 department system 


include_once 'E1bRefactorStatic.php';

// first you must set your values that will be passed by the function 

$suppliers = 4;
$departments = 4;

//the demand array will hold the value of demand for department 1, department 2, department 3.....
$demand=array(5000,3000,6500,800);

//the profit array holds the value of profit that will be obtained from each product at department 1, department 2, department 3...
$profit=array(70,65,80,40);

//capacity array is the capacity that each supplier can hold at supplier 1, supplier 2, supplier 3...
$capacity=array(10000,2000,5000,1000);

//distance is a 2D array that holds the distances between each department and supplier
$distance = array(
		array(1,5,2,3), // this line is the distance between supplier 1 and all of the departments S1-D1, S1-D2, S1-D3....
		array(1,9,4,2), // this line is the distance between supplier 2 and all of the departments S2-D1, S2-D2, S2-D3....
		array(10,8,2,1),
		array(4,4,6,5)
	
);

//now that you have your values set, you input them into the function and the solution will be returned 

solveExamProblem($suppliers, $departments, $demand,$profit,$capacity,$distance);

