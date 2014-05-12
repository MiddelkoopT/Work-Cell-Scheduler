<html>
<head>
  <title>Schedule Result</title>
</head>
<body>
<h1>Result</h1>
<?php 
//creat short variable names
$search_name=trim($_POST['search_name']);
if (!$search_name){
echo 'You have not entered anything, go back to the previous page'	;
exit;
}
if (!get_magic_quotes_gpc()){	
$search_name=addslashes($search_name);
}
@ $db=new mysqli('localhost','root','webis','database');
if(mysqli_connect_errno()){
echo 'Error:Could not connnect to the database. Try again.';
exit;	
}

$query="SELECT * FORM TrainingMatrix WHERE person='$search_name'";
$result= mysqli_query($db, $query);
echo $result;
echo "<p><strong><br/>Worker:";
echo $result['person'];
echo "<br/>Workstation";
echo $result['workstation'];
echo "<br/>cell:";
echo $result['cell'];
echo "<br/>wsp";
echo $result['wsp'];
echo "<br/>wcp:";
echo $result['wcp'];
echo "</p>";

$result->free();
$db->close();

?>
</body>
</html>

  