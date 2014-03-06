<table border=1>
<?php

$description= array('Worker', 'Work Station', 'WSP');
$db= mysqli('$dbhost', '$dbuser', '$dbpass', 'TrainingMatrix');
$cell = mysql_query("SELECT * FROM TrainingMatrix");
foreach($description as $des)
	echo "<th>$des</th>";
while( $data= mysql_fetch_array($cell))
	echo "<tr>
		<td>".$cell['person']."</td>
		<td>".$cell['workstation']."</td>
		<td>".$cell['wsp']."</td>
		</tr>";
?>
</table>	
<?php


$header= array('Worker', 1010, 1020, 2010, 2020);
$worker= array('Max Smith', 'Sammy Davis', 'Jessica Thompson');
$cell1= array(1000, 1000, 1000);
$cell2= array(2000,2000,2000);
$workstation1010= array (1010, 1010,1010);
$workstation1020= array(1020, 1020, 1020);
$workstation2010= array(2010,2010,2010);
$workstation2020= array(2020,2020,2020);
$wsp1010= array(.9, .7, .5);
$wsp1020= array(.9, .6, .5);
$wsp2010= array(.5, .8, .9);
$wsp2020= array(.7, .9, .9);
?>



<table border=1>

<?php

foreach($header as $h)
	echo "<th>$h</th>";

for($row=0; $row<3; $row++){
	echo "<tr>
		<td>".$worker[$row]."</td>
		<td>".$wsp1010[$row]."</td>
		<td>".$wsp1020[$row]."</td>
		<td>".$wsp2010[$row]."</td>
		<td>".$wsp2020[$row]."</td>
		<tr>";
	
		
	}
	

	



?>
</tr>
</table>
