<?php
//Person Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class Employee {
	
	/**
	 * Database Handle
	 * @var \mysqli
	 */
	private $db=Null;
	
	public $employee=NULL;
	public $operator=NULL;
	public $training=NULL;
	
	function _construct(){
		$this->db = new 
\mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);		
	if($this->db->connect_error){
		throw me \Exception("Error Database Connection Error:
				".$this->connect_error);
		}
	
	}
	
	function _destruct() {
		if ($this->db!=Null){
				$this->dbclose();
				}
	}
	/**
	 * Set Employee
	 * @param string $employee Alphanumeric username {a-ZA-Z0-9]
	 * return bool employee set
	 */
	public function setEmployee($employee){
		if (preg_match('/^[a-zA-Z0-9]+$/',$employee)){
			$this->employee=$employee;
			return True;
		}
		return False;
	}
	/**
	 * Set operator
	 * @param string $operator Employees name
	 * @return bool operator set.
	 */
	public function setOperator($operator){
		$this->operator=$operator;
		return TRUE;
	}
	/**
	 * Display Person
	 * @return string human readable dispaly.
	 */
	public function dispaly(){
		$operator=''; 
		if(!\is_null($this->operator)){
			$operator=" operator: $this->operator";
		}
		return "{employee: $this->employee".$operator."}";
	}
	public function insert() {
		$stmt=$this->db->prepare("INSERT INTO Person (employee,operator,training) VALUES (?,?,?)");
		if($stmt===FALSE){
			error_log("WCS/Employee.insert> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('ssd',$this->employee,$this->operator,$this->training)===FALSE){
			error_log("WCS/Employee.insert> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			if($this->db->errno==1062){ // Duplicate.
				return FALSE;
			}
			error_log("WCS/Employee.insert> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * Remove Person
	 * @return bool TRUE on success (even if record did not exist);
	 */
	public function delete() {
		$stmt=$this->db->prepare("DELETE FROM Employee WHERE employee=?");
		if($stmt===FALSE){
			error_log("WCS/Employee.delete> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('s',$this->employee)===FALSE){
			error_log("WCS/Employee.delete> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			error_log("WCS/Employee.delete> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}
	
	public function get() {
		$stmt=$this->db->prepare("SELECT operator,training FROM Employee WHERE person=?");
		if($stmt===FALSE){
			error_log("WCS/Employee.get> stmt:".$this->db->error);
			return FALSE;
		}
	
		if($stmt->bind_param('s',$this->employee)===FALSE){
			error_log("WCS/Employee.get> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_result($this->operator,$this->training)===FALSE){
			error_log("WCS/Employee.get> bind_result:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			error_log("WCS/Employee.get> bind_result:".$this->db->error);
			return FALSE;
		}
		return $stmt->fetch();
	}
}

