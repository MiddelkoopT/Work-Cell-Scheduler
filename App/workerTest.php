<?php
/*
// Worker APP Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'workerApp.php';

class WorkerTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testWorker() {
	$p=new \WCS\Worker();
	$this->assertTrue($p->setWorkerID('j100'));
	$this->assertEquals("WorkerID: j100",$p->display());
	$this->assertFalse($p->setWorkerID('j.100'));
	$this->assertTrue($p->setFirstName('JD'));
	$this->assertFalse($p->setFirstName('JD73'));
	$this->assertEquals("WorkerID: j100 Employee Name: JD",$p->display());
	$this->assertTrue($p->delete());
	$this->assertTrue($p->delete());
	$this->assertTrue($p->write());
	$this->assertFalse($p->write());
	$this->assertTrue($p->read());
}

function workerApp(){
	$p=new \WCS\Worker();
	$this->assertTrue($p->setFirstName('JD'));
	$a=new \WCS\WorkerApp();
	$this->assertTrue($a->add($p));
	$this->assertContains('JD', $a->edit("worker.php"),"edit problem");
	$a=new \WCS\WorkerApp();
	$this->assertFalse($a->load());
	$_REQUEST["action"]='Load';
	$_REQUEST["workerID"]='j100';
	$this->assertTrue($a->load());
	$this->assertContains('JD',$p->getFirstName());
	$_REQUEST["action"]='Update';
	$_REQUEST["workerID"]='j100';
	$_REQUEST["firstname"]='';
	$this->assertTrue($a->save());
}
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	WorkerTestCase::main();
}
?>
