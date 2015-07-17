
<!DOCTYPE html>
<html>
<head>
<!-- Person Edit Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>SEARCH</title>
</head>
<body>
<?php require_once 'Work-Cell-Scheduler/App/projectAPP.php';?>
<strong>
<font style="font-family:Cursive;color:green" size="5">Worker</font>
</strong>
<form action="webpage.php" method="GET">
<?php 
$a=new \WCS\WorkerApp();
$a->process();
$b=new \WCS\WorkerApp();
$b->process();
?>
	<input type="submit" name="action1" value="Update">
	<input type="submit" name="action1" value="Load">
	<input type="submit" name= "action1" value="Clear">
</form>
<strong><font style = "font-family:Cursive;color:Coral" size="5">Subcell</font></strong>
<form action="webpage.php" method="GET">
<?php 
$d=new \WCS\SubcellApp();
$d->process();
$e=new \WCS\SubcellApp();
$e->process();

?>
	<input type="submit" name="action2" value="Update">
	<input type="submit" name="action2" value="Load">
	<input type="submit" name= "action2" value="Clear">
</form>
<strong><font style = "font-family:Cursive;color:CornflowerBlue" size="5">Training</font></strong>
<form action="webpage.php" method="GET">
<?php 
$a=new \WCS\TrainingApp();
$a->process();



?>
	<input type="submit" name="action3" value="Update">
	<input type="submit" name="action3" value="Load">
	<input type="submit" name= "action3" value="Clear">
	<input type="submit" name= "action3" value="Display">
</form>

</body>
</html>

