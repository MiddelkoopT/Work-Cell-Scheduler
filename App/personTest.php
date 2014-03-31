<?php
// Person Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'personApp.php';

class PersonTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testPerson(){
		$p=new \WCS\Person();
		$this->assertTrue($p->setEmployeeid('Jennifer'));
		$this->assertEquals("Emloyee ID: Jennifer",$p->display());
		$this->assertFalse($p->setEmployeeid('Jen.B'));
		$this->assertTrue($p->setEmployeename('Jen'));
		$this->assertFalse($p->setEmployeename('Jen1'));
		$this->assertEquals("Emloyee ID: Jennifer Employee Name: Jen",$p->display());
		$this->assertTrue($p->delete());
		$this->assertTrue($p->delete());
		$this->assertTrue($p->insert());	
		$this->assertFalse($p->insert());
		$this->assertTrue($p->select());
		

	}
	
	function testPersonApp(){
		$p=new \WCS\Person();
		$this->assertTrue($p->setEmployeename('Jen'));
		
		$a=new \WCS\PersonApp();
		$this->assertTrue($a->add($p));
		$this->assertContains('Jen', $a->edit("person.php"),"edit problem");
		
		$a=new \WCS\PersonApp();
		$this->assertFalse($a->load());
		$_REQUEST["action"]='Load';
		$_REQUEST["person"]='Jennifer';
		$this->assertTrue($a->load());
		$this->assertContains('Jen',$p->getName());
		$_REQUEST["action"]='Update';
		$_REQUEST["person"]='Jennifer';
		$_REQUEST["name"]='Jen';
		$this->assertTrue($a->save());
	}
	
	
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	PersonTestCase::main();
}
?>