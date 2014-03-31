<?php
// TrainingMatrix Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';


class TrainingMatrixApp{
	
	public $employeeid=NULL;
	public $subcell=NULL;
	public $training=NULL;
	
	function addemployeeid(TrainingMatrix $training_employeeid){
		$this->employeeid=$training_employeeid;
	}
	
	function addsubcell(TrainingMatrix $training_subcell){
		$this->subcell=$training_subcell;
	}
	
	
	function process($page){
//		$this->load();
//		$this->save();
		echo $this->edit($page);
	}
	
	

	
	function edit($action){
		$employeeid=htmlspecialchars($this->employeeid);
		$subcell=htmlspecialchars($this->subcell);
		$training=htmlspecialchars($this->training);
		return <<<HTML
		<form action="$action" method="GET">
		<table border="1">
		<tr><td>Employee ID:</td><td><input type="text" name="employeeid" value="$employeeid"></td></tr>
		<tr><td>Subcell:</td> <td><input type="text" name="subcell" value="$subcell"></td></tr>
		<tr><td>Training:</td> <td><input type="text" name="training" value="$training"></td></tr>
		</table>
		<input type="submit" name="action" value="Update">
		<input type="submit" name="action" value="Load">
		</form>
HTML;
	}
		
	
}


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
	private $training_employeeid;
	private $training_subcell;
	private $training_training;

	function __construct(){
		//print "TrainingMatrix>";
		$this->db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'WCS');
		if($this->db===NULL){
			die("Error unable to connect to database");
		}
	}

	public function getEmployeeid() {
		$stmt=$this->db->prepare("SELECT DISTINCT employeeid FROM TrainingMatrix ORDER BY employeeid");
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
		$stmt=$this->db->prepare("SELECT DISTINCT subcell FROM TrainingMatrix");
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
	
	function training(){
		if($this->training_stmt!=NULL){
			return $this->training_stmt;
		}
		$stmt=$this->db->prepare("SELECT training FROM TrainingMatrix WHERE employeeid=? AND subcell=?");
		if($stmt===FALSE){
			die("prepare error 3".$this->db->error);
		}
		if($stmt->bind_param('si',$this->training_employeeid,$this->training_subcell)===FALSE){
			die("bind error ".$this->db->error);
		}
		if($stmt->bind_result($this->training_training)===FALSE){
			die("bind error ".$this->db->error);
		}
		$this->training_stmt=$stmt;
		return $stmt;
	}
	
	public function getTraining($employeeid,$subcell){
		$this->training_employeeid=$employeeid;
		$this->training_subcell=$subcell;
		$stmt=$this->training();
		if($stmt->execute()===FALSE){
			die("getTraining: ".$this->db->error);
		}
		if($stmt->fetch()){
			return $this->training_training;
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
