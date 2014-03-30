<!DOCTYPE html>
<html>
<head>
<!-- Training Test Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>WCS Edit Employee</title>
<style>
caption {caption-side:bottom;}
</style>
</head>
<body>
<h1>WCS Employee Information</h1>
<?php require_once 'Work-Cell-Scheduler/App/workerApp.php';

$a=new \WCS\workerApp();
$a->process("worker.php");
?>
<br>
<p><b>Note:</b> Type in Worker ID and click 'Load' to view Name </p><br>
<br>
<a href="http://127.0.0.1:8000/Work-Cell-Scheduler/Web/">Back to Index Page</a> 
</body>
</html>





