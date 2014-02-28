<?php
//<?php
//require_once 'Work-Cell-Scheduler/App/training.php';
//$t=new WCS\TrainingMatrix();
//foreach($t->getWorkstations() as $w){
	//echo "<th>$w\n";
//} TRIED TO GET WORKSTATIONS FROM TRAINING SQL FETCH TO POPULATE WORKSTATION ARRAY

//</tr>
 
//foreach($t->getPeople() as $p){
	//echo "<tr><td>$p</td>";
	//foreach($t->getWorkstations() as $w) {
		//echo "<td> $p:$w ". $t->getTraining($p,$w);
			
	//echo "\n";
	//TRIED TO GET EMPLOYEE AND TRAINING INFO FROM SQL PULL TO POPLULATE EMPLOYEE ARRAY WITH CORRESPONDING WS TRAINING



$employee = array("Dr. Middelkoop", "JD", "AL", "BG","SM");
$workstation = array(1010,1020,1030,1040,1050);
$ws1010 = array(0.99,0.40,0.50,0.40,0.66);
$ws1020 = array(0.30,0.80,0.60,0,0.35);
$ws1030 = array(0.90,0,0.60,0,0.55);
$ws1040 = array(0.60,0.88,0.40,0.8,0.25);
$ws1050 = array(0.30,0.85,0.33,0.66,0);

echo "<table width='800' cellpadding='5' cellspacing='5' border='1'>";

echo "<tr><th>Employee</th><th>Workstation $workstation[0]</th><th>Workstation $workstation[1]</th><th>Workstation $workstation[2]</th><th>Workstation $workstation[3]</th><th>Workstation $workstation[4]</th></tr>";

for ($i = 0; $i <= sizeof($employee)-1; $i++) {

echo "<tr><th>$employee[$i]</th><td>$ws1010[$i]</td><td>$ws1020[$i]</td><td>$ws1030[$i]</td><td>$ws1040[$i]</td><td>$ws1050[$i]</td></tr>";
}

echo "</table>";

?>