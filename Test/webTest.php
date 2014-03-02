<?php
// Main Page Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';

class WebTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;
	
	function testValidator() {
		$this->assertValidHTML("Web/static.php","<h1>Work Cell Scheduler</h1>");
	}
	
	function testApp() {
		$this->assertValidHTML("Web/ping.php","Ping");
		$this->assertValidHTML("Web/ping.php","pong:&lt;em&gt;PING&lt;em&gt;",array('ping'=>'<em>PING<em>'));
	}
						
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	WebTestCase::main();
}

?>

