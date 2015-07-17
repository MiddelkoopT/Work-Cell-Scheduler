<?php
class personApp{
	/**
	 * Database handle
	 * @var \mysqli
	 */
 
	public $db = NULL;
	public $name = NULL;
	public $person = NULL;
	public $rate = NULL;


	//connect to db
	function __construct(){
		$this->db = new \mysqli('127.0.0.1', 'root', 'webis', 'database');
		if($this->db===NULL){
			die("Error unable to connect to database");
		}
	}
	//close db
	function __destruct(){
		if($this->db !=NULL){
			$this->db->close();
		}
	}
	//checks input of person
	public function setPerson($person){
		if (preg_match('/^[a-zA-Z0-9]+$/', $person)){
			$this->person=$person;
			return TRUE;
		}
		return FALSE;
	}

	public function setName($name){
		$this->name=$name;
		return TRUE;
	}

	public function display(){
		$name='';
		if(!\is_null($this->name)){
			$name=" name: $this->name";
		}
		return "{person: $this->person".$name."}";
	}

	public function insert(){
		$stmt=$this->db->prepare("INSERT INTO personApp (person,name,rate) VALUES (?,?,?)");
		if ($stmt===FALSE){
			error_log("personApp.insert> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('ssd', $this->person, $this->name, $this->rate)===FALSE){
			error_log("personApp.insert> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			if($this->db->errno==1062){
				return FALSE;
			}
			error_log("personApp.insert> execute:".$this->db_>errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;

	}

	public function delete(){
		$stmt=$this->db->prepare("DELETE FROM personApp WHERE person=?");
		if($stmt===FALSE){
			error_log("personApp.delete> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('s',$this->person)===FALSE){
			error_log("personApp.delete> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			error_log("personApp.delete> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}


	public function get(){
		$stmt=$this->db->prepare("SELECT name,rate FROM personApp WHERE person=?");
		if($stmt===FALSE){
			error_log("personApp.get> stmt:".$this->db->error);
			return FALSE;
		}

		if($stmt->bind_param('s',$this->person)===FALSE){
			error_log("personApp.get> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_result($this->name,$this->rate)===FALSE){
			error_log("personApp.get> bind_result:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			error_log("personApp.get> bind_result:".$this->db->error);
			return FALSE;
		}
		return $stmt->fetch();
	}


}
?>
