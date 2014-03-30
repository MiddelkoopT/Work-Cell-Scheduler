<?php
//Worker App Copyright 2014 by WEBIS Spring 2014 License Apache 2.0

namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class WorkerApp {
	private $workerID=NULL;
	
	
	function add(Worker $workerID){
		$this->workerID=$workerID;
		return TRUE;
	}
	
	function process($page){
		$this->load();
		$this->save();
		echo $this->edit($page);
	}
	
	function get(){
		if($this->workerID===NULL){
				$this->workerID=new Worker();		
		}
		if(!$this->workerID->setWorkerID($_REQUEST['workerID'])){
			//print ":WorkerApp.process: unable to set workerID |".$_REQUEST['worker']."|");
			return FALSE;
		}
		if(isset($_REQUEST['firstname']) and !$this->workerID->setFirstName($_REQUEST['firstname'])){
			//print ":WorkerApp.process: unable to set firstname |".$_REQUEST['firstname']."|");
			return FALSE;
		}
	}
	
	function load(){
		if(!isset($_REQUEST['action'])){
			return FALSE;
		}
		if($_REQUEST['action']!='Load'){
			return FALSE;
		}
		$this->get();
		if($this->workerID->read()===FALSE){
			return FALSE;
		}
		return TRUE;
	}
	
	function save(){
		if ($this->workerID===NULL){
			$this->workerID= new Worker();
		}
		if(!isset($_REQUEST['action'])){
			return FALSE;
		}
		if($_REQUEST['action']!='Update'){
			return FALSE;
		}
		$this->get();
		if($this->workerID->delete()===FALSE){
			print "WorkerApp.save: unable to delete()";
			return FALSE;
		}
		if($this->workerID->write()===FALSE){
			print ":WorkerApp.save: unable to write()";
			return FALSE;
		}
		return TRUE;
	}
		
	function edit($action){
		$workerID=htmlspecialchars($this->workerID->getWorkerID());
		$firstname=htmlspecialchars($this->workerID->getFirstName());
		return <<<HTML
		<form action="$action" method="get">
		<fieldset><legend> Enter Information in Form Below:</legend>
			<table border="1">
				<tr><td> Worker ID </td><td><input type="text" size= "20" name ="workerID" value="$workerID"></td></tr>
				<tr><td> First Name </td><td><input type="text" size= "20" name ="workerID" value="$firstname"></td></tr>
				</table>
		<input type="submit" name="action" value="Update">
		<input type="submit" name="action" value="Load">
		</fieldset>
		</form>
HTML;
		}
					
	}
	
class Worker {

	public $workerID=NULL;
	public $firstname=NULL;
	
	/**
	 * Database handle
	 * @var \mysqli
	 */
	
	private $db=NULL;
	
	function __construct(){
		$this->db= @new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
		if($this->db->connect_error){
			throw new \Exception("Error unable to connect to database: ".$this->db->connect_error);
					}
		}
		
	function __destruct(){
		if($this->db!=NULL){
			$this->db->close();
		}
	}
	
	/**
	 * Set WorkerID
	 * @param string $workerID Alphanumeric workerID [a-zA-Z0-9]
	 * @return boolean workerID set.
	 */
	
	public function setWorkerID($workerID){
		if(preg_match('/^[a-aZ-Z0-9]+/',$workerID)){
			$this->workerID=$workerID;
			return TRUE;
		}
		else {
			return False;
		}
	}
	
	/**
	 * Set Person FirstName
	 * @param string $firstname Persons First name
	 * @return bool first name set.
	 */
	
	public function setFirstName($firstname){
		if(preg_match('/^\s*$/',$firstname)){
			$this->firstname=$firstname;
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function display(){
		$firstname=$this->firstname;
		if(!is_null($this->firstname)){
			$firstname=" firstname: $this->firstname";
		}
		return "workerID: $this->workerID".$firstname;
	}
	
	function getFirstName(){
		return $this->firstname;
	}
	
	function getWorkerID(){
		return $this->workerID;
	}
	
	function write(){
	$stmt=$this->db->prepare("INSERT INTO WorkerInfo (worker_ID, worker_first) VALUES (?,?)");
		if($stmt===FALSE){
			die("WCS/Worker.write> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('ss',$this->workerID,$this->firstname)===FALSE){
			die("WCS/Worker.write> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			if($this->db->errno==1062){ // Duplicate.
				return FALSE;
			}
			die("WCS/Worker.write> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}
		
		
/**
 * Remove WorkerID
 * @return boolean TRUE on Success (even if record did not exist)
 */
	
	public function delete(){
		$stmt=$this->db->prepare("DELETE FROM WorkerInfo WHERE worker_ID=?");
		if($stmt===FALSE){
			die("WCS/Worker.delete> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('s',$this->person)===FALSE){
			die("WCS/Worker.delete> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			die("WCS/Worker.delete> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}
	
	function read() {
		$stmt=$this->db->prepare("SELECT worker_first FROM WorkerInfo WHERE worker_ID=?");
		if($stmt===FALSE){
			die("WCS/Worker.read> stmt:".$this->db->error);
			return FALSE;
				}
		if($stmt->bind_param('s',$this->workerID)===FALSE){
			die("WCS/Worker.read> bind_param:".$this->db->error);
			return FALSE;
			}
		if($stmt->bind_result($this->workerID)===FALSE){
			die("WCS/Worker.read> bind_result:".$this->db->error);
			return FALSE;
			}
		if($stmt->execute()===FALSE){
			die("WCS/Worker.select> execute:".$this->db->error);
			return FALSE;
			}
			return $stmt->fetch();
	}
	
	
	public function getWID(){
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
}
?>