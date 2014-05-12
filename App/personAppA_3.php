<?php
namespace WCS;

class PersonApp {
	private $person=NULL;
	
	function add(Person $person){
		$this->person=$person;
		return TRUE;
	}

	function process($page){
		$this->load();
		$this->save();
		echo $this->edit($page);
	}
	
	function get(){
		if($this->person===NULL){
			$this->person=new Person();
		}
		if(!$this->person->setPerson($_REQUEST['person'])){
			//print ":PersonApp.process: unable to set person |".$_REQUEST['person']."|");
			return FALSE;
		}
		if(isset($_REQUEST['name']) and !$this->person->setName($_REQUEST['name'])){
			//print ":PersonApp.process: unable to set person |".$_REQUEST['name']."|");
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
		if($this->person->read()===FALSE){
			return FALSE;
		}
		return TRUE;
	}
	
	function save(){
		if($this->person===NULL){
			$this->person=new Person();
		}
		if(!isset($_REQUEST['action'])){
			return FALSE;
		}
		if($_REQUEST['action']!='Update'){
			return FALSE;
		}
		$this->get();
		if($this->person->delete()===FALSE){
			print ":PersonApp.save: unable to delete()";
			return FALSE;
		}
		if($this->person->write()===FALSE){
			print ":PersonApp.save: unable to write()";
			return FALSE;
		}
		return TRUE;
	}
	
	function edit($action){
		$person=htmlspecialchars($this->person->getPerson());
		$name=htmlspecialchars($this->person->getName());
		return <<<HTML
		<form action="$action" method="GET">
		<table border="1">
		  <tr><td>Person</td><td><input type="text" name="person" value="$person"></td></tr>
    	  <tr><td>Name</td>  <td><input type="text" name="name"   value="$name"></td></tr>
    	</table>
		<input type="submit" name="action" value="Update">
		<input type="submit" name="action" value="Load">
		</form>
HTML;
	}
}


class Person {
	private $person=NULL;
	private $name=NULL;
	private $rate=NULL;
	
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
	
	function display(){
		$str="{person: $this->person";
		if(!is_null($this->name)){
			$str.=" name: $this->name";
		}
		return $str.'}';
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

	function getName(){
		return $this->name;
	}
	
	function getPerson(){
		return $this->person;
	}
	
	function write(){
		$stmt=self::$db->prepare("INSERT INTO Person (person,name) VALUES (?,?)");
		if($stmt===FALSE){
			die("Person.write: unable to create statement " . self::$db->error);
			return FALSE;
		}
		if($stmt->bind_param("ss",$this->person,$this->name)===FALSE){
			die("Person.write: unable to bind " . self::$db->error);
		}
		if($stmt->execute()===FALSE){
			if($stmt->errno==1062){ // Duplicate Entry
				$stmt->close();
				self::$db->close();
				return FALSE;
			}
			die("Person.write: unable to execute self::$db->errno self::$db->error");
			return FALSE;
		}
		$stmt->close();
		return TRUE;
	}
	
	/**
	 * Remove Person
	 * @return bool TRUE on success (even if record did not exist);
	 */
	function delete(){
		$stmt=self::$db->prepare("DELETE FROM Person WHERE person=?");
		if($stmt===FALSE){
			die("WCS/Person.delete> stmt:".self::$db->error);
			return FALSE;
		}
		if($stmt->bind_param('s',$this->person)===FALSE){
			die("WCS/Person.delete> bind_param:".self::$db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			die("WCS/Person.delete> execute:".self::$db->errno." ".self::$db->error);
			return FALSE;
		}
		return TRUE;
	}
	
	function read() {
		$stmt=self::$db->prepare("SELECT name,rate FROM Person WHERE person=?");
		if($stmt===FALSE){
			die("Person.get: unable to create statement " . self::$db->error);
			return FALSE;
		}
		if($stmt->bind_param("s",$this->person)===FALSE){
			die("Person.get: unable to bind_param " . self::$db->error);
			return FALSE;
		}
		if($stmt->bind_result($this->name,$this->rate)===FALSE){
			die("Person.get: unable to bind_result " . self::$db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			die("Person.get: unable to execute self::$db->errno self::$db->error");
			return FALSE;
		}
		if($stmt->fetch()==FALSE){
			$stmt->close();
			return FALSE;
		}
		// print "Person.get: ".$this->display();
		return TRUE;
	}
	
}

?>
