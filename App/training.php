<?php
// TrainingMatrix Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class TrainingMatrix{

	private $people = array('Ann','Bob','Clide');
	private $line = array(1010,1020,1030,1040); 

	public function getPeople() {
		// $people=array('Dr.Middelkoop','JD');
		$db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'database');
		if($db===NULL){
			echo "Error unable to connect to database";
			exit();
		}
		$stmt=$db->prepare("SELECT person FROM TrainingMatrix");
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->execute();
		$stmt->bind_result($person);
		$people=array();
		while($stmt->fetch()){
			$people[]=$person;
		}
		return $people;
	}
	
	public function getWorkstations() {
		return $this->line;
	}
	
	public function getTraining($person,$workstation){
		return 0.10;
	}
	
}

?>
