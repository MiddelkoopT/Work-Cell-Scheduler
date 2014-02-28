<!DOCTYPE html>
<html>
<head>
<!-- Ping Test Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>WCS</title>
</head>
<body>
<h1>Ping</h1>
<p>App:
<?php 
require_once 'Work-Cell-Scheduler/App/pingApp.php';
if(isset($_REQUEST['ping'])){
	$p=new WCS\Ping();
	echo htmlspecialchars($p->ping($_REQUEST['ping']));
}
?>
</p>

</body>
</html>