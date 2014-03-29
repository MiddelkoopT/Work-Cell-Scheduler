<!DOCTYPE html>
<html>
<head>
<!-- Employee Edit Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>WCS</title>
</head>
<body>
<?php 
require_once 'Work-Cell-Scheduler/App/employeeApp.php';
$a=new \WCS\EmployeeApp();
$a->process("employee.php");

?>
</body>
</html>