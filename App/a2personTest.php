<?php

// Person Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'a2personApp.php';

class a2personTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testa2person() {
		$n=new \WCS\a2person();
		$this->AssertTrue($n->seta2person("MikeGroene"),"this is an error message");
		$this->AssertFalse($n->seta2person("Mike...Groene"));
		$this->AssertEquals("{person: MikeGroene}", $n->display());
		$this->AssertTrue($n->seta2name("Mike Groene"));
		$this->AssertEquals("{person: MikeGroene name: Mike Groene}",$n->display());
		$this->AssertTrue($n->a2delete(),"first delete test");
		$this->AssertTrue($n->a2delete(), "second delete test");
		$this->AssertTrue($n->a2insert(),"first insert test");
		$this->AssertFalse($n->a2insert(),"second insert test");
		$n=new \WCS\a2person();
		$this->AssertTrue($n->seta2person("MikeGroene"));
		$this->AssertTrue($n->seta2name("Mike Groene"));
		$this->AssertEquals("{person: MikeGroene name: Mike Groene}",$n->display());
	}


	/**
	 * @depends testa2person
	 */
	function testa2personapp() {
		$n=new \WCS\a2person();
		$this->assertTrue($n->seta2person("MikeGroene"),"Set a2person failed");
		$h=new \WCS\a2personapp();
		$this->assertTrue($h->add($n),"adding a2person to a2personapp failed");
		
		
		
	}
	
	
	
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	a2personTestCase::main();
}
?>