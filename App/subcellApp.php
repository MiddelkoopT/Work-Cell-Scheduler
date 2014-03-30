<?php

namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class Subcell{
	
	/**
	 * Database handle
	 * 
	 * @var \mysqli
	 */
	private $db=NULL;
	private $subcell=NULL;
	private $scell=NULL;
	
	
	
	function cheat(){
		$s= new \WCS\Subcell();
		//Validate Form
		if(!empty($REQUEST['subcelly'])){
			$scell=$REQUEST_['subcelly]'];
		}else {
			$scell=NULL;
			echo '<p class="error"> You Did not enter a Subcell!</p>';
		}	
		$q="INSERT INTO Subcell (subcell) VALUES ('$scell')";
		$r=@mysqli_query($this->db,$q);
	}
	
	function __construct(){
		$this->db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'WCS');
		if($this->db===NULL){
			die("Error unable to connect to database");
		}
	
	}
	public function getsubcellID() {
		$stmt=$this->db->prepare("SELECT DISTINCT subcell FROM Subcell");
		if($stmt===FALSE){
			die("prepare error ".$this->db->error);
		}
		if($stmt->bind_result($subcell_ID)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->execute()===FALSE){
			die("execute error ".$this->db->error);
		}
		$subcells=array();
		while($stmt->fetch()){
			$subcells[]=$subcell_ID;
		}
		return $subcells;
	}	
	
	function get(){
		if($this->subcell===NULL){
			$this->subcell=new subcell();
		}
		if(!$this->subcell->setSubcellID($_REQUEST['subcell_ID'])){
			//print ":WorkerApp.process: unable to set workerID |".$_REQUEST['worker']."|");
			return FALSE;
						}
				}

	function save(){
		if ($this->subcell===NULL){
			$this->subcell= new Subcell();
		}
		if(!isset($_REQUEST['action'])){
			return FALSE;
		}
		if($_REQUEST['action']!='Update'){
			return FALSE;
		}
		$this->get();
		if($this->subcell->insert()===FALSE){
			print ":SubcellApp.save: unable to write()";
			return FALSE;
		}
		return TRUE;
	}
	
public function insert() {
		$stmt=$this->db->prepare("INSERT INTO Subcell (subcell) VALUES (?)");
		if($stmt===FALSE){
			error_log("WCS/Subcell.insert> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('d',$this->subcell)===FALSE){
			error_log("WCS/Person.insert> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			if($this->db->errno==1062){ // Duplicate.
				return FALSE;
			}
			error_log("WCS/Subcell.insert> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * 
	 * @param string $subcell
	 * @return boolean subcell set
	 */
	 
	function setSubcell($subcell){
		//print ":Person.setPerson: |$person|".gettype($person);
		if(preg_match('/^[a-zA-Z0-9]+$/',$subcell)){
			$this->subcell=$subcell;
			return TRUE;
		}
		return FALSE;
	}	
	
}
?>