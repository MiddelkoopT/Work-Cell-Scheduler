<?php
// OS Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0

require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'os.php';

class WebOSTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;
	
	function testOsXML () {
		// Problem: develop a class that provides an empty OSiL XML Document
		// Reference: https://github.com/MiddelkoopT/Work-Cell-Scheduler/blob/master/Test/osTest.php
		// Solution: properly formed xml document with the root node <osil></osil> 
	
		$os=new OS();
		$this->assertEquals("<osil></osil>",$os->osil());
	}
	
}


if (!defined('PHPUnit_MAIN_METHOD')) {
	WebOSTestCase::main();
}
?>
