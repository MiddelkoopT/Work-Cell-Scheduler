<?php

// TrainingMatrix Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class Schedule{

	public function getPerson() {
		// $people=array('Dr.Middelkoop','JD');
		$db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'database');
		if($db===NULL){
			echo "Error unable to connect to database";
			exit();
		}
		$stmt=$db->prepare("SELECT person FROM Schedule");
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->execute();
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->bind_result($person);
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$people=array();
		while($stmt->fetch()){
			$people[]=$person;
		}
		return $people;
	}



	public function getWorkcell() {
		// $people=array('Dr.Middelkoop','JD');
		$db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'database');
		if($db===NULL){
			echo "Error unable to connect to database";
			exit();
		}
		$stmt=$db->prepare("SELECT person FROM Schedule");
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->execute();
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->bind_result($c);
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$cell=array();
		while($stmt->fetch()){
			$cell[]=$c;
		}
		return $cell;
	}

}

?>
