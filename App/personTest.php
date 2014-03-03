<?php
// Person Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'personApp.php';

class PersonTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testTrainingApp() {

	}
	
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	PersonTestCase::main();
}
?>