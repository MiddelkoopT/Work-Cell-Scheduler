<!DOCTYPE html>
<html>
<head>
<!-- Training Test Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>WCS Subcell  </title>
<style>
caption {caption-side:bottom;}
</style>
</head>
<body>
<h1>WCS Add/Edit Subcells </h1>

<table border='1'>
<caption>Table 1.3 Display Subcell List </caption>
<tr><th> Subcell List</th></tr>
<?php
require_once 'Work-Cell-Scheduler/App/subcellApp.php';
$s=new WCS\Subcell();
$subcells=$s->getsubcellID();
sort($subcells);
foreach($subcells as $w){
	echo "<tr><td align =center>$w </tr></td>";
}
?>
</table>
<br>
<form action="subcellApp.php" method="get">
				<table border="1">
				<fieldset><legend>Enter Subcel in Form Below:</legend>
				<tr><td>Subcell:</td><td><input type="text" name="subcelly"></td></tr>
				<tr><td> <input type="submit" name="action" value="Update Subcell"></td></tr>
				</fieldset>
	
				</table>
</form>
<br>
<a href="http://127.0.0.1:8000/Work-Cell-Scheduler/Web/">Back to Index Page</a> 

</body>
</html>
