<?php
// Person App Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class PersonApp {
	private $person=NULL;
	
	function add($person){
		$this->person=$person;
		return TRUE;
	}
	
	function load(){
		if(!isset($_REQUEST['action'])){
			return FALSE;
		}
		if($_REQUEST['action']!='Load'){
			return FALSE;
		}
		$p=new Person();
		$p->setPerson($_REQUEST['person']);
		if($p==FALSE){
			return FALSE;
		}
		$this->person=$p;
		return TRUE;
	}
	
	function edit($action){
		$person=htmlspecialchars($this->person->getPerson());
		$name=htmlspecialchars($this->person->getName());
		return <<<HTML
		<form action="$action" type="GET">
		<table border="1">
		  <tr><td>Person</td><td><input type="text" name="person" value="$person"></td></tr>
    	  <tr><td>Name</td>  <td><input type="text" name="name"   value="$name"></td></tr>
    	</table>
		<input type="submit" name="action" value="Update">
		<input type="submit" name="action" value="Load">
HTML;
	}
}


class Person {
	private $person=NULL;
	private $name=NULL;
	
	/**
	 * Database Handle
	 * @var \mysqli
	 */
	private $db=NULL;
	
	function __construct(){
		$this->db = @new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
		if($this->db->connect_error){
			throw new \Exception("Error unable to connect to database: ".$this->db->connect_error);
		}
	}
	
	function __destruct(){
		if($this->db!=NULL){
			$this->db->close();
		}
	}
	
	function display(){
		$str="{person: $this->person";
		if(!is_null($this->name)){
			$str.=" name: $this->name";
		}
		return $str.'}';
	}
	
	/**
	 * Set person
	 * @param string $person Alphanumeric username [a-zA-Z0-9]
	 * @return bool person set.
	 */
	function setPerson($person){
		if(preg_match('/^[a-zA-Z0-9]+$/',$person)){
			$this->person=$person;
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
	
	function getPerson(){
		return $this->person;
	}
	
	function write(){
		$stmt=$this->db->prepare("INSERT INTO Person (person,name) VALUES (?,?)");
		if($stmt===FALSE){
			die("Person.write: unable to create statement " . $this->db->error);
			return FALSE;
		}
		if($stmt->bind_param("ss",$this->person,$this->name)===FALSE){
			die("Person.write: unable to bind " . $this->db->error);
		}
		if($stmt->execute()===FALSE){
			if($stmt->errno==1062){ // Duplicate Entry
				$stmt->close();
				$this->db->close();
				return FALSE;
			}
			die("Person.write: unable to execute $this->db->errno $this->db->error");
			return FALSE;
		}
		$stmt->close();
		return TRUE;
	}
	
	/**
	 * Remove Person
	 * @return bool TRUE on success (even if record did not exist);
	 */
	function delete(){
		$stmt=$this->db->prepare("DELETE FROM Person WHERE person=?");
		if($stmt===FALSE){
			die("WCS/Person.delete> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('s',$this->person)===FALSE){
			die("WCS/Person.delete> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			die("WCS/Person.delete> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}
	
	function get() {
		$stmt=$this->db->prepare("SELECT name,rate FROM Person WHERE person=?");
		if($stmt===FALSE){
			die("Person.write: unable to create statement " . $this->db->error);
			return FALSE;
		}
		if($stmt->bind_param("s",$this->person)===FALSE){
			die("Person.write: unable to bind " . $this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			if($stmt->errno==1062){ // Duplicate Entry
				$stmt->close();
				$this->db->close();
				return FALSE;
			}
			die("Person.write: unable to execute $this->db->errno $this->db->error");
			return FALSE;
		}
		$stmt->close();
		return TRUE;
	}
	
}

?>
