<?php
// Person App Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
use PDO;
require_once 'Work-Cell-Scheduler/Config/global.php';

class Worker {

private $db=NULL;

public $person=NULL;
public $cell=NULL;
public $workstation=NULL;
public $wcp=NULL;
public $wsp=NULL;

public $result=NULL;



function __construct()
{
	try
		{
			$host   = 'localhost';
			$dbname = 'wcs';
			$user   = 'root';
			$pass   = '';
			$this->db = new \PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	catch(Exception $exc)
		{
			echo $exc->getMessage();
			file_put_contents('log.txt', $exc->getMessage() . '\r\n', FILE_APPEND);
		}

}

function __destruct() 
{
	if($this->db!=NULL)
	{
		// $this->db->close();
	}
}


function search()
{
	$statement = $this->db->prepare('SELECT person, cell, workstation, wcp, wsp FROM trainingmatrix WHERE person = ?');
	$param = array($this->person);
	$statement->execute($param);
	$statement->setFetchMode(PDO::FETCH_BOTH);
	$this->result = $statement->fetch();
// 	while($row = $statement->fetch())
// 		{
// 			echo $row->person;
// 			echo $row->cell;
// 			echo $row->workstation;
// 			echo $row->wcp;
// 			echo $row->wsp;
// 	}

	return $this->result;
}

public function display(){
	$name='';
	if(!\is_null($this->person)){
		$name=" name: $this->person";
	}
	return "{person: $this->person".$name."}";
}

public function insert()
{
	

// 		$statement = $this->db->prepare('INSERT INTO trainingmatrix(person, cell, workstation, wcp, wsp) VALUES (?,?,?)');
// 		$param = array($this->person, $this->cell, $this->workstation, $this->wcp, $this->wsp);
// 		$statement->execute($param);
		
		$statement = $this->db->prepare('INSERT INTO trainingmatrix(person, cell, workstation, wcp, wsp) VALUES (:person, :cell, :workstation, :wcp, :wsp)');
		
		if($statement===FALSE)
		{
			die("WCS/Worker.insert> statement:".$this->db->error);
			return FALSE;
		}
		
		$param = array(
						'person'=> $this->person,
						'cell'=> $this->cell,
						'workstation' => $this->workstation,
						'wcp' => $this->wcp,
						'wsp' => $this->wsp
				);
		//$statement->execute($param);
		
		if($statement->execute($param)===FALSE){
			if($this->db->errno==1062)
			{
				return FALSE;
			}
			die("WCS/Worker.insert> execute:".$this->db->errno." ".$this->db->error);
			return FALSE;
		}
		
		$this->search();
		
		return TRUE;
	
}

public function save()
{
	$statement = $this->db->prepare('UPDATE trainingmatrix SET person=:person, cell=:cell, workstation=:workstation, wcp=:wcp, wsp=:wsp WHERE person=:person');
	
	if($statement===FALSE)
	{
		die("WCS/Worker.save> statement:".$this->db->error);
		return FALSE;
	}
	
	$param = array(
			'person'=> $this->person,
			'cell'=> $this->cell,
			'workstation' => $this->workstation,
			'wcp' => $this->wcp,
			'wsp' => $this->wsp
	);
	//$statement->execute($param);
	
	if($statement->execute($param)===FALSE){
		if($this->db->errno==1062)
		{
			return FALSE;
		}
		die("WCS/Worker.save> execute:".$this->db->errno." ".$this->db->error);
		return FALSE;
	}
	
	$this->search();
	
	return TRUE;

}

public function delete()
{
	$statement = $this->db->prepare('DELETE FROM trainingmatrix WHERE person = :person');
	
	if($statement===FALSE)
	{
		die("WCS/Worker.save> statement:".$this->db->error);
		return FALSE;
	}
	
	$param = array(
			'person'=> $this->person
	);
	//$statement->execute($param);
	
	if($statement->execute($param)===FALSE){
		if($this->db->errno==1062)
		{
			return FALSE;
		}
		die("WCS/Worker.save> execute:".$this->db->errno." ".$this->db->error);
		return FALSE;
	}
	
	//$this->search();
	
	return TRUE;

}


}

?>