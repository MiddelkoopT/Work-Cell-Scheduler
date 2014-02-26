<?php
// TrainingMatrix Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class TrainingMatrix{

	private $people = array('Ann','Bob','Clide');
	private $line = array(1010,1020,1030,1040); 

	public function getPeople() {
		return $this->people;
	}
	
	public function getWorkstations() {
		return $this->line;
	}
	
	public function getTraining($person,$workstation){
		return 0.10;
	}
	
}

?>
