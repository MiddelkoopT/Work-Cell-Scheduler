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
		$this->AssertTrue($n->seta2person("MikeGroene"),"Set a2person failed");
		$h=new \WCS\a2personapp();
		$this->AssertTrue($h->add($n),"adding a2person to a2personapp failed");
		$this->AssertContains("Mike Groene",$h->edit("a2person.php"),"failed to edit");
		
		$h=new \WCS\a2personapp();
		$this->AssertFalse($h->load);
		$__REQUEST['action']='Load';
		$__REQUEST['person']='MikeGroene';
		$this->AssertTrue($h->load());
		$this->AssertContains("Mike Groene",$n->a2getname());
		$__REQUEST['action']='Update';
		$__REQUEST['person']='MikeGroene';
		$__REQUEST['name']='Mike Groene';
		$this->AssetTrue($h->save());
	}

	/**
	 * @depends testa2personapp
	 */
	function testa2personweb() {
		$this->AssertValidHTML('Web/a2person.php');
		$this->AssertValidHTML('Web/a2person.php','Mike Groene',array('action'=>'Load','person'=>'MikeGroene'));
		$this->AssertValidHTML('Web/a2person.php','Michael Groene',array('action'=>'Update','person'=>'MikeGroene','name'=>'Michael Groene'));
		
		
	}
	
	
	
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	a2personTestCase::main();
}
?>