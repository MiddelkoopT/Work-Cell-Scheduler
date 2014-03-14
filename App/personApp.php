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
