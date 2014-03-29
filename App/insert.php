<?php
namespace WCS;
//include ("outputTable.php");

static $dbhost='127.0.0.1';
static $dbuser='root';
static $dbpassword='webis';
static $dbdatabase='WCS';

$dbConn = mysql_connect ($dbhost, $dbuser, $dbpassword) or die ('MySQL connect failed. ' . mysql_error());
mysql_select_db($dbdatabase,$dbConn) or die('Cannot select database. ' . mysql_error());

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
 if (isset($_POST['person'])) {
 	$person = $_POST['person'];
 } 
 if (isset($_POST['cell'])) {
  	$cell = $_POST['cell'];
 }
 if (isset($_POST['training'])) {
 	$training = $_POST['training'];
 }
 if (isset($_POST['ergo'])) {
 	$ergo = $_POST['ergo'];
 }

$sql="INSERT INTO TrainingMatrix (Person, Cell, Training) 
	VALUES ('person','cell','training','ergo')";

if (!mysql_query($sql,$dbConn))
  {
  die('Error: ' . mysql_error($dbConn));
  }
echo "1 record added";

mysqli_close($dbConn);
?>