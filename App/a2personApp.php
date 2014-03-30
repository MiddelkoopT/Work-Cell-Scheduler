<?php
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class a2personapp {
	
	private $person=NULL;
	static $counter=0;
	private $id=0;
	
	
	function __construct(){
		self::$counter+=1;
		$this->id=self::$counter;
	}	
		
	function add(a2person $a2person){
		// add function brings value of $a2person from a2person class to a2personapp class and sets it equal to $person
		$this->person=$a2person;
		return TRUE;
	}
	
	
			
	function process($page){
		$this->save();
		$this->load();
		echo $this->edit($page);
	}	
	
	function getperson(){
		if($this->person===NULL){
			$this->person= new a2person();
		}
		if(!$this->person->seta2person($__REQUEST['person'])){
			return FALSE;
		}
		if(isset($__REQUEST['name']) and !$this->person->seta2name($__REQUEST['name'])){
			return FALSE;
		}
	}
	
	function load(){
		if(!isset($__REQUEST['action'])){
			return FALSE;
		}
		if($__REQUEST['action']!='Load'){
			return FALSE;
		}
		$this->getperson();
		if($this->person->a2get()===FALSE){
			return FALSE;
		}
		return TRUE;
	}
	
	function save(){
		$this->person=new a2person();
		
		if(!isset($__REQUEST['action'])){
			return FALSE;
		}
		if($__REQUEST['action']!='update'){
			return FALSE;
		}
		$this->getperson();
		
		if($this->person->a2delete()===FALSE){
			return FALSE;	
		}
		if($this->person->a2insert()===FALSE){
			return FALSE;
		}
		return TRUE;
	}
	
	function edit(){
		$person=htmlspecialchar($this->a2person->a2getperson());
		$name=htmlspecialchar($this->a2person->a2getname());
		$id=$this->id;
		
		return <<<HTML
		<form>
		<table border="1">
			<tr><td>Person</td><td><input type="text" name="$id-person" value="$person"></td></tr>
			<tr><td>Name</td> <td><input type="text" name="$id-name" value="$name"></td></tr>
		</table>
					
		<input type="submit" name="action" value="Load">
		<input type="submit" name="action" value="Update">
		<\form>
HTML;
		
		}
		
}


class a2person {
	
	/**
	 * Database handle
	 * @var \mysqli
	 */
	private $db=NULL;
	
	private $a2person=NULL;
	private $a2name=NULL;
	private $a2rate=NULL;
	
	function __construct(){
		$this->db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
		If($this->db===NULL){
			die('Error database failed to construct');
		}		
	}
	
			
	function __destruct(){
		if ($this->db!=NULL){
				$this->db->close();
		}
	}
	
	function a2getperson(){
		return $this->a2person;
	}
	
	function a2getname(){
		return $this->a2name;
		
		
	}
	
	/**
	 * Set a2person
	 * @param  string $a2person alphabetic [a-zA-Z]
	 * @return boolean a2person
	 */
		
	public function seta2person($a2person){
		//print "seta2person: ".$a2person;
		if (preg_match('/^[a-zA-Z]+$/',$a2person)){
			$this->a2person=$a2person;
			Return TRUE;
		}
		Return FALSE;
	}
	
	/**
	 * Set a2name
	 * @param string $a2name is person's name
	 * @return boolean a2name set
	 */
	public function seta2name($a2name){
		$this->a2name=$a2name;
		return TRUE;	
	}
	
	/**
	 * Display a2person
	 * @return string human readable display.
	 */
	public function display(){
		$a2name='';
		if(!\is_null($this->a2name)){
			$a2name=" name: $this->a2name";
		}
		return "{person: $this->a2person".$a2name."}";
	}
	
	
	public function a2insert() {
		$query = "INSERT INTO Person (person,name,rate) VALUES (?,?,?)";
		$stmt = $this->db->prepare($query);
		if($stmt===FALSE){
			error_log("WCS/a2person.a2insert> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param("ssd",$this->a2person,$this->a2name,$this->a2rate)===FALSE){
			error_log("WCS/a2person.a2insert> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			if($this->db->errno==1062){ // Duplicate.					
				return FALSE;
			}
			error_log("WCS/a2person.a2insert> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * Remove Person
	 * @return boolean TRUE
	 */
	public function a2delete(){
		$stmt=$this->db->prepare("DELETE FROM Person WHERE person=?");
		if ($stmt===FALSE){
			error_log("WCS/a2person.a2delete> stmt:".$this->db->error);
			return FALSE;
		}
		if ($stmt->bind_param('s',$this->a2person)===FALSE){
			error_log("WCS/a2person.a2delete> bind_param:".$this->db->error);
			return FALSE;
		}
		if ($stmt->execute()===FALSE){
			error_log("WCS/a2person.a2delete> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
	return TRUE;
	
	}
	
	public function a2get(){
		$query = "SELECT name,rate FROM Person WHERE person=?";
		$stmt = $this->db->prepare($query);
		if ($stmt===FALSE){
			echo "WCS/a2person.a2get> stmt error";
			return FALSE;
		}
		
		if ($stmt->bind_param('s',$this->a2person)===FALSE){
			echo "WCS/a2person.a2get> bind_param error";
			return FALSE;
		}
		
		if ($stmt->bind_result($this->a2name,$this->a2rate)===FALSE){
			echo "WCS/a2person.a2get> bind_result error";
			return FALSE;
		}
		
		if ($stmt->execute()===FALSE){
			echo "WCS/a2person.a2get> execute error";
			return FALSE;
		}
		
		return $stmt->fetch();	
	}	
	
}

?>