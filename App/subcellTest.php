<?php
//Training Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'subcellApp.php';

class SubcellTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testsubcell() {
		$t=new \WCS\Subcell();
		$this->assertTrue($t->setSubcell('6'));
		$this->assertFalse($t->setSubcell('J1'));
		$this->assertEquals(6,$t->getSubcell());
		$this->assertTrue($t->delete());
		$this->assertTrue($t->delete());
		$this->assertTrue($t->insert());
		
		
		
	}

	function testsubcellApp() {
		$t=new \WCS\Subcell();
		$this->assertTrue($t->setSubcell('5'));
		
		$a=new \WCS\SubcellApp();
		$this->assertTrue($a->add($t));
		$this->assertContains("5",$a->edit("subcell.php"),"Edit app does not edit");

		$a=new \WCS\SubcellApp();
		$_REQUEST['action']='Update';
		$_REQUEST['subcell']='5';
 		$this->assertTrue($a->save(),"can't save");
	}
	

}

if (!defined('PHPUnit_MAIN_METHOD')) {
	SubcellTestCase::main();
}

?>