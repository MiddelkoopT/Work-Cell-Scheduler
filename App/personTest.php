<?php
// Person Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'personApp.php';

class PersonTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testPersonApp(){
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
	
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	PersonTestCase::main();
}
?>