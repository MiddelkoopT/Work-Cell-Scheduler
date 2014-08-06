<?php
namespace WCS;
require_once 'Work-Cell-Scheduler/TDD/validator.php';
require_once 'a2Class.php';
require_once 'Work-Cell-Scheduler/Config/global.php';
?>

<form action="a2.php" method="post">
    <div>
    <h1>WCS\TrainingMatrix Database</h1> 
    <h1>Input</h1> 
    (for searching, just input person's name)<br></br>
    
        Person:<br>
        <input type="text" name="person" /><br>
        
        Cell: <br>
        <input type="text" name="cell" /><br>
        
        Worksation:<br>
        <input type="text" name="workstation" /><br>
        
        Wcp:<br>
        <input type="text" name="wcp" /><br>
        
         Wsp:<br>
        <input type="text" name="wsp" /><br>
        
        <input type="submit" name="search" value="Search"/>
        <input type="submit" name="add" value="Add"/>
    </div>
        
     <br></br>
        
    <div>
    <h1>Result</h1>
        <table width='600px' border='1' style="text-align: left">
    	<tr>
        <th>person</th>
        <th>cell</th>
        <th>workstation</th>
        <th>wcp</th>
        <th>wsp</th>
        <th>ACTION</th>
        <th>ACTION</th>
    	</tr>
    
<?php
	$p=new \WCS\Worker();
	$result = NULL;
	
	if(isset($_POST['search'])){
		$p->person = $_POST['person'];
		$result = $p->search();
	
	}
	
	if(isset($_POST['add'])){
		$p->person = $_POST['person'];
		$p->cell = $_POST['cell'];
		$p->workstation = $_POST['workstation'];
		$p->wcp = $_POST['wcp'];
		$p->wsp = $_POST['wsp'];
		$p->insert();
		$result = $p->result;
		
	
	}
	
	
	if(isset($_POST['save']))
	{
		 
	
		$p->person = $_POST['person2'];
		$p->cell = $_POST['cell2'];
		$p->workstation = $_POST['workstation2'];
		$p->wcp = $_POST['wcp2'];
		$p->wsp = $_POST['wsp2'];

		$p->save();
		$result = $p->search();
	}

?>

		

<?php

	if (isset($result))
	{
?>
      
      <tr>
       <td><?php echo $result['person']; ?></td>
       <td><?php echo $result['cell']; ?></td>
       <td><?php echo $result['workstation']; ?></td>
       <td><?php echo $result['wcp']; ?></td>
       <td><?php echo $result['wsp']; ?></td>
       
       <td><a href="?edit=<?php echo $p->person; ?>">Edit</a></td>
       <td><a href="?delete=<?php echo $p->person; ?>">Delete</a></td>
       </tr>
       
 <?php
}
?>      
      </table>
       
<!--        while($row = mysql_fetch_array($result)) -->
<!-- 	{ -->
<!-- 		echo "<tr>"; -->
<!-- 		echo "<td>" . $row['person'] . "</td>"; -->
<!-- 		echo "<td>" . $row['cell'] . "</td>"; -->
<!-- 		echo "<td>" . $row['workstation'] . "</td>"; -->
<!-- 		echo "<td>" . $row['wcp'] . "</td>"; -->
<!-- 		echo "<td>" . $row['wsp'] . "</td>"; -->
<!-- 		echo "</tr>"; -->
<!-- 	} -->
<!-- 	echo "</table>"; -->
       
       
       
<?php
// }
?>
        
        
   </div>
   
    <br></br>
   
   
    <?php
    
    
    if(isset($_GET['delete']))
	{ 
		$p->person = $_GET['delete'];
		$p->delete(); 
    }
    
    if(isset($_GET['edit']))
	{ 
		$p->person = $_GET['edit'];
		$result = $p->search();  
	?>
	<div>
    <h1>Edit</h1>
        Person:<br>
        <input type="text" name="person2" value="<?php echo $result['person']; ?>" (read only) /><br>
        
        Cell: <br>
        <input type="text" name="cell2" value="<?php echo $result['cell']; ?>" /><br>
        
        Worksation:<br>
        <input type="text" name="workstation2" value="<?php echo $result['workstation']; ?>" /><br>
        
        Wcp:<br>
        <input type="text" name="wcp2" value="<?php echo $result['workstation']; ?>" /><br>
        
         Wsp:<br>
        <input type="text" name="wsp2" value="<?php echo $result['workstation']; ?>" /><br>
        
        <input type="submit" name="save" value="Save"/>
    </div>
        

	<?php
	
	
	
    }
    

    
	?>
	

        
</form>



<?php 

?>


