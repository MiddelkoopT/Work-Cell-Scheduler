<?php
// Training Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'training.php';

class TrainingTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testTraining() {
		$t=new \WCS\TrainingMatrix();
		$this->assertEquals(array('Ann','Bob','Clide'),$t->getPeople());
		$this->assertEquals(array(1010,1020,1030,1040),$t->getWorkstations());
		$this->assertEquals(0.10,$t->getTraining('Ann',1010));
	}
	
	function testTrainingPage(){
		$this->assertValidHTML("Web/training.php","Ann");
	}

}

if (!defined('PHPUnit_MAIN_METHOD')) {
	TrainingTestCase::main();
}
?>