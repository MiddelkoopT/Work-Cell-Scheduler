<?php
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class Workers {

	
	private $db=NULL;
	private $workerID=NULL;
	private $name=NULL;
	private $subcell=NULL;
	private $rate=NULL;
	

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
	
	public function SetSubcell($subcell){
		if(preg_match('/^[0-9]+$/', $subcell)){
			$this->subcell=$subcell;
			RETURN TRUE;
		}
			RETURN FALSE;
	}
	
	public function SetRate($rate){
		if(preg_match('/^[0-9]+$/', $rate)){
			$this->rate=$rate;
			RETURN TRUE;
		}
			RETURN FALSE;
	}
	public function insert(){
		$stmt=$this->db->prepare("INSERT INTO Workers (workerID,name,subcell,rate) VALUES (?,?,?,?)");
		if($stmt===FALSE){
			error_log("WCS/Workers.insert> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('isid',$this->workerID,$this->name,$this->subcell,$this->rate)===FALSE){
			error_log("WCS/Workers.insert> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			if($this->db->errno==1062){ // Duplicate.
				return FALSE;
			}
			error_log("WCS/Workers.insert> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}
	
	public function delete(){
		$stmt=$this->db->prepare("DELETE FROM Workers Where workerID=?");
		if ($stmt===FALSE){
			error_log("WCS/Workers.delete> stmt:" . $this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('i', $this->workerID)===FALSE){
			error_log("WCS/Workers.delete> bind_param:".$this->db->error);
		    return FALSE;
		}
		if ($stmt->execute()===FALSE){
			error_log("WCS/Workers.delete> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
			}
			return TRUE;
	}
public function getworkerID() {
		$stmt=$this->db->prepare("SELECT DISTINCT workerID FROM Workers ORDER BY workerID");
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
		$stmt=$this->db->prepare("SELECT DISTINCT name FROM Workers ORDER BY name");
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
	
	public function getsubcell() {
		$stmt=$this->db->prepare("SELECT DISTINCT subcell FROM Workers ORDER BY subcell");
		if($stmt===FALSE){
			die("prepare error ".$this->db->error);
		}
		if($stmt->bind_result($subcell)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->execute()===FALSE){
			die("execute error ".$this->db->error);
		}
		$subcells=array();
		while($stmt->fetch()){
			$subcells[]=$subcell;
				
		}
		return $subcells;
	
	
	}
	public function getrate() {
		$stmt=$this->db->prepare("SELECT DISTINCT rate FROM Workers ORDER BY rate");
		if($stmt===FALSE){
			die("prepare error ".$this->db->error);
		}
		if($stmt->bind_result($rate)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->execute()===FALSE){
			die("execute error ".$this->db->error);
		}
		$rates=array();
		while($stmt->fetch()){
			$rates[]=$rate;
	
		}
		return $rates;
	
	
	}
}


$t= new Workers();
$t->SetID("102");
$t->SetName("Mark Dintelman");
$t->SetSubcell("10");
$t->SetRate("9");
$t->insert();
$t->delete();
$t->insert();
$t->getworkerID();

$t1= new Workers();
$t1->SetID("102");
$t1->SetName("Mark Dintelman");
$t1->SetSubcell("11");
$t1->SetRate("5");
$t1->insert();
$t1->delete();
$t1->insert();
$t1->getworkerID();

$tt= new Workers();
$tt->SetID("103");
$tt->SetName("Max Smith");
$tt->SetSubcell("11");
$tt->SetRate("10");
$tt->insert();
$tt->delete();
$tt->insert();
$tt->getworkerID();

$c= new Workers();
foreach($c->getworkerID() as $id)
	echo $id;
foreach($c->getname() as $name)
	echo $name;
foreach($c->getsubcell() as $sub)
	echo $sub;
foreach($c->getrate() as $r)
	echo $r;



?>

