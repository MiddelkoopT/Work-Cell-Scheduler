<?php
// Person App Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';


class PersonApp {
	private $person=NULL;

	function add(Person $person){
		$this->person=$person;
		return TRUE;
	}

	function process($page){
		$this->load();
		$this->save();
		echo $this->edit($page);
	}

	function get(){
		if($this->person===NULL){ 
			$this->person=new Person();
		}
		if(!$this->person->setEmployeeid($_REQUEST['person'])){
			//print ":PersonApp.process: unable to set person |".$_REQUEST['person']."|");
			return FALSE;
		}
		if(isset($_REQUEST['name']) and !$this->person->setEmployeename($_REQUEST['name'])){
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
		if($this->person->select()===FALSE){
			return FALSE;
		}
		return TRUE;
	}

	function save(){
		if($this->person===NULL){
			$this->person=new Person();
		}
		if(!isset($_REQUEST['action'])){
			return FALSE;
		}
		if($_REQUEST['action']!='Update'){
			return FALSE;
		}
		$this->get();
		if($this->person->delete()===FALSE){
			print ":PersonApp.save: unable to delete()";
			return FALSE;
		}
		if($this->person->insert()===FALSE){
			print ":PersonApp.save: unable to write()";
			return FALSE;
		}
	return TRUE;
	}

	function edit($action){
		$person=htmlspecialchars($this->person->getID());
		$name=htmlspecialchars($this->person->getName());
		return <<<HTML
		<form action="$action" method="GET">
		<table border="1">
		<tr><td>Employee ID:</td><td><input type="text" name="person" value="$person"></td></tr>
		<tr><td>Name:</td> <td><input type="text" name="name" value="$name"></td></tr>
		</table>
		<input type="submit" name="action" value="Update">
		<input type="submit" name="action" value="Load">
		</form>
HTML;
	}

	
	
}





class Person {

	/**
	 * Database handle
	 * @var \mysqli
	 */
	private $db=NULL;
	public $employeeid=NULL;
	public $employeename=NULL;
	
	
	function __construct(){
		$this->db= @new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
		if($this->db->connect_error){
			throw new \Exception("Error unable to connect to database: ".$this->db->connect_error);
		}
	}
		
	function destruct(){
		if($this->db!=null){
			$this->db->close();
		}
	}
	
	function setEmployeeid($employeeid){
		if(preg_match('/^[a-zA-Z0-9]+$/',$employeeid)){
			$this->employeeid=$employeeid;
			return TRUE;
		}
		else{ 
			return FALSE;
		}
	}
	
	
	function setEmployeename($employeename){
	if(preg_match('/^[a-zA-Z]+$/',$employeename)){
			$this->employeename=$employeename;
			return TRUE;
		}
		else{ 
			return FALSE;
		}
	}	


	function display(){
		$employeename=$this->employeename;
		if(!is_null($this->employeename)){
			$employeename=" Employee Name: $this->employeename";
		}
		return "Emloyee ID: $this->employeeid".$employeename;
	}	

	function getID(){
		return $this->employeeid;
	}
	
	function getName(){
		return $this->employeename;
	}
	
	
	function insert(){
		$stmt=$this->db->prepare("INSERT INTO Person (employeeid, employeename) VALUES (?,?)");
		if($stmt===FALSE){
			die ("WCS/Person.insert> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('ss',$this->employeeid,$this->employeename)===FALSE){
			die ("WCS/Person.insert> bind_param:".$this->db->error);
			return FALSE;			
		}
		if($stmt->execute()===FALSE){
			if($this->db->errno==1062){
				return FALSE;
			}
			die ("WCS/Person.insert> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}
	
	
	function delete(){
		$stmt=$this->db->prepare("DELETE FROM Person WHERE employeeid=?");
		if($stmt===FALSE){
			die("WCS/Person.delete> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('s',$this->employeeid)===FALSE){
			die("WCS/Person.delete> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			die("WCS/Person.delete> execute:".$this->db->error);
			return FALSE;
		}
		return TRUE;
		
	}
	
	
	function select(){
		$stmt=$this->db->prepare("SELECT employeename FROM Person WHERE employeeid=?");
		if($stmt===FALSE){
			die("WCS/Person.select> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('s',$this->employeeid)===FALSE){
			die("WCS/Person.select> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_result($this->employeename)===FALSE){
			die("WCS/Person.select> bind_result:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			die("WCS/Person.select> execute:".$this->db->error);
			return FALSE;
		}
		return $stmt->fetch();
	}
	
	
	
	
	
	
}

?>
