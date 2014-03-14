<?php
// Person Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'personApp.php';

class PersonTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testTrainingApp() {
		$p=new \WCS\Person();
		$this->assertTrue($p->setPerson("LanceMarkert"));
		$this->assertFalse($p->setPerson("Lance Markert"));
		$this->assertEquals("{person: LanceMarkert}",$p->display());
		$this->assertTrue($p->setName("Lance Markert"));
		$this->assertEquals("{person: LanceMarkert name: Lance Markert}",$p->display());
		$this->assertTrue($p->delete());
		// Use assertTrue($p->delete()) again to return true if the record does not exist
		$this->assertTrue($p->delete()); 
		$this->assertTrue($p->insert());
		$this->assertFalse($p->insert(),"record exists, should return false");
		$p=new \WCS\Person();
		$this->assertTrue($p->setPerson("LanceMarkert"));
		$this->assertTrue($p->get());
		$this->assertEquals("{person: LanceMarkert name: Lance Markert}",$p->display());
	}
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	PersonTestCase::main();
}
?>