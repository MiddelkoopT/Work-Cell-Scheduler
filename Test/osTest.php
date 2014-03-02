<?php
// Optimization Services Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
require_once 'Work-Cell-Scheduler/WCS/os.php';
include 'Work-Cell-Scheduler/Config/local.php';


class OsServiceTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	// Basic OSSolverServices test.
	function testOS() {
		exec(WebIS\OS::$solver." --version",$output,$return);
		//print_r($output);
		$this->assertEquals(0,$return);
		$this->assertContains("OS Version: 2.",$output[5]);
	}

	function testSolver(){
		// check and create tmp directory, on for production should be 0775 and group www-data.
		if(!is_dir(WebIS\OS::$tmp)){
			echo "[creating tmp dir]";
			$this->assertTrue(mkdir(WebIS\OS::$tmp,0755),"Unable to create OS tmp directory");
		}
		$this->assertTrue(is_dir(WebIS\OS::$tmp),"no temporary directory for OS");
		file_put_contents(WebIS\OS::$tmp."first.osil",self::$osil);
		exec(WebIS\OS::$solver." -osil ".WebIS\OS::$tmp."first.osil -osrl ".WebIS\OS::$tmp."first.osrl",$output,$return);
		$this->assertEquals(0,$return);
		$result=file_get_contents(WebIS\OS::$tmp.'first.osrl');
		$this->assertNotEquals(FALSE,$result);
		$this->assertContains('<var idx="0">0</var>',$result);
		$this->assertContains('<var idx="1">40</var>',$result);
		$this->assertContains('<obj idx="-1">-80</obj>',$result);
		
		unlink(WebIS\OS::$tmp."first.osil");
		unlink(WebIS\OS::$tmp."first.osrl");
	}

	static $osil =<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<osil xmlns="os.optimizationservices.org" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="os.optimizationservices.org http://www.optimizationservices.org/schemas/OSiL.xsd">
	<instanceHeader>
		<name>First OSiL Example</name>
		<source>Timothy Middelkoop</source>
		<description>
			min -x -2y
			s.t.:
     			x  + y &lt;= 40
    			2x + y &lt;= 60
    			x &gt;=0, y &gt;= 0
    			
    		Solution -80 @(x=0,y=40)
    						
			OSSolverService -osil first.osil -osrl first.osrl
		</description>
	</instanceHeader>
	<instanceData>
		<variables numberOfVariables="2">
			<var name="x" />
			<var name="y" />
		</variables>
		<objectives>
			<obj maxOrMin="min" numberOfObjCoef="2">
				<coef idx="0">-1</coef>
				<coef idx="1">-2</coef>
			</obj>
		</objectives>
		<constraints numberOfConstraints="2">
			<con ub="40"/>
			<con ub="60"/>
		</constraints>
		<linearConstraintCoefficients numberOfValues="4">
			<start>
				<el>0</el>
				<el>2</el>
				<el>4</el>
			</start>
			<colIdx>
				<el>0</el><el>1</el>
				<el>0</el><el>1</el>
			</colIdx>
			<value>
				<el>1</el><el>1</el>
				<el>2</el><el>1</el>			
			</value>
		</linearConstraintCoefficients>
	</instanceData>
</osil>
XML;

}

if (!defined('PHPUnit_MAIN_METHOD')) {
	OsServiceTestCase::main();
}

?>

