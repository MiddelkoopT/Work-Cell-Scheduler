<?php

$capacity= array("s1" => 600, "s2" => 300, "s3" => 200);
//print_r($capacity);

$demand=array("d1"=>600, "d2"=>200, "d3"=>300);
//print_r($demand);

$profit=array("d1"=>20, "d2"=>30, "d3"=>40);
//print_r($profit['d1']);

$distance=array("s1,d1"=>2, "s1,d2"=>3, "s1,d3"=>3,"s2,d1"=>5, "s2,d2"=>2, "s2,d3"=>4, "s3,d1"=>3, "s3,d2"=>2, "s3,d3"=>8);
//print_r($distance['s1,d1']);

$a=$demand['d1']*$profit['d1'];
//print_r($a);
$b=$demand['d2']*$profit['d2'];
$c=$demand['d3']*$profit['d3'];

$revenue=$a+$b+$c;
//print_r($revenue);

//300 from s1 to d1

//300 from s1 to d3


?>