<?php
// Person App Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';


class SubcellApp {
	public $subcell=NULL;

	function add(Subcell $subcell){
		$this->subcell=$subcell;
		return TRUE;
	}

	function process($page){
		$this->save();
		echo $this->edit($page);
	}

	function get(){
		if($this->subcell===NULL){
			$this->subcell=new Subcell();
		}
		if(!$this->subcell->setSubcell($_REQUEST['subcell'])){
			//print ":PersonApp.process: unable to set person |".$_REQUEST['person']."|");
			return FALSE;
		}
	}


	function save(){
		if($this->subcell===NULL){
			$this->subcell=new Subcell();
		}
		if(!isset($_REQUEST['action'])){
			return FALSE;
		}
		if($_REQUEST['action']!='Update'){
			return FALSE;
		}
		$this->get();
		if($this->subcell->delete()===FALSE){
			print ":PersonApp.save: unable to delete()";
			return FALSE;
		}
		if($this->subcell->insert()===FALSE){
			print ":PersonApp.save: unable to write()";
			return FALSE;
		}
		return TRUE;
	}

	function edit($action){
		$subcell=htmlspecialchars($this->subcell->getSubcell());
		return <<<HTML
		<form action="$action" method="GET">
		<table border="1">
		<tr><td>Subcell:</td><td><input type="text" name="subcell" value="$subcell"></td></tr>
		</table>
		<input type="submit" name="action" value="Update">
		</form>
HTML;
	}



}





class Subcell{
	
	private $db=NULL;
	public $subcell=NULL;

	
	
	function __construct(){
		$this->db= @new \mysqli(\WCS\Config::$dbhost,\WCS\Config::$dbuser,\WCS\Config::$dbpassword,\WCS\Config::$dbdatabase);
		if($this->db->connect_error){
			throw new \Exception("Error unable to connect to database: ".$this->db->connect_error);
		}
	}
	
	function destruct(){
		if($this->db!=null){
			$this->db->close();
		}
	}


	function setSubcell($subcell){
		if(preg_match('/^[0-9]+$/',$subcell)){
			$this->subcell=$subcell;
			return TRUE;
		}
		else{
			return FALSE;
		}
	}	
	
	
	function getSubcell(){
		return $this->subcell;
	}
	
	
	
	function insert(){
		$stmt=$this->db->prepare("INSERT INTO Subcell (subcell) VALUES (?)");
		if($stmt===FALSE){
			die ("WCS/Person.insert1> stmt:".$this->db->error);
			print "1";
			return FALSE;
		}
		if($stmt->bind_param('i',$this->subcell)===FALSE){
			die ("WCS/Person.insert2> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			if($this->db->errno==1048){
				return FALSE;
			}
			if($this->db->errno==1062){
				echo "Subcell already in database.  Go back and add a unique cell";
			}
			die ("WCS/Person.insert3> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		return TRUE;
	}
	
	function delete(){
		$stmt=$this->db->prepare("DELETE FROM Subcell WHERE subcell=?");
		if($stmt===FALSE){
			die("WCS/Person.delete> stmt:".$this->db->error);
			return FALSE;
		}
		if($stmt->bind_param('s',$this->subcell)===FALSE){
			die("WCS/Person.delete> bind_param:".$this->db->error);
			return FALSE;
		}
		if($stmt->execute()===FALSE){
			die("WCS/Person.delete> execute:".$this->db->error);
			return FALSE;
		}
		return TRUE;
	
	}



}
?>