<?php
// Worker2 Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'ta3.php';

class WorkersTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testworkers(){
		$w= new \WCS\Workers2();
		$this->assertTrue($w->SetID("102"));
		$this->assertTrue($w->SetName("Mark Dintelman"));
		$this->assertTrue($w->SetrateSub1("0.9"));	
		$this->assertTrue($w->SetrateSub2("0.8"));
		$this->assertTrue($w->delete());
		$this->assertTrue($w->insert());
		$this->assertEquals(("102"),$w->getworkerIDs());
		$this->assertEquals(("Mark Dintelman"),$w->getnames());
		
	
		
	}
	
	function testworkerApp(){
		$p= new \WCS\Workers2();
		$this->assertTrue($p->SetName("Mark Dintelman"));
		$a= new \WCS\Workers2App();
		$this->assertTrue($a->add($p),"Unable to add worker to edit app");
		$this->assertContains("Mark Dintelman",$a->edit("ta3.php"),"Edit app does not edit");
		
		
		$a=new \WCS\Workers2App();
		$this->assertFalse($a->load(),"Should not load empty workerID");
		$_REQUEST['action']='Load';
		$_REQUEST['workerID']='102';
		$this->assertTrue($a->load(),"workerID:102 is not in the database");
		$this->assertContains("Mark Dintelman",$p->getnames(),"WorkerID object does not contain name");
		$this->assertEquals(array("0.9"),$p->getrateSub1(),"WorkerID object does not contain rateSub1");
		$_REQUEST['action']='Update';
		$_REQUEST['workerID']='102';
		$_REQUEST['name']='Mark Dintelman';
		$_REQUEST['rateSub1']='0.9';
		$_REQUEST['rateSub2']='0.8';
		$this->assertTrue($a->save(),"Cannot save");
		
	}
	function testTA3Web(){
		$this->assertValidHTML('Web/ta3.php');
		$this->assertValidHTML('Web/ta3.php','Mark Dintelman',
				array('action'=>'Load','workerID'=>'102','name'=>'Mark Dintelman','rateSub1'=>'0.9','rateSub2'=>'0.8'),
				"unable to load from page");
		$this->assertValidHTML('Web/ta3.php','Max',
				array('action'=>'Update','workerID'=>'102','name'=>'Max','rateSub1'=>'1','rateSub2'=>'0.5'),
				"unable to save from page");
		
	}
	
	

}
if (!defined('PHPUnit_MAIN_METHOD')) {
	WorkersTestCase::main();
}