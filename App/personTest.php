<?php
// Person Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'personApp.php';

class PersonTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testTrainingApp() {
		
		// test write
		$p=new \WCS\Person();
		$this->assertTrue($p->setPerson("DrMiddelkoop"));
		$this->assertFalse($p->setPerson("Dr.Middelkoop"));
		$this->assertEquals("{person: DrMiddelkoop}",$p->display(),"display only person");
		$this->assertTrue($p->setName("Dr. Middelkoop"));
		$this->assertFalse($p->setName(""));
		$this->assertFalse($p->setName(" "));
		$this->assertEquals("Dr. Middelkoop",$p->getName());
		$this->assertEquals("{person: DrMiddelkoop name: Dr. Middelkoop}",$p->display(),"adding name to object");
		// echo $p->display();
		$this->assertTrue($p->delete());
		$this->assertTrue($p->write());
		
		// Test read
		$p=new \WCS\Person();
		$this->assertTrue($p->setPerson('DrMiddelkoop'));
		$this->assertTrue($p->read(),"Unable to read from database");
		$this->assertEquals("Dr. Middelkoop",$p->getName(),"Object does not contain Dr. Middelkoop");
		
		$a=new \WCS\PersonApp();
		$this->assertTrue($a->add($p));
		$this->assertContains("Dr. Middelkoop",$a->edit("person.php"));
		$this->assertFalse($a->load());
		$_REQUEST['action']='Load';
		$_REQUEST['person']='DrMiddelkoop';
		$this->assertTrue($a->load());
		$this->assertContains("Dr. Middelkoop",$a->edit("person.php"),"Edit does not contain Dr. Middelkoop");
		
		
	}
	
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	PersonTestCase::main();
}
?>