<?php
// Person Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'personApp.php';

class PersonTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testTrainingApp() {
		$p=new \WCS\Person();
		$this->assertTrue($p->setPerson("DrMiddelkoop"));
		$this->assertFalse($p->setPerson("Dr.Middelkoop"));
		$this->assertEquals("{person: DrMiddelkoop}",$p->display());
		$this->assertTrue($p->setName("Dr. Middelkoop"));
		$this->assertEquals("{person: DrMiddelkoop name: Dr. Middelkoop}",$p->display());
		$this->assertTrue($p->delete());
		$this->assertTrue($p->delete()); // second one should also succeed.
		$this->assertTrue($p->insert());
		$this->assertFalse($p->insert(),"record exists, should return false");
		$p=new \WCS\Person();
		$this->assertTrue($p->setPerson("DrMiddelkoop"));
		$this->assertTrue($p->get());
		$this->assertEquals("{person: DrMiddelkoop name: Dr. Middelkoop}",$p->display());
	}
	
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	PersonTestCase::main();
}
?>