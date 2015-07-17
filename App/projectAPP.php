<?php
// Person App Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class WorkerApp {
	private $workerID=NULL;
	static $counter=0;
	private $id=0;

	function __construct(){
		self::$counter+=1;
		$this->id=self::$counter;
	}
	//限制
	function add(Worker $workerID){
		$this->workerID=$workerID;
		return TRUE;
	}
	//在同一个页面 刷新后重置
	function getId() {
		//echo $this->id;
		return $this->id;

	}

	function process(){
		$this->load();
		$this->save();
		$this->clear();
		echo $this->edit();

	}

	function get(){
		$id=$this->id;
		if($this->workerID===NULL){
			$this->workerID=new Worker();
		}
		if(!$this->workerID->setWorkerID($_REQUEST["$id-workerID"])){
			return FALSE;
		}
		if(isset($_REQUEST["$id-name"]) and !$this->workerID->setName($_REQUEST["$id-name"])){
			return FALSE;
		}
		if(isset($_REQUEST["$id-person"]) and !$this->workerID->setPerson($_REQUEST["$id-person"])){
			return FALSE;
		}
	}

	function load(){
		if(!isset($_REQUEST["action1"])){
			return FALSE;
		}
		if($_REQUEST["action1"]!='Load'){
			return FALSE;
		}
		$this->get();
		if($this->workerID->read()===FALSE){
			return FALSE;
		}
		return TRUE;
	}

	function save(){
		if($this->workerID===NULL){
			$this->workerID=new Worker();
		}
		if(!isset($_REQUEST["action1"])){
			return FALSE;
		}
		if($_REQUEST["action1"]!='Update'){
			return FALSE;
		}
		$this->get();
		if($this->workerID->delete()===FALSE){
			print ":PersonApp.save: unable to delete()";
			return FALSE;
		}
		if($this->workerID->write()===FALSE){
			print ":PersonApp.save: unable to write()";
			return FALSE;
		}
		return TRUE;
	}
	//只是显示不是request_
	function edit(){
		$workerID=htmlspecialchars($this->workerID->getWorkerID());
		$person=htmlspecialchars($this->workerID->getPerson());
		$name=htmlspecialchars($this->workerID->getName());
		$id=$this->id;

		return <<<HTML
		<h>Worker Search.$id</h>
		<table border="1" >
		  <tr><td>ID</td><td><input type="text" name="$id-workerID" value="$workerID"></td></tr>
		  <tr><td>Person</td><td><input type="text" name="$id-person" value="$person"></td></tr>
    	  <tr><td>Name</td>  <td><input type="text" name="$id-name"   value="$name"></td></tr>
    	</table>
HTML;
	}

		function Clear(){

			if(!isset($_REQUEST["action1"])){
				return FALSE;
			}
			if($_REQUEST["action1"]!='Clear'){
				return FALSE;
			}
			$this->workerID=new Worker();
			return TRUE;

		}
}


class Worker {
	private $workerID=NULL;
	private $person=NULL;
	private $name=NULL;

	/**
	 * Database Handle
	 * @var \mysqli
	 */
	static $db=NULL;

	function __construct(){
		if(!is_null(self::$db)){
			return;
		}
		self::$db = @new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
		if(self::$db->connect_error){
			throw new \Exception("Error unable to connect to database: ".self::$db->connect_error);
		}
	}


	/**
	 * Set person
	 * @param string $person Alphanumeric username [a-zA-Z0-9]
	 * @return bool person set.
	 */
	function setPerson($person){
		//print ":Person.setPerson: |$person|".gettype($person);
		if(preg_match('/^[a-zA-Z0-9]+$/',$person)){
			$this->person=$person;
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Set Person name
	 * @param string $name of person.
	 */
	function setName($name){
		if(preg_match('/^\s*$/',$name)){
			return FALSE;
		}
		$this->name=$name;
		return TRUE;
	}

	function setWorkerID($workerID){
		if(preg_match('/^[0-9]+$/',$workerID)){
			$this->workerID=$workerID;
			return TRUE;
		}

		else return FALSE; //需要加else，否则无法读入

	}


	function getName(){
		return $this->name;
	}

	function getPerson(){
		return $this->person;
	}
	function getWorkerID(){

		return $this->workerID;
	}

	function write(){
		$stmt=self::$db->prepare("INSERT INTO Worker (workerID,person,name) VALUES (?,?,?)");
		if($stmt===FALSE){
			die("Worker.write: unable to create statement " . self::$db->error);
			return FALSE;
		}
		if($stmt->bind_param("sss",$this->workerID,$this->person,$this->name)===FALSE){
			die("Worker.write: unable to bind " . self::$db->error);
		}
		if($this->workerID!=NULL){//Important!!如果ID等于NULL不能写入DATABASE,其他的可以是NULL 因为他们不是primary key
			if($stmt->execute()===FALSE){
				if($stmt->errno==1062){ // Duplicate Entry
					$stmt->close();
					self::$db->close();
					return FALSE;
				}
				die("Worker.write: unable to execute ".self::$db->errno.",".self::$db->error);
				return FALSE;
			}
		}
		$stmt->close();
		return TRUE;
	}

	/**
	 * Remove Person
	 * @return bool TRUE on success (even if record did not exist);
	 */
	function delete(){
		$stmt=self::$db->prepare("DELETE FROM Worker WHERE workerID=?");
		if($stmt===FALSE){
			die("WCS/Worker.delete> stmt:".self::$db->error);
			return FALSE;
		}
		if($stmt->bind_param('s',$this->workerID)===FALSE){
			die("WCS/Worker.delete> bind_param:".self::$db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			die("WCS/Worker.delete> execute:".self::$db->errno." ".self::$db->error);
			return FALSE;
		}
		return TRUE;
	}

	function read() {
		$stmt=self::$db->prepare("SELECT person,name FROM Worker WHERE workerID=?");
		if($stmt===FALSE){
			die("Worker.get: unable to create statement " . self::$db->error);
			return FALSE;
		}
		if($stmt->bind_param("s",$this->workerID)===FALSE){
			die("Worker.get: unable to bind_param " . self::$db->error);
			return FALSE;
		}
		if($stmt->bind_result($this->person,$this->name)===FALSE){
			die("Worker.get: unable to bind_result " . self::$db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			die("Worker.get: unable to execute self::$db->errno self::$db->error");
			return FALSE;
		}
		if($stmt->fetch()==FALSE){
			$stmt->close();
			return FALSE;
		}
		// print "Person.get: ".$this->display();
		//echo "WCS database: { name: ".$this->name."  rate:".$this->rate."}";
		return TRUE;
	}

}


class SubcellApp {
	private $workerID=NULL;
	static $counter=0;
	private $id=0;

	function __construct(){
		self::$counter+=1;
		$this->id=self::$counter;
	}
	//限制
	function add(Subcell $workerID){
		$this->workerID=$workerID;
		return TRUE;
	}
	//在同一个页面 刷新后重置
	function getId() {
		echo $this->id;
		return $this->id;

	}

	function process(){
		$this->load();
		$this->save();
		$this->clear();
		echo $this->edit();


	}

	function get(){
		$id=$this->id;
		if($this->workerID===NULL){
			$this->workerID=new Subcell();
		}
		if(!$this->workerID->setWorkerID($_REQUEST["$id-workerID"])){
			return FALSE;
		}
		if(isset($_REQUEST["$id-subcell"]) and !$this->workerID->setSubcell($_REQUEST["$id-subcell"])){
			return FALSE;
		}

	}

	function load(){
		if(!isset($_REQUEST["action2"])){
			return FALSE;
		}
		if($_REQUEST["action2"]!='Load'){
			return FALSE;
		}
		$this->get();
		if($this->workerID->read()===FALSE){
			return FALSE;
		}
		return TRUE;
	}

	function save(){
		if($this->workerID===NULL){
			$this->workerID=new Subcell();
		}
		if(!isset($_REQUEST["action2"])){
			return FALSE;
		}
		if($_REQUEST["action2"]!='Update'){
			return FALSE;
		}
		$this->get();
		if($this->workerID->delete()===FALSE){
			print ":PersonApp.save: unable to delete()";
			return FALSE;
		}
		if($this->workerID->write()===FALSE){
			print ":PersonApp.save: unable to write()";
			return FALSE;
		}
		return TRUE;
	}
	function Clear(){

		if(!isset($_REQUEST["action2"])){
			return FALSE;
		}
		if($_REQUEST["action2"]!='Clear'){
			return FALSE;
		}
		$this->workerID=new Subcell();
		return TRUE;

	}

	//只是显示不是request_
	function edit(){
		$workerID=htmlspecialchars($this->workerID->getWorkerID());
		$subcell=htmlspecialchars($this->workerID->getSubcell());
		$id=$this->id;
		return <<<HTML
		<h>Subcell Search.$id</h>
		<table border="1">
		  <tr><td>ID</td><td><input type="text" name="$id-workerID" value="$workerID"></td></tr>
		  <tr><td>Subcell</td><td><input type="text" name="$id-subcell" value="$subcell"></td></tr>
    
    	</table>
HTML;
	}

}


class Subcell {
private $workerID=NULL;
private $subcell=NULL;

/**
* Database Handle
 * @var \mysqli
 */
 static $db=NULL;

 function __construct(){
 if(!is_null(self::$db)){
 return;
 }
 self::$db = @new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
 if(self::$db->connect_error){
 throw new \Exception("Error unable to connect to database: ".self::$db->connect_error);
 }
 }



 function setSubcell($subcell){

 	if(preg_match('/^[0-9]+$/',$subcell)){
			$this->subcell=$subcell;
 	return TRUE;
     }
   else return FALSE;
 }

 /**
 * Set Person nam
 * @param string $name of person.
  */


 function setWorkerID($workerID){
    if(preg_match('/^[0-9]+$/',$workerID)){
 	$this->workerID=$workerID;
 	return TRUE;
 	}

 	else return FALSE;

 }



 function getSubcell(){
 return $this->subcell;
 }
 function getWorkerID(){

 return $this->workerID;
}

function write(){
 	$stmt=self::$db->prepare("INSERT INTO Subcell (workerID,subcell) VALUES (?,?)");
		if($stmt===FALSE){
			die("Worker.write: unable to create statement " . self::$db->error);
			return FALSE;
		}
		if($stmt->bind_param("ss",$this->workerID,$this->subcell)===FALSE){
		die("Worker.write: unable to bind " . self::$db->error);
		}
		if($this->workerID!=NULL){
		  if($stmt->execute()===FALSE){
		    if($stmt->errno==1062){ // Duplicate Entry
		     $stmt->close();
		     self::$db->close();
			 return FALSE;
		     }
		  die("Worker.write: unable to execute ".self::$db->errno.",".self::$db->error);
			return FALSE;
		  }
		}
		$stmt->close();
		return TRUE;
		}

		/**
	 * Remove Person
	 * @return bool TRUE on success (even if record did not exist);
	 */
	 function delete(){
		$stmt=self::$db->prepare("DELETE FROM Subcell WHERE workerID=?");
		if($stmt===FALSE){
			die("WCS/Worker.delete> stmt:".self::$db->error);
			return FALSE;
		}
		if($stmt->bind_param('s',$this->workerID)===FALSE){
			die("WCS/Worker.delete> bind_param:".self::$db->error);
				return FALSE;
		}
		if($stmt->execute()===FALSE){
				die("WCS/Worker.delete> execute:".self::$db->errno." ".self::$db->error);
			return FALSE;
				}
				return TRUE;
				}

	function read() {
	    $stmt=self::$db->prepare("SELECT subcell FROM Subcell WHERE workerID=?");
		if($stmt===FALSE){
			die("Worker.get: unable to create statement " . self::$db->error);
			return FALSE;
				}
				if($stmt->bind_param("s",$this->workerID)===FALSE){
				die("Worker.get: unable to bind_param " . self::$db->error);
			return FALSE;
				}
				if($stmt->bind_result($this->subcell)===FALSE){
				die("Worker.get: unable to bind_result " . self::$db->error);
			return FALSE;
				}
				if($stmt->execute()===FALSE){
				die("Worker.get: unable to execute self::$db->errno self::$db->error");
				return FALSE;
				}
				if($stmt->fetch()==FALSE){
				$stmt->close();
				return FALSE;
				}
				// print "Person.get: ".$this->display();
				//echo "WCS database: { name: ".$this->name."  rate:".$this->rate."}";
				return TRUE;
				}

	}


Class TrainingApp{

	private $workerID=NULL;
	static $counter=0;
	private $id=0;

	function __construct(){
		self::$counter+=1;
		$this->id=self::$counter;
	}




	function process(){
		$this->load();
		$this->save();
		$this->clear();
		echo $this->edit();
		$this->displayMatrix();

	}
	function getId() {
		//echo $this->id;
		return $this->id;

	}

	function get(){
		$id=$this->id;
		if($this->workerID===NULL){
			$this->workerID=new Training();
		}
		if(!$this->workerID->setWorkerID($_REQUEST["$id-workerID"])){
			return FALSE;
		}
		if(isset($_REQUEST["$id-training"]) and !$this->workerID->setTraining($_REQUEST["$id-training"])){
			return FALSE;
		}

	}
	function displayMatrix(){

		if(!isset($_REQUEST["action3"])){
			return FALSE;
	      }
	    if (($_REQUEST["action3"]!='Display')){
	    	return FALSE;
	    }
	    $return_matrix=$this->workerID->display();
	    $num=count($return_matrix,COUNT_NORMAL);
	  
	    echo "<font style='font-family:Cursive;color:red'>Training Matrix</font>";
	    echo "<table border='1'>";
	    echo "<tr><td>WorkerID</td><td>Training</td></tr>";
	    while($num>0){
	    	$num--;
	    	echo "<tr><td>".$return_matrix[$num][0]."</td><td>".$return_matrix[$num][1]."</td><tr>";
	  
	    }
	    echo "</table>";
	  
	  
	   return $this->workerID->display();

	}
	function load(){
		if(!isset($_REQUEST["action3"])){
			return FALSE;
		}
		if($_REQUEST["action3"]!='Load'){
			return FALSE;
		}
		$this->get();
		if($this->workerID->read()===FALSE){
			return FALSE;
		}
		return TRUE;
	}

	function save(){
		if($this->workerID===NULL){
			$this->workerID=new training();
		}
		if(!isset($_REQUEST["action3"])){
			return FALSE;
		}
		if($_REQUEST["action3"]!='Update'){
			return FALSE;
		}
		$this->get();
		if($this->workerID->delete()===FALSE){
			print ":PersonApp.save: unable to delete()";
			return FALSE;
		}
		if($this->workerID->write()===FALSE){
			print ":PersonApp.save: unable to write()";
			return FALSE;
		}
		return TRUE;
	}
	//只是显示不是request_

function Clear(){

	if(!isset($_REQUEST["action3"])){
			return FALSE;
		}
		if($_REQUEST["action3"]!='Clear'){
			return FALSE;
		}
		$this->workerID=new Training();
		return TRUE;

	}

	function edit(){
		$workerID=htmlspecialchars($this->workerID->getWorkerID());
		$training=htmlspecialchars($this->workerID->getTraining());
		$id=$this->id;
		return <<<HTML
		<h>Training Search.$id</h>
		<table border="1">
		<tr><td>ID</td><td><input type="text" name="$id-workerID" value="$workerID"></td></tr>
		<tr><td>Training</td><td><input type="text" name="$id-training" value="$training"></td></tr>

		</table>
HTML;
	}

	}


	class Training {
	private $workerID=NULL;
	private $training=NULL;

	/**
	* Database Handle
	* @var \mysqli
	*/
	static $db=NULL;

	function __construct(){
	if(!is_null(self::$db)){
	return;
	}
	self::$db = @new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
	if(self::$db->connect_error){
	throw new \Exception("Error unable to connect to database: ".self::$db->connect_error);
	}
	}



		function setTraining($training){
		$this->training=$training;
		return TRUE;
	}

	/**
	* Set Person nam
	* @param string $name of person.
	*/


	function setWorkerID($workerID){
	if(preg_match('/^[0-9]+$/',$workerID)){
			$this->workerID=$workerID;
			return TRUE;
	}

			else return FALSE;

	}



			function getTraining(){
			return $this->training;
	}
			function getWorkerID(){

			return $this->workerID;
	}


			function write(){
			$stmt=self::$db->prepare("INSERT INTO Trainingmatrix (workerID,training) VALUES (?,?)");
					if($stmt===FALSE){
					die("training.write: unable to create statement " . self::$db->error);
			return FALSE;
	}
			if($stmt->bind_param("ss",$this->workerID,$this->training)===FALSE){
			die("training.write: unable to bind " . self::$db->error);
	}
	if($this->workerID!=NULL){
	if($stmt->execute()===FALSE){
	if($stmt->errno==1062){ // Duplicate Entry
	$stmt->close();
	self::$db->close();
	return FALSE;
	}
	die("training.write: unable to execute ".self::$db->errno.",".self::$db->error);
	return FALSE;
	}
	}
	$stmt->close();
	return TRUE;
	}

	/**
	* Remove Person
	* @return bool TRUE on success (even if record did not exist);
	*/
	function delete(){
	$stmt=self::$db->prepare("DELETE FROM Trainingmatrix WHERE workerID=?");
	if($stmt===FALSE){
	die("WCS/training.delete> stmt:".self::$db->error);
	return FALSE;
	}
	if($stmt->bind_param('s',$this->workerID)===FALSE){
	die("WCS/training.delete> bind_param:".self::$db->error);
			return FALSE;
	}
			if($stmt->execute()===FALSE){
			die("WCS/training.delete> execute:".self::$db->errno." ".self::$db->error);
			return FALSE;
	}
			return TRUE;
	}

			function read() {
			$stmt=self::$db->prepare("SELECT training FROM Trainingmatrix WHERE workerID=?");
			if($stmt===FALSE){
			die("training.get: unable to create statement " . self::$db->error);
			return FALSE;
	}
			if($stmt->bind_param("s",$this->workerID)===FALSE){
			die("training.get: unable to bind_param " . self::$db->error);
					return FALSE;
	}
					if($stmt->bind_result($this->training)===FALSE){
					die("training.get: unable to bind_result " . self::$db->error);
							return FALSE;
	}
							if($stmt->execute()===FALSE){
							die("training.get: unable to execute self::$db->errno self::$db->error");
							return FALSE;
	}
							if($stmt->fetch()==FALSE){
					$stmt->close();
					return FALSE;
	}
					// print "Person.get: ".$this->display();
					//echo "WCS database: { name: ".$this->name."  rate:".$this->rate."}";
					return TRUE;
	}
					function display(){
					$stmt=self::$db->prepare("SELECT * FROM Trainingmatrix ORDER BY workerID");
					if($stmt===FALSE){
					die("training.get: unable to create statement " . self::$db->error);
					return FALSE;
	}

					if($stmt->bind_result($this->workerID,$this->training)===FALSE){
							die("training.get: unable to bind_result " . self::$db->error);
							return FALSE;
	}
							if($stmt->execute()===FALSE){
							die("training.get: unable to execute self::$db->errno self::$db->error");
							return FALSE;
	}

							//reset($stmt->fetch());
							$c=0;
							$t=array();
							while ($stmt->fetch()) {
					$t[$c][0]=$this->workerID;
					$t[$c][1]=$this->training;
					$c=$c+1;
	}

       return $t;
		}

	}


?>