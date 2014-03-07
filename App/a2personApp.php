<?php
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class a2person {
	
	private $db=NULL;
	
	private $a2person_name=NULL;
	private $a2person_email=NULL;
	
	function _construct(){
		
		$this->db = new mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
	}
	public function seta2person($a2person_name){
		if (preg_match('/^[a-Z]+$/',$a2person_name)){
			$this->a2person_name=$a2person_name;
		}
	}
	
}

?>