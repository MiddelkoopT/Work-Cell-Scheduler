<?php
// ergoMatrix Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class ErgoMatrix{

	/**
	 * Database handle
	 * @var \mysqli
	 */
	private $db=NULL;
	/**
	 * ergo statement
	 * @var \mysqli_stmt
	 */
	private $ergo_stmt=NULL;
	/**
	 * ergo CRW that the staement binds to.
	 * @var unknown
	 */
	private $ergo_employeeid;
	private $ergo_subcell;
	private $ergo_ergo;

	function __construct(){
		//print "ergoMatrix>";
		$this->db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'WCS');
		if($this->db===NULL){
			die("Error unable to connect to database");
		}
	}

	public function getEmployeeid() {
		$stmt=$this->db->prepare("SELECT DISTINCT employeeid FROM ErgoMatrix ORDER BY employeeid");
		if($stmt===FALSE){
			die("prepare error 1".$this->db->error);
		}
		if($stmt->bind_result($employeeid)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->execute()===FALSE){
			die("execute error ".$this->db->error);
		}
		$id=array();
		while($stmt->fetch()){
			$id[]=$employeeid;
		}
		return $id;
	}

	public function getSubcell() {
		$stmt=$this->db->prepare("SELECT DISTINCT subcell FROM ErgoMatrix");
		if($stmt===FALSE){
			die("prepare error 2".$this->db->error);
		}
		if($stmt->bind_result($subcell)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->execute()===FALSE){
			die("execute error ".$this->db->error);
		}
		$scell=array();
		while($stmt->fetch()){
			$scell[]=$subcell;
		}
		return $scell;
	}

	function ergo(){
		if($this->ergo_stmt!=NULL){
			return $this->ergo_stmt;
		}
		$stmt=$this->db->prepare("SELECT ergoscore FROM ErgoMatrix WHERE employeeid=? AND subcell=?");
		if($stmt===FALSE){
			die("prepare error 3".$this->db->error);
		}
		if($stmt->bind_param('si',$this->ergo_employeeid,$this->ergo_subcell)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->bind_result($this->ergo_ergo)===FALSE){
			die("bind error ".$this->db->error);
		}
		$this->ergo_stmt=$stmt;
		return $stmt;
	}

	public function getErgo($employeeid,$subcell){
		$this->ergo_employeeid=$employeeid;
		$this->ergo_subcell=$subcell;
		$stmt=$this->ergo();
		if($stmt->execute()===FALSE){
			die("getErgo: ".$this->db->error);
		}
		if($stmt->fetch()){
			return $this->ergo_ergo;
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
