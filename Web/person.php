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
require_once 'Work-Cell-Scheduler/App/personApp.php';
$a=new \WCS\PersonApp();
$a->load();
echo $a->edit("person.php");

?>
</p>

</body>
</html>