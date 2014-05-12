<?php
// Optimization Services Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
require_once 'Work-Cell-Scheduler/WCS/os.php';
include 'Work-Cell-Scheduler/Config/local.php';


class OsTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	// Basic OSSolverServices test.
	function testOS() {
		exec(WebIS\OS::$solver." --version",$output,$return);
		$this->assertEquals(0,$return);
		$this->assertContains("OS Version: 2.",$output[5]);
	}

	function testSolver(){
		$os=New WebIS\OS;
		//$this->assertEquals(0.0,$os->solve(),"Solve empty problem");
		//$this->assertContains(date('Y-m-d'),$os->getName(),"Solved today");
		$os->addVariable('x11');
		//$this->assertEquals(0.0,$os->solve(),"Solve problem with only one variable");
		//$this->assertEquals(0.0,$os->getVariable('x11'),"x11 is zero");
		$os->addObjCoef('x11', '3');
		//$this->assertEquals(0.0,$os->solve());
		$os->addVariable('x12');
		$os->addObjCoef('x12', '2');
		$os->addVariable('x21');
		$os->addObjCoef('x21', '1');
		$os->addVariable('x22');
		$os->addObjCoef('x22', '5');
		$os->addVariable('x31');
		$os->addObjCoef('x31', '5');
		$os->addVariable('x32');
		$os->addObjCoef('x32', '4');
		
		$os->addConstraint(NULL, 45);
		$os->addConstraintCoef('x11',1);
		$os->addConstraintCoef('x12',1);
		
		$os->addConstraint(NULL, 60);
		$os->addConstraintCoef('x21',1);
		$os->addConstraintCoef('x22',1);
		
		$os->addConstraint(NULL, 35);
		$os->addConstraintCoef('x31',1);
		$os->addConstraintCoef('x32',1);
		
		$os->addConstraint(50);
		$os->addConstraintCoef('x11',1);
		$os->addConstraintCoef('x21',1);
		$os->addConstraintCoef('x31',1);
		
		$os->addConstraint(60);
		$os->addConstraintCoef('x12',1);
		$os->addConstraintCoef('x22',1);
		$os->addConstraintCoef('x32',1);
		
		//$this->assertEquals(-80.0,$os->solve());
		//$this->assertEquals(0,$os->getVariable('x1'));
		//$this->assertEquals(40,$os->getVariable('x2'));
		
		//$this->assertEquals(350,$os->solve());
		//$this->assertEquals(20,$os->getVariable('x11'));
		//$this->assertEquals(20,$os->getVariable('x12'));
		//$this->assertEquals(20,$os->getVariable('x21'));
		//$this->assertEquals(20,$os->getVariable('x22'));
		//$this->assertEquals(10,$os->getVariable('x31'));
		//$this->assertEquals(20,$os->getVariable('x32'));
		
	
		
		print_r($os->solve());
		
	}
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	OsTestCase::main();
}

?>

