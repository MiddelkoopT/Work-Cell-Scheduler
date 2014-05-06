<?php
// Training Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'trainingApp.php';

class TrainingTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testTrainingApp() {
		$t=new \WCS\TrainingMatrix();
		$this->assertEquals(array('Dr.Middelkoop','JD'),$t->getPeople());
		$this->assertEquals(array(1010,1020,1030),$t->getWorkstations());
		$this->assertEquals(0.99,$t->getTraining('JD',1010));
		$this->assertEquals(0.00,$t->getTraining('Dr.Middelkoop',1040));
	}
	
	/**
	 * @depends testTrainingApp
	 */
	function testTrainingPage(){
		$this->assertValidHTML("Web/training.php","Dr.Middelkoop");
	}

}

if (!defined('PHPUnit_MAIN_METHOD')) {
	TrainingTestCase::main();
}
?>