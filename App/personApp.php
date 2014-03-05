<?php
// Person App Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class Person {
	private $person=NULL;
	private $name=NULL;
	
	function display(){
		$str="{person: $this->person";
		if(!is_null($this->name)){
			$str.=" name: $this->name";
		}
		return $str.'}';
	}
	
	function setPerson($person){
		if(preg_match('/^[a-zA-Z0-9]+$/',$person)){
			$this->person=$person;
			return TRUE;
		}
		return FALSE;
	}
	
	function getName(){
		return $this->name;
	}
	
	function setName($name){
		if(preg_match('/^\s*$/',$name)){
			return FALSE;
		}
		$this->name=$name;
		return TRUE;
	}
	
	function write(){
		$db=new \mysqli('127.0.0.1','root','webis','WCS');
		if($db===NULL){
			echo "Person.write:","cannot connect to database";
		}
		
		return TRUE;
	}
		
}

?>
