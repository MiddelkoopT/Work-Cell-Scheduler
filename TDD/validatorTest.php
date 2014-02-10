<?php
// WebIS validatorTest Copyright 2014 by Timothy Middelkoop License Apache 2.0
// Project version
require_once 'TDD/validator.php';

class MyTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;
	
	function testValidator() {
		$this->assertValidHTML("TDD/static.html","Static html");
	}
						
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	MyTEstCase::main();
}

?>

