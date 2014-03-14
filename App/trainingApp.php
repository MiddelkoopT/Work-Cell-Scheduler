<?php
// TrainingMatrix Copyright 2014 by WebIS Spring 2014 License Apache 2.0
//TrainingApp.php
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
	private $worker_ID;
	private $subcell;
	private $training;
	
	
	function __construct(){
		//print "TrainingMatrix>";
		$this->db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'WCS');
		if($this->db===NULL){
			die("Error unable to connect to database");
		}
	}

	public function getworkerID() {
		$stmt=$this->db->prepare("SELECT DISTINCT worker_ID FROM TrainingMatrix");
		if($stmt===FALSE){
			die("prepare error ".$this->db->error);
		}
		if($stmt->bind_result($workerID)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->execute()===FALSE){
			die("execute error ".$this->db->error);
		}
		$worker_ID=array();
		while($stmt->fetch()){
			$worker_ID[]=$workerID;
		}
		return $worker_ID;
	}
		
	public function getsubcell() {
		$stmt=$this->db->prepare("SELECT DISTINCT subcell FROM TrainingMatrix");
		if($stmt===FALSE){
			die("prepare error12 ".$this->db->error);
		}
		if($stmt->bind_result($subcellNum)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->execute()===FALSE){
			die("execute error ".$this->db->error);
			$stmt->close();
		}
		$subcell=array();
		while($stmt->fetch()){
			$subcell[]=$subcellNum;
		}
		return $subcell;
	}
	function training(){
		if($this->training_stmt!=NULL){
			return $this->training_stmt;
		}
		$stmt=$this->db->prepare("SELECT training FROM TrainingMatrix WHERE worker_ID=? AND subcell=?");
		if($stmt===FALSE){
			die("prepare error ".$this->db->error);
		}
		if($stmt->bind_param('sd',$this->worker_ID,$this->subcell)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->bind_result($this->training)===FALSE){
			die("bind error ".$this->db->error);
		}
		$this->training_stmt=$stmt;
		return $stmt;
	}
	
	public function getTraining($worker_ID,$subcell){
		$this->worker_ID=$worker_ID;
		$this->subcell=$subcell;
		$stmt=$this->training();
		if($stmt->execute()===FALSE){
			die("getTraining: ".$this->db->error);
		}
		if($stmt->fetch()){
			return $this->training;
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
