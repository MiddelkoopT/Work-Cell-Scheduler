<!DOCTYPE html>
<html>
<head>
<!-- a2person Test Copyright 2014 by WebIS Spring 2014 class License Apache 2.0 -->
<meta charset="UTF-8">
<title>WCS</title>
</head>
<body>
<h1>a2person</h1>
<p>App:
<?php 
require_once 'Work-Cell-Scheduler/App/a2personApp.php';


?>

<table border="1">
		<tr><td>Person</td> <td><input type="text" name="$id-a2person" value="$person"> </td></tr>
		<tr><td>Name</td><td><input type="text" name="$id-a2name" value="$name"> </td></tr>
		</table>


<input type="submit" name="action" value="Load">
<input type="submit" name="action" value="Update">

</p>

</body>
</html>