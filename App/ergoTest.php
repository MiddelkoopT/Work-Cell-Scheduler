<?php
//Ergonomic Score Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'ergoApp.php';

class ErgoTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testErgoApp() {
		$e=new \WCS\ErgoMatrix();
		$this->assertEquals(array('JB','JS','MD'), $e->getEmployeeid());
		$this->assertEquals(array(1,2,3), $e->getSubcell());
		$this->assertEquals(.3,$e->getErgo('JB', '1'));
		$this->assertNotEquals(.4,$e->getErgo('JB', '1'));
	}



}

if (!defined('PHPUnit_MAIN_METHOD')) {
	ErgoTestCase::main();
}

?>