<?php

namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class Workers {


	private $db=NULL;
	private $workerID=NULL;
	private $name=NULL;
	private $rateSub1=NULL;
	private $rateSub2=NULL;


	function __construct(){
		//print "WCS/Pers>";
		$this->db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
		if($this->db===NULL){
			die("Error unable to connect to database");
		}
	}

	function __destruct() {
		if($this->db!=NULL){
			$this->db->close();
		}
	}

	public function SetID($ID){
		if(preg_match('/^[0-9]+$/', $ID)){
			$this->workerID=$ID;
			RETURN TRUE;
		}
		RETURN FALSE;
	}

	function SetName($name){
		if(preg_match('/^\s*$/',$name)){
			return FALSE;
		}
		$this->name=$name;
		return TRUE;
	}

	public function Setratesub1($subcell1){
			$this->rateSub1=$subcell1;
			RETURN TRUE;
	
	}

	public function SetrateSub2($sub2){
			$this->rateSub2=$sub2;
			RETURN TRUE;
	}
	
	public function insert(){
		$stmt=$this->db->prepare("INSERT INTO Workers2 (workerID,name,rateSub1,rateSub2) VALUES (?,?,?,?)");
		if($stmt===FALSE){
			error_log("WCS/Workers2.insert> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('isdd',$this->workerID,$this->name,$this->rateSub1,$this->rateSub2)===FALSE){
			error_log("WCS/Workers2.insert> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			if($this->db->errno==1062){ // Duplicate.
				return FALSE;
			}
			error_log("WCS/Workers2.insert> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}

	public function delete(){
		$stmt=$this->db->prepare("DELETE FROM Workers2 Where workerID=?");
		if ($stmt===FALSE){
			error_log("WCS/Workers2.delete> stmt:" . $this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('i', $this->workerID)===FALSE){
			error_log("WCS/Workers2.delete> bind_param:".$this->db->error);
			return FALSE;
		}
		if ($stmt->execute()===FALSE){
			error_log("WCS/Workers2.delete> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}
	public function getworkerID() {
		$stmt=$this->db->prepare("SELECT DISTINCT workerID FROM Workers2 ORDER BY workerID");
		if($stmt===FALSE){
			die("prepare error ".$this->db->error);
		}
		if($stmt->bind_result($ID)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->execute()===FALSE){
			die("execute error ".$this->db->error);
		}
		$workerID=array();
		while($stmt->fetch()){
			$workerID[]=$ID;
				
		}
		return $workerID;


	}

	public function getname() {
		$stmt=$this->db->prepare("SELECT DISTINCT name FROM Workers2 ORDER BY name");
		if($stmt===FALSE){
			die("prepare error ".$this->db->error);
		}
		if($stmt->bind_result($name)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->execute()===FALSE){
			die("execute error ".$this->db->error);
		}
		$names=array();
		while($stmt->fetch()){
			$names[]=$name;

		}
		return $names;


	}

	public function getrateSub1() {
		$stmt=$this->db->prepare("SELECT DISTINCT rateSub1 FROM Workers2 ORDER BY rateSub1");
		if($stmt===FALSE){
			die("prepare error ".$this->db->error);
		}
		if($stmt->bind_result($sub1)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->execute()===FALSE){
			die("execute error ".$this->db->error);
		}
		$ratesub1=array();
		while($stmt->fetch()){
			$rateSub1[]=$sub1;

		}
		return $rateSub1;


	}
	public function getrateSub2() {
		$stmt=$this->db->prepare("SELECT DISTINCT rateSub2 FROM Workers2 ORDER BY rateSub2");
		if($stmt===FALSE){
			die("prepare error ".$this->db->error);
		}
		if($stmt->bind_result($sub2)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->execute()===FALSE){
			die("execute error ".$this->db->error);
		}
		$rateSub2=array();
		while($stmt->fetch()){
			$rateSub2[]=$sub2;

		}
		return $rateSub2;


	}
}






?>

