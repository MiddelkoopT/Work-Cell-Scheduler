<?php
// Person App 2 Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class Person {
	
	public function setPerson($person){
		if (preg_match('/^[a-zA-Z0-9]+$/',$person)){
			$this->person=$person;
			return TRUE;
		}
		return FALSE;
	}
	
	public function setName($name){
		$this->name=$name;
		return TRUE;
	}
	
	public function display(){
		$name='';
		if(!\is_null($this->name)){
			$name =" name: $this->name";
		}
		return "{person: $this->person".$name."}";
		
	}
	function __construct(){
		$this->db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
		if ($this->db === NULL){
			die ("Unable to connect to DB");
			
		}
		
	}
	
	public function insert(){
		$stmt=$this->db->prepare("INSERT INTO person (person, name, rate) VALUES (?,?,?)");
		if ($stmt === FALSE){
			error_log("WCS/Person.insert> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('ssd',$this->person,$this->name,$this->rate)===FALSE){
			error_log("WCS/Person.insert> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			if($this->db->errno==1062){ // Duplicate.
				return FALSE;
			}
			error_log("WCS/Person.insert> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}
	
	public function delete(){
		$stmt=$this->db->prepare("DELETE FROM person WHERE person=?");
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
	
	public function get(){
		$stmt=$this->db->prepare("SELECT name FROM person WHERE person=?");
		if($stmt===FALSE){
			error_log("WCS/Person.get> stmt:".$this->db->error);
			return FALSE;
		}
		
		if($stmt->bind_param('s',$this->person)===FALSE){
			error_log("WCS/Person.get> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_result($this->name)===FALSE){
			error_log("WCS/Person.get> bind_result:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			error_log("WCS/Person.get> bind_result:".$this->db->error);
			return FALSE;
		}
		return $stmt->fetch();
	}
	function __destruct(){
		if($this->db!=NULL){
			$this->db->close();
		}
	}
}