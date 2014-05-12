<!DOCTYPE html>
<html>
<head>

<!-- Joe Ahlbrandt Exam 1 Part B 

(d) 

display the input and output in html using tables 
This only diplays the input and output from the random problem 

-->
<meta charset="UTF-8">
<title>Exam 1</title>
</head>
<body>
<h1>EXAM INPUT AND OUTPUT</h1>
<p> 
</p>
<?php

include_once 'E1bRandom.php';
echo "<h3>The maximum profit = $$os->solution</h3>";

//shipping matrix
echo "<h4>Shipping Matrix";
echo "<table border='1'><tr><td>\n";

foreach($suppliers as $s){
	echo "<th>$s</th>";
}
foreach($departments as $d){
	echo "<tr><th>${d} ";
	foreach($suppliers as $s){
		$var="${s}-${d}";
		$val=$os->getVariable($var);
		echo "<td>$val </td>";
	}
	echo "<tr>\n";
}
echo "</tr>";
echo "\n</table>";

echo "\n";


//capacity matrix
echo "<h4>Capacity Matrix";
echo "<table border='1'><tr><td>\n";

foreach($suppliers as $s){
	echo "<th>$s</th>";
}
echo "<tr>";
echo "<td></td>";
foreach($supplierCap as $sc){
	echo "<td>$sc->capacity </td>";
}
echo "</tr>";
echo "\n</table>";

echo "\n";



//Demand matrix
echo "<h4>Demand Matrix";
echo "<table border='1'><tr><td>\n";

foreach($departments as $d){
	echo "<th>$d</th>";
}
echo "<tr>";
echo "<td></td>";
foreach($departmentDem as $dd){
	echo "<td>$dd->demand </td>";
}
echo "</tr>";
echo "\n</table>";

echo "\n";

//Profit matrix
echo "<h4>Profit Matrix";
echo "<table border='1'><tr><td>\n";

foreach($departments as $d){
	echo "<th>$d</th>";
}
echo "<tr>";
echo "<td></td>";
foreach($departmentDem as $dd){
	echo "<td>$$dd->profit </td>";
}
echo "</tr>";
echo "\n</table>";

echo "\n";


//Distance matrix
echo "<h4>Distance Matrix";
echo "<table border='1'><tr><td>\n";

foreach($suppliers as $s){
	echo "<th>$s</th>";
}
foreach($departments as $d){
	echo "<tr><th>${d} ";
	foreach($suppliers as $s){
		$var="${s}-${d}";
		$val=$distanceMatrix[$var]->distance;
		echo "<td>$val </td>";
	}
	echo "<tr>\n";
}
echo "</tr>";
echo "\n</table>";
echo "\n";
echo "\n</body></html>\n";
?>

</body>
</html>