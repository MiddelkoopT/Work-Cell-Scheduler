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

//B: Setup problem and data structures

//B1: create arrays for workers,cells,products
$numworkers=5;
$numcells=4;
$numproducts=6;

for($i = 0; $i < $numworkers; $i++) {
	$workers[] = "worker-$i";
}

for($i = 0; $i < $numcells; $i++) {
	$cells[] = "cell-$i";
}

for($i = 0; $i < $numproducts; $i++) {
	$products[] = "product-$i";
}

//B2: Pick at random a worker and use TDD to test
 assertEquals("worker-1", $workers[1]);

//B3: Create demand using a structure/class that holds (products,cells,hours)
$demand=array();

class Demand{
	Public $product;
	Public $cell;
	Public $hours;
	
	function __construct($p,$c,$h){
		$this->product=$p;
		$this->cell=$c;
		$this->hours=$h;
	}	
}
 
$numlist=10;
for($i = 0; $i < $numlist; $i++) {
	$demandList[]= new Demand($products[array_rand($products)],$cells[array_rand($cells)] ,rand(1,3));
}

//print_r($demandList);

//B4: Create training matrix class to hold worker/cell productivity

//SET
$productivity=array();
foreach($workers as $wo){
	foreach($cells as $ce){
		$productivity["{$wo}_{$ce}"]= rand(0,100)/100.0;
	}
}
//print_r($productivity);

//GET
function getProductivity($worker,$cell,$productivity){
	if (array_key_exists("{$worker}_{$cell}", $productivity)===FALSE){
		return 0.5;
	}
	return $productivity["{$worker}_{$cell}"];
}

$v = getProductivity("worker-1", "cell-1",$productivity);

//print_r($v);

//C: Optimization 
//C0: Solve empty problem
require_once 'Work-Cell-Scheduler/WCS/os.php';
$a=new WebIS\OS();
$a->solve();
//print_r($a);

//C1: setup obj function, minimize worker hours on each cell
$obj=array();
foreach($workers as $wo){
	foreach($cells as $ce){
		$b=$a->addVariable("{$wo}_{$ce}");
		$a->addObjCoef("{$wo}_{$ce}", 1);
	}
}
//print_r($a);


//C2: cell requirements, 
$cellrequirements=array();

foreach ($cells as $c){
	$cellrequirements[$c]=0;
}

foreach($demandList as $demand){
	$cellrequirements[$demand->cell] += $demand->hours;
}

//print_r($cellrequirements);

$tph=0;
foreach($cellrequirements as $c){
	$tph= $tph + $c;
}

//print_r($tph);

//Generate constraints 
foreach($cellrequirements as $key=>$cr){
	$constraint=$a->addConstraint(NULL,$cr);
	foreach($workers as $w){
		$a->addConstraintCoef("{$w}_{$key}", $productivity["{$w}_{$key}"]);
	}
}

//echo $a->solve();

//C4: Check total hours allocated is atleast the total required
assert($a->solve()>=$tph);

//C5: Cap worker hours to 8 a day
foreach($workers as $wo){
	$a->addConstraint(8,NULL);
	foreach($cells as $ce){
		$a->addConstraintCoef("{$wo}_{$ce}", 1);
	}
}

echo "Total Worker Hours: ";
echo $a->solve();
print_r($a);


//Display products on each cell

$p=array();

foreach ($cells as $c){
	$p[$c]="";
}

foreach($demandList as $demand){
	$p[$demand->cell] .= "$demand->product";
}

//print_r($p);
	
?>


<html>
<head>
<meta charset="UTF-8">
<title></title>
</head>
<body>
<h1>Worker Hours per Cell</h1>
<p>
<table border='1'>

<tr><th></th>
<?php 
foreach($cells as $c){
	echo "<th>$c\n";
}	
?>
</tr>
<?php 
foreach($workers as $w){
	echo "<tr><th>$w</th>";	
	foreach($cells as $c){
		echo "<td>".$a->getVariable("{$w}_{$c}")."</td>";		
		echo "\n";
	}	
}
?>

</table>


<html>
<head>
<meta charset="UTF-8">
<title></title>
</head>
<body>
<h1>Worker Productivity</h1>
<p>
<table border='1'>

<tr><th></th>
<?php 
foreach($cells as $c){
	echo "<th>$c\n";
}	
?>
</tr>
<?php 
foreach($workers as $w){
	echo "<tr><th>$w</th>";	
	foreach($cells as $c){
		echo "<td>".$productivity["{$w}_{$c}"]."</td>";		
		echo "\n";
	}	
}
?>

</table>

</body>
</html>






