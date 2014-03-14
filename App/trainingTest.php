<?php
//Training Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'trainingApp.php';

class TrainingTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testTrainingApp() {
		$t=new \WCS\TrainingMatrix();
		$this->assertEquals(array('JB','JS','MD'), $t->getEmployeeid());
		$this->assertEquals(array(1,2,3), $t->getSubcell());
		$this->assertEquals(1,$t->getTraining('JB', '1'));
		$this->assertNotEquals(0,$t->getTraining('JB', '1'));
	}
	


}

if (!defined('PHPUnit_MAIN_METHOD')) {
	TrainingTestCase::main();
}

?>