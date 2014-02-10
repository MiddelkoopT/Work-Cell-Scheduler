<?php
// Main Page Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'TDD/validator.php';

class MyTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;
	
	function testValidator() {
		$this->assertValidHTML("Web/","<h1>Work Cell Scheduler</h1>");
	}
						
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	MyTEstCase::main();
}

?>

