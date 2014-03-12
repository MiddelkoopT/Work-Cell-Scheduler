<?php

require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'a2Class.php';

class WorkerTestCase extends WebIS\Validator 
{

	protected static $__CLASS__=__CLASS__;
	
	function testa2() 
	{
		$p=new \WCS\Worker();
		
		$this->assertTrue($p->insert());
		$this->assertTrue($p->save());
		$this->assertTrue($p->delete());
		
// 		$param = array(
// 								'person'=> 'Dr.Middelkoop',
// 								'cell'=> '1000',
// 								'workstation' => '1010',
// 								'wcp' => '0.19',
// 								'wsp' => '0.19'
// 						);
// 		$this->assertEquals($param,$p->search());
	
	}



}



if (!defined('PHPUnit_MAIN_METHOD')) 
	{
		WorkerTestCase::main();
	}

?>