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
	
	public function getWorkstations() {
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
		$stmt->bind_result($workstation);
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		for ($id = 0; $id <= sizeof($workstation)-1; $i++){
		$workstation[$id]=array();
		while($stmt->fetch()){
			$workstation[$id]=$workstation;
				}
		return $workstation;
		
			}
		}
	
	public function getTraining($person,$workstation){
	$db = new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,'database');
		if($db===NULL){
			echo "Error unable to connect to database";
			exit();
		}
		$stmt=$db->prepare("SELECT wsp FROM TrainingMatrix");
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->execute();
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$stmt->bind_result($workstation);
		if($stmt===FALSE){
			echo "prepare error ",$db->error;
			exit();
		}
		$workstation=array();
		while($stmt->fetch()){
			$wsp[]=$wsp;
		}
		return $wsp;
	}
	
}
?>
