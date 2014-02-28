<?php

require_once 'Work-Cell-Scheduler/Config/global.php';
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';

$peopleass = array();
for($i=0;$i<6;$i++){
$period[$i] = array();
}

	$db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'database');
	if($db===NULL){
		echo "no connect";
		exit();
		}
//PeopleAssignments
	$data=$db->prepare("SELECT personcell FROM OutputMatrix");
	if($data===FALSE){
		echo "prepare wrong ",$db->error;
		exit();
		}
	$data->execute();
	$data->bind_result($personcell);
	$people=array();
	while($data->fetch()){
		$peopleass[]=$personcell;
		}
		
//Period1
		$data=$db->prepare("SELECT period1 FROM OutputMatrix");
		if($data===FALSE){
			echo "prepare wrong ",$db->error;
			exit();
		}
		$data->execute();
		$data->bind_result($period);
		$period1=array();
		while($data->fetch()){
			$period1[]=$period;
		}	

//Period2
		$data=$db->prepare("SELECT period2 FROM OutputMatrix");
		if($data===FALSE){
			echo "prepare wrong ",$db->error;
			exit();
		}
		$data->execute();
		$data->bind_result($period);
		$period2=array();
		while($data->fetch()){
			$period2[]=$period;
		}

//Period3
		$data=$db->prepare("SELECT period3 FROM OutputMatrix");
		if($data===FALSE){
			echo "prepare wrong ",$db->error;
			exit();
		}
		$data->execute();
		$data->bind_result($period);
		$period3=array();
		while($data->fetch()){
			$period3[]=$period;
		}

//Period4
		$data=$db->prepare("SELECT period4 FROM OutputMatrix");
		if($data===FALSE){
			echo "prepare wrong ",$db->error;
			exit();
		}
		$data->execute();
		$data->bind_result($period);
		$period4=array();
		while($data->fetch()){
			$period4[]=$period;
		}

//Period5
		$data=$db->prepare("SELECT period5 FROM OutputMatrix");
		if($data===FALSE){
			echo "prepare wrong ",$db->error;
			exit();
		}
		$data->execute();
		$data->bind_result($period);
		$period5=array();
		while($data->fetch()){
			$period5[]=$period;
		}

//Period6
		$data=$db->prepare("SELECT period6 FROM OutputMatrix");
		if($data===FALSE){
			echo "prepare wrong ",$db->error;
			exit();
		}
		$data->execute();
		$data->bind_result($period);
		$period6=array();
		while($data->fetch()){
			$period6[]=$period;
		}
	
		
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Output Matrix</title>
</head>
<body>

<h1>Output Matrix</h1>

<table border='1'>

<tr>
	<td><?php echo "Worker Assignments";?></td>
	<td><?php echo "Period 1";?></td>
	<td><?php echo "Period 2";?></td>
	<td><?php echo "Period 3";?></td>
	<td><?php echo "Period 4";?></td>
	<td><?php echo "Period 5";?></td>
	<td><?php echo "Period 6";?></td>
</tr>	
	
<?php
for($i=0;$i<6;$i++){
	$var1=$i;
	$var2=$i;
	?>
	<tr>
		<td><?php echo $peopleass[$i];?>  </td>
		<td> <?php echo $period1[$i]; ?> </td>
		<td> <?php echo $period2[$i]; ?> </td>
		<td> <?php echo $period3[$i]; ?> </td>
		<td> <?php echo $period4[$i]; ?> </td>
		<td> <?php echo $period5[$i]; ?> </td>
		<td> <?php echo $period6[$i]; ?> </td>
	</tr>
	<?php } ?>

</table>

<?php 
echo '<table><tr>';
?>

