
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert Subcells</title>
</head>
<body>
Insert a New Subcell
<p></p>
<?php 
require_once 'Work-Cell-Scheduler/App/subcellApp.php';
$a=new \WCS\subcellApp();
$a->process("subcell.php");

?>



<br></br> 
<a
href="http://127.0.0.1:8000/Work-Cell-Scheduler/Web/">
Go to index page
</a>


</body>
</html>