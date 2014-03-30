<?php
// Worker Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'ta3.php';

class WorkersTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testworkers(){
		$w= new \WCS\Workers2();
		$this->assertTrue($w->SetID("102"));
		$this->assertFalse($w->SetID("Mark"));
		$this->assertFalse($w->SetName(" "));
		$this->assertTrue($w->SetName("Mark Dintelman"));
		$this->assertTrue($w->Setratesub1("0.9"));
		$this->assertTrue($w->Setratesub2("0.8"));
		
		$this->assertEquals(array('102'),$w->getworkerID());
		$this->assertEquals(array('0.9'),$w->getrateSub1());
	
		





	}

}
if (!defined('PHPUnit_MAIN_METHOD')) {
	WorkersTestCase::main();
}