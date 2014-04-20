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
		$os=new WebIS\OS();
		$this->assertTrue($os->solve(),"Solve empty problem");
		$this->assertEquals(0.0,$os->getSolution(),"Solution to empty problem is 0.0");
		$this->assertContains(date('Y-m-d'),$os->getName(),"Solved today");
		$os->addVariable('x1');
		$this->assertTrue($os->solve(),"Solve problem with only one variable");
		$this->assertEquals(0.0,$os->getSolution(),"Solution to one variable is 0.0");
		$this->assertEquals(0.0,$os->getVariable('x1'),"x1 is zero");
		$os->addObjCoef('x1', '-1');
		$this->assertEquals("unbounded",$os->solve(),"Problem is unbounded");
		$this->assertEquals(0.0,$os->getSolution());
		$os->addVariable('x2');
		$os->addObjCoef('x2', '-2');
		$os->addConstraint(NULL,40);
		$os->addConstraintCoef('x1',1);
		$os->addConstraintCoef('x2',1);
		$os->addConstraint(NULL,60);
		$os->addConstraintCoef('x1',2);
		$os->addConstraintCoef('x2',1);
		$this->assertTrue($os->solve());
		$this->assertEquals(-80.0,$os->getSolution());
		$this->assertEquals(0,$os->getVariable('x1'));
		$this->assertEquals(40,$os->getVariable('x2'));
		
		## test LB
		$os=new WebIS\OS();
		$os->addVariable('x1');
		$os->addConstraint(40,NULL);
		$this->assertContains('lb=',$os->getOsil());
		
	}
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	OsTestCase::main();
}

?>

