<?php

require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'personApp.php';


class AssignmentTestCase extends WebIS\Validator{
	
	
	protected static $__CLASS__=__CLASS__;
		
	function testA2App() {
		$p = new \WCS\Person();
		$this->assertTrue($p->setPerson("JoeAhlbrandt"));
		$this->assertFalse($p->setPerson("Joe/Ahlbrandt")); //asserting that the person is entered correctly	
		
		$this->assertEquals("{person: JoeAhlbrandt}", $p->display());
		
		$this->assertTrue($p->setname("Joe Ahlbrandt"));
		
		$this->assertEquals("{person: JoeAhlbrandt name: Joe Ahlbrandt}", $p->display());
		
		$this->assertTrue($p->delete());
		$this->assertTrue($p->delete());
		
		$this->assertTrue($p->insert());
		$this->assertFalse($p->insert(),"record exists, should return false");
		
		$p=new \WCS\Person();
		$this->assertTrue($p->setPerson("JoeAhlbrandt"));
		$this->assertTrue($p->get());
		$this->assertEquals("{person: JoeAhlbrandt name: Joe Ahlbrandt}",$p->display());
	}
}
if (!defined('PHPUnit_MAIN_METHOD')) {
	
	AssignmentTestCase::main();
}

?>