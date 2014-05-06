<?php
// Optimization Services Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'pingApp.php';

class MyTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testPing() {
		$p=new WCS\Ping();
		$this->assertTRUE($p->config());
		$this->assertEquals("pong:ping",$p->ping('ping'));
	}

}

if (!defined('PHPUnit_MAIN_METHOD')) {
	MyTestCase::main();
}
?>