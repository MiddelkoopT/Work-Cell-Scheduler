<?php
// Person App Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class Person {

	/**
	 * Database handle
	 * @var \mysqli
	 */
	private $db=NULL;	
	public $person=NULL;
	public $name=NULL;
	public $rate=NULL;
	
//Construct Connection to Database

	function __construct()
	{
		$this->db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
		if($this->db===NULL){
			die("Error unable to connect to database");
		}
	}
//Destruct Database Connection	

	function __destruct() {
		if($this->db!=NULL){
			$this->db->close();
		}
	}
	
	/**
	 * Set person
	 * @param string $person Alphanumeric username [a-zA-Z0-9]
	 * @return bool person set.
	 */
//Use a regular expression to put character constraint on string $person	

	public function setPerson($person){
		if(preg_match('/^[a-zA-Z0-9]+$/',$person)){
			$this->person=$person;
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Set name
	 * @param string $name Persons name
	 * @return bool name set.
	 */
	
	public function setName($name){
		$this->name=$name;
		return TRUE;
	}
	
	/**
	 * Display Person
	 * @return string human readable display.
	 */
	
	public function display(){
		$name='';
		if(!\is_null($this->name)){
			$name=" name: $this->name";
		}
		return "{person: $this->person".$name."}";
	}

	public function insert() {
		$stmt=$this->db->prepare("INSERT INTO Person (person,name,rate) VALUES (?,?,?)");
		if($stmt===FALSE){
			error_log("WCS/Person.insert> stmt:".$this->db->error);
			return FALSE;
		}
			if($stmt->bind_param('ssd',$this->person,$this->name,$this->rate)===FALSE){
			error_log("WCS/Person.insert> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			if($this->db->errno==1062){ 
				return FALSE;
		//errno==1062 is the error for a duplicate
			}
			error_log("WCS/Person.insert> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Remove Person
	 * @return bool TRUE on success (even if record did not exist);
	 */
	
	public function delete() {
		$stmt=$this->db->prepare("DELETE FROM Person WHERE person=?");
		if($stmt===FALSE){
			error_log("WCS/Person.delete> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('s',$this->person)===FALSE){
			error_log("WCS/Person.delete> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			error_log("WCS/Person.delete> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}
	
	public function get() {
		//1. Prepare MySQL Statement
		$stmt=$this->db->prepare("SELECT name,rate FROM Person WHERE person=?");
		if($stmt===FALSE){
			error_log("WCS/Person.get> stmt:".$this->db->error);
			return FALSE;
		}
		//2. Bind parameters
		if($stmt->bind_param('s',$this->person)===FALSE){
			error_log("WCS/Person.get> bind_param:".$this->db->error);
			return FALSE;
		}
		//3. Bind the result
		if($stmt->bind_result($this->name,$this->rate)===FALSE){
			error_log("WCS/Person.get> bind_result:".$this->db->error);
			return FALSE;
		}
		//4. Execute statement
		if($stmt->execute()===FALSE){
			error_log("WCS/Person.get> bind_result:".$this->db->error);
			return FALSE;
		}
		//5. Return statement
		return $stmt->fetch();
	}
}
?>
