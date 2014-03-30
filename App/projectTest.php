<?php
// Person Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local-linux.php';
require_once 'projectAPP.php';

class ProjectTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testWorker() {
		$p=new \WCS\Worker();
		$this->assertTrue($p->setPerson("JianghongLi"));
		$this->assertFalse($p->setPerson("Jianghong Li"));
		//$this->assertEquals("{person: DrMiddelkoop}",$p->display(),"display only person");
		$this->assertTrue($p->setName("Jianghong Li"));
		$this->assertFalse($p->setName(""));
		$this->assertFalse($p->setName(" "));
		$this->assertTrue($p->setWorkerID("111"));
		$this->assertFalse($p->setWorkerID("aa"));
		$this->assertEquals("JianghongLi",$p->getPerson());
		$this->assertEquals("Jianghong Li",$p->getName());
		$this->assertEquals("111",$p->getWorkerID());
		$this->assertTrue($p->delete());
		$this->assertTrue($p->write());
		$this->assertTrue($p->read());
		$this->assertEquals("JianghongLi",$p->getPerson(),"person not match");
		$this->assertEquals("Jianghong Li",$p->getName(),"name not match");
		//$this->assertFalse($p->wirte());
		/*
		$this->assertEquals("{person: DrMiddelkoop name: Dr. Middelkoop}",$p->display(),"adding name to object");
		// echo $p->display();
		
	*/
	}
    function testWorkerApp(){
    	$p1=new \WCS\WorkerApp;
    	$p2=new \WCS\WorkerApp;
    	$this->assertEquals("2",$p2->getId());
    	//$p=new \WCS\Worker();
    	//$this->assertTrue($p->setWorkerID("3"));
    	$id=$p1->getId();
        $this->assertFalse($p1->load());
        $_REQUEST["action1"]='Load';
        $_REQUEST["$id-workerID"]='111';
        $this->assertTrue($p1->load());
        $_REQUEST["action1"]="Update";
        $_REQUEST["$id-workerID"]='222';
        $_REQUEST["$id-person"]='AA';
        $_REQUEST["$id-name"]='A A';
        $this->assertTrue($p1->save(),"cannot save the input");
        $this->assertContains("222",$p1->edit());//“22”也可以，因为也contain在222里
        
    }
    
    
    function testSubcell() {
    	$p=new \WCS\Subcell();
    	$this->assertTrue($p->setSubcell("1004"));
    	$this->assertFalse($p->setSubcell("aa"));
    	//$this->assertEquals("{person: DrMiddelkoop}",$p->display(),"display only person");
    	$this->assertTrue($p->setWorkerID("111"));
    	$this->assertFalse($p->setWorkerID("aa"));
    	$this->assertEquals("1004",$p->getSubcell());
    	$this->assertEquals("111",$p->getWorkerID());
    	$this->assertTrue($p->delete());
    	$this->assertTrue($p->write());
    	$this->assertTrue($p->read());
    	$this->assertEquals("1004",$p->getSubcell(),"Subcell not match");
    	$this->assertEquals("111",$p->getWorkerID(),"WorkerID not match");
    	//$this->assertFalse($p->wirte());
    	/*
    		$this->assertEquals("{person: DrMiddelkoop name: Dr. Middelkoop}",$p->display(),"adding name to object");
    	// echo $p->display();
    
    	*/
    }
    function testSubcellApp(){
    	$p1=new \WCS\SubcellApp;
    	$id=$p1->getId();
    	$this->assertFalse($p1->load());
    	$_REQUEST["action2"]='Load';
    	$_REQUEST["$id-workerID"]='111';
    	$this->assertTrue($p1->load());
    	$_REQUEST["action2"]="Update";
    	$_REQUEST["$id-workerID"]='222';
    	$_REQUEST["$id-subcell"]='1006';
    	$this->assertTrue($p1->save(),"cannot save the input");
    	$this->assertContains("222",$p1->edit());//“22”也可以，因为也contain在222里
    
    }
    
    
    function testTraining() {
    	$p=new \WCS\Training();
    	$this->assertTrue($p->setTraining("ABC"));
    	//$this->assertEquals("{person: DrMiddelkoop}",$p->display(),"display only person");
    	$this->assertTrue($p->setWorkerID("111"));
    	$this->assertFalse($p->setWorkerID("aa"));
    	$this->assertEquals("ABC",$p->getTraining());
    	$this->assertEquals("111",$p->getWorkerID());
    	$this->assertTrue($p->delete());
    	$this->assertTrue($p->write());
    	$this->assertTrue($p->read());
    	$this->assertEquals("ABC",$p->getTraining(),"Training not match");
    	$this->assertEquals("111",$p->getWorkerID(),"WorkerID not match");
    	//$this->assertFalse($p->wirte());
    	/*
    	 $this->assertEquals("{person: DrMiddelkoop name: Dr. Middelkoop}",$p->display(),"adding name to object");
    	// echo $p->display();
    
    	*/
    }
    function testTrainingApp(){
    	$p1=new \WCS\TrainingApp;
    	$id=$p1->getId();
    	$this->assertFalse($p1->load());
    	$_REQUEST["action3"]='Load';
    	$_REQUEST["$id-workerID"]='111';
    	$this->assertTrue($p1->load());
    	$_REQUEST["action3"]="Update";
    	$_REQUEST["$id-workerID"]='222';
    	$_REQUEST["$id-training"]='CCC';
    	$this->assertTrue($p1->save(),"cannot save the input");
    	$this->assertContains("222",$p1->edit());//“22”也可以，因为也contain在222里
    
    }
    

    		
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	ProjectTestCase::main();
}
?>
