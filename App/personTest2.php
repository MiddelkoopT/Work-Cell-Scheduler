<?php
// Person Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/global.php';
require_once 'personApp2.php';

Class PersonTestCase extends WebIS\Validator {
	protected static $__CLASS__ = __CLASS__;
	
	/**
	 * Test personApp2
	 */
	function testTrainingApp2(){
		$p = new \WCS\Person();
		$this->assertTrue($p->setPerson("MrLaz"));
		$this->assertFalse($p->setPerson("Mr. Laz"));
		$this->assertTrue($p->setName("Mr. Laz"));
		$this->assertEquals("{person: MrLaz name: Mr. Laz}",$p->display());
		$this->assertTrue($p->delete());
		$this->assertTrue($p->delete());
		$this->assertTrue($p->insert());
		$this->assertFalse($p->insert(),"Record exists from first insert callout, should return false");
		$p = new \WCS\Person();
		$this->assertTrue($p->setPerson("MrLaz"));
		$this->assertTrue($p->get());
		$this->assertEquals("{person: MrLaz name: Mr. Laz}",$p->display());
		}

	}

if (!defined('PHPUnit_MAIN_METHOD')) {
	PersonTestCase::main();
}
?>
