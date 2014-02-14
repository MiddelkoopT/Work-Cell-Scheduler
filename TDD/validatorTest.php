<?php
// WebIS validatorTest Copyright 2014 by Timothy Middelkoop License Apache 2.0
// Project version
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';

class ValidatorTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;
	
	function testTidy() {
		exec(self::$tidy." --version",$output,$return);
		$this->assertEquals(0,$return);
		$this->assertContains("HTML Tidy for HTML5",$output[0]);
	}
	
	function testValidator() {
		$this->assertValidHTML("TDD/static.html","Static html");
	}
						
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	ValidatorTestCase::main();
}

?>

