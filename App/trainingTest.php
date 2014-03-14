<?php
// Training Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'trainingApp.php';

class TrainingTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testTrainingApp() {
		$t=new \WCS\TrainingMatrix();
		$this->assertEquals(array('j100','j101','j102','j103','j104','j105','j106',),$t->getworkerID());
		$this->assertEquals(array(1000,1010,1020,1030,1060,1040,1050),$t->getsubcell());
		$this->assertEquals(1,$t->getTraining('j100',1020));
		$this->assertEquals(1,$t->getTraining('j102',1020));
	}
	
	/**
	 * @depends testTrainingApp
	 */
	function testTrainingPage(){
		$this->assertValidHTML("Web/training.php","Training Matrix");
	}

}

if (!defined('PHPUnit_MAIN_METHOD')) {
	TrainingTestCase::main();
}
?>