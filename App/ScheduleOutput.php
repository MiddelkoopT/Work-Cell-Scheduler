<?php

//ARRAYS WOULD BE DUMPED IN $time, $employee, $workstation, $cell FROM THE SOLVER BASED ON WORKER TRAINING
//Dr. M WOULD STAY IN WS1010 FROM 0000 UNTIL 0200 AND THEN SWITCH TO WS1020

$time = array('0000','0000','0030','0030','0100','0200');
$employee = array("Dr. Middelkoop", "JD", "AL", "BG","SM","Dr. Middelkoop");
$workstation = array(1010,1020,1030,1040,1050,1020);
$cell = array(1000,1000,1000,2000,2000,1000);


echo "<table width='800' cellpadding='5' cellspacing='5' border='1'>";

echo "<tr><th>Time</th><th>Employee</th><th>Cell</th><th>Workstation</th></tr>";

for ($i = 0; $i <= sizeof($employee)-1; $i++) {

	echo "<tr><th>$time[$i]</th><td>$employee[$i]</td><td>$cell[$i]</td><td>$workstation[$i]</td></tr>";
}

echo "</table>";

?>