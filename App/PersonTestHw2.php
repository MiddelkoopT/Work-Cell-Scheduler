<?php
//Person Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
Include 'Work-Cell-Scheduler/Config/local.php';
require_once 'PersonHw2.php';

class PersonTestCase extends WebIS\validator{
	protected static $__CLASS__=__Class__;
	
	function testPersonTestHW2() {
		$p=new \WCS\Employee();
		$this->assertTrue($p->setEmployee("Mr.calebboyer"));
		$this-assertFalse($p->setEmployee("Caleb Boyer"));
		$this-assertEquals("{person: calebboyer}",$p->display());
		$this->assertTrue($p->setName("Caleb Boyer"));
		$this->assertEquals("{person: calebboyer name: Caleb Boyer}",$p->dispaly());
		$this->assertTrue($p->delete());
		$this->assertTrue($p->delete()); // second one should also succeed.
		$this->assertTrue($p->insert());
		$this->assertFalse($p->insert(),"record exists, should return false");
		$p=new \WCS\Person();
		$this->assertTrue($p->setPerson("calebboyer"));
		$this->assertTrue($p->get());
		$this->assertEquals("{person: calebboyer name: Caleb Boyer}",$p->display());
		
	}
}
if (!defined('PHPUnit_MAIN_METHOD')) {
	PersonTestCase::main();
}
?>