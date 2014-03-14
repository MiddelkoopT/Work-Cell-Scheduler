<?php
//Worker App Copyright 2014 by WEBIS Spring 2014 License Apache 2.0

namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class WorkerApp {
	private $worker=NULL;
	
	
	function add($workerID){
		$this->worker=$workerID;
		return TRUE;
	}
	
	function load(){
		if(isset($_REQUEST['action'])){
			return FALSE;
		}
		
		if($_REQUEST['action']!='Load'){
			return FALSE;
		}
		
	}
	
	function edit($action){
		$workerID=htmlspecialchars($this->worker->getworkerID());
		$firstname=htmlspecialchars($this->firstname->getfirstName());
		$lastname=htmlspecialchars($this->lastname->getlastName());
		return <<<HTML
		<form action="$action" type="GET">
			<table border="1">
				<tr><td> WorkerID ID </td><td>< input type="text" name ="workerID" value="$workerID"></td></tr>
				<tr><td> First Name </td><td>< input type="text" name ="firstname" value="$firstname"></td></tr>
				<tr><td> Last Name </td><td>< input type="text" name ="lastname" value="$lastname"></td></tr>
				</table>
		<input type="submit" name="action" value="Update">
		<input type="submit" name="action" value="Load">
		
HTML;
		
			}
	}
	
class worker {
	/**
	 * Database handle
	 * @var \mysqli
	 */
	
	private $db=NULL;
	public $workerID=NULL;
	public $firstname=NULL;
	public $lastname=NULL;
	
	
	function __construct(){
		$this->db=new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser, \WCS\Config::$dbpassword,\WCS\Config::$database);
		if($this->db===NULL){
			die("Error! Unable to connect to database");
		}	
	}

	function __destruct(){
		if($this->db!=NULL){
			$this->db->close();
			
		}
	}
	
	/**
	 * 
	 * @param string $workerID Alphanumeric workerID [a-zA-Z0-9]
	 * @return boolean workerID set.
	 */
	public function setWorkerID($workerID){
		if(preg_match('/^[a-aZ-Z0-9]+/',$workerID)){
			$this->workerID=$workerID;
			return TRUE;	
		}
			return False;
			
		}
		
	/**
	 * 
	 * @param string $firstname Persons First name
	 * @return bool first name set.
	 */
		
	public function setFirstName($firstname){
		$this->firstname=$firstname;
		return TRUE;
		
	}
		
		
}
?>