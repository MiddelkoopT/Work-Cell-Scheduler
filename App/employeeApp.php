<?php
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class EmployeeApp {
	private $employee=NULL;

	function add(Employee $employee){
		$this->employee=$employee;
		return TRUE;
	}

	function process($page){
		$this->load();
		$this->save();
		echo $this->edit($page);
	}

	function get(){
		if($this->employee===NULL){
			$this->employee=new Employee();
		}
		if(!$this->employee->setEmployee($_REQUEST['employee'])){
			//print ":PersonApp.process: unable to set employee |".$_REQUEST['employee']."|");
			return FALSE;
		}
		if(isset($_REQUEST['name']) and !$this->employee->setName($_REQUEST['name'])){
			//print ":PersonApp.process: unable to set person |".$_REQUEST['name']."|");
			return FALSE;
		}
	}

	function load(){
		if(!isset($_REQUEST['action'])){
			return FALSE;
		}
		if($_REQUEST['action']!='Load'){
			return FALSE;
		}
		$this->get();
		if($this->employee->read()===FALSE){
			return FALSE;
		}
		return TRUE;
	}

	function save(){
		if($this->employee===NULL){
			$this->employee=new Employee();
		}
		if(!isset($_REQUEST['action'])){
			return FALSE;
		}
		if($_REQUEST['action']!='Update'){
			return FALSE;
		}
		$this->get();
		if($this->employee->delete()===FALSE){
			print ":employeeApp.save: unable to delete()";
			return FALSE;
		}
		if($this->employee->write()===FALSE){
			print ":employeeApp.save: unable to write()";
			return FALSE;
		}
		return TRUE;
	}

	function edit($action){
		$employee=htmlspecialchars($this->employee->getEmployee());
		$name=htmlspecialchars($this->employee->getName());
		return <<<HTML
		<form action="$action" method="GET">
		<table border="1">
		  <tr><td>Employee</td><td><input type="text" name="employee" value="$employee"></td></tr>
    	  <tr><td>Name</td>  <td><input type="text" name="name"   value="$name"></td></tr>
    	</table>
		<input type="submit" name="action" value="Update">
		<input type="submit" name="action" value="Load">
    	<input type="submit" name="action" value="Write">
    	<input type="submit" name="action" value="Delete">
		</form>
HTML;
	}
	
	function displayEmployee(){
		$result = mysql_query("SELECT employee,name FROM Employee");
		while($row = mysql_fetch_array($result)){
			print "<tr><td>".$row['employee']."</td><td>".$row['name']."</td></tr>";
		}
		print "</table>";
	}
	
}

class Employee {
	private $employee=NULL;
	private $name=NULL;
	private $rate=NULL;

	/**
	 * Database Handle
	 * @var \mysqli
	 */
	static $db=NULL;

	function __construct(){
		if(!is_null(self::$db)){
			return;
		}
		self::$db = @new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
		if(self::$db->connect_error){
			throw new \Exception("Error unable to connect to database: ".self::$db->connect_error);
		}
	}

	function display(){
		$str="{employee: $this->employee";
		if(!is_null($this->name)){
			$str.=" name: $this->name";
		}
		return $str.'}';
	}

	/**
	 * Set employee
	 * @param string $employee Alphanumeric username [a-zA-Z0-9]
	 * @return bool person set.
	 */
	function setEmployee($employee){
		//print ":Employee.setEmployee: |$employee|".gettype($employee);
		if(preg_match('/^[a-zA-Z0-9]+$/',$employee)){
			$this->employee=$employee;
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Set Person name
	 * @param string $name of person.
	 */
	function setName($name){
		if(preg_match('/^\s*$/',$name)){
			return FALSE;
		}
		$this->name=$name;
		return TRUE;
	}

	function getName(){
		return $this->name;
	}

	function getEmployee(){
		return $this->employee;
	}

	function write(){
		$stmt=self::$db->prepare("INSERT INTO Employee (employee,name) VALUES (?,?)");
		if($stmt===FALSE){
			die("employee.write: unable to create statement " . self::$db->error);
			return FALSE;
		}
		if($stmt->bind_param("ss",$this->employee,$this->name)===FALSE){
			die("employee.write: unable to bind " . self::$db->error);
		}
		if($stmt->execute()===FALSE){
			if($stmt->errno==1062){ // Duplicate Entry
				$stmt->close();
				self::$db->close();
				return FALSE;
			}
			die("employee.write: unable to execute self::$db->errno self::$db->error");
			return FALSE;
		}
		$stmt->close();
		return TRUE;
	}

	/**
	 * Remove employee
	 * @return bool TRUE on success (even if record did not exist);
	 */
	function delete(){
		$stmt=self::$db->prepare("DELETE FROM Employee WHERE employee=?");
		if($stmt===FALSE){
			die("WCS/Employee.delete> stmt:".self::$db->error);
			return FALSE;
		}
		if($stmt->bind_param('s',$this->employee)===FALSE){
			die("WCS/Person.delete> bind_param:".self::$db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			die("WCS/Person.delete> execute:".self::$db->errno." ".self::$db->error);
			return FALSE;
		}
		return TRUE;
	}

	function read() {
		$stmt=self::$db->prepare("SELECT name,rate FROM Employee WHERE employee=?");
		if($stmt===FALSE){
			die("employee.get: unable to create statement " . self::$db->error);
			return FALSE;
		}
		if($stmt->bind_param("s",$this->employee)===FALSE){
			die("Person.get: unable to bind_param " . self::$db->error);
			return FALSE;
		}
		if($stmt->bind_result($this->name,$this->rate)===FALSE){
			die("employee.get: unable to bind_result " . self::$db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			die("employee.get: unable to execute self::$db->errno self::$db->error");
			return FALSE;
		}
		if($stmt->fetch()==FALSE){
			$stmt->close();
			return FALSE;
		}
		// print "employee.get: ".$this->display();
		return TRUE;
	}

}


?>