<?php
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class a2person {
	
	/**
	 * Database handle
	 * @var \mysqli
	 */
	
	private $db=NULL;
	
	private $a2person_whitelist=NULL;
	private $a2person_name=NULL;
	private $a2person_email=NULL;
	
	function __construct(){
		$this->db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
		If($this->db===NULL){
			die('Error database failed to construct');
		}		
	}
	
			
	public function __destruct(){
		if ($this->db!=NULL){
				$this->db->close();
		}
	}
	
	/**
	 * Set a2person_whitelist
	 * @param  string $a2person_whitelist alphabetic [a-zA-Z]
	 * @return boolean a2person_whitelist
	 */
		
	public function seta2person_whitelist($a2person_whitelist){
		print "seta2person_whitelist: ".$a2person_whitelist;
		if (preg_match('/^[a-zA-Z]+$/',$a2person_whitelist)){
			$this->a2person_whitelist=$a2person_whitelist;
			Return TRUE;
		}
		Return FALSE;
	}
	
	/**
	 * Set a2person_name
	 * @param string $a2person_name is person's name
	 * @return boolean a2person_name set
	 */
	public function seta2person_name($a2person_name){
		$this->a2person_name=$a2person_name;
		return TRUE;	
	}
	
	/**
	 * Display a2person
	 * @return string human readable display.
	 */
	public function display(){
		$a2person_name='' ;
		if(!\is_null($this->a2person_name)){
			$a2person_name=" name: $this->a2person_name";
		}
		return "{person: $this->a2person_whitelist".$a2person_name."}";
	}
	
	/**
	 * Insert into database
	 * @return boolean info in database.
	 */
	public function insert() {
		$query = "INSERT INTO a2person (a2person_whitelist,a2person_name,a2person_email) VALUES (?,?,?)";
		$stmt = $this->db->prepare($query);
		if($stmt===FALSE){
			
			return FALSE;
		}
		if($stmt->bind_param("sss",$this->a2person_whitelist,$this->a2person_name,$this->a2person_email)===FALSE){
			
			return FALSE;
		}
		if($stmt-> execute()===FALSE){
			
			return FALSE;
		}
		
	return TRUE;
	}
	
	/**
	 * Remove Person
	 * @return boolean TRUE
	 */
	public function delete(){
		$stmt=$this->db->prepare("DELETE FROM a2person WHERE a2person_whitelist=?");
		
		if ($stmt===FALSE){
			
			return FALSE;
		}
		if ($stmt->bind_param('s',$this->a2person_whitelist)===FALSE){
			
			return FALSE;
		}
		if ($stmt->execute()===FALSE){
			
			return FALSE;
		}
	return TRUE;
	}
	
	public function a2get();
	
	
	
	
	
}

?>