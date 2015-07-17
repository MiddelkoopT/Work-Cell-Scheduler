<?php
// Worker Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'ta2.php';

class WorkersTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;
	
	function testworkers(){
		$w= new \WCS\Workers();
		$this->assertTrue($w->SetID("102"));
		$this->assertFalse($w->SetID("MARK"));
		$this->assertFalse($w->SetName(" "));
		$this->assertTrue($w->SetName("Mark Dintelman"));
		$this->assertTrue($w->SetSubcell("10"));
		$this->assertFalse($w->SetSubcell("Mark"));
		$this->assertTrue($w->SetRate("9"));
		$this->assertTrue($w->delete());
		$this->assertTrue($w->insert());
		$this->assertEquals(array("102","103",),$w->getworkerID());
		$this->assertEquals(array("Mark Dintelman","Max Smith"),$w->getname());
		$this->assertEquals(array("10","11"),$w->getsubcell());
		$this->assertEquals(array("9","10"),$w->getrate());
		
		
		
		
		
	}
	
}
if (!defined('PHPUnit_MAIN_METHOD')) {
	WorkersTestCase::main();
}