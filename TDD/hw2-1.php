<?php

require_once 'Work-Cell-Scheduler/Config/global.php';
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';

$people = array();
$cells = array();
$workstations = array();
$wcps = array();
$wsps = array();

$db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'database');
if($db===NULL){
	echo "no connect";
	exit();
}

//People
$data=$db->prepare("SELECT person FROM TrainingMatrix");
if($data===FALSE){
	echo "prepare wrong ",$db->error;
	exit();
}
$data->execute();
$data->bind_result($person);
$people=array();
while($data->fetch()){
	$people[]=$person;
}

//Cells
$data=$db->prepare("SELECT cell FROM TrainingMatrix");
if($data===FALSE){
	echo "prepare wrong ",$db->error;
	exit();
}
$data->execute();
$data->bind_result($cell);
$cells=array();
while($data->fetch()){
	$cells[]=$cell;
}

//Workstations
$data=$db->prepare("SELECT workstation FROM TrainingMatrix");
if($data===FALSE){
	echo "prepare wrong ",$db->error;
	exit();
}
$data->execute();
$data->bind_result($workstation);
$workstations=array();
while($data->fetch()){
	$workstations[]=$workstation;
}

//WCPs
$data=$db->prepare("SELECT wcp FROM TrainingMatrix");
if($data===FALSE){
	echo "prepare wrong ",$db->error;
	exit();
}
$data->execute();
$data->bind_result($wcp);
$wcps=array();
while($data->fetch()){
	$wcps[]=$wcp;
}

//WSPs
$data=$db->prepare("SELECT wsp FROM TrainingMatrix");
if($data===FALSE){
	echo "prepare wrong ",$db->error;
	exit();
}
$data->execute();
$data->bind_result($wsp);
$wsps=array();
while($data->fetch()){
	$wsps[]=$wsp;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Training Matrix</title>
</head>
<body>

<h1>Training Matrix</h1>

<table border='1'>

<tr>
	<td><?php echo "Workers";?></td>
	<td><?php echo "Cell";?></td>
	<td><?php echo "WorkStation";?></td>
	<td><?php echo "WCPs";?></td>
	<td><?php echo "WSPs";?></td>
</tr>	
	
<?php
for($i=0;$i<6;$i++){
	$var1=$i;
	$var2=$i;
	?>
	<tr>
		<td><?php echo $people[$i];?>  </td>
		<td> <?php echo $cells[$i]; ?> </td>
		<td> <?php echo $workstations[$i]; ?> </td>
		<td><?php echo $wcps[$i];?>  </td>
		<td><?php echo $wsps[$i];?>  </td>
	</tr>
	<?php } ?>

</table>

<?php 
echo '<table><tr>';
?>
