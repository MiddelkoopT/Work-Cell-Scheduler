<?php
require_once'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local-linux.php';
require_once 'projectAPP.php';

class PersonTest extends WebIS\Validator{
	//get the class name:
	
	
    protected static $__CLASS__=__CLASS__;
    
    
    function testPersonApp(){
    	$a=new \WCS\Person();
    	$this->assertFalse($a->setPerson("Jianghong Li"));   	
    	$this->assertTrue($a->setPerson("JianghongLi"));
    	
    	$this->assertEquals("{person: JianghongLi}",$a->display());
    	
    	$this->assertTrue($a->setName("Jianghong Li"));   	
    	$this->assertTrue($a->setRate("0.6"));
    	
    	$this->assertEquals("{person: JianghongLi name: Jianghong Li rate: 0.6}", $a->display());
    	
     //can be delected twice, but cannot insert twice
    	$this->assertTrue($a->Delete());
    	$this->assertTrue($a->Delete());
    	$this->assertTrue($a->Insert());
    	$this->assertFalse($a->Insert());
    
    	$a=new \WCS\Person();
    	$this->assertTrue($a->setPerson("JianghongLi"));
    	$this->assertTrue($a->get());
    	echo "name: ".$a->name." "."rate: ".$a->rate;
    	
    }
	
	
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	PersonTest::main();
}
?>