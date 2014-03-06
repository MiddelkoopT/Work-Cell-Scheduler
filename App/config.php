
<?php

$sDbHost = 'localhost';
$sDbName = 'database';
$sDbUser = 'root';
$sDbPwd  = 'webis';

$dbConn = mysql_connect ($sDbHost, $sDbUser, $sDbPwd) or die ('MySQL connect failed. ' . mysql_error());
mysql_select_db($sDbName,$dbConn) or die('Cannot select database. ' . mysql_error());



?>
