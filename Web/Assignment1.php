<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Assignment 1</title>
</head>
<body>

<p> Couldn't get the database to display the table but atleast I can do this. </p>

<?php

function create_table($data){
	echo "<table border=\"2\">";
	reset($data);
	$value=current($data);
	while ($value){
		echo "<tr><td>".$value."</td></tr>\n";
		$value = next($data);
	}
	echo"</table>";
	
}

$workers = array('Mary','Joe','Jane');
$training = array('1000','1010','1020','1030');
create_table($workers);
create_table($training);
?>


<?php 
class database{
	function display_table(){

		$db = mysql_connect("localhost", "root", "webis")

		or die (mysql_error());

		mysql_select_db("database",$db);

		$this->execute($db,"CREATE TABLE workers
		(
		WorkerID int NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(WorkerID),
		FirstName varchar(255),
		LastName varchar(255),
		WorkCell int,
		WorkStation int,
		wcp double,
		wsp double,
		)"
		);

		$this->execute($db,"INSERT into workers (WorkerID, FirstName, LastName, WorkCell, WorkStation, wcp, wsp)
	VALUES (1, 'Tim', 'Merkel', 1000, 1010, 0.80, 0.80)");
	}
}

?>



</body>
</html>
