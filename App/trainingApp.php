<?php

// TrainingMatrix Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class TrainingMatrix{

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

	public function getCell() {
		$db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'database');
		if($db===NULL){
			echo "Error unable to connect to database";
			exit();
		}
		$stmt=$db->prepare("SELECT cell FROM TrainingMatrix");
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->execute();
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->bind_result($cell);
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$workcell=array();
		while($stmt->fetch()){
			$workcell[]=$cell;
		}
		return $workcell;
	}
		

	public function getWorkstation() {
		$db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'database');
		if($db===NULL){
			echo "Error unable to connect to database";
			exit();
		}
		$stmt=$db->prepare("SELECT workstation FROM TrainingMatrix");
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->execute();
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->bind_result($station);
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$workstation=array();
		while($stmt->fetch()){
			$workstation[]=$station;
		}
		return $workstation;
	}
	
	
//public function getTraining($person,$station){
//		return 0.10;

	
//	}

	public function getTraining() {
		$db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'database');
		if($db===NULL){
			echo "Error unable to connect to database";
			exit();
		}
		$stmt=$db->prepare("SELECT training FROM TrainingMatrix");
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->execute();
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->bind_result($wsp);
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$wsproductivity=array();
		while($stmt->fetch()){
			$wsproductivity[]=$wsp;
		}
		return $wsproductivity;
	}	
	
	public function getErgo() {
		$db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'database');
		if($db===NULL){
			echo "Error unable to connect to database";
			exit();
		}
		$stmt=$db->prepare("SELECT ergonomicscore FROM TrainingMatrix");
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->execute();
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->bind_result($score);
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$es=array();
		while($stmt->fetch()){
			$es[]=$score;
		}
		return $es;
	}

}



?>


