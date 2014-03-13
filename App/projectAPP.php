<?php

namespace WCS;

//include this file when running
require_once 'Work-Cell-Scheduler/Config/global.php';

class Person{
		
// build attribute for this class:
   private $db = NULL;
   public $person = NULL;
   public $name = NULL;
   public $rate = NULL;
   
// build constructor: automaticlly connect to the database when new object was built.there has a space behind funtion
   function __construct(){
   	$this->db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
   	
   	if($this->db===NULL){
   		die("cannot connect to the database!");	
   	}
   	   	
   }
   
   function __destruct(){
   	
   	if($this->db!=NULL){
   		
   		$this->db->close();
   		
   	}
   	
   }
   
//build the operations for this class:
   
   //operation : set the person 
   function setPerson($person){
   	 // limit the enter type of the person
   	 if(preg_match('/^[a-zA-Z0-9]+$/',$person)){
   	 	
   	 	$this->person=$person;
   	 	return TRUE;
   	 }

   	 return FALSE;
   } 	
   
   
   // operation: set the name 
   function setName($name){
   	$this->name=$name;
   	return TRUE; 	
   }
   	 	
   // opetation: set the rate
   function setRate($rate){
   	$this->rate=$rate;
   	return TRUE;  	
   }	 
   	
   function display(){
   	
   	$name="";
   	$rate="";
   	if(!\is_null($this->name)){
   		
   		$name=" name: $this->name";
   	}
   	if(!\is_null($this->rate)){
   		$rate=" rate: $this->rate";
   	}
   	
   	return "{person: $this->person".$name.$rate."}";
   	
   }
   
   //communicate with the database:
   
   function Insert(){
   	$stmt=$this->db->prepare("INSERT INTO Person (person,name,rate) VALUES (?,?,?)");
   	if($stmt===FALSE){
   		error_log("WCS/Person.Insert> stmt:".$this->db->error);
   		return FALSE;
   	}
   	
   	if($stmt->bind_param('ssd', $this->person,$this->name,$this->rate)===FALSE){
   		error_log("WCS/Person.Insert> bind_param:".$this->db->error);
   		return FALSE;
   	}
   	
   	if($stmt->execute()===FALSE){
   		if($this->db->errno==1062){
   			return FALSE;
   		}
   		error_log("WCS/Person.Insert> execute:".$this->db->error);
   		return FALSE;
   		
   	}
   	return TRUE;	
   }
   
   
   function Delete(){
   	$stmt=$this->db->prepare("DELETE FROM Person WHERE person=?");
   	if($stmt===FALSE){
   		
   		error_log("WCS/Person.Delete> stmt:".$this->db->error);
   		return FALSE;
   		
   	}
   	
   	if($stmt->bind_param('s', $this->person)===FALSE){
   		
   		error_log("WCS/Person.Delete> bind_param:".$this->db->error);
   		return FALSE;
   		
   	}
   	
   	if($stmt->execute()===FALSE){
   		
   		error_log("WCS/Person.Delete> execute:".$this->db->error );
   		return FALSE;
   	}
   	
   	return TRUE;
   	
   	
   }
   
   function get(){
   	$stmt=$this->db->prepare("SELECT name,rate FROM Person WHERE person=?");
   	if($stmt===FALSE){
   		
   		error_log("WCS/Person.get> stmt:".$this->db->error);
   		return FALSE;
   		
   	}
   	if($stmt->bind_param( 's', $this->person)===FALSE){
   		error_log("WCS/Person.get> bind_param:".$this->db->error);
   		return FALSE;	
   	}
   	if($stmt->bind_result($this->name,$this->rate)===FALSE){
   		error_log("WCS/Person.get> bind_result:".$this->db->error);
   		return FALSE;
   	}
   	
   	if($stmt->execute()===FALSE){
   		error_log("WCS/Person.get> execute:".$this->db->error);
   		return FALSE;
   		
   	}
   	
   	
   	return $stmt->fetch();
   	
   	
   }
   
   
   	
   	
   	
   }

	
	
	
	
?>
		
		

	
	
	
	
	
	
	
	
