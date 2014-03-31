<!DOCTYPE html>
<html>
<head>
<!-- Person Edit Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>Add and Update Employee Information</title>
</head>
<body>
Add and Update Employee Information below:
<?php
require_once 'Work-Cell-Scheduler/App/personApp.php';
$a=new \WCS\PersonApp();
$a->process("person.php");
?>

<br></br>

<a
href="http://127.0.0.1:8000/Work-Cell-Scheduler/Web/">
Go to index page
</a>

</body>
</html>


