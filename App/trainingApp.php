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
		$this->db = @new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
		if($this->db->connect_error){
			throw new \Exception("Error unable to connect to database: ".$this->db->connect_error);
		}
	}

	public function getPeople() {
		$stmt=$this->db->prepare("SELECT DISTINCT person FROM TrainingMatrix ORDER BY person");
		if($stmt===FALSE){
			die("WCS/TrainingMatrix.getPeople> prepare:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_result($person)===FALSE){
			die("WCS/TrainingMatrix.getPeople> bind:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			die("WCS/TrainingMatrix.getPeople> execute:".$this->db->error);
			return FALSE;
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
			die("WCS/TrainingMatrix.getWorkstations> prepare:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_result($workstation)===FALSE){
			die("WCS/TrainingMatrix.getWorkstations> bind:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			die("WCS/TrainingMatrix.getWorkstations> execute:".$this->db->error);
			return FALSE;
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
			die("WCS/TrainingMatrix.training> prepare:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('ss',$this->training_person,$this->training_workstation)===FALSE){
			die("WCS/TrainingMatrix.training> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_result($this->training_wsp)===FALSE){
			die("WCS/TrainingMatrix.training> bind_result:".$this->db->error);
			return FALSE;
		}
		$this->training_stmt=$stmt;
		return $stmt;
	}
	
	public function getTraining($person,$workstation){
		$this->training_person=$person;
		$this->training_workstation=$workstation;
		$stmt=$this->training();
		if($stmt->execute()===FALSE){
			die("WCS/TrainingMatrix.getTraining> execute:".$this->db->error);
			return FALSE;
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
