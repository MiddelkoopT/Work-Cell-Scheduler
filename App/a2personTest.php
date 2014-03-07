<?php
use WCS\a2person;
// Person Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'a2personApp.php';

class a2personTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testa2personApp() {
		$n=new \WCS\a2person();
		
		
	}
	
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	a2personTestCase::main();
}
?>