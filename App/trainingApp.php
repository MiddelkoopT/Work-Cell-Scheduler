<?php
// TrainingMatrix Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class TrainingMatrix{

	/**
	 * Database handle
	 * @var \mysqli
	 */
	private $db=NULL;
	/**
	 * Training statement
	 * @var \mysqli_stmt
	 */
	private $training_stmt=NULL;
	/**
	 * Training CRW that the staement binds to.
	 * @var unknown
	 */
	private $training_person;
	private $training_workstation;
	private $training_wsp;

	function __construct(){
		//print "TrainingMatrix>";
		$this->db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'WCS');
		if($this->db===NULL){
			die("Error unable to connect to database");
		}
	}

	public function getPeople() {
		$stmt=$this->db->prepare("SELECT DISTINCT person FROM TrainingMatrix ORDER BY person");
		if($stmt===FALSE){
			die("prepare error ".$this->db->error);
		}
		if($stmt->bind_result($person)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->execute()===FALSE){
			die("execute error ".$this->db->error);
		}
		$people=array();
		while($stmt->fetch()){
			$people[]=$person;
		}
		return $people;
	}
	
	public function getWorkstations() {
		$stmt=$this->db->prepare("SELECT DISTINCT workstation FROM TrainingMatrix ORDER BY workstation");
		if($stmt===FALSE){
			die("prepare error ".$this->db->error);
		}
		if($stmt->bind_result($workstation)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->execute()===FALSE){
			die("execute error ".$this->db->error);
		}
		$workstations=array();
		while($stmt->fetch()){
			$workstations[]=$workstation;
		}
		return $workstations;
	}
	
	function training(){
		if($this->training_stmt!=NULL){
			return $this->training_stmt;
		}
		$stmt=$this->db->prepare("SELECT wsp FROM TrainingMatrix WHERE person=? AND workstation=?");
		if($stmt===FALSE){
			die("prepare error ".$this->db->error);
		}
		if($stmt->bind_param('ss',$this->training_person,$this->training_workstation)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->bind_result($this->training_wsp)===FALSE){
			die("bind error ".$this->db->error);
		}
		$this->training_stmt=$stmt;
		return $stmt;
	}
	
	public function getTraining($person,$workstation){
		$this->training_person=$person;
		$this->training_workstation=$workstation;
		$stmt=$this->training();
		if($stmt->execute()===FALSE){
			die("getTraining: ".$this->db->error);
		}
		if($stmt->fetch()){
			return $this->training_wsp;
		}
		return 0;
	}
	
	function __destruct() {
		if($this->db!=NULL){
			$this->db->close();
		}
	}
	
}

?>
